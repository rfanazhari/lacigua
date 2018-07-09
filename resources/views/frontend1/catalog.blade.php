<style type="text/css">
	@php $BannerModelType = 'Banner'.ucwords(strtolower($ModelType)); @endphp
	@php $TextModelType = 'Text'.ucwords(strtolower($ModelType)); @endphp
	@if($Setting->$BannerModelType)
	section.sale.catalog .headerBack {
		background: url('{{$basesite}}assets/frontend/images/content/settings/{{$Setting->$BannerModelType}}') no-repeat;
	}
	@endif
	section.sale.catalog .headerBack .captIsi .headerBackMenu {
		width: auto;
		text-align: center;
		margin: 0 auto;
		display: table;
	}
	section.sale .boxContentSale .gallery_spot .slider_gallery.catalog .slide li .img-hover {
		z-index: 1;
	}
	section.sale .boxContentSale .gallery_spot .slider_gallery .slide li a .label_new {
		z-index: 2;
	}
	section.sale .boxContentSale .gallery_spot .slider_gallery .slide li a .label_sale {
		z-index: 2;
	}
	section.sale .boxContentSale .gallery_spot .slider_gallery.catalog .slide li a .boxText .title {
		width: 100%;
	}
	section.sale .boxContentSale .gallery_spot .slider_gallery .slide li a .boxText .desc .detail {
		width: 160px;
	}
	section.sale .boxContentSale .gallery_spot .slider_gallery .slide li a .boxText .price .price-coret {
		float: right;
	}
	section.sale .boxContentSale .gallery_spot .title {
		text-align: left;
		letter-spacing: 0px;
	}
</style>
<section class="sale catalog labels produk">
	<div class="wrapper" style="">
		<div class="breadcrumb">
			<a href="{{$basesite}}">HOME</a><span>></span>
			<a href="{{$basesite}}{{strtolower($ModelType)}}">{{$ModelType}}</a><span>></span>
			<a href="{{$basesite}}{{strtolower($ModelType)}}/detail">DETAIL</a>
			@if(isset($getselect))
			<span>></span>
			<a href="javascript:;">WHAT'S NEW</a>
			@elseif(isset($getfind) and count($getfind) == 1)
			<span>></span>
			<a href="javascript:;">{{$Category[0]->Name}}</a>
			@endif
		</div>
		<div class="headerBack">
			<div class="captIsi">
				<div class="title">{{$ModelType}}</div>
				<div class="desc">{{$Setting->$TextModelType}}</div>
				<ul class="headerBackMenu after_clear">
					<li><a href="{{$basesite}}{{strtolower($ModelType)}}/detail/select_new-arrivals" @if(isset($getselect) and $getselect == 'new-arrivals')class="active"@endif>What's New</a></li>
					@foreach($ArrayCategorySubHeader as $obj)
					@php
					$tmpgetcategory = '';
					if(count($obj->_child)) {
						$tmpgetcategory .= '[';
						foreach ($obj->_child as $vals) {
							$tmpgetcategory .= $vals->ID.',';
						}
						$tmpgetcategory = rtrim($tmpgetcategory, ',');
						$tmpgetcategory .= ']';
					}
					@endphp
					<li><a href="{{$basesite}}{{strtolower($ModelType)}}/detail/category_[{{$obj['ID'].$tmpgetcategory}}]" @if(isset($getcategory) and count($getcategory) == 1 and $getcategory[0]['category'] == $obj['ID'])class="active"@endif>{{$obj->Name}}</a></li>
                    @endforeach
				</ul>	
			</div>
		</div>
		<div class="boxNewFilterLink" style="display: none;">
			<ul class="after_clear">
				<li><a href="javascript:;" class="filter" data-id="boxFilter">Filter Categories</a></li>
				<li><a href="javascript:;" class="sort" data-id="pop_sort">Sort</a></li>
			</ul>
		</div>
		<div class="overlay_filter" style="display: none;" data-id="boxFilter"></div>
		<div class="boxNewSort" style="display: none;"  id="pop_sort">
			<div class="boxNewSort1">
				<div class="title">Sort</div>
				<ul>
					@foreach($ArraySort as $key => $val)
					<option value="{{$basesite}}{{$inv->parseextlink($extlink, 'sort', $key)}}" @if($getsort == $key) selected @endif >{{$val}}</option>
                    @endforeach
				</ul>				
			</div>
			<div class="boxBatalSort">
				<a href="javascript:;">Batal</a>
			</div>
		</div>
		@if(isset($result['data']))
		<div class="boxPaginationSale top after_clear">
			<div class="boxSummarySale">
				<span class="label">SHOWING :</span> 
				<span class="text">1 - {{$getview}} of {{$result['total']}}</span>
			</div>
			<div class="boxSummarySale">
				<span class="label">VIEW :</span> 
				@foreach($ArrayShow as $obj)
				<span class="show_view"><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'view', $obj)}}" @if($getview == $obj) class="active" @endif >{{$obj}}</a></span>
                @endforeach
			</div>
			<div class="boxSummarySale">
				<span class="label">SORT :</span>
				<span class="select">
					<select class="select2 nosearch" onchange="window.location.href=this.value">
						@foreach($ArraySort as $key => $val)
						<option value="{{$basesite}}{{$inv->parseextlink($extlink, 'sort', $key)}}" @if($getsort == $key) selected @endif >{{$val}}</option>
	                    @endforeach
					</select>					
				</span> 
			</div>
			<div class="boxSummarySale">
				{!!$result['pagination']!!}
			</div>
		</div>
		@endif
		<div class="boxContentSale after_clear">
			<div class="boxFilter" id="boxFilter">
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
											@php $subcategoryurl = $inv->parseextlink($extlink, 'category', 'check'.$obj['ID'].'['.$objlast['ID'].']') @endphp
											<input id="checkboxchild-{{$objlast['ID']}}" class="checkbox-custom" name="checkboxchild-{{$objlast['ID']}}" type="checkbox" onclick="window.location.href = '{{$basesite}}{{$subcategoryurl}}'" @if(is_numeric($keycategory) && isset($getcategory[$keycategory]['subcategory']) && in_array($objlast['ID'], $getcategory[$keycategory]['subcategory'])) checked @endif>
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
					<li><a href="javsript:void(0)" class="link_drop">LABELS</a>
						<div class="contentMenuDrop after_clear">
							<div class="textSearch">
								<input type="search" id="search_link" name="search" placeholder="Search Labels" data-list=".listLink">
							</div>
							<div class="linkIsi listLink">
								@foreach($ArrayBrand as $obj)
								<div>
									<a href="javascript:;">
										<div class="form-group">
											@php $labelsurl = $inv->parseextlink($extlink, 'labels', $obj['permalink']) @endphp
											<input id="checkbox_label-{{$obj['permalink']}}" class="checkbox-custom" name="checkbox_label-{{$obj['permalink']}}" type="checkbox" onclick="window.location.href = '{{$basesite}}{{$labelsurl}}'" @if(isset($getlabels) && in_array($obj['permalink'], array_column($getlabels, 'labels'))) checked @endif>
											<label for="checkbox_label-{{$obj['permalink']}}" class="checkbox-custom-label">
												<span class="img"></span>
												{{$obj['Name']}}
											</label>
									    </div>
									</a>
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
				<div class="gallery_spot">
					<div class="slider_gallery catalog">
						<ul class="slide after_clear">
							@if(isset($result['data']))
							@foreach($result['data'] as $obj)
							@php
								$ProductName = $inv->_cutstring(strip_tags($obj['NameShow']), 21);
								$ProductDesc = $inv->_cutstring(strip_tags($obj['Description']), 55);
							@endphp
							<li>
								@if(!$obj['TypeProduct'])
								<a href="{{$basesite}}product-detail/id_{{$obj['permalink']}}">
								@else
								<a href="{{$basesite}}product-beauty/id_{{$obj['permalink']}}">
								@endif
									@if($obj['StatusNew'] == 1)
									<div class="label_new"></div>
									@elseif($obj['StatusSale'] == 1)
									<div class="label_sale"></div>
									@endif
									<img src="{{$basesite}}assets/frontend/images/content/product/medium_{{$obj['Image1']}}">
									<img src="{{$basesite}}assets/frontend/images/content/product/medium_{{$obj['Image2']}}" class="img-hover">
									<div class="boxText">
										<div class="title">{{$ProductName}}</div>
										<div class="desc">
											<div class="detail">
												{{$ProductDesc}}
											</div>
											<!--
												<span class="diskon satu">
													<span>20%<br/>OFF</span>
												</span>
												<span class="diskon dua">
													<span>+5%</span>
												</span>
											-->
										</div>
										@if($obj['StatusSale'] == 1)
										<div class="price">
											{{$inv->_formatamount($obj['SalePrice'], 'Rupiah', 'IDR ')}}
											<span class="price-coret">{{$inv->_formatamount($obj['SellingPrice'], 'Rupiah', 'IDR ')}}</span>
										</div>
										@else
										<div class="price default">
											{{$inv->_formatamount($obj['SellingPrice'], 'Rupiah', 'IDR ')}}
										</div>
										@endif
									</div>
								</a>
							</li>
		                    @endforeach
		                    @else
		                    <h4 class="colorred">PRODUCTS not found !</h4>
		                    @endif
						</ul>
					</div>
				</div>
				@if(isset($result['data']))
				<div class="boxPaginationSale after_clear">
					<div class="boxSummarySale">
						<span class="label">SHOWING :</span> 
						<span class="text">1 - {{$getview}} of {{$result['total']}}</span>
					</div>
					<div class="boxSummarySale">
						<span class="label">VIEW :</span> 
						@foreach($ArrayShow as $obj)
						<span class="show_view"><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'view', $obj)}}" @if($getview == $obj) class="active" @endif >{{$obj}}</a></span>
		                @endforeach
					</div>
					<div class="boxSummarySale">
						{!!$result['pagination']!!}
					</div>
				</div>
				@endif
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
	        url         : '{{$basesite}}{{strtolower($ModelType)}}/ajaxpost',
	        type        : 'POST',
	        data        : {'ajaxpost':"pricerange",'_token':'{{csrf_token()}}','extlink':'{{$extlink}}','pricerange':values[0].replace('.','')+'-'+values[1].replace('.','')},
	        success     : function(data) {
	            window.location.href = "{{$basesite}}"+data;
	        }
	    });
	});

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
</script>
<!-- end of middle -->