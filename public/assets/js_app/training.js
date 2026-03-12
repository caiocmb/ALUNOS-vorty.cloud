const modalExercicio = document.getElementById('modal-exercicio');

if (modalExercicio) {
    modalExercicio.addEventListener('show.bs.modal', event => {
        // Botão que acionou o modal
        const button = event.relatedTarget;
        
        // Extrai as informações dos atributos data-bs-*
        const title = button.getAttribute('data-bs-title');
        const imgUrl = button.getAttribute('data-bs-img');
        
        // Atualiza os elementos internos do modal
        const modalTitle = modalExercicio.querySelector('#modal-exercicio-title');
        const modalImg = modalExercicio.querySelector('#modal-exercicio-img');

        modalTitle.textContent = title;
        modalImg.src = imgUrl;
    });
}

function notify(m) {
    const t = document.getElementById('toast');
    t.innerText = m; t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2000);
}