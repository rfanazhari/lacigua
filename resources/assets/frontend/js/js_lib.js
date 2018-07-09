/*=============================================================================================	
 Document   : Javascript Plugin Lib
 Author     : Muhammad Ramdhani (mr.ramdani@outlook.com) and Rizki N Chaerulsyah
 ==============================================================================================*/

$.fn.isOnScreen = function () {
    if (this.length) {
        var viewport = {};
        viewport.top = $(window).scrollTop();
        viewport.bottom = viewport.top + $(window).height();
        var bounds = {};
        bounds.top = this.offset().top;
        bounds.bottom = bounds.top + this.outerHeight();
        return ((bounds.top <= viewport.bottom) && (bounds.bottom >= viewport.top));
    } else
        return false;
};

$.fn.fileInput = function (e) {
    var elem = this;

    elem.wrap('<div class="' + e.class_name + '"></div>');
    elem.css({
        position: 'absolute',
        top: 0,
        left: 0,
        opacity: 0
    });
    elem.parent('.' + e.class_name).css({
        position: 'relative',
        width: elem.outerWidth() - 2,
        height: elem.outerHeight() - 2,
        display: 'inline-block'
    });
    elem.parent('.' + e.class_name).append("<span>"+elem.attr('placeholder-text')+"</span>");
    elem.on('change', function () {
        var value = $(this).val();
        if (value != "") {
            value = value.substring(12, value.length);
            $(this).next("span").html(value);
        } else {
            $(this).next("span").html(elem.attr('placeholder-text'));
        }
    });
};


$.fn.optCustom = function (q) {
    var
            elem = this,
            s = {
                className: 'checkbox_custom',
            };
    s = $.extend(s, q);
    elem.wrap("<div class='" + s.className + "' style='position:relative' ></div>");
    elem.css({
        position: 'absolute',
        top: 0,
        left: 0,
        opacity: 0,
        width: "100%",
        height: "100%"
    });
    elem.each(function () {
        if ($(this).is(":checked")) {
            $(this).parent().addClass('active');
        }
    });
    elem.on('change', function () {
        if ($(this).attr('type') === "checkbox")
            if (!$(this).is(":checked")) {
                $(this).parent().removeClass('active');
            } else {
                $(this).parent().addClass('active');
            }
        else
            $("input[type=radio][name=" + $(this).attr('name') + "]").each(function () {
                if ($(this).is(":checked")) {
                    $("input[type=radio][name=" + $(this).attr('name') + "]").parent().removeClass('active');
                    $(this).parent().addClass('active');
                    return false;
                }
            });
    });

    elem.parent().on('click', function () {
        if ($(this).attr('type') === "checkbox")
            if (!$(this).children('input').is(":checked")) {
                $(this).removeClass('active');
            } else {
                // console.log('sa')
                $(this).addClass('active');
            }
        else
            $("input[type=radio][name=" + $(this).attr('name') + "]").each(function () {
                if ($(this).is(":checked")) {
                    $("input[type=radio][name=" + $(this).attr('name') + "]").parent().removeClass('active');
                    $(this).parent().addClass('active');
                    return false;
                }
            });
    });

};


$.fn.autoheight = function(s){
    var e = {
        column:'auto',
        boxList:'',
        outer: false
    }
    e = $.extend(e,s);
    var elem = this, a, b = 0, outheight = $(this).height(), column = e.column, excol = column - 1, outer = e.outer;
    var ffirst = 0, flast;

    if(outer == true){
        outheight = $(this).outerHeight();
    }

    var setheight = function(){

        if(column != 'auto'){
            for (var i = 0; i < elem.length; i++) {
                if(outer == true){
                    a = $(elem).eq(i).outerHeight();
                }else{
                    a = $(elem).eq(i).height();
                }
                if(a > b){
                    b = a;
                }
                if(i % column == excol || i == elem.length - 1){
                    var minex = excol;
                    if(i % column == excol){
                        minex = excol;
                    }else{
                        if(i % column == excol){
                            minex = 0;
                        }else if(i == elem.length - 1){
                            if(i - flast > 1){
                                minex = elem.length - i;
                            }else{
                                minex = elem.length - i - 1;
                            }
                        }else{
                            minex = elem.length - i - 1;
                        }
                    }
                    ffirst = i - minex;
                    flast = i;
                    for(var lss = ffirst; lss <= flast; lss++){
                        $(elem).eq(lss).css('height', b+'px');
                    }
                    b = 0;
                }
            }
            return true;
        }else{
            $(elem).each(function(){
                a = outheight;
                if(a > b){
                    b = a;
                }
            });
            $(elem).css('height', b+'px');
        }
    };
    setheight();
    var resizeTimer;

    $(window).resize(function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            console.log('sa');
            if(setheight()){
                location.reload();
            }
        }, 500);
    });
}

$.fn.responsiveImage = function (s) {
    var e ={
        type:undefined
    }
    e = $.extend(e,s);
    var elem = this, etype,
            action = function () {
                if(e.type == undefined){
                    etype = "background";
                }else{
                    etype = e.type;
                }
                window_width = $(window).width();
                elem.each(function () {
                    flag = false;
                    if (window_width > 1023 && $(this).attr('has_load') != 'large') {
                        images_url = $(this).attr('img-large');
                        $(this).attr('has_load', 'large');
                        flag = true;
                    } else if (window_width <= 1023 && window_width >= 640 && $(this).attr('has_load') != 'medium') {
                        images_url = $(this).attr('img-medium');
                        $(this).attr('has_load', 'medium');
                        flag = true;
                    } else if (window_width < 640 && window_width >= 0 && $(this).attr('has_load') != 'small') {
                        images_url = $(this).attr('img-small');
                        $(this).attr('has_load', 'small');
                        flag = true;
                    }
                    if (images_url == undefined) {
                        images_url = $(this).attr('img-large');
                        $(this).attr('has_load', 'large');
                    }

                    if (flag){
                        if(etype == "background"){
                            $(this).css('background-image', 'url('+images_url+')');
                        }else{
                            $(this).attr('src', images_url);
                        }     
                    }     
                });

            }
    action();
   
    var resizeTimer;

    $(window).resize(function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            action();
        }, 500);
    });
}



function responsiveGallerySlider(slider) {
    var act = {};
    act.responsive = function () {
        var window_width = $(window).width();
        if (window_width > 1000) {
            slider.reloadSlider({
                slideMargin: 10,
                slideWidth: 375,
                minSlides: 3,
                maxSlides: 3,
                pager: false
            });
        }
        else if (window_width < 1000 && window_width >= 768) {
            slider.reloadSlider({
                slideMargin: 10,
                slideWidth: 300,
                minSlides: 2,
                maxSlides: 2,
                pager: false
            });
        }
        else if (window_width < 768 && window_width >= 480) {
            slider.reloadSlider({
                slideMargin: 0,
                slideWidth: 375,
                minSlides: 1,
                maxSlides: 1,
                pager: false
            });
        }
        else if (window_width < 480 && window_width >= 320) {
            slider.reloadSlider({
                slideMargin: 0,
                slideWidth: 250,
                minSlides: 1,
                maxSlides: 1,
                pager: false
            });
        }
    };
    if ($(slider.selector).length) {
        setTimeout(function () {
            act.responsive();
        }, 300);
        $(window).resize(function () {
            act.responsive();
        });
    }

};
function responsiveGallerySliderArts(slider) {
    var act = {};
    act.responsive = function () {
        var window_width = $(window).width();
        if (window_width > 1000) {
            slider.reloadSlider({
                slideMargin: 10,
                slideWidth: 375,
                minSlides: 3,
                maxSlides: 3,
                pager: false
            });
        }
        else if (window_width < 1000 && window_width >= 768) {
            slider.reloadSlider({
                slideMargin: 10,
                slideWidth: 300,
                minSlides: 2,
                maxSlides: 2,
                pager: false
            });
        }
        else if (window_width < 768 && window_width >= 480) {
            slider.reloadSlider({
                slideMargin: 0,
                slideWidth: 375,
                minSlides: 1,
                maxSlides: 1,
                pager: false
            });
        }
        else if (window_width < 480 && window_width >= 320) {
            slider.reloadSlider({
                slideMargin: 0,
                slideWidth: 250,
                minSlides: 1,
                maxSlides: 1,
                pager: false
            });
        }
    };
    if ($(slider.selector).length) {
        setTimeout(function () {
            act.responsive();
        }, 300);
        $(window).resize(function () {
            act.responsive();
        });
    }

};
function responsiveGallerySliderIndie(slider) {
    var act = {};
    act.responsive = function () {
        var window_width = $(window).width();
        if (window_width > 1000) {
            slider.reloadSlider({
                slideMargin: 10,
                slideWidth: 375,
                minSlides: 3,
                maxSlides: 3,
                pager: false
            });
        }
        else if (window_width < 1000 && window_width >= 768) {
            slider.reloadSlider({
                slideMargin: 10,
                slideWidth: 300,
                minSlides: 2,
                maxSlides: 2,
                pager: false
            });
        }
        else if (window_width < 768 && window_width >= 480) {
            slider.reloadSlider({
                slideMargin: 0,
                slideWidth: 375,
                minSlides: 1,
                maxSlides: 1,
                pager: false
            });
        }
        else if (window_width < 480 && window_width >= 320) {
            slider.reloadSlider({
                slideMargin: 0,
                slideWidth: 250,
                minSlides: 1,
                maxSlides: 1,
                pager: false
            });
        }
    };
    if ($(slider.selector).length) {
        setTimeout(function () {
            act.responsive();
        }, 300);
        $(window).resize(function () {
            act.responsive();
        });
    }

};
function responsiveGallerySlider2(slider) {
    var act = {};
    act.responsive = function () {
        var window_width = $(window).width();
        if (window_width > 1000) {
            slider.reloadSlider({
                slideMargin: 10,
                slideWidth: 280,
                minSlides: 3,
                maxSlides: 3,
                pager: false
            });
        }
        else if (window_width < 1000 && window_width >= 768) {
            slider.reloadSlider({
                slideMargin: 10,
                slideWidth: 280,
                minSlides: 2,
                maxSlides: 2,
                pager: false
            });
        }
        else if (window_width < 768 && window_width >= 480) {
            slider.reloadSlider({
                slideMargin: 0,
                slideWidth: 375,
                minSlides: 1,
                maxSlides: 1,
                pager: false
            });
        }
        else if (window_width < 480 && window_width >= 320) {
            slider.reloadSlider({
                slideMargin: 0,
                slideWidth: 250,
                minSlides: 1,
                maxSlides: 1,
                pager: false
            });
        }
    };
    if ($(slider.selector).length) {
        setTimeout(function () {
            act.responsive();
        }, 300);
        $(window).resize(function () {
            act.responsive();
        });
    }

};
function responsiveGallerySlider3(slider) {
    var act = {};
    act.responsive = function () {
        var window_width = $(window).width();
        if (window_width > 1000) {
            slider.reloadSlider({
                slideMargin: 20,
                slideWidth: 230,
                minSlides: 4,
                maxSlides: 4,
                pager: false
            });
        }
        else if (window_width < 1000 && window_width >= 768) {
            slider.reloadSlider({
                slideMargin: 20,
                slideWidth: 200,
                minSlides: 3,
                maxSlides: 3,
                pager: false
            });
        }
        else if (window_width < 768 && window_width >= 480) {
            slider.reloadSlider({
                slideMargin: 0,
                slideWidth: 375,
                minSlides: 1,
                maxSlides: 1,
                pager: false
            });
        }
        else if (window_width < 480 && window_width >= 320) {
            slider.reloadSlider({
                slideMargin: 0,
                slideWidth: 230,
                minSlides: 1,
                maxSlides: 1,
                pager: false
            });
        }
    };
    if ($(slider.selector).length) {
        setTimeout(function () {
            act.responsive();
        }, 300);
        $(window).resize(function () {
            act.responsive();
        });
    }

};

function openPopup(id) {       
    var idPop = $("#" + id),
        contentPop = idPop.find('.box-popup');      
    TweenLite.set(idPop, {
        'opacity': '0',
        'scale': '1'
    });  
    TweenLite.set(contentPop, {
        'opacity': '0',
        'scale': '0.9'
    });
    
    
    TweenLite.to(idPop, 0.5, {
        css: {
            'display': 'block',
            'opacity': '1',
            'scale': '1'
        },
        delay: 0,
        ease: Quart.easeOut
    });
    TweenLite.to(contentPop, 0.3, {
        css: {            
            'opacity': '1',
            'scale': '1'
        },
        delay: 0.1,
        ease: Quart.easeOut
    }); 

    $('body').addClass('no-scroll');
}
function closePopup(id) {
    var idPop = $("#" + id),
        contentPop = idPop.find('.box-popup');  
    TweenLite.to(idPop, 0.5, {
        css: {
            'display': 'none',
            'opacity': '0',
            'scale': '1'
        },
        delay: 0.2,
        ease: Quart.easeOut
    });    
    TweenLite.to(contentPop, 0.3, {
        css: {            
            'opacity': '0',
            'scale': '0.9'           
        },
        delay: 0,
        ease: Quart.easeOut
    });
    $('body').removeClass('no-scroll'); 
}

function toggleAccMenu(){
//first
$(".boxAccordion ul.list_acc li.list_first").click(function(){
  var $this = $(this),
      $icoToggle = $("li.list_first > a > span.ico_acc");
      $content = $("li.list_first > ul.list_menu_acc");
  if(!$this.hasClass("opened")){
     $icoToggle.css({
        background : "url(images/material/ico_min_hover.png) no-repeat"
     });
    TweenMax.to($content, .2, {css: {alpha:1,height:"auto",visibility:"visible"},ease: Circ.easeOut});
    $this.addClass("active");
     $(".boxAccordion ul.list_acc li.list_first").addClass("opened");
  }else{
     $icoToggle.css({
        background : "url(images/material/ico_plus.png) no-repeat"
     });
    TweenLite.set($content, {height:0,alpha:0,visibility:"hidden"})
    TweenLite.from($content, 0.2, {height:"auto"})
    $this.removeClass("active");
     $(".boxAccordion ul.list_acc li.list_first").removeClass("opened");
  }
});

//second
$(".boxAccordion ul.list_acc li.list_second").click(function(){
  var $this = $(this),
      $icoToggle = $("li.list_second > a > span.ico_acc");
      $content = $("li.list_second > ul.list_menu_acc");
  if(!$this.hasClass("opened")){
     $icoToggle.css({
        background : "url(images/material/ico_min_hover.png) no-repeat"
     });
    TweenMax.to($content, .2, {css: {alpha:1,height:"auto",visibility:"visible"},ease: Circ.easeOut});
    $this.addClass("active");
     $(".boxAccordion ul.list_acc li.list_first").addClass("opened");
     $(".boxAccordion ul.list_acc li.list_second").addClass("opened");
  }else{
     $icoToggle.css({
        background : "url(images/material/ico_plus.png) no-repeat"
     });
    TweenLite.set($content, {height:0,alpha:0,visibility:"hidden"})
    TweenLite.from($content, 0.2, {height:"auto"})
    $this.addClass("active");
     $(".boxAccordion ul.list_acc li.list_first").removeClass("opened");
     $(".boxAccordion ul.list_acc li.list_second").removeClass("opened");
  }
});

}

function contentMenuDrop(){
    $(".linkMenuDrop").on("click", "li a.link_drop", function(){
        // alert("ok");
        var contentMenuDrop = $(this).parent().find(".contentMenuDrop");

        if(!$(this).hasClass("active")){
            $(contentMenuDrop).slideDown();
            $(this).addClass("active");
            $(this).removeClass("noactive");
        }else{
            $(contentMenuDrop).slideUp();
            $(this).removeClass("active");            
            $(this).addClass("noactive");            
        }
        
    });
}
function contentMenuDropChild(){
    $(".linkIsi").on("click", "a.haschild label", function(){
        // alert("ok");
        var childCategories = $(this).attr("data-child");
        var opr = $(this).find("span.opr");

        if(!$(this).hasClass("active")){
            $("#"+childCategories).slideDown();
            $(this).addClass("active");
            $(opr).html("-");
        }else{
            $("#"+childCategories).slideUp();
            $(this).removeClass("active");            
            $(opr).html("+");
        }
        
    });
}

function changeImgDisplay(){
    $(".imgLinkView").on("click", "li a", function(){
        var large_img = $(this).attr("data-url-img"),
            img_target = $(".imgView img");

        // console.log(large_img);

        $(img_target).attr("src", large_img);

    });
}

function ToggleMenu(){
    $(".boxNewMenu").on("click", ".toggle", function(){
        var contentBody = $("html"),
            navmenu = $("nav.navMenu"),
            top_bar = $("header > .top_bar");


        if(!$(this).hasClass("active")){
            $(".overlay_mob, .closeMenuMobile").show();
            TweenLite.set(contentBody, {
                'position': 'relative',
            });

            TweenLite.set(top_bar, {
                'opacity': '0',
                'visibility': 'visible',
                'display': 'inherit',
            });
            TweenMax.to(top_bar, 0.3, {
                css: {
                    right: 0,
                    autoAlpha: 1

                },
                ease: Cubic.easeOut
            });
            TweenLite.set(navmenu, {
                'opacity': '0',
                'visibility': 'visible',
                'display': 'inherit',
            });
            TweenMax.to(navmenu, 0.3, {
                css: {
                    right: 0,
                    autoAlpha: 1

                },
                ease: Cubic.easeOut
            });
            TweenMax.to(contentBody, 0.3, {
                css: {
                    left: -navmenu.width()
                },
                ease: Cubic.easeOut
            });
            $('body, html').addClass('no-scroll');
        }else{
            $(".overlay_mob, .closeMenuMobile").hide();
            TweenMax.to(top_bar, 0.3, {
                css: {
                    right: -top_bar.width(),
                    autoAlpha: 1
                },
                ease: Cubic.easeOut
            });
            TweenMax.to(navmenu, 0.3, {
                css: {
                    right: -navmenu.width(),
                    autoAlpha: 1
                },
                ease: Cubic.easeOut
            });
            TweenMax.to(contentBody, 0.3, {
                css: {
                    left: 0
                },
                ease: Cubic.easeOut
            });
            $('body, html').removeClass('no-scroll');
        }
    });

    // overlay click
    $(".overlay_mob, .closeMenuMobile, .closeMenuOnMob a").click(function(){
        var contentBody = $("html"),
            navmenu = $("nav.navMenu"),
            top_bar = $("header > .top_bar");

        $(".overlay_mob, .closeMenuMobile").hide();
        TweenMax.to(navmenu, 0.3, {
            css: {
                right: -navmenu.width(),
                autoAlpha: 1
            },
            ease: Cubic.easeOut
        });
        TweenMax.to(top_bar, 0.3, {
                css: {
                    right: -top_bar.width(),
                    autoAlpha: 1
                },
                ease: Cubic.easeOut
            });
        TweenMax.to(contentBody, 0.3, {
            css: {
                left: 0
            },
            ease: Cubic.easeOut
        });
        $('body, html').removeClass('no-scroll');
    });
}
function ToggleMenuChild(){
    $(".navMenu").on("click", ".ico.hasChild", function(){
        // console.log("ok");
        var $childmenu = $(this).attr("data-child");

        if(!$(this).hasClass("active")){
            $(this).css({
                background: 'url("images/material/minus.png") no-repeat',
                backgroundPosition: 'right 10px center'
            });

        TweenLite.set("#"+$childmenu, {
            'opacity': '0',
            'visibility': 'visible',
            'display': 'inherit',
            // 'scale': '0.9'
        });
        TweenLite.to("#"+$childmenu, 0.3, {
            css: {            
                'opacity': '1',
                // 'scale': '1'
            },
            delay: 0.1,
            ease:Power2.easeInOut
            // ease: Quart.easeOut
        }); 

        $('body').addClass('no-scroll');            

            $(this).addClass("active");
        }else{
            $(this).css({
                background: 'url("images/material/plus.png") no-repeat',
                backgroundPosition: 'right 10px center'
            });
            TweenLite.to("#"+$childmenu, 0.3, {
                css: {            
                    'opacity': '0',
                    'visibility': 'hidden',
                    'display': 'none',
                    // 'scale': '0.9'           
                },
                delay: 0,
                ease:Power2.easeInOut
            });
            $('body').removeClass('no-scroll');

            $(this).removeClass("active");

        }

    });
}

//toggle term
function ToggleMenusLeft(){
    $(".toggleMenu").click(function(){
        console.log("ok")
        var $id = $(this).attr("data-id");

        if(!$(this).hasClass("active")){
            $(this).html("Sembunyikan menu");
            $("#"+$id).slideDown();
            $(this).addClass("active");
        }else{
            $(this).html("Lihat menu");
            $("#"+$id).slideUp();
            $(this).removeClass("active");            
        }
    });
        
}

function ToggleSearch(){

    $(".boxSearchMobile").on("click", ".search_mobile", function(){

        $(".boxSearch").show();
        $(".text_search").focus();

    });
    $(".boxSearch").on("click", ".closeSearch", function(){
        $(".boxSearch").slideUp();
    });
};

function ToggleMenuLaci(){
    $(".list_top").on("click", "li > .my_laci", function(){
        console.log("oklaci");
        var $childmenu = $(".boxLaci");

        if(!$(this).hasClass("active")){
            // $(this).css({
            //     background: 'url("images/material/minus.png") no-repeat',
            //     backgroundPosition: 'right 10px center'
            // });

        TweenLite.set($childmenu, {
            'opacity': '0',
            'visibility': 'visible',
            'display': 'inherit',
            // 'scale': '0.9'
        });
        TweenLite.to($childmenu, 0.3, {
            css: {            
                'opacity': '1',
                // 'scale': '1'
            },
            delay: 0.1,
            ease:Power2.easeInOut
            // ease: Quart.easeOut
        }); 

        $('body').addClass('no-scroll');            

            $(this).addClass("active");
        }else{
            // $(this).css({
            //     background: 'url("images/material/plus.png") no-repeat',
            //     backgroundPosition: 'right 10px center'
            // });
            TweenLite.to($childmenu, 0.3, {
                css: {            
                    'opacity': '0',
                    'visibility': 'hidden',
                    'display': 'none',
                    // 'scale': '0.9'           
                },
                delay: 0,
                ease:Power2.easeInOut
            });
            $('body').removeClass('no-scroll');

            $(this).removeClass("active");

        }

    });
}


function changeImageShipmentMobile(){

    $(".boxTrack").each(function(){
        var window_width = $(window).width();
       var shipment_confirm = $(this).find(".boxTrackInner .status .shipment .confirm .imgcircle img");
       var shipment_confirm_done = $(this).find(".boxTrackInner .status .shipment .confirm.done .imgcircle img");
       console.log($(shipment_confirm_done).attr("src"));

       if(window_width <= 320){
            $(shipment_confirm).attr("src", "images/material/proses_small.png");
            $(shipment_confirm_done).attr("src", "images/material/proses_done_small.png");
        }

    });
    
}

