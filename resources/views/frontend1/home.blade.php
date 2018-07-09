<script src="{{$basesite}}assets/frontend/countdown/js/jquery.plugin.min.js"></script>
<script src="{{$basesite}}assets/frontend/countdown/js/jquery.countdown.js"></script>
<style type="text/css">
	section.banner .wrapper .boxPromo .time div {
		font-size: 35px;
	}
	@media (max-width: 1300px) and (min-width: 0px) {
		section.banner .wrapper .boxPromo .time div {
			font-size: 12px;
		}
	}
	section.banner .wrapper .boxPromo {
		border-radius: 50%;
	    -moz-border-radius: 50%;
	    -webkit-border-radius: 50%;
	    -o-border-radius: 50%;
	    margin-top: -50px;
	    padding-top: 50px;
	}
	section.spotlight .gallery_spot .slider_gallery .slide li .boxBackImg .boxCaption a {
		width: auto;
	}
	section.banner .slider .boxInfo .infoInner {
		margin-top: -20px;
		opacity: 1;
	}
	section.banner .slider .boxInfo {
		height: 0px;
		width: 200px;
		border-right: 40px solid transparent;
		background: none;
		opacity: 0.7;
	}
	section.banner .slider .boxInfo:hover {
		background: none;
	}
	.newlinkimg:hover {
		text-decoration: none;
	}
</style>
<section class="banner">
    <ul class="slider">
    	@foreach($SlidingBanner as $obj)
    	<li>
        	<a href="@if($obj['BannerURL']){{$obj['BannerURL']}}@else{{'javascript:;'}}@endif">
            	<div class="wrapper">
					<div class="boxPromo" @if($obj['BgColorNote']) style="background: {{$obj['BgColorNote']}};" @endif>
						@if($obj['Title'])
						<div class="title">
							{{$obj['Title']}}
						</div>
						@endif
						@if($obj['Text1'])
						<div class="text">
							{{$obj['Text1']}}
						</div>
						@endif
						@if($obj['SubTitle1'])
						<div class="subtitle">
							{{$obj['SubTitle1']}}
						</div>
						@endif
						@if($obj['Text2'])
						<div class="text">
							{{$obj['Text2']}}
						</div>
						@endif
						@if($obj['SubTitle2'])
						<div class="subtitle">
							{{$obj['SubTitle2']}}
						</div>
						@endif
			        	@if($obj['ShowTime'] == 1)
			        	<div id="BannerEnd" style="display: none;">{{$obj['BannerEnd']}}</div>
			        	<div id="noDays" class="time after_clear"></div>
			        	@endif
			        </div>
				</div>
            	<img src="{{$basesite}}assets/frontend/images/content/slidingbanner/{{$obj['Banner']}}"/>
        	</a>
      		@if($obj['BrandName'] || $obj['BrandBy'])
            <div class="boxInfo" @if($obj['BgColorNote2']) style="border-top: 40px solid {{$obj['BgColorNote2']}}; border-bottom: 40px solid {{$obj['BgColorNote2']}};" @else style="padding-top: 40px; padding-bottom: 40px;" @endif>
            	<a href="@if($obj['BannerURL']){{$obj['BannerURL']}}bbb@else javascript:;ccc @endif">
	            	<div class="infoInner">
	            		@if($obj['BrandName'])
						<div>{{$obj['BrandName']}}</div>
						@endif
	            		@if($obj['BrandBy'])
						<div>{{$obj['BrandBy']}}</div>
						@endif
	            	</div>            		
            	</a>
            </div>
            @endif
        </li>
    	@endforeach
    </ul>
</section>
<section class="spotlight">
	<div class="wrapper">
		<h1>CHECK OUR LABELS</h1>
		<p>
			Explore and browse our exclusive labels over 900 top rated label from artist to indie label,<br/>
			You can find all of your favourite style and the best outfitting right here in one easy to shop spot
		</p>
		@if($arrFeatured)
		<div class="gallery_spot">
			<div class="title">FEATURE LABELS</div>
			<div class="slider_gallery">
				<ul class="slide" id="slide1">
					@foreach($arrFeatured as $obj)
			    	<li>
						<div class="boxBackImg">
							<div class="boxCaption">
								<a href="{{$basesite}}feature/id_{{$obj['permalink']}}">{{$obj['Name']}}</a>
							</div>
						</div>
						<img src="{{$basesite}}assets/frontend/images/content/brand/{{$obj['Icon']}}" style="height: 464px;">
					</li>
			    	@endforeach
				</ul>
			</div>
		</div>
    	@endif
    	@if($arrArtist)
		<div class="gallery_spot">
			<div class="title">ARTIST LABELS</div>
			<div class="slider_gallery">
				<ul class="slide" id="slide2">
					@foreach($arrArtist as $obj)
			    	<li>
						<div class="boxBackImg">
							<div class="boxCaption">
								<a href="{{$basesite}}artist/id_{{$obj['permalink']}}" class="label2">{{$obj['Name']}} <div>{{$obj['TitleUnFeature']}}</div></a>
							</div>
						</div>
						<img src="{{$basesite}}assets/frontend/images/content/brand/{{$obj['Icon']}}" style="height: 464px;">
					</li>
			    	@endforeach
				</ul>
			</div>
		</div>
		@endif
		@if($arrIndie)
		<div class="gallery_spot">
			<div class="title">INDIE LABELS</div>
			<div class="slider_gallery">
				<ul class="slide" id="slide3">
					@foreach($arrIndie as $obj)
			    	<li>
						<div class="boxBackImg">
							<div class="boxCaption">
								<a href="{{$basesite}}indie/id_{{$obj['permalink']}}" class="label2">{{$obj['Name']}} <div>{{$obj['TitleUnFeature']}}</div></a>
							</div>
						</div>
						<img src="{{$basesite}}assets/frontend/images/content/brand/{{$obj['Icon']}}" style="height: 464px;">
					</li>
			    	@endforeach
				</ul>
			</div>
		</div>
		@endif
	</div>
</section>
<section class="spottab maintab">
	<div class="wrapper">
		<div id="parentHorizontalTab">
			<ul class="resp-tabs-list hor_1">
				<li>NEW ARRIVAL</li>
				<li>MOST RATED</li>
				<li>BACK IN STOCK</li>
			</ul>
			<div class="resp-tabs-container hor_1">
				<div>
					<div class="boxGalleryTab after_clear">
					@if(count($arrProductNew))
						@foreach($arrProductNew as $obj)
						@if(!$obj['TypeProduct'])
						<a href="{{$basesite}}product-detail/id_{{$obj['permalink']}}" class="newlinkimg" style="margin-right: 8px;">
						@else
						<a href="{{$basesite}}product-beauty/id_{{$obj['permalink']}}" class="newlinkimg" style="margin-right: 8px;">
						@endif
							<img src="{{$basesite}}assets/frontend/images/content/product/medium_{{$obj['Image1']}}" width="230">
						</a>
						@endforeach
					@endif
					</div>
					<div class="buttonGo">
						<a href="{{$basesite}}women/detail/select_new-arrivals" class="btn medium arrow">SHOP NEW ARRIVAL</a>
					</div>
				</div>	
				<div>
					<div class="boxGalleryTab after_clear">
					@if(count($arrProductMost))
						@foreach($arrProductMost as $obj)
						@if(!$obj['TypeProduct'])
						<a href="{{$basesite}}product-detail/id_{{$obj['permalink']}}" class="newlinkimg" style="margin-right: 8px;">
						@else
						<a href="{{$basesite}}product-beauty/id_{{$obj['permalink']}}" class="newlinkimg" style="margin-right: 8px;">
						@endif
							<img src="{{$basesite}}assets/frontend/images/content/product/medium_{{$obj['Image1']}}" width="230">
						</a>
						@endforeach
					@endif
					</div>
					<div class="buttonGo">
						<a href="{{$basesite}}women/detail/sort_most-wanted" class="btn medium arrow">SHOP MOST RATED</a>
					</div>
				</div>
				<div>
					<div class="boxGalleryTab after_clear">
					@if(count($arrProductBack))
						@foreach($arrProductBack as $obj)
						@if(!$obj['TypeProduct'])
						<a href="{{$basesite}}product-detail/id_{{$obj['permalink']}}" class="newlinkimg" style="margin-right: 8px;">
						@else
						<a href="{{$basesite}}product-beauty/id_{{$obj['permalink']}}" class="newlinkimg" style="margin-right: 8px;">
						@endif
							<img src="{{$basesite}}assets/frontend/images/content/product/medium_{{$obj['Image1']}}" width="230">
						</a>
						@endforeach
					@endif
					</div>
					<div class="buttonGo">
						<a href="{{$basesite}}catalog" class="btn medium arrow">SHOP BACK IN STOCK</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@if($arrIndie)
<section class="my_style">
	<div class="wrapper">
		<h1>WHAT'S IS YOUR STYLE?</h1>
		<p>
			You can find all of our favourite style from our label with full of fun inspiration. Whether you want to shop <br/>
			the latest collection, our feature labels or the hottest trends of the week. <br/>
			Our Labels will satisfied your pasion of fashion!
		</p>
	</div>
	<div class="gallery_spot">
		<div class="slider_gallery type2 style">
			<ul class="slide" id="slide_type2">
				@foreach($arrStyle as $obj)
				<li>
					<div class="boxBackImg">
						<div class="boxCaption">
							<a href="{{$basesite}}labels/style_[{{$obj['permalink']}}]">{{$obj['Name']}}</a>
						</div>
					</div>
					<img src="{{$basesite}}assets/frontend/images/content/style/{{$obj['StyleImage']}}" style="height: 464px;">
				</li>
		    	@endforeach
			</ul>
		</div>
	</div>
</section>
@endif
<section class="insta">
	<div class="wrapper">
		<div class="title">SEEN IT ON INSTAGRAM?</div>
		<div class="subtitle">SHOP IT RIGHT HERE...</div>	
		<div class="boxInstaGallery after_clear">
			<div>
				<a href="{{$basesite}}label">
					<img src="{{$basesite}}assets/frontend/images/content/insta-1.png">				
				</a>
			</div>
			<div>
				<a href="{{$basesite}}label">
					<img src="{{$basesite}}assets/frontend/images/content/insta-2.png">				
				</a>
			</div>
			<div>
				<a href="{{$basesite}}label">
					<img src="{{$basesite}}assets/frontend/images/content/insta-3.png">				
				</a>
			</div>
			<div>
				<a href="{{$basesite}}label">
					<img src="{{$basesite}}assets/frontend/images/content/insta-4.png">				
				</a>
			</div>
			<div>
				<a href="{{$basesite}}label">
					<img src="{{$basesite}}assets/frontend/images/content/insta-5.png">				
				</a>
			</div>
		</div>
		<div class="buttonGo">
			<a href="{{$basesite}}label" class="btn medium arrow">SHOP OUR INSTA EDIT</a>
		</div>
	</div>
</section>
<section class="my_style">
	<div class="wrapper">
		<h1>WHAT'S ON</h1>
		<p>Be the first to know the hottest fashion trends and event full of fun inspiration</p>
		<div class="gallery_spot">
			<div class="slider_gallery type3 noslide">
				<ul class="slide" id="slide_type3">
					<li>
						<!-- RUN VIDEO ON POP-->
						<div class="wrap-popup" id="popup-std">
						    <div class="overlay-pop"></div>
						    <div class="box-popup">
								<video width="400" controls>
								  <source src="{{$basesite}}assets/frontend/images/content/lat_tomatina.mp4" type="video/mp4">
								  Your browser does not support HTML5 video.
								</video>
						    </div>
						</div>
						<!-- RUN VIDEO ON POP-->
						<div class="has_video">
							<a href="javascript:openPopup('popup-std')">
								<span class="ico"></span>
								<img src="{{$basesite}}assets/frontend/images/content/what_on-1.png">
							</a>						
						</div>
						<div class="desc">
							<div class="title">LA TOMATINA 2016</div>
							<div class="text">
								Don’t miss this year's <br/>
								La Tomatina 2016 great fun! <br/>
								Held on 31 August 2016, 
							</div>
						</div>
						<div class="boxMore">
							<a href="{{$basesite}}label" class="more">More ></a>
						</div>
					</li>
					<li>
						<img src="{{$basesite}}assets/frontend/images/content/insta-2.png">
						<div class="desc">
							<div class="title">PROSHOP NEW ARRIVAL</div>
							<div class="text">
								Spots, stripes and button up <br/>
								skirts this is the cute combo <br/>
								we're wearing this season.
							</div>
						</div>
						<div class="boxMore">
							<a href="{{$basesite}}label" class="more">More ></a>
						</div>
					</li>
					<li>
						<img src="{{$basesite}}assets/frontend/images/content/what_on-3.png">
						<div class="desc">
							<div class="title">DENIM SQUAD</div>
							<div class="text">
								Introducing Holly, Leah, <br/>
								Sandy, Olivia & Alexis.  
							</div>
						</div>
						<div class="boxMore">
							<a href="{{$basesite}}label" class="more">More ></a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</section>