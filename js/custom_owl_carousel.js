$( document ).ready(function() {
    $('.owl-carousel').owlCarousel({
	center:true,
    loop:true,
    margin:30,
    // autoplay:true,
    autoplayHoverPause:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
})
});