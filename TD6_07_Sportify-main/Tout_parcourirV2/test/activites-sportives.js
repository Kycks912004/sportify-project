const activityCards = document.getElementById('activity-cards');

fetch('activites-sportives.json') // Remplacez par l'URL ou le chemin d'accès à votre fichier JSON
  .then(response => response.json())
  .then(data => {
    data.forEach(activity => {
      const card = document.createElement('div');
      card.classList.add('activity-card');

      const image = document.createElement('img');
      image.src = activity.coach.photo;
      image.alt = activity.coach.nom;
      card.appendChild(image);

      const info = document.createElement('div');
      info.classList.add('activity-info');

      const title = document.createElement('h3');
      title.textContent = activity.nom;
      info.appendChild(title);

      const coach = document.createElement('p');
      coach.textContent = `Responsable : ${activity.coach.nom}`;
      info.appendChild(coach);

      const availability = document.createElement('p');
      availability.textContent = `Disponibilité : ${activity.coach.disponibilite}`;
      info.appendChild(availability);

      const cv = document.createElement('p');
      cv.textContent = `CV : ${activity.coach.cv}`;
      info.appendChild(cv);

      card.appendChild(info);
      activityCards.appendChild(card);
    });
  });
