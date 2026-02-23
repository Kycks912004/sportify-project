$(document).ready(function(){
    $('.carousel-images').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: true,
        dots: true,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    // Charger les informations de l'utilisateur
    loadUserInfo();
});

function loadUserInfo() {
    // Ici, nous ferions un appel AJAX à notre backend pour obtenir les informations de l'utilisateur
    // Simulons avec des données statiques pour cet exemple
    let userInfo = {
        name: "Alice Dupont",
        email: "alice@example.com",
        userType: "Client",
        appointments: [
            { date: "2024-06-01 10:00:00", coach: "Guy DUMAIS" },
            { date: "2024-06-02 14:00:00", coach: "Jean MARTIN" }
        ]
    };

    $("#user-name").text(userInfo.name);
    $("#user-email").text("Email: " + userInfo.email);
    $("#user-type").text("Type de compte: " + userInfo.userType);

    let appointmentList = $("#appointment-list");
    userInfo.appointments.forEach(function(appointment) {
        appointmentList.append("<li>" + appointment.date + " avec " + appointment.coach + "</li>");
    });
}

function logout() {
    // Déconnecter l'utilisateur et rediriger vers la page de connexion
    window.location.href = 'login.html';
}
