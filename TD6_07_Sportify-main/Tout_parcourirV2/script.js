document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("activites-sportives-link").addEventListener("click", function() {
        fetchActivities('sportives');
    });

    document.getElementById("sports-competition-link").addEventListener("click", function() {
        fetchActivities('competition');
    });
});

function fetchActivities(type) {
    fetch(`fetch_activities.php?type=${type}`)
        .then(response => response.json())
        .then(data => {
            displayActivities(data);
        })
        .catch(error => console.error('Error fetching activities:', error));
}

function displayActivities(activities) {
    const activitiesList = document.getElementById("activities-list");
    activitiesList.innerHTML = '';

    activities.forEach(activity => {
        const activityItem = document.createElement("div");
        activityItem.className = "activity-item";
        activityItem.textContent = activity.nom;
        activityItem.addEventListener("click", () => {
            fetchCoachDetails(activity.responsable_id);
        });
        activitiesList.appendChild(activityItem);
    });
}

function fetchCoachDetails(coachId) {
    fetch(`fetch_coach.php?id=${coachId}`)
        .then(response => response.json())
        .then(data => {
            displayCoachDetails(data);
        })
        .catch(error => console.error('Error fetching coach details:', error));
}

function displayCoachDetails(coach) {
    const coachDetails = document.getElementById("coach-details");
    coachDetails.innerHTML = `
        <h3>Coach Responsable</h3>
        <p><strong>Nom:</strong> ${coach.nom}</p>
        <img src="${coach.photo}" alt="${coach.nom}" style="width:200px;height:200px;">
        <p><strong>Bureau:</strong> ${coach.bureau}</p>
        <p><strong>Disponibilité:</strong> ${coach.disponibilite}</p>
        <p><strong>CV:</strong> ${coach.cv}</p>
    `;
}
