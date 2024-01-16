//////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// ALL SLIDER /////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////

document.addEventListener('DOMContentLoaded', function () {
    var mySwiper = new Swiper('.swiper-container', {
        loop: true,
        effect: 'slide',
        speed: 800,
        slidesPerView: 1, 
        autoplay: {
            delay: 5000, // temps entre chaque slide
        },
       
    });
});


//////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// DEPART /////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////


document.addEventListener('DOMContentLoaded', function() {
    var redLights = document.getElementById('redLights');
    var moveWheelChair = document.querySelector('.moveWheelChair');

    redLights.addEventListener('animationiteration', function() {
        moveWheelChair.style.animation = 'moveWheelChairAnimation 10s linear infinite';
    });
});


    





//////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// UPLOAD IMAGE /////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////

document.addEventListener("DOMContentLoaded", function () {
    var redLight5 = document.querySelector(".redLight5");
    var wheelChairImage = document.querySelector(".wheelChair img");

    // Attend le début de l'animation de redLight5
    redLight5.addEventListener("animationstart", function () {
        wheelChairImage.classList.add("moveWheelChair");
    });
});


















