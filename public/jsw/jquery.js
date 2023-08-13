// ini untuk carousel
$('.owl-carousel').owlCarousel({
    loop: true,
    padding: 20,
    margin: 30,
    responsiveClass: true,
    responsive: {
        375: {
            items: 1,
            nav: true
        },
        576: {
            items: 2,
            nav: true
        },
        768: {
            items: 2,
            nav: true
        },
        992: {
            items: 3,
            nav: true,
            loop: false
        }
    }
})

// ini untuk menambahkan class pada tag di html
$(document).ready(function () {
    $(window).resize(function () {
        if ($(window).width() < 992)
            $('#resize').removeClass('offset-2');
        else
            $('#resize').addClass('offset-2');
    });
});

//ini untuk Animated On Scroll 
AOS.init();

// ini untuk tombol kembali ke atas
$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 400) {
            $('#Back-to-top').fadeIn();
        }
        else { $('#Back-to-top').fadeOut(); }
    });
    $('#Back-to-top').click(function () {
        $('body,html')
            .animate({ scrollTop: 0 }, 400)
            .animate({ scrollTop: 40 }, 300)
            .animate({ scrollTop: 0 }, 180)
            .animate({ scrollTop: 15 }, 200)
            .animate({ scrollTop: 0 }, 140);
    });
});