jQuery(document).ready(function(){
    var accordionsMenu = $('.cd-accordion-menu');

    if( accordionsMenu.length > 0 ) {
        
        accordionsMenu.each(function(){
            var accordion = $(this);
            //detect change in the input[type="checkbox"] value
            accordion.on('change', 'input[type="checkbox"]', function(){
                var checkbox = $(this);
                // console.log(checkbox.prop('checked'));
                // checkbox.prop('checked', true);

                ( checkbox.prop('checked') ) ? checkbox.siblings('ul').attr('style', 'display:none;').slideDown(300) : checkbox.siblings('ul').attr('style', 'display:block;').slideUp(300);
    
                // setTimeout(function(){
                //     $(".cd-accordion-menu input[type=\"checkbox\"]").prop('checked', false);
                // },1000);

            });

        });
    }
});

$(document).ready(function () {
    ToggleMenu(); // MENU MOBILE
    ToggleMenuChild(); //CHILD MENU
    ToggleMenusLeft();
    contentMenuDrop(); //
    contentMenuDropChild(); //
    changeImgDisplay(); // change image display
    ToggleSearch(); // Toggle search
    ToggleMenuLaci(); //Toggle Laci
    // changeImageShipmentMobile();

    $(".linkIsi").on("click", "a.haschild input", function() {
        var childCategories = $(this).parent().find('label').attr("data-child");
        $("#"+childCategories).find('input:checkbox').not(this).prop('checked', this.checked);
    });

    $(".select2").select2({ //select customize 
        width: '100%'
    });

    $('.select2.nosearch').select2({
        minimumResultsForSearch: -1
    });

    $(".banner .slider").bxSlider({
        auto: false,
        pause: 5000,
        controls : false,
        responsive: true,
        onSlideBefore: function($slideElement, oldIndex, newIndex) {
            var check = $slideElement.find("#BannerEnd").html();
            if(check) {
                var liftoffTime = new Date(Date.parse(check.trim()));
                liftoffTime.setDate(liftoffTime.getDate());
                $slideElement.find("#noDays").countdown({
                    until: liftoffTime,
                    format: 'HMS',
                    layout: 
                    '<div>' +
                    '   {hnn} {sep}' +
                    '   <span>HRS</span>' +
                    '</div>' +
                    '<div>' +
                    '   {mnn} {sep}' +
                    '   <span>MIN</span>' +
                    '</div>' +
                    '<div>' +
                    '   {snn}' +
                    '   <span>SECS</span>' +
                    '</div>'
                });
            }
        }
    });

    $(".faq .slider").bxSlider({
        auto: false,
        pause: 5000,
        controls : false,
        responsive: true,
        pager:false
    });

    $('#parentHorizontalTab').easyResponsiveTabs({
        type: 'default', //Types: default, vertical, accordion
        width: 'auto', //auto or any width like 600px
        fit: true, // 100% fit in a container
        tabidentify: 'hor_1', // The tab groups identifier
    });

    var gallery_carousel = $("#slide1").bxSlider({
    	pager: false,
        slideMargin: 10,
        slideWidth: 391,
        minSlides: 3,
        maxSlides: 3
    });

    var gallery_carouselartist = $("#slide2").bxSlider({
    	pager: false,
        slideMargin: 10,
        slideWidth: 391,
        minSlides: 3,
        maxSlides: 3
    });

    var gallery_carousel_indie = $("#slide3").bxSlider({
    	pager: false,
        slideMargin: 10,
        slideWidth: 391,
        minSlides: 3,
        maxSlides: 3
    });

    var gallery_carousel2 = $("#slide_type2").bxSlider({
        pager: false,
        slideMargin: 10,
        slideWidth: 391,
        minSlides: 3,
        maxSlides: 3
    });

    var slide_product_detail = $("#slide_product_detail").bxSlider({
        pager: false,
        slideMargin: 10,
        slideWidth: 300,
        minSlides: 4,
        maxSlides: 4
    });

    responsiveGallerySlider(gallery_carousel);//reload slider for responsive
    responsiveGallerySliderArts(gallery_carouselartist);//reload slider for responsive
    responsiveGallerySliderIndie(gallery_carousel_indie);//reload slider for responsive
    responsiveGallerySlider2(gallery_carousel2);//reload slider for responsive
    responsiveGallerySlider3(slide_product_detail);//reload slider for responsive

    //close popup 
    $(".wrap-popup .closepop,.wrap-popup .overlay-pop").click(function (e) {
        e.preventDefault();
        var id = $(this).parents('.wrap-popup').attr('id');

        closePopup(id);
    });
});