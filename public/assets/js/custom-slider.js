document.addEventListener('DOMContentLoaded', function () {
    var mySwiper = new mySwiper('.swiper-container', {
        loop: true,
        effect: 'slide',
        speed: 800,
        slidesPerView: 1, 
        autoplay: {
            delay: 5000, // temps entre chaque slide
        },
       
    });
});


