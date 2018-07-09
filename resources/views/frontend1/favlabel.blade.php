<style>
	.ui-widget.ui-widget-content{
		border: none;
	}
	.ui-tabs .ui-tabs-panel{
		border: 1px solid lightgrey;
		margin-left: 3px;
		min-height: 520px;
		padding:0px;
	}
	.ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited{
		color:black;
		border:none;
		border-top: 1px solid lightgrey;
		border-left: 1px solid lightgrey;
		border-right: 1px solid lightgrey;
	}
	section.akun_profile p{
		margin-bottom: 20px;
	}
	.newlink {
		font-size: 21px;
	    font-family: "robotoboldcondensed";
	    text-transform: uppercase;
	    display: inline-block;
	    margin: 0 4px 0 0;
	    list-style: none;
	    cursor: pointer;
	    color: #898989;
	    text-decoration: none;
	}
	.newlink:hover {
		font-size: 21px;
	    font-family: "robotoboldcondensed";
	    text-transform: uppercase;
	    display: inline-block;
	    margin: 0 4px 0 0;
	    list-style: none;
	    cursor: pointer;
	    color: #898989;
	    text-decoration: none;
	}
	.newbrand {
		width: 100%;
	    display: block;
	    line-height: 25px;
	    padding: 10px;
	    margin-bottom: 2px;
	    background: rgba(255, 255, 255, 0.9);
	    color: #333;
	    font-size: 22px;
	    font-family: "robotoboldcondensed";
	    text-align: center;
	}
</style>
<section class="akun_profile akun_saya">
	<div class="wrapper">
		<h1>MY PROFILE</h1>
		<p style="text-align: center;">TERAKHIR LOGIN : {{strtoupper($LastLogin)}}</p>
		<section class="spottab" style="padding-bottom: 40px;">
			<div class="wrapper">
				<div class="tab_akun" id="parentHorizontalTab">
					<ul class="resp-tabs-list hor_1">
						<li><a href="{{$basesite}}account" class="newlink">ACCOUNT</a></li>
						<li><a href="{{$basesite}}order" class="newlink">ORDER</a></li>
						<li><a href="{{$basesite}}wishlist" class="newlink">WISHLIST</a></li>
						<li><a href="{{$basesite}}wallet" class="newlink">WALLET</a></li>
						<li><a href="{{$basesite}}message" class="newlink">MESSAGE</a></li>
						<li><a href="{{$basesite}}favlabel" class="newlink">FAV LABEL</a></li>
					</ul>
					<div class="resp-tabs-container hor_1">
						<div></div>
						<div></div>
						<div></div>
						<div></div>
						<div></div>
						<div>
							<div class="gallery_spot gallery_akun_fav">
								<div class="slider_gallery type2">
									@if(count($CustomerFavoriteBrand))
									<ul id="checklabel" class="slide after_clear">
										@foreach($CustomerFavoriteBrand as $key1 => $val1)
										<li id="{{$val1['ID']}}">
											<a href="{{$basesite}}{{$arraymode[$val1['BrandMode']]}}/id_{{$val1['BrandPermalink']}}">
												<div class="boxBackImg">
													<div class="boxCaption edit_mode">
														<span class="newbrand">{{$val1['BrandName']}}</span>
													</div>
												</div>
											</a>
											<img src="{{$basesite}}assets/frontend/images/content/brand/medium_{{$val1['BrandIcon']}}">
											<div class="boxbtnFav">
												<a href="javascript:;" onclick="RemoveFavLabel('{{$val1['ID']}}')">
													<span class="txt_mob">Delete Favorite</span>
													<span class="txt_dek">Delete Favorite Label</span>
												</a>
											</div>
										</li>
										@endforeach
									</ul>
									@else
									<div width="100%" style="text-align: center;"><h4 style="color:red">Anda belum memiliki favorite label saat ini.</h4></div>
									@endif
								</div>
							</div>

							@if(count($FeaturedBrand))
							<div class="gallery_spot gallery_akun_fav">
								<div class="slider_gallery type2 promoted">
									<div class="title">
										Promoted<span class="ico tooltip" style="cursor: pointer;" data-tooltip-content="#tooltip-content" data-tooltipster='{"side":"right","animation":"fade","maxWidth":"300", "trigger": "click", "theme": ["tooltipster-noir","tooltipster-noir-customized"]}'>ico</span>
										<div class="tooltip-template">
											<div id="tooltip-content">
												<p>Promosi oleh TopAds yang muncul berdasarkan favorite label Anda </p>
											</div>
										</div>
									</div>
									<ul class="slide after_clear">
										@foreach($FeaturedBrand as $key1 => $val1)
										<li>
											<a href="{{$basesite}}{{$arraymode[$val1['Mode']]}}/id_{{$val1['permalink']}}">
												<div class="boxBackImg">
													<div class="boxCaption edit_mode">
														<span class="newbrand">{{$val1['Name']}}</span>
													</div>
												</div>
											</a>
											<img src="{{$basesite}}assets/frontend/images/content/brand/medium_{{$val1['Icon']}}">
											<div class="boxbtnFav">
												<a href="javascript:;" onclick="AddFavLabel('{{$val1['ID']}}')">
													<span class="txt_mob">Add to Favorite</span>
													<span class="txt_dek">Add to Favorite Label</span>
												</a>
											</div>
										</li>
										@endforeach
									</ul>
								</div>
							</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>	
</section>
<script type="text/javascript">
function RemoveFavLabel(ID) {
	$('#popup .titlenew').contents()[0].nodeValue = 'Remove ?';

	var contentnew = 
	'<div class="boxFormInline register after_clear" style="width: 100%; margin-top: 0px;"><div class="form-group">' +
		'<div class="control-label colorred">Anda yakin akan menghapus ?</div>' +
	'</div>' +
    '<div class="form-group">' +
		'<button id="btnok" class="btn black" style="top: auto;">OK</button> <button id="btncancel" class="btn white" style="top: auto;">Cancel</button>' +
	'</div></div>';

	$('#popup .contentnew').css('height', 'auto');
	$('#popup .contentnew').html(contentnew);

	openPopup('popup');

	$("#btnok").on('click', function() {
		$.ajax({
            url         : '{{$basesite}}favlabel/ajaxpost',
            type        : 'POST',
            data        : {'ajaxpost':"RemoveFavLabel",'_token':'{{csrf_token()}}','ID':ID},
            success     : function(data) {
                var data = JSON.parse(data);
                if(data['response'] == 'OK') {
                	$('[id^='+ID+']').remove();
                	var checklabel = $('#checklabel').html().trim();
                	if(!checklabel)
                		$('#checklabel').parent().html('<div width="100%" style="text-align: center;"><h4 style="color:red">Anda belum memiliki favorite label saat ini.</h4></div>');
                	closePopup('popup');
                } else {
            		var messageerror = '';
            		$.each(data['data']['error'], function(keys, vals) {
						messageerror = messageerror + '<div class="control-label"><span class="colorred">*</span> '+vals+'</div>';
					});
			    	_alertvalidation(messageerror);
                }
            }
        });
	});

	$("#btncancel").on('click', function() { closePopup('popup'); });
}

function AddFavLabel(ID) {
	$.ajax({
        url         : '{{$basesite}}favlabel/ajaxpost',
        type        : 'POST',
        data        : {'ajaxpost':"AddFavLabel",'_token':'{{csrf_token()}}','ID':ID},
        success     : function(data) {
            var data = JSON.parse(data);
            if(data['response'] == 'OK' || data['response'] == 'CANCEL') {
				if(data['response'] == 'OK') {
					$('#btnfavorit').addClass('red');
				} else {
					$('#btnfavorit').removeClass('red');
				}
            }
        }
    });
}
</script>