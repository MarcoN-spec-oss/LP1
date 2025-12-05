<?php

require_once __DIR__ . '/functions/auth.php';
logout();
header('Location: index.php');
exit;
