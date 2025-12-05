
async function fetchJSON(url, opts = {}) {
  const res = await fetch(url, Object.assign({
    headers: {'Content-Type':'application/json'},
    credentials: 'same-origin'
  }, opts));
  return res.json();
}

async function postQuestion(title, description) {
  return fetchJSON('/ajax/post_question.php', { method: 'POST', body: JSON.stringify({title, description}) });
}

async function postAnswer(question_id, answer) {
  return fetchJSON('/ajax/post_answer.php', { method: 'POST', body: JSON.stringify({question_id, answer}) });
}

async function vote(answer_id, vote) {
  return fetchJSON('/ajax/vote.php', { method: 'POST', body: JSON.stringify({answer_id, vote}) });
}

async function fetchQuestions() {
  return fetchJSON('/ajax/fetch_questions.php');
}

async function fetchAnswers(question_id) {
  return fetchJSON('/ajax/fetch_answers.php?question_id=' + encodeURIComponent(question_id));
}

document.addEventListener('DOMContentLoaded', () => {
  const createForm = document.getElementById('createQuestionForm');
  if (createForm) {
    createForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const title = createForm.querySelector('[name=title]').value.trim();
      const description = createForm.querySelector('[name=description]').value.trim();
      if (!title || !description) return alert('Completa los campos');
      const res = await postQuestion(title, description);
      if (res.ok) {
        createForm.reset();
        loadQuestions();
      } else alert(res.msg || 'Error');
    });
  }

  loadQuestions();
});

async function loadQuestions() {
  const container = document.getElementById('questionsContainer');
  if (!container) return;
  container.innerHTML = '<p>Cargando...</p>';
  const res = await fetchQuestions();
  if (!res.ok) { container.innerHTML = '<p>Error al cargar</p>'; return; }
  container.innerHTML = '';
  res.data.forEach(q => {
    const el = document.createElement('div');
    el.className = 'questionCard';
    el.innerHTML = `
      <h3 class="q-title" data-id="${q.id}" style="cursor:pointer">${escapeHtml(q.title)}</h3>
      <small>por ${escapeHtml(q.username)} • ${q.created_at} • respuestas: ${q.answers_count}</small>
      <p>${escapeHtml(q.description)}</p>
      <button class="toggleAnswersBtn" data-id="${q.id}">Ver respuestas</button>
      <div class="answersArea" id="answers-${q.id}" style="display:none; margin-top:10px;"></div>
    `;
    container.appendChild(el);
  });

  document.querySelectorAll('.toggleAnswersBtn').forEach(b => {
    b.addEventListener('click', async () => {
      const id = b.getAttribute('data-id');
      const area = document.getElementById('answers-' + id);
      if (area.style.display === 'none') {
        area.innerHTML = '<p>Cargando respuestas...</p>';
        const resA = await fetchAnswers(id);
        if (!resA.ok) { area.innerHTML = '<p>Error</p>'; return; }
        area.innerHTML = renderAnswersHTML(id, resA.data);
        area.style.display = 'block';
        wireAnswerFormAndVotes(id);
      } else {
        area.style.display = 'none';
      }
    });
  });

  document.querySelectorAll('.q-title').forEach(t => {
    t.addEventListener('click', () => {
      const id = t.getAttribute('data-id');
      window.open('/question.php?id=' + id, '_blank');
    });
  });
}

function renderAnswersHTML(question_id, answers) {
  let html = '<div>';
  html += '<div><strong>Respuestas</strong></div>';
  if (answers.length === 0) html += '<p>No hay respuestas aún</p>';
  answers.forEach(a => {
    html += `<div class="answerCard" style="border:1px solid #eee;padding:8px;margin:6px 0">
      <div><small>${escapeHtml(a.username)} • ${a.created_at}</small></div>
      <div>${escapeHtml(a.answer)}</div>
      <div style="margin-top:6px">
        <button class="voteBtn" data-id="${a.id}" data-vote="1">Like</button>
        <button class="voteBtn" data-id="${a.id}" data-vote="0">Dislike</button>
        <span class="score" id="score-${a.id}"> ${a.score} </span>
      </div>
    </div>`;
  });
  html += `<div style="margin-top:10px">
    <textarea id="answerText-${question_id}" rows="2" style="width:100%" placeholder="Escribe tu respuesta..."></textarea>
    <button id="submitAnswer-${question_id}" data-id="${question_id}">Responder</button>
  </div>`;
  html += '</div>';
  return html;
}

function wireAnswerFormAndVotes(question_id) {
  const submitBtn = document.getElementById('submitAnswer-' + question_id);
  if (submitBtn) {
    submitBtn.addEventListener('click', async () => {
      const qid = submitBtn.getAttribute('data-id');
      const text = document.getElementById('answerText-' + qid).value.trim();
      if (!text) return alert('Escribe una respuesta');
      const res = await postAnswer(qid, text);
      if (res.ok) {
        loadQuestions(); 
      } else {
        alert(res.msg || 'Error');
      }
    });
  }
  document.querySelectorAll(`#answers-${question_id} .voteBtn`).forEach(btn => {
    btn.addEventListener('click', async () => {
      const aid = btn.getAttribute('data-id');
      const v = parseInt(btn.getAttribute('data-vote'), 10);
      const res = await vote(aid, v);
      if (res.ok) {
        
        const scoreEl = document.getElementById('score-' + aid);
        if (scoreEl) {
          
          const resA = await fetchAnswers(question_id);
          if (resA.ok) {
            const updated = resA.data.find(x => x.id == aid);
            if (updated) scoreEl.textContent = ' ' + updated.score + ' ';
          }
        }
      } else {
        alert(res.msg || 'Error al votar');
      }
    });
  });
}

function escapeHtml(s) {
  if (!s) return '';
  return s.replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;');
}
