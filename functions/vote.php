<?php
// functions/vote.php
require_once __DIR__ . '/../includes/db_connect.php';

function cast_vote($answer_id, $user_id, $vote) {
    global $pdo;
    // $vote: 1 like, 0 dislike
    // Insert or update? Con UNIQUE(answer_id,user_id) intentamos insertar y manejar error.
    try {
        $stmt = $pdo->prepare("INSERT INTO votes (answer_id, user_id, vote) VALUES (?, ?, ?)");
        $stmt->execute([$answer_id, $user_id, $vote]);
        return ['ok' => true, 'action' => 'insert'];
    } catch (PDOException $e) {
        // Si ya existe, actualizar si es distinto
        if ($e->errorInfo[1] == 1062) { // duplicate entry
            $stmt = $pdo->prepare("SELECT vote FROM votes WHERE answer_id = ? AND user_id = ?");
            $stmt->execute([$answer_id, $user_id]);
            $row = $stmt->fetch();
            if ($row && intval($row['vote']) === intval($vote)) {
                return ['ok' => false, 'msg' => 'Ya votaste lo mismo'];
            } else {
                $stmt = $pdo->prepare("UPDATE votes SET vote = ?, created_at = CURRENT_TIMESTAMP WHERE answer_id = ? AND user_id = ?");
                $stmt->execute([$vote, $answer_id, $user_id]);
                return ['ok' => true, 'action' => 'update'];
            }
        } else {
            return ['ok' => false, 'msg' => $e->getMessage()];
        }
    }
}
