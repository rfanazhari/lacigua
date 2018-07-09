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
						<div><a href="javascript:;" id="sendmessage" style="margin-top: -1px !important;"><img src="{{$basesite}}assets/frontend/images/material/ico_msg_white.png"></a></div>
						@if(count($BrandSocialMedia))
						<div class="social" style="float: left; margin-top: -3px !important; padding-left: 11px !important;">
							<ul class="after_clear">
								@foreach ($BrandSocialMedia as $obj)
								<style type="text/css">.new{{$obj['ID']}} { background: url({{$basesite}}assets/frontend/images/content/iconsocialmedia/{{$obj['IconSocialMediaImageHover']}}) no-repeat center center; width:33px !important; height:auto !important; border-radius:0px !important;}</style>
                        		<li><a href="{{$obj['Link']}}" target="_blank" class="new{{$obj['ID']}}">{{$obj['Name']}}</a></li>
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
		<div class="boxNewFilterLink" style="display: none;">
			<ul class="after_clear">
				<li><a href="javascript:;" class="filter" data-id="boxFilter">Filter Categories</a></li>
			</ul>
		</div>
		<div class="overlay_filter" style="display: none;" data-id="boxFilter"></div>
		<div class="boxContentSale after_clear">
			<div class="boxFilter" id="boxFilter">
				<div class="boxFavorit">
					<a id="btnfavorit" href="javascript:;" class="btn favorit @if(isset($CustomerFavoriteBrand->StatusFavorite) && $CustomerFavoriteBrand->StatusFavorite == 1) red @endif" onclick="setfavorite()">Favorite Labels</a>
				</div>
				<ul class="linkMenu">
					<li><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'main', '')}}">VIEW ALL</a></li>
					<li><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'main', 'women')}}">WOMEN</a></li>
					<li><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'main', 'men')}}">MEN</a></li>
					<li><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'main', 'kids')}}">KIDS</a></li>
				</ul>
				<ul class="linkMenuDrop">
					<li><a href="javsript:void(0)" class="link_drop">CATEGORIES</a>
						<div class="contentMenuDrop after_clear">
							<div class="linkIsi listLink_categories">
								@foreach($ArrayCategory as $obj)
								<div>
									<div class="form-group">
										<a href="javascript:;" class="haschild">
										@php

										$checkchild = false;
										$subcategory = '';
										$keycategory = '';
										if(isset($obj['_child']) and count($obj['_child'])) {
											$checkchild = true;
											$subcategory = '['.implode(',',array_column($obj['_child'], 'ID')).']';
											if(isset($getcategory))
												$keycategory = array_search($obj['ID'], array_column($getcategory, 'category'));
										}

										$categoryurl = $inv->parseextlink($extlink, 'category', $obj['ID'].$subcategory);

										@endphp
										<input id="checkbox-{{$obj['ID']}}" class="checkbox-custom" name="{{$obj['ID']}}" type="checkbox" onclick="window.location.href = '{{$basesite}}{{$categoryurl}}'" @if(isset($getcategory) && in_array($obj['ID'], array_column($getcategory, 'category'))) checked @endif>
										<label for="checkbox-{{$obj['ID']}}" class="checkbox-custom-label @if(isset($getcategory) && in_array($obj['ID'], array_column($getcategory, 'category'))) active @endif" data-child="child_{{$obj['ID']}}">
											@if($checkchild)<span class="opr">+</span>@endif
											<span class="img"></span>
											{{$obj['Name']}}
										</label>
										</a>
									</div>
									@if($checkchild)
									<div class="childCategories" id="child_{{$obj['ID']}}" @if(isset($getcategory) && in_array($obj['ID'], array_column($getcategory, 'category'))) style="display:block;" @endif>
										@foreach($obj['_child'] as $objlast)
										<div class="form-group">
											<a href="javascript:;" class="haschild">
											@php $subcategoryurl = $inv->parseextlink($extlink, 'category', $obj['ID']) @endphp
											<input id="checkboxchild-{{$objlast['ID']}}" class="checkbox-custom" name="checkboxchild-{{$objlast['ID']}}" type="checkbox" @if(is_numeric($keycategory) && isset($getcategory[$keycategory]['subcategory']) && in_array($objlast['ID'], $getcategory[$keycategory]['subcategory'])) checked @endif>
											<label for="checkboxchild-{{$objlast['ID']}}" class="checkbox-custom-label">
												<span class="img"></span>
												{{$objlast['Name']}}
											</label>
											</a>
										</div>
			                    		@endforeach
									</div>
									@endif
								</div>
			                    @endforeach
							</div>
						</div>
					</li>
					<li><a href="javsript:void(0)" class="link_drop">STYLE</a>
						<div class="contentMenuDrop after_clear">
							<div class="linkIsi listLink2">
								@foreach($ArrayStyle as $obj)
								<div class="form-group">
									@php $styleurl = $inv->parseextlink($extlink, 'style', $obj['permalink']) @endphp
									<input id="checkbox_style-{{$obj['permalink']}}" class="checkbox-custom" name="checkbox_style-{{$obj['permalink']}}" value="{{$obj['permalink']}}" type="checkbox" onclick="window.location.href = '{{$basesite}}{{$styleurl}}'" @if(isset($getstyle) && in_array($obj['permalink'], array_column($getstyle, 'style'))) checked @endif>
									<label for="checkbox_style-{{$obj['permalink']}}" class="checkbox-custom-label">
										<span class="img"></span>
										{{$obj['Name']}}
									</label>
							    </div>
			                    @endforeach
							</div>
						</div>
					</li>
					<li><a href="javsript:void(0)" class="link_drop">COLOUR</a>
						<div class="contentMenuDrop after_clear">
							<div class="linkIsi listLink_search" style="height: 180px;">
								<ul class="boxcolour">
									@foreach($ArrayColor as $obj)
									<li @if(isset($getcolour) && in_array($obj['permalink'], array_column($getcolour, 'colour'))) style="border: 1px solid #BBBBBB;" @endif><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'colour', $obj['permalink'])}}" style="background-color: {{$obj['Hexa']}};"></a></li>
				                    @endforeach
								</ul>
							</div>
						</div>
					</li>
					<li>
						<div class="boxSliderPrice">
							<div class="label">PRICE
								<span>IDR</span>
							</div>
							<div id="slider-price-step"></div>	
							<div class="boxSliderlbl">
								<span id="slider-snap-value-lower">0</span>
								<span id="slider-snap-value-upper">10000K</span>
							</div>
							<input type="text" name="pricestart" value="{{explode('-', $getprice)[0]}}" style="display: none;">
							<input type="text" name="priceend" value="{{explode('-', $getprice)[1]}}" style="display: none;">
						</div>
					</li>
				</ul>
			</div>
			<div class="boxSaleContent after_clear">
				<section class="spottab artist_tab">
					<div class="tabHorizontalArtist">
						<div class="after_clear nav_tab">
							<a href="{{$basesite}}{{$controller}}/id_{{$getid}}" class="active">COLLECTIONS</a>
							<a href="{{$basesite}}{{$controller}}-feedback/id_{{$getid}}">FEEDBACK</a>
							<a href="{{$basesite}}{{$controller}}-about-us/id_{{$getid}}">ABOUT US</a>
						</div>
						<div class="resp-tabs-container">
							<div class="activecontent">
								@include('frontend1.tab_unfeature_collections')
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	var snapSlider = document.getElementById('slider-price-step');

	var snapValues = [
		document.getElementById('slider-snap-value-lower'),
		document.getElementById('slider-snap-value-upper')
	];

	noUiSlider.create(snapSlider, {
		start: [ $('[name="pricestart"]').val(), $('[name="priceend"]').val() ],
		// snap: true,
		connect: true,
		range: {
			'min': 0,
			'10%': 1000,
			'20%': 2000,
			'30%': 3000,
			'40%': 4000,
			'50%': 5000,
			'60%': 6000,
			'70%': 7000,
			'80%': 8000,
			'90%': 9000,
			'100%': 10000,
			'max': 10000
		},
		format: wNumb({
	        decimals: 0,
	        thousand: '.'
	    })
	});

	snapSlider.noUiSlider.on('update', function(values, handle) {
		snapValues[handle].innerHTML = values[handle]+"K";
	});

	snapSlider.noUiSlider.on('set', function(values, handle) {
		$.ajax({
	        url         : '{{$basesite}}feature/ajaxpost',
	        type        : 'POST',
	        data        : {'ajaxpost':"pricerange",'_token':'{{csrf_token()}}','extlink':'{{$extlink}}','pricerange':values[0].replace('.','')+'-'+values[1].replace('.','')},
	        success     : function(data) {
	            window.location.href = "{{$basesite}}"+data;
	        }
	    });
	});

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

	$(".boxNewFilterLink").each(function(){
		$("ul").on("click", "a", function(){
			var content = $(this).attr("data-id");
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

	$("#sendmessage").on("click", function(){
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