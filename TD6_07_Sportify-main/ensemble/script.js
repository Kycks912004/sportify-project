$(document).ready(function(){
    $('.carousel-images').slick({
        infinite: true,
        slidesToShow: 3,  // Affiche trois images à la fois
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,  // Définit la vitesse de défilement à 3 secondes
        arrows: false, // Désactiver les flèches du carrousel
        dots: false, // Désactiver les points de navigation du carrousel
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

    // Ajout de fonctionnalités aux boutons de navigation
    $('.prev-button').click(function(){
        $('.carousel-images').slick('slickPrev');
    });

    $('.next-button').click(function(){
        $('.carousel-images').slick('slickNext');
    });
});
