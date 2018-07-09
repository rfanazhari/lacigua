$(document).ready(function() {
	// Start Set Line in Menu
	$('.navMenu').find('.drop-box').each(function() {
		$(this).find('#linemenu').height($(this).find('#linemenu').parent().height());
	});
	// End Set Line in Menu
	// Start bxslider
	$('.bxslider').bxSlider({
		controls: false,
		infiniteLoop: false,
		onSliderLoad: function(currentIndex) {
			var check = $(".boxFreeShip").find('.desc').text();
			if(check) {
				$(".boxFreeShip").show();
				$(".boxFreeShip").attr('style', 'background:'+$(".boxFreeShip").find('.bgcolor').html());
			} else {
				$(".boxFreeShip").hide();
			}
		},
		onSlideBefore: function($slideElement, oldIndex, newIndex) {
			var check = $slideElement.find(".hidecaption").find('.desc').html();
			if(check.trim()) {
				$(".boxFreeShip").html($slideElement.find(".hidecaption").html());
				$(".boxFreeShip").attr('style', 'background:'+$slideElement.find(".hidecaption").find('.bgcolor').html());
				$(".boxFreeShip").show();
			} else {
				$(".boxFreeShip").hide();
			}
		}
	});
	// End bxslider
	// Start bxslider sale
	$('.bxslidersale').bxSlider({
		controls: false,
		infiniteLoop: false,
		onSliderLoad: function(currentIndex) {
			var check = $(".boxFreeShip").find('.desc').text();
			if(check.trim()) {
				$(".boxFreeShip").show();
				$(".boxFreeShip").attr('style', 'background:'+$(".boxFreeShip").find('.bgcolor').html());
			} else {
				$(".boxFreeShip").hide();
			}
			var check = $(".captIsi").find('.desc').text();
			if(check.trim()) {
				$(".captIsi").show();
				$(".captIsi").find('.title').attr('style', 'color:'+$(".captIsi").find('.bgcolor').html());
				$(".captIsi").find('.desc').attr('style', 'color:'+$(".captIsi").find('.bgcolor').html());
			} else {
				$(".captIsi").hide();
			}
			var check = $(".boxFreeShip").parent().find(".BannerColor").html();
			if(check) {
				$(".bx-wrapper").attr('style', 'background-color:'+$(".boxFreeShip").parent().find(".BannerColor").html());
			}
		},
		onSlideBefore: function($slideElement, oldIndex, newIndex) {
			var check = $slideElement.find(".hidecaption").find('.desc').html();
			if(check.trim()) {
				$(".boxFreeShip").html($slideElement.find(".hidecaption").html());
				$(".boxFreeShip").attr('style', 'background:'+$slideElement.find(".hidecaption").find('.bgcolor').html());
				$(".boxFreeShip").show();
			} else {
				$(".boxFreeShip").hide();
			}
			var check = $slideElement.find(".hidetext").find('.desc').html();
			if(check.trim()) {
				$(".captIsi").html($slideElement.find(".hidetext").html());
				$(".captIsi").find('.title').attr('style', 'color:'+$slideElement.find(".hidetext").find('.bgcolor').html());
				$(".captIsi").find('.desc').attr('style', 'color:'+$slideElement.find(".hidetext").find('.bgcolor').html());
				$(".captIsi").show();
			} else {
				$(".captIsi").hide();
			}
			var check = $slideElement.find(".BannerColor").html();
			if(check) {
				$(".bx-wrapper").attr('style', 'background-color:'+$slideElement.find(".BannerColor").html());
			}
		}
	});
	// End bxslider sale
	$('.numberonly').numberOnly();
});
$.fn.numberOnly = function() {
	return this.each(function() {
		$(this).keydown(function(e) {
			var key = e.charCode || e.keyCode || 0;
			return (key == 8 || key == 9 || key == 13 || key == 46 || key == 110 || key == 190 || (key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105));
		});
	});
};