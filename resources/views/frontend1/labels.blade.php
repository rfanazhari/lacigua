<style type="text/css">
	@if($Setting->BannerLabels)
	section.sale.catalog .headerBack {
		background: url('{{$basesite}}assets/frontend/images/content/settings/{{$Setting->BannerLabels}}') no-repeat;
	}
	@endif
</style>
<section class="sale catalog labels">
	<div class="wrapper" style="">
		<div class="breadcrumb">
			<a href="{{$basesite}}">Home</a><span>></span>
			<a href="{{$basesite}}labels">LABELS</a>
		</div>
		<div class="headerBack">
			<div class="captIsi">
				<div class="title">LABELS</div>
				<div class="desc">{{$Setting->TextLabels}}</div>
				<a href="javascript:;" class="btn find_labels" style="display: none;" data-id="pop_labels">Find Labels</a>
				<div class="headerNewBackMenu" style="display: none;"  id="pop_labels">
					<div class="boxNewSort1">
						<div class="title">Labels</div>
						<ul>
							<li><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'select', '')}}">ALL LABELS</a></li>
							<li><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'select', 'feature')}}">FEAUTURE LABELS</a></li>
							<li><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'select', 'artist')}}">ARTIST LABELS</a></li>
							<li><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'select', 'indie')}}">INDIE LABELS</a></li>
						</ul>				
					</div>
					<div class="boxBatalSort">
						<a href="javascript:;">Batal</a>
					</div>
				</div>
				<ul class="headerBackMenu after_clear">
					<li><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'select', '')}}" @if(!isset($getselect))class="active"@endif>ALL LABELS</a></li>
					<li><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'select', 'feature')}}" @if(isset($getselect) && $getselect == 'feature')class="active"@endif>FEAUTURE LABELS</a></li>
					<li><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'select', 'artist')}}" @if(isset($getselect) && $getselect == 'artist')class="active"@endif>ARTIST LABELS</a></li>
					<li><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'select', 'indie')}}" @if(isset($getselect) && $getselect == 'indie')class="active"@endif>INDIE LABELS</a></li>
				</ul>
				<ul class="tabMenu after_clear">
					<li><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'filter', '')}}" @if(!isset($getfilter))class="active"@endif>ALL</a></li>
					<li><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'filter', 'top-rated')}}" @if(isset($getfilter) && $getfilter == 'top-rated')class="active"@endif>TOP RATED</a></li>
					<li><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'filter', 'new')}}" @if(isset($getfilter) && $getfilter == 'new')class="active"@endif>NEW</a></li>
				</ul>
			</div>
		</div>
		@if(isset($result['data']))
		<div class="boxNewFilterLink" style="display: none;">
			<ul class="after_clear">
				<li><a href="javascript:;" class="filter" data-id="boxFilter">Filter Categories</a></li>
				<li><a href="javascript:;" class="sort" data-id="pop_sort">Sort</a></li>
			</ul>
		</div>
		@endif
		<div class="overlay_filter" style="display: none;" data-id="boxFilter"></div>
		<div class="boxNewSort" style="display: none;"  id="pop_sort">
			<div class="boxNewSort1">
				<div class="title">Sort</div>
				<ul>
					@foreach($ArraySort as $key => $val)
					<li><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'sort', $key)}}">{{$val}}</a></li>
                    @endforeach
				</ul>				
			</div>
			<div class="boxBatalSort">
				<a href="javascript:;">Batal</a>
			</div>
		</div>
		<div class="boxPaginationSale top after_clear">
			@if(isset($result['data']))
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
				<span class="select type_2">
					<select name="sort" class="select2" onchange="window.location.href=this.value">
						@foreach($ArraySort as $key => $val)
						<option value="{{$basesite}}{{$inv->parseextlink($extlink, 'sort', $key)}}" @if($getsort == $key) selected @endif >{{$val}}</option>
	                    @endforeach
					</select>
				</span> 
			</div>
			<div class="boxSummarySale">
				{!!$result['pagination']!!}
			</div>
			@endif
		</div>
		<div class="boxContentSale after_clear">
			<div class="boxFilter" id="boxFilter">
				<ul class="linkMenu">
					<li><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'main', '')}}">VIEW ALL</a></li>
					<li><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'main', 'women')}}">WOMEN</a></li>
					<li><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'main', 'men')}}">MEN</a></li>
					<li><a href="{{$basesite}}{{$inv->parseextlink($extlink, 'main', 'kids')}}">KIDS</a></li>
				</ul>
				<ul class="linkMenuDrop">
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
				</ul>
			</div>
			<div class="boxSaleContent after_clear">
				<div class="gallery_spot">
					<div class="slider_gallery labels">
						<ul class="slide after_clear">
							@if(isset($result['data']))
							@foreach($result['data'] as $obj)
							@php
								$Mode = '';
								if($obj['Mode'] == 0) $Mode = 'feature';
								if($obj['Mode'] == 1) $Mode = 'artist';
								if($obj['Mode'] == 2) $Mode = 'indie';
							@endphp
							<li>
								<div class="boxBackImg">
									<div class="boxCaption">
										<a href="{{$basesite}}{{$Mode}}/id_{{$obj['permalink']}}">{{$obj['Name']}}</a>
									</div>
								</div>
								<img src="{{$basesite}}assets/frontend/images/content/brand/{{$obj['Icon']}}">
							</li>
		                    @endforeach
		                    @else
		                    <h4 class="colorred">LABELS not found !</h4>
		                    @endif
						</ul>
					</div>
				</div>
				<div class="boxPaginationSale after_clear" style="margin-top: 0px;">
					@if(isset($result['data']))
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
					@endif
				</div>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
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
$(".boxNewFilterLink").each(function() {
	$("ul").on("click", "a", function() {
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
	TweenLite.to("#pop_sort, #boxFilter, #pop_labels", 0.3, {
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

$(".find_labels").click(function(){

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

$(".boxBatalSort").on("click", "a", function(){
	$(".overlay_filter").hide();
		TweenLite.to("#pop_sort, #pop_labels", 0.3, {
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
