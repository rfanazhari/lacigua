<style type="text/css">
	section.sale .boxContentSale .boxFavorit .btn.favorit.red {
		background: url({{$basesite}}assets/frontend/images/material/stars-white.png) no-repeat;
	    background-position: right 30px center;
		background-color: red;
		color: white;
		border-color: red;
	}
</style>
<section class="sale feature">
	<div class="wrapper">
		<div class="breadcrumb">
			<a href="{{$basesite}}">Home</a><span>></span>
			<a href="{{$basesite}}labels">LABELS</a><span>></span>
			<a href="{{$basesite}}labels/select_{{$controller}}">{{strtoupper($controller)}} LABELS</a><span>></span>
			<a href="{{$basesite}}{{$controller}}/id_{{$getid}}">{{strtoupper($Brand->Name)}}</a>
		</div>
		<div class="headerBack">	
			<div class="boxcaptionHeader">
				<div class="logo_1">
					<img src="{{$basesite}}assets/frontend/images/content/brand/{{$Brand->Logo}}" class="img1">
				</div>
				<div class="logo_2">
					{{$Brand->TitleUnFeature}}
				</div>
				<div class="desc">
					{{$Brand->Note}}
				</div>
				<div class="contact_us">
					<div>CONTACT US :</div>
					<div class="boxConnectWith after_clear">
						<div><a href="javascript:;" id="sendmessage"><img src="{{$basesite}}assets/frontend/images/material/ico_msg_white.png"></a></div>
						@if(count($BrandSocialMedia))
						<div class="social">
							<ul class="after_clear">
								@foreach ($BrandSocialMedia as $obj)
			    				<li>
			    					<a href="{{$obj->Link}}">
			    						<span class="fa-stack fa-md" style="color:white;">
											<i class="fa fa-circle-thin fa-stack-2x"></i>
											<i class="{{$obj->Icon}} fa-stack-1x"></i>
										</span>
			    					</a>
			    				</li>
								@endforeach
			    			</ul>
						</div>
						@endif
					</div>
				</div>
			</div>	
			<div class="imgLabel">
				<img src="{{$basesite}}assets/frontend/images/content/brand/{{$Brand->Banner}}">
			</div>	
		</div>
		<div class="boxContentSale after_clear">
			<div class="boxFilter" id="boxFilter">			
				<div class="boxFavorit">
					<a id="btnfavorit" href="javascript:;" class="btn favorit @if(isset($CustomerFavoriteBrand->StatusFavorite) && $CustomerFavoriteBrand->StatusFavorite == 1) red @endif" onclick="setfavorite()">Favorite Labels</a>
				</div>			
			</div>
			<div class="boxSaleContent after_clear">
				<section class="spottab artist_tab">
					<div class="tabHorizontalArtist">
						<div class="after_clear nav_tab">
							<a href="{{$basesite}}{{$controller}}/id_{{$getid}}">COLLECTIONS</a>
							<a href="{{$basesite}}{{$controller}}-feedback/id_{{$getid}}">FEEDBACK</a>
							<a href="{{$basesite}}{{$controller}}-about-us/id_{{$getid}}" class="active">ABOUT US</a>
						</div>
						<div class="resp-tabs-container">
							<div class="activecontent">
								@include('frontend1.tab_unfeature_aboutus')
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	function setfavorite() {
		$.ajax({
            url         : '{{$basesite}}feature/ajaxpost',
            type        : 'POST',
            data        : {'ajaxpost':"setfavorite",'_token':'{{csrf_token()}}','ID':'{{$getid}}'},
            success     : function(data) {
                var data = JSON.parse(data);
                
                if(data['response'] == 'OK' || data['response'] == 'CANCEL') {
					if(data['response'] == 'OK') {
						$('#btnfavorit').addClass('red');
					} else {
						$('#btnfavorit').removeClass('red');
					}
                } else {
                	$('#popup .titlenew').contents()[0].nodeValue = 'Daftar atau Login';

					var contentnew = 
					'<div class="boxFormInline register after_clear" style="width: 100%; margin-top: 0px;"><div class="form-group">' +
						'<div class="control-label colorred">' + data['response'] + '</div>' +
					'</div>' +
				    '<div class="form-group">' +
						'<button id="btnok" class="btn black" style="top: auto;">OK</button> <button id="btncancel" class="btn white" style="top: auto;">Cancel</button>' +
					'</div></div>';

					$('#popup .contentnew').css('height', 'auto');
					$('#popup .contentnew').html(contentnew);

        			openPopup('popup');

        			$("#btnok").on('click', function() { window.location.href = '{{$basesite}}login'; });
        			$("#btncancel").on('click', function() { closePopup('popup'); });
                }
            }
        });
	}

	$('#search_link').hideseek({
        highlight: true,
        nodata: 'No results found',
    });
    $('#search_link2').hideseek({
        highlight: true,
        nodata: 'No results found',
    });
    $('#search_categories').hideseek({
        highlight: true,
        nodata: 'No results found',
    });	
//open pop up filter on mobile
$(".boxNewFilterLink").each(function(){
    $("ul").on("click", "a", function(){

            var content = $(this).attr("data-id");
	
	    	console.log(content);
	    	$(".overlay_filter").show();

            TweenLite.set("#"+content, {
		        'opacity': '0',
		        'display': "inherit",
		        'visibility': "visible",
		        'scale': '0.9'
		    });
            TweenLite.to("#"+content, 0.3, {
		        css: {            
		            'opacity': '1',
		            'scale': '1'
		        },
		        delay: 0.1,
		        ease: Quart.easeOut
		    }); 
    });
});
$(".overlay_filter").click(function(){
	$(this).hide();
		TweenLite.to("#pop_sort, #boxFilter", 0.3, {
	        css: {        
		        'display': "none",
		        'visibility': "hidden",
	            'opacity': '0',
	            'scale': '0.9'           
	        },
	        delay: 0,
	        ease: Quart.easeOut
	    });	
});

$(".boxBatalSort").on("click", "a", function(){
	$(".overlay_filter").hide();
		TweenLite.to("#pop_sort", 0.3, {
	        css: {        
		        'display': "none",
		        'visibility': "hidden",
	            'opacity': '0',
	            'scale': '0.9'           
	        },
	        delay: 0,
	        ease: Quart.easeOut
	    });
});
$("#sendmessage").on("click", function() {
	var $title = $(this).attr("data-title");

	var idPop = $("#popup-message"),
    	contentPop = idPop.find('.box-popup'),
   	 	titlePop = idPop.find('.tp');  

   	$(titlePop).html($title);

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
});
</script>