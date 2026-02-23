document.addEventListener("DOMContentLoaded", function() {
    fetchRendezVous();

    document.getElementById('rendez_vous_list').addEventListener('click', function(event) {
        if (event.target.classList.contains('annuler-rendez-vous')) {
            const rendezVousId = event.target.dataset.id;
            annulerRendezVous(rendezVousId);
        }
    });
});

function fetchRendezVous() {
    fetch('fetch_rendez_vous.php')
        .then(response => response.json())
        .then(data => {
            const rendezVousList = document.getElementById('rendez_vous_list');
            rendezVousList.innerHTML = '';

            if (data.error) {
                rendezVousList.innerHTML = `<p>${data.error}</p>`;
                return;
            }

            data.forEach(rendezVous => {
                const rendezVousElement = document.createElement('div');
                rendezVousElement.classList.add('rendez-vous');
                rendezVousElement.innerHTML = `
                    <p>Coach: ${rendezVous.coach_name}</p>
                    <p>Date: ${rendezVous.date}</p>
                    <p>Heure: ${rendezVous.time}</p>
                    <p>Adresse: ${rendezVous.address}</p>
                    <p>Document demandé: ${rendezVous.document}</p>
                    <p>Digicode: ${rendezVous.digicode}</p>
                    <button class="annuler-rendez-vous" data-id="${rendezVous.id}">Annuler le RDV</button>
                `;
                rendezVousList.appendChild(rendezVousElement);
            });
        })
        .catch(error => console.error('Erreur:', error));
}

function annulerRendezVous(id) {
    fetch('annuler_rendez_vous.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${id}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        fetchRendezVous();
    })
    .catch(error => console.error('Erreur:', error));
}
