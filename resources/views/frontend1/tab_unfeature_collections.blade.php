<style type="text/css">
	section.sale .boxContentSale .gallery_spot .slider_gallery.catalog .slide li .img-hover {
		z-index: 1;
	}
	section.sale .boxContentSale .gallery_spot .slider_gallery .slide li a .soldout {
		z-index: 2;
	}
	section.sale .boxContentSale .gallery_spot .slider_gallery .slide li a .label_new {
		z-index: 2;
	}
	section.sale .boxContentSale .gallery_spot .slider_gallery .slide li a .label_sale {
		z-index: 2;
		margin-top: 15px;
	    width: 44px;
	    height: 21px;
	    position: absolute;
    	background: url({{$basesite}}assets/frontend/images/material/label_sale.png) no-repeat;
    	background-size: 44px 21px;
	    border: 1px solid #979797;
	}
	section.sale .boxContentSale .gallery_spot .title {
		font-family: "robotomedium";
	    font-size: 28px;
	    text-align: center;
	    color: #111111;
	    letter-spacing: 2px;
	    margin-bottom: 30px;
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
	section.sale .boxContentSale .gallery_spot .title.center {
		text-align: center;
	}
	section.sale .boxContentSale .catalognew {
		border-bottom: 1px solid #000;
    	padding: 0px;
	}
</style>
@if(count($ArrayProductNew))
<div class="gallery_spot">
	<div class="slider_gallery catalog catalognew">
		<div class="title center">WHAT'S NEW</div>
		<ul class="slide after_clear">
			@foreach($ArrayProductNew as $obj)
			<li>
				@if(!$obj['TypeProduct'])
				<a href="{{$basesite}}product-detail/id_{{$obj['permalink']}}">
				@else
				<a href="{{$basesite}}product-beauty/id_{{$obj['permalink']}}">
				@endif
					<img src="{{$basesite}}assets/frontend/images/content/product/medium_{{$obj['Image1']}}">
					<img src="{{$basesite}}assets/frontend/images/content/product/medium_{{$obj['Image2']}}" class="img-hover">
				</a>
			</li>
			@endforeach
		</ul>
	</div>
</div>
@endif
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
		{!!$result['pagination']!!}
	</div>
</div>
@endif
<div class="gallery_spot">
	<div class="slider_gallery catalog">
		<ul class="slide after_clear">
			@if(isset($result['data']))
			@foreach($result['data'] as $obj)
			@php
				$ProductName = $inv->_cutstring(strip_tags($obj['Name']), 21);
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
<script type="text/javascript">
	$(".feature .slide").on("click", "li a", function(){
		var $title = $(this).attr("data-title"),
			$img = $(this).attr("data-large-src");


		var idPop = $("#popup-image"),
        	contentPop = idPop.find('.box-popup'),
        	contentImg = idPop.find('.content .imgDisplay'),
       	 	titlePop = idPop.find('.tp');  

       	$(titlePop).html($title);
       	$(contentImg).attr("src", $img)

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