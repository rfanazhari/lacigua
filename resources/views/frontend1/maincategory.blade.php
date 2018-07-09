<style type="text/css">
	.bx-viewport, .bx-wrapper {
		z-index: 0;
	}
	.hidecaption {
		display: none;
	}
	section.story .slider.type_3 .boxFreeShip {
		z-index: 1;
		margin-top: -440px;
	}
	.bx-wrapper img {
	    display:block;
	    max-width: 100%;
	}
	section.story .wrapper_woman.type_2 .woman-outer .woman-1 {
		border: none;
	}
	section.story .wrapper_woman.type_3 .woman-outer .woman-1 .woman-1-Inner {
		width:270px;
	}
	section.story .wrapper_woman.type_3 .woman-outer .woman-1 .woman-1-Inner {
		margin-right:13px;
	}
	section.story .wrapper_woman.type_3 .woman-outer .woman-1 .woman-1-Inner:last-child {
		margin-right:0px;
	}
</style>
<section class="story woman">
	<div class="wrapper">
		<div class="slider type_3 woman after_clear" style="margin-top: 20px;">
			<div class="bxslider">
				@foreach($MainCategoryBanner['TOP'] as $obj)
				<div>
					<a href="@if($obj['BannerURL']){{$obj['BannerURL']}}@else javascript:;@endif">
						<div class="hidecaption">
							<div class="title">{{$obj['Title']}}</div>
							<div class="desc">
								{!!$obj['Note']!!}
							</div>
							<div class="bgcolor" style="display: none">{{$obj['BgColorNote']}}</div>
						</div>
		            	<img src="{{$basesite}}assets/frontend/images/content/maincategorybanner/{{$obj['Banner']}}" alt="slide1"/>
		        	</a>
				</div>
				@endforeach
			</div>
			<div class="boxFreeShip">
			@if($MainCategoryBanner['TOP'][0]['Title'])
				<div class="title">{{$MainCategoryBanner['TOP'][0]['Title']}}</div>
				<div class="desc">
					{!!$MainCategoryBanner['TOP'][0]['Note']!!}
				</div>
				<div class="bgcolor" style="display: none">{{$MainCategoryBanner['TOP'][0]['BgColorNote']}}</div>
			@endif
			</div>
		</div>

		<div class="wrapper_woman">
			<div class="woman-1 after_clear">
				<div class="woman-1-Inner">
					<a href="@if($MainCategoryBanner['LEFT'][0]['BannerURL']){{$MainCategoryBanner['LEFT'][0]['BannerURL']}}@else javascript:;@endif">
						<img src="{{$basesite}}assets/frontend/images/content/maincategorybanner/{{$MainCategoryBanner['LEFT'][0]['Banner']}}">
					</a>
				</div>
				<div class="woman-1-Inner">
					<a href="@if($MainCategoryBanner['RIGHT'][0]['BannerURL']){{$MainCategoryBanner['RIGHT'][0]['BannerURL']}}@else javascript:;@endif">
						<img src="{{$basesite}}assets/frontend/images/content/maincategorybanner/{{$MainCategoryBanner['RIGHT'][0]['Banner']}}">
					</a>
				</div>
			</div>
		</div>

		<div class="wrapper_woman type_2">
			<div class="woman-outer">
				<div class="woman-1 after_clear">
					<a href="@if($MainCategoryBanner['BOTTOM'][0]['BannerURL']){{$MainCategoryBanner['BOTTOM'][0]['BannerURL']}}@else javascript:;@endif">
						<img src="{{$basesite}}assets/frontend/images/content/maincategorybanner/{{$MainCategoryBanner['BOTTOM'][0]['Banner']}}">
					</a>
				</div>
			</div>
		</div>

		<div class="wrapper_woman type_3">
			<div class="woman-outer">
				<div class="woman-1 after_clear">
					<div class="title">SHOP BY FAVORITE CATEGORIES</div>
					@foreach($Category as $obj)
                    <div class="woman-1-Inner">
						<a href="{{$basesite}}{{strtolower($ModelType)}}/detail/category_[{{$obj['ID']}}@if(isset($obj['_child']))[{{implode(',', array_column($obj['_child'], 'ID'))}}]@endif]">
							<div class="hoverback">
								<div class="boxButton">
									{{$obj['Name']}}
								</div>
							</div>
							<img src="{{$basesite}}assets/frontend/images/content/category/{{$obj['CategoryImage']}}">
						</a>
					</div>
                    @endforeach
				</div>
			</div>
		</div>
	</div>
</section>