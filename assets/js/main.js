document.getElementById('questionForm').addEventListener('submit', function(e){
    e.preventDefault();
    let formData = new FormData(this);

    fetch('add_question.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            alert('Pregunta agregada!');
            location.reload(); // Recarga lista de preguntas
        } else {
            alert('Error al agregar pregunta.');
        }
    });
});
