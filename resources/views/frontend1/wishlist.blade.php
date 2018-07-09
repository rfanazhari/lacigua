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
	.title2 {
		width: 100%;
		font-family: "robotomedium";
	    font-size: 16px;
	    color: #231f20;
	    border-bottom: 1px solid #000;
	    text-transform: uppercase;
	    padding-bottom: 10px;
	    margin-bottom: 10px;
	}
	.desc2 {
		font-family: "robotoreguler";
	    font-size: 12px;
	    color: #6d6e70;
	    margin-bottom: 10px;
	    line-height: 23px;
	    position: relative;
	}
	.desc2 {
	    font-family: "robotoreguler";
	    font-size: 12px;
	    color: #6d6e70;
	    margin-bottom: 10px;
	    line-height: 23px;
	    position: relative;
	}
	.detail2 {
	    width: 160px;
	}
	.price2 {
	    color: #ed1c24;
    	font-size: 13px;
	}
	.price2.default {
	    color: #231f20;
	}
	.price-coret {
	    float: right;
	    color: #231f20;
	    text-decoration: line-through;
	    margin-left: 20px;
	}
	.diskon {
		border: 1px solid #555555;
	    background-color: #555555;
	    width: 30px;
	    height: 30px;
	    font-family: "robotomedium";
	    font-size: 9px;
	    border-radius: 50%;
	    -moz-border-radius: 50%;
	    -webkit-border-radius: 50%;
	    -o-border-radius: 50%;
	    color: #fff;
	    text-align: center;
	    line-height: 10px;
	    position: absolute;
	    top: 0px;
	    right: 13px;
	    z-index: 1;
	}
	.diskon span {
		top: 5px;
	    right: 0px;
	    position: relative;
	}
	.diskon.dua {
		right: 2px;
	    top: -3px;
	    z-index: 2;
	    width: 17px;
	    height: 17px;
	    font-size: 7px;
	}
	.diskon.dua span {
		top: 4px;
    	right: 0px;
	}
	.newa:hover, li:hover {
		text-decoration: underline !important;
		cursor: pointer !important;
	}
	.label_new {
	    z-index: 2;
	    margin-top: 15px;
	    width: 44px;
	    height: 21px;
	    position: absolute;
	    border: 1px solid #979797;
	    background: url({{$basesite}}assets/frontend/images/material/label_new.png) no-repeat;
	}
	.label_sale {
	    z-index: 2;
		margin-top: 15px;
		width: 44px;
		height: 21px;
		position: absolute;
		border: 1px solid #979797;
		background: url({{$basesite}}assets/frontend/images/material/label_sale_small.png) no-repeat;
		background-size: 44px 21px;
	}
	li .img-hover {
		position: absolute;
		top: 0;
		opacity: 0;
		transition: 0.2s ease-out all;
		-webkit-transition: 0.2s ease-out all;
		-moz-transition: 0.2s ease-out all;
		-ms-transition: 0.2s ease-out all;
		-o-transition: 0.2s ease-out all;
	}
	li:hover .img-hover {
		opacity: 1;
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
						<div>
							<div class="boxWishList">
								@if(count($CustomerProductWishlist))
								<table class="tb_shop">
									<thead class="h_black">
										<tr>
											<th scope="col" style="width: 40%">PRODUK</th>
											<th scope="col" align="left" style="width: 10%">TANGGAL</th>
											<th scope="col" align="center" style="width: 20%">STATUS</th>
											<th scope="col" align="left" style="width: 20%">HARGA</th>
											<th scope="col" align="center" style="width: 5%"></th>
										</tr>
									</thead>
									<tbody id="checkwishlist">
										@foreach($CustomerProductWishlist as $key1 => $val1)
										<tr id="{{$val1['ID']}}">
											<td data-label="PRODUK">
												<div class="boxTrack type_table">
													<div class="boxTrackInner after_clear">
														<div class="detail">
															<div class="detail_inner after_clear">
																<div class="det1">
																	<img src="{{$basesite}}assets/frontend/images/content/product/medium_{{$val1['Image1']}}">
																</div>
																<div class="det1">
																	<div class="name">{{strtoupper($val1['BrandName'])}}</div>
																	<div class="desc" style="width:250px;">{{strtoupper($val1['Name'])}}</div>
																	<table class="other_det">
																		<tr>
																			<td style="width:30px !important;">SIZE</td>
																			<td>{{$val1['SizeName']}}</td>
																		</tr>
																		<tr>
																			<td colspan="2" style="padding-top: 40px;">
																				<a href="javascript:;" class="remove_prod" onclick="RemoveWishlist('{{$val1['ID']}}')">x HAPUS PRODUK</a>
																			</td>
																		</tr>
																	</table>
																</div>
															</div>
														</div>
													</div>
												</div>
											</td>								
											<td data-label="TANGGAL" align="left" style="vertical-align: top;">{{$inv->_dateformysql($val1['CreatedDate'])->format('d/m/y')}}</td>
											<td data-label="STATUS" align="center" style="vertical-align: top;">
												@if($val1['ProductQty'])
												<span>TERSEDIA</span>
												@else
												<span class="red">OUT OF STOCK</span>
												@endif
											</td>
											@php
												$ProductPrice = $val1['SellingPrice'];

												$SaleProductPrice = 0;
												if($val1['StatusSale']) {
													$SaleProductPrice = $val1['SalePrice'];
												}

												if($val1['CurrencyCode'] == 'IDR') {
							                        $ProductPrice = $inv->_formatamount($ProductPrice, 'Rupiah', $val1['CurrencyCode'].' ');
							                        $SaleProductPrice = $inv->_formatamount($SaleProductPrice, 'Rupiah', $val1['CurrencyCode'].' ');
												} else {
							                        $ProductPrice = $inv->_formatamount($ProductPrice, 'Dollar', $val1['CurrencyCode'].' ');
							                        $SaleProductPrice = $inv->_formatamount($SaleProductPrice, 'Dollar', $val1['CurrencyCode'].' ');
												}
					                        @endphp
											<td data-label="HARGA" align="left" style="vertical-align: top;">
												@if($val1['StatusSale'])
												<div class="price_save">
													<div><span class="coret">{{$ProductPrice}}</span></div>
													<div><span class="red">{{$SaleProductPrice}}</span></div>
													<div style="margin-top: 30px;"><span class="red">SAVE {{round(($val1['SalePrice'] / $val1['SellingPrice'] * 100), 2)}} %</span></div>
												</div>
												@else
												{{$ProductPrice}}
												@endif
											</td>
											<td align="center" style="vertical-align: top;padding-right: 20px;">
												@if($val1['ProductQty'])
												@if(!$obj['TypeProduct'])
												<a href="{{$basesite}}product-detail/id_{{$val1['permalink']}}" target="_blank" class="btn">PESAN</a>
												@else
												<a href="{{$basesite}}product-beauty/id_{{$val1['permalink']}}" target="_blank" class="btn">PESAN</a>
												@endif
												@else
												<a href="javascript:;" class="btn">PESAN</a>
												@endif
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
								@else
								<div width="100%" style="text-align: center;"><h4 style="color:red">Anda belum memiliki wishlist saat ini.</h4></div>
								@endif
							</div>
							@if($ArrayProduct)
							<div class="gallery_spot">
								<div class="slider_gallery type2 promoted">
									<div class="title">
										Promoted<span class="ico tooltip" style="cursor: pointer;" data-tooltip-content="#tooltip-content" data-tooltipster='{"side":"right","animation":"fade","maxWidth":"300", "trigger": "click", "theme": ["tooltipster-noir","tooltipster-noir-customized"]}'>ico</span>
										<div class="tooltip-template">
											<div id="tooltip-content">
												<p>Promosi oleh TopAds yang muncul berdasarkan favorite label Anda</p>
											</div>
										</div>
									</div>
									<ul class="slide type_2 after_clear">
										@foreach($ArrayProduct as $obj)
											@php
												$ProductName = $inv->_cutstring(strip_tags($obj['NameShow']), 21);
												$ProductDesc = $inv->_cutstring(strip_tags($obj['Description']), 55);
											@endphp
											<li>
												@if(!$obj['TypeProduct'])
												<a class="newa" href="{{$basesite}}product-detail/id_{{$obj['permalink']}}">
												@else
												<a class="newa" href="{{$basesite}}product-beauty/id_{{$obj['permalink']}}">
												@endif
													@if($obj['StatusNew'] == 1)
													<div class="label_new"></div>
													@elseif($obj['StatusSale'] == 1)
													<div class="label_sale"></div>
													@endif
													<img src="{{$basesite}}assets/frontend/images/content/product/medium_{{$obj['Image1']}}">
													<img src="{{$basesite}}assets/frontend/images/content/product/medium_{{$obj['Image2']}}" class="img-hover">
													<div class="boxText">
														<div class="title2">{{$ProductName}}</div>
														<div class="desc2">
															<div class="detail2">
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
														<div class="price2">
															{{$inv->_formatamount($obj['SalePrice'], 'Rupiah', 'IDR ')}}
															<span class="price-coret">{{$inv->_formatamount($obj['SellingPrice'], 'Rupiah', 'IDR ')}}</span>
														</div>
														@else
														<div class="price2 default">
															{{$inv->_formatamount($obj['SellingPrice'], 'Rupiah', 'IDR ')}}
														</div>
														@endif
													</div>
												</a>
											</li>
					                    @endforeach
									</ul>
								</div>
							</div>
							@endif
						</div>
						<div></div>
						<div></div>
						<div></div>
					</div>
				</div>
			</div>
		</section>
	</div>	
</section>
<script type="text/javascript">
function RemoveWishlist(ID) {
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
            url         : '{{$basesite}}wishlist/ajaxpost',
            type        : 'POST',
            data        : {'ajaxpost':"RemoveWishlist",'_token':'{{csrf_token()}}','ID':ID},
            success     : function(data) {
                var data = JSON.parse(data);
                if(data['response'] == 'OK') {
                	$('[id^='+ID+']').remove();
                	var checkwishlist = $('#checkwishlist').html().trim();
                	if(!checkwishlist)
                		$('#checkwishlist').parent().parent().html('<div width="100%" style="text-align: center;"><h4 style="color:red">Anda belum memiliki wishlist saat ini.</h4></div>');
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
</script>