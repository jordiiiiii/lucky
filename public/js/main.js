const premis = document.getElementById('premis');

if (premis) {
    premis.addEventListener('click', e => {
        if (e.target.className === 'btn btn-danger delete-premi') {
            if (confirm('Estas seguuuur?')) {
                const id = e.target.getAttribute('data-id');

                fetch(`/premi/delete/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}