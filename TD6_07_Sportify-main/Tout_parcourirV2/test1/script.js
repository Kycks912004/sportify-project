function loadCoachInfo(activite_id) {
    console.log('Activité sélectionnée ID:', activite_id);
    fetch('get_coach_info.php?activite_id=' + activite_id)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Données reçues:', data);
            if (data.error) {
                document.getElementById('coach-info').innerHTML = '<p>' + data.error + '</p>';
                return;
            }
            if (data && data.nom) {
                const coachInfoDiv = document.getElementById('coach-info');
                coachInfoDiv.innerHTML = `
                    <h3>Coach Information</h3>
                    <div class="coach-card">
                        <img src="${data.photo}" alt="Coach Photo" class="coach-photo"/>
                        <div class="coach-details">
                            <p><strong>Nom:</strong> ${data.nom}</p>
                            <p><strong>Bureau:</strong> ${data.bureau}</p>
                            <p><strong>Disponibilité:</strong> ${data.disponibilite}</p>
                            <p><strong>Bio:</strong> ${data.bio}</p>
                            <p><strong>CV:</strong> <a href="${data.cv}" target="_blank">Télécharger le CV</a></p>
                        </div>
                    </div>
                `;
            } else {
                document.getElementById('coach-info').innerHTML = '<p>Aucune information disponible pour cette activité.</p>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('coach-info').innerHTML = '<p>Une erreur est survenue. Veuillez réessayer plus tard.</p>';
        });
}
