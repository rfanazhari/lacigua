<style type="text/css">
	.content_pop_order .boxTrack .boxTrackBorder .boxtrackMultiInner .boxTrackInner.bordered .detail .detail_inner .det1:nth-of-type(2) {
		width: auto;
	}
	section.sale .boxContentSale .gallery_spot .title {
		font-family: "robotomedium";
	    font-size: 28px;
	    text-align: center;
	    color: #111111;
	    letter-spacing: 2px;
	    margin-bottom: 30px;
	}
	section.sale .boxContentSale .catalog {
		border-bottom: 1px solid #000;
	    padding: 20px 0 40px;
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
	.boxAlamat {
		width: 100%;
	}
	.boxAlamat #TextAddressInfo {
		font-weight: 700;
		font-size: 20px;
	}
	.tbaddress {
		height: 25px;
	    font-family: "robotoreguler";
	    font-size: 15px;
	    color: #111111;
	}
	.tbaddress tr {
		height: 25px;
	}
</style>
<section class="sale catalog product_order">
	<div class="wrapper" style="">
		<div class="breadcrumb">
			<a href="{{$basesite}}">HOME</a><span>></span>
			<a href="{{$basesite}}{{strtolower($Product->ModelType)}}/detail">{{$Product->ModelType}}</a><span>></span>
			<a href="{{$basesite}}{{strtolower($Product->ModelType)}}/detail/category_[{{$Product->CategoryID}}[{{$Product->SubCategoryIDAll}}]]">{{$Product->CategoryName}}</a><span>></span>
			<a href="{{$basesite}}{{strtolower($Product->ModelType)}}/detail/category_[{{$Product->CategoryID}}[{{$Product->SubCategoryID}}]]">{{$Product->SubCategoryName}}</a><span></span>
		</div>

		<div class="boxProductDetail after_clear">
			<div class="boxImgDisplay after_clear">
				<input type="hidden" name="arrprovince" value="{{json_encode($arrprovince, JSON_FORCE_OBJECT)}}">
				<div class="imgView">
					<img src="{{$basesite}}assets/frontend/images/content/product/{{$Product->Image1}}">
				</div>
				<ul class="imgLinkView after_clear">
					<li><a href="javascript:;" data-url-img="{{$basesite}}assets/frontend/images/content/product/{{$Product->Image1}}"><img src="{{$basesite}}assets/frontend/images/content/product/small_{{$Product->Image1}}"></a></li>
					<li><a href="javascript:;" data-url-img="{{$basesite}}assets/frontend/images/content/product/{{$Product->Image2}}"><img src="{{$basesite}}assets/frontend/images/content/product/small_{{$Product->Image2}}"></a></li>
					@if($Product->Image3)
					<li><a href="javascript:;" data-url-img="{{$basesite}}assets/frontend/images/content/product/{{$Product->Image3}}"><img src="{{$basesite}}assets/frontend/images/content/product/small_{{$Product->Image3}}"></a></li>
					@endif
					@if($Product->Image4)
					<li><a href="javascript:;" data-url-img="{{$basesite}}assets/frontend/images/content/product/{{$Product->Image4}}"><img src="{{$basesite}}assets/frontend/images/content/product/small_{{$Product->Image4}}"></a></li>
					@endif
					@if($Product->Image5)
					<li><a href="javascript:;" data-url-img="{{$basesite}}assets/frontend/images/content/product/{{$Product->Image5}}"><img src="{{$basesite}}assets/frontend/images/content/product/small_{{$Product->Image5}}"></a></li>
					@endif
				</ul>
				<div class="boxChangeandShare after_clear">
					<div class="boxChangeProduct">
						<div class="see_others">
							<a href="{{$basesite}}{{$Product->BrandMode}}/id_{{$Product->BrandPermalink}}" target="_blank">See another product from {{strtoupper($Product->BrandName)}}</a>
						</div>
						<div class="ask_seller">
							<a href="javascript:;" class="link_detail" data-title="SEND MESSAGE" onclick="AskSeller()">
								<span></span>
								Ask Seller a question
							</a>
						</div>
					</div>
					<div class="boxShareProduct">
						<div class="title">SHARE</div>
						<ul class="social_share after_clear">
		    				<li class="sharedPopup"><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}" data-type="sharefb" class="fb">fb</a></li>
		    				<li class="sharedPopup"><a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::fullUrl()) }}" data-type="sharetw" class="tw">tw</a></li>
		    				<li class="sharedPopup"><a href="http://pinterest.com/pin/create/button/?url={{ urlencode(Request::fullUrl()) }}" data-type="sharepi" class="pi">pi</a></li>
		    				<li class="sharedPopup"><a href="https://plus.google.com/share?url={{ urlencode(Request::fullUrl()) }}" data-type="sharegg" class="google">google</a></li>
		    			</ul>
		    			<div class="report"><a href="javascript:;" class="link_report" data-title="REPORT THIS ITEM" onclick="ReportThis()">Report this Item</a></div>
					</div>
				</div>
			</div>

			<div class="boxImgDesc">
				<div class="title">{{strtoupper($Product->BrandName)}}</div>
				<div class="desc">{{strtoupper($Product->NameShow)}}</div>
				<div id="Weight" style="display: none;">{{$Product->Weight}}</div>
				<div class="code">CODE# {{strtoupper($Product->SKUPrinciple)}}</div>
				<div class="price">@if($Product->StatusSale == 1){{$inv->_formatamount($Product->SalePrice, 'Rupiah', 'IDR ')}}@else{{$inv->_formatamount($Product->SellingPrice, 'Rupiah', 'IDR ')}}@endif</div>
				

				<div class="label_color">Variasi :</div>
				<ul class="box_variasi" id="box_variasi">
					@foreach($ArrSize as $obj)
					<li><a href="javascript:;" data-size="{{$obj['SizeVariantID']}}" @if($obj === reset($ArrSize)) class="active" @endif>{{$obj['Name']}}</a></li>
					@endforeach
					<input type="hidden" name="size_text" id="size_text" value="{{$ArrSize[0]['SizeVariantID']}}">
				</ul>

				<div class="boxQuantity">
					<label>Quantity : </label>
					<div class="boxWish after_clear">
						<select name="Qty">
							@foreach (range(1, $ArrSize[0]['Qty']) as $obj) {
							<option value="{{$obj}}">{{$obj}}</option>
							@endforeach
						</select>
						<a href="javascript:;" class="btn" id="addtoWish" onclick="setwishlist()">ADD TO WISHLIST</a>
					</div>
					<button type="button" class="btn red tooltip" id="addtoBag" data-tooltip-content="#tooltip-content" data-tooltipster='{"side":"right","animation":"fade","maxWidth":"300", "trigger": "hover", "theme": ["tooltipster-shadow","tooltipster-lightmenu-customized"]}' onclick="AddToBag()">ADD TO BAG</button>
					<!-- <div class="tooltip-template">
						<div id="tooltip-content">
							<div class="title">Pilih Size</div>
							<ul class="boxMenuSize">
								<li><a href="javascript:;">XS</a></li>
								<li><a href="javascript:;">S</a></li>
								<li><a href="javascript:;">M</a></li>
								<li><a href="javascript:;">L</a></li>
								<li><a href="javascript:;">XL</a></li>
							</ul>
						</div>
					</div> -->
				</div>

				<div class="boxTabDesc">
					<ul class="tab_menu after_clear">
						<li>
							<a href="javascript:;" data-id="tab_desc">Description</a>
						</li>
						<li>
							<a href="javascript:;" data-id="tab_sizing">Sizing</a>
						</li>
						<li>
							<a href="javascript:;" class="active" data-id="tab_return">Return & Exchange</a>
						</li>
					</ul>
					<div class="boxTabDescContent">
						<div class="boxTabDescContentInner" id="tab_desc">
							<div class="desc">
								{!!$Product->Description!!}
							</div>
						</div>
						<div class="boxTabDescContentInner" id="tab_sizing">
							<div class="desc">
								{!!$Product->SizingDetail!!}
							</div>
						</div>
						<div class="boxTabDescContentInner" id="tab_return" style="display: inherit;">
							<div class="title">Kebijakan Pengembalian:</div>
							<div class="desc">
								<p>Nikmati layanan GRATIS pengembalian dalam 7 hari untuk produk ini! </p>
								<p>
									Info lebih lanjut mengenai layanan ini lihat <a href="{{$basesite}}faq" target="_blank">FAQ disini</a>
								</p>
							</div>
						</div>		
					</div>
				</div>
			</div>
		</div>

		@if(count($ArrayProduct))
		<div class="boxYouMight boxContentSale">
			<div class="title">YOU MIGHT ALSO LIKE</div>
			<div class="gallery_spot">
				<div class="slider_gallery catalog">
					<ul class="slide after_clear" id="slide_product_detail">
						@foreach($ArrayProduct as $obj)
						@php
							$ProductName = $inv->_cutstring(strip_tags($obj['NameShow']), 21);
							$ProductDesc = $inv->_cutstring(strip_tags($obj['Description']), 55);
						@endphp
						<li>
							<a href="{{$basesite}}product-detail/id_{{$obj['permalink']}}">
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
											{!!$ProductDesc!!}
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
					</ul>
				</div>
			</div>
		</div>
		@endif
	</div>
</section>
<div class="wrap-popup" id="popup-message">
    <div class="overlay-pop2"></div>
    <div class="box-popup type_2 pop_askseller" style="max-width: 650px;padding:20px;">
        <div class="title" style="background-color: #fff;color: #000;border-bottom: 2px solid #000;text-align: left;margin: 0 40px;"><span class="tp">ASK SELLER</span>
            <span class="closepop" style="color: #000">X</span>
        </div>
        <div class="content" style="width: 100%;height: auto;padding-left: 40px;padding-right: 40px;">
            <div class="boxForm" style="width: 100%;margin-left:0px;">
				<div class="form-group">
					<label class="control-label" for="subject" style="float: none;display: block;width: 100%;margin-bottom: 15px">Subject</label>
					<div class="control-input" style="float: none;">
						<input type="text" name="subject" id="subject" style="width: 550px;">
					</div>
				</div>
			    <div class="form-group">
					<label class="control-label " for="catatan1" style="float: none;display: block;width: 100%;margin-bottom: 15px">Catatan</label>
					<div class="control-input" style="float: none;width: 550px;">          			     
						<textarea class="form-control" id="catatan1" rows="6" maxlength="255" style="width: 550px;"></textarea>
						<span class="textarea_max">Characters 0/255</span>
					</div>
			    </div>
			    <div class="form-group">
					<label class="control-label " for="portfolio" style="float: none;display: block;width: 100%;margin-bottom: 15px">Image:</label>
					<div class="control-input" style="">
						<div class="boxFile">
							<input type="file" class="form-control" id="portfolio" name="portfolio" style="width: 550px;">
							<a class="btn_file" data-id="portfolio">PILIH FILE</a>			      		
						</div>
					</div>
			    </div>
			    <div class="form-group" style="margin-top: 40px;">
					<div class="boxButton" style="margin-left: 0px;">
						<button type="button" name="send" class="btn black">SEND</button>		      	
						<button type="button" class="btn grey closepop" style="margin-left: 10px;">CANCEL</button>	      	
					</div>
			    </div>
			</div>
        </div>
    </div>
</div>
<div class="wrap-popup" id="popup-report">
    <div class="overlay-pop2"></div>
    <div class="box-popup type_2" style="max-width: 650px;padding:20px;">
        <div class="title" style="background-color: #fff;color: #000;border-bottom: 2px solid #000;text-align: left;margin: 0 40px;"><span class="tp">Report Item</span>
            <span class="closepop" style="color: #000">X</span>
        </div>
        <div class="content" style="width: 100%;height: auto;padding-left: 40px;padding-right: 40px;">
        	<p style="line-height: 23px;">If you think this item is inappropirate for ASOS Marketplace you can let us know <br/>
        		by reporting the item here. Don't worry, reporting an item is confidential, The <br/>
        		Marketplace team will review the item and take appropriate action. 
        	</p>
            <div class="boxForm" style="width: 100%;margin-left:0px;margin-top: 40px;">
			    <div class="form-group">
					<label class="control-label" for="subject" style="float: none;display: block;width: 100%;margin-bottom: 15px">Select a reason:</label>
					<div class="control-input" style="float: none;width: 570px;">
						<select name="Reason">
							@foreach($arrayreason as $key => $val)
							<option value="{{$key}}">{{$val}}</option>
							@endforeach
						</select>
					</div>
			    </div>
			    <div class="form-group" style="margin-top: 40px;">
					<label class="control-label " for="catatan2" style="float: none;display: block;width: 100%;margin-bottom: 15px">Please add any details:</label>
					<div class="control-input" style="float: none;width: 550px;">          			     
						<textarea class="form-control" id="catatan2" rows="6" maxlength="255" name="Detail"></textarea>
						<span class="textarea_max">Characters 0/255</span>
					</div>
			    </div>
			    <div class="form-group" style="margin-top: 20px;">
					<div class="boxButton" style="margin-left: 0px;">
						<button type="button" name="SendReport" class="btn black">SEND</button>		      	
						<button type="button" class="btn grey closepop" style="margin-left: 10px;">CANCEL</button>		      	
					</div>
			    </div>
			</div>
        </div>
    </div>
</div>
<div class="wrap-popup" id="popup-thanks">
    <div class="overlay-pop2"></div>
    <div class="box-popup type_2" style="max-width: 650px;padding:20px;">
        <div class="title" style="background-color: #fff;color: #000;border-bottom: 2px solid #000;margin: 40px 40px 0;"><span class="tp">THANK YOU!</span>
            <span class="closepop" style="color: #000">X</span>
        </div>
        <div class="content" style="height: auto;padding-left: 40px;padding-right: 40px;">
        	<p style="line-height: 23px;text-align: center;">
        		We will review and process your report immediately and take the appropriate<br/>
        		action for this product.
        	</p>
        </div>
    </div>
</div>
<div class="wrap-popup" id="popup-infochart">
    <div class="overlay-pop2"></div>
    <div class="box-popup type_2" style="max-width: 650px;padding:20px;">
    	<div class="title">
            <span class="closepop" style="color: #000">X</span>
        </div>
        <div class="content" style="height: auto;padding-left: 40px;padding-right: 40px;">
        	<img id="infochart">
        </div>
    </div>
</div>
<div class="wrap-popup" id="popup-order">
    <div class="overlay-pop2"></div>
    <div class="box-popup type_2 pop_order" style="max-width: 900px;padding:20px;">
        <div class="title" style="background-color: #fff;color: #000;margin: 0px 20px 0;text-align: left;text-transform: uppercase;"><span class="tp">Beli</span>
            <span class="closepop" style="color: #000">X</span>
        </div>
        <div class="content content_pop_order" style="height: auto;padding-left: 20px;padding-right: 20px;">
			<div class="boxTrack boxtrackMulti after_clear">
				<div class="boxTrackBorder after_clear">
					<div class="boxtrackMultiInner">
						<div class="boxTrackInner bordered after_clear" style="background-color: #fafafa">
							<div class="detail">
								<div class="detail_inner after_clear">
									<div id="showtempimg" class="det1">
									</div>
									<div class="det1">
										<div class="desc">{{strtoupper($Product->Name)}}</div>
										<div class="name">{{strtoupper($Product->BrandName)}}</div>
										<div class="price"><span id="realprice" style="display: none;">@if($Product->StatusSale == 1){{$Product->SalePrice}}@else{{$Product->SellingPrice}}@endif</span>
											@if($Product->StatusSale == 1){{$inv->_formatamount($Product->SalePrice, 'Rupiah', 'IDR ')}}@else{{$inv->_formatamount($Product->SellingPrice, 'Rupiah', 'IDR ')}}@endif
										</div>
										<table class="other_det">
											<tr>
												<td style="width: 80px;">COLOR</td>
												<td id="popcolor">White - Blue</td>
											</tr>
											<tr>
												<td>SIZE</td>
												<td id="popsize">S</td>
											</tr>
											<tr>
												<td>Quantity</td>
												<td id="popqty">2</td>
											</tr>
										</table>
									</div>
									<div class="det1">
										<div class="boxCatatan">
											<span class="catatan" id="catat1">Catatan untuk penjual</span>
											<textarea class="text_catatan" data-id="catat1" name="Notes"></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="boxAlamatDelivery after_clear">
						<div class="boxtrackMultiInner" style="width:569px;padding-right:0px;margin-right:0px;">
							<div class="boxTrackInner ship_address after_clear">
								<div class="status" style="width:100%;float:left;">
									<div class="label_status">
										<span>SHIPPING ADDRESS</span>
										<div class="box_select_kurir" style="float: right;padding-right:40px;">
											@if(\Session::get('customerdata'))
												<span id="ElementSelectShippingAddress">
													@if(count($ArrayCustomerAddress))
													<select name="SelectShippingAddress" onchange="SelectShippingAddress(this.value)" style="width:150px;margin-right: 10px;">
														@foreach($ArrayCustomerAddress as $obj)
														<option value="{{$obj->ID}}" @if($SelectCustomerAddress->ID == $obj->ID) selected @endif>{{$obj->AddressInfo}}</option>
														@endforeach
													</select>
													@endif
												</span>
												<a href="javascript:;" id="addaddress" class="add_ship" style="position: relative;">+ Tambah Alamat</a>
											@else
												<a href="javascript:;" id="addaddress" class="add_ship" style="position: relative;">+ Tambah Alamat</a>
												<a href="javascript:;" id="editaddress" class="add_ship" style="position: relative; display:none;">+ Ubah Alamat</a>
											@endif
										</div>
									</div>
									<table class="tbaddress" style="width:100%;">
										@if(is_object($SelectCustomerAddress))
										<div class="boxAlamat">
											<span id="IDCustomerAddress" style="display: none;">{{$SelectCustomerAddress->ID}}</span>
											<b><span id="TextAddressInfo">{{$SelectCustomerAddress->AddressInfo}}</span></b>
											<br/><br/>
											<tr>
												<td width="130px">Name</td><td width="10px">:</td><td>
													<span id="TextRecepientName">{{$SelectCustomerAddress->RecepientName}}</span>
												</td>
											</tr>
											<tr>
												<td>Phone</td><td>:</td><td>
													<span id="TextRecepientPhone">{{$SelectCustomerAddress->RecepientPhone}}</span>
												</td>
											</tr>
											<tr>
												<td>Address</td><td>:</td><td>
													<span id="TextAddress">{!!nl2br($SelectCustomerAddress->Address)!!}</span><br/>
													<span id="IDProvince" style="display: none;">{{$SelectCustomerAddress->ProvinceID}}</span>
													<span id="TextDistrictName">{{$SelectCustomerAddress->DistrictName.','}}</span><span id="IDDistrict" style="display: none;">{{$SelectCustomerAddress->DistrictID}}</span> <span id="TextCityName">{{$SelectCustomerAddress->CityName}}</span><span id="IDCity" style="display: none;">{{$SelectCustomerAddress->CityID}}</span> <span id="TextPostalCode">{{$SelectCustomerAddress->PostalCode}}</span>
												</td>
											</tr>
										</div>
										@else
										<div class="boxAlamat">
											<span id="IDCustomerAddress" style="display: none;"></span>
											<b><span id="TextAddressInfo"></span></b>
											<br/><br/>
											<tr>
												<td width="130px">Name</td><td width="10px">:</td><td>
													<span id="TextRecepientName"></span>
												</td>
											</tr>
											<tr>
												<td>Phone</td><td>:</td><td>
													<span id="TextRecepientPhone"></span>
												</td>
											</tr>
											<tr>
												<td>Address</td><td>:</td><td>
													<span id="TextAddress"></span><br/>
													<span id="IDProvince" style="display: none;"></span>
													<span id="TextDistrictName"></span><span id="IDDistrict" style="display: none;"></span> <span id="TextCityName"></span><span id="IDCity" style="display: none;"></span> <span id="TextPostalCode"></span>
												</td>
											</tr>
										</div>
										@endif
									</table>
								</div>
							</div>
						</div>	
						<div class="boxPilihKurir">
							<div class="pilihkurir after_clear">
								<div class="title_kurir">DELIVERY</div>
								<div class="box_select_kurir" style="float:right;">
									<select name="ShippingID" onchange="changeshipping(this.value)" @if(\Session::get('customerdata')) @if(!count($ArrayCustomerAddress)) disabled @endif @else disabled @endif>
										<option value="">Pilih Delivery</option>
										@foreach($arrShipping as $obj)
										<option value="{{$obj->ID}}">{{$obj->Name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="pilihpaket"></div>
							<div class="boxCekTarif">
								<a href="{{$basesite}}delivery-service" target="_blank">Cek Tarif Pengiriman</a>
							</div>
						</div>
					</div>

					<div class="boxTotal">
						SUB TOTAL : <b id="showprice"></b>
					</div>
					<div class="boxAddtobag">
						<button class="btn red" onclick="sendorder()">ADD TO BAG</button>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
<div class="wrap-popup" id="popup-berhasil">
    <div class="overlay-pop2"></div>
    <div class="box-popup type_2 berhasil" style="max-width: 600px;padding:20px;">
        <div class="title" style="background-color: #fff;color: #000;margin: 0px 20px 0;font-family:'robotoboldcondensed';font-size: 29px;"><span class="tp">Produk Berhasil Dimasukan ke Keranjang</span>
            <span class="closepop" style="color: #000">X</span>
        </div>
        <div class="content content_pop_order" style="height: auto;padding-left: 20px;padding-right: 40px;">
        	<div class="content_pop_order">
	        	<div class="boxlinkContinue after_clear">
	        		<a href="javascript:;" class="btn closepop">CONTINUE SHOPPING</a>
	        		<a href="{{$basesite}}payment-method" class="btn black">PAY NOW</a>
	        	</div>
        	</div>
        </div>
    </div>
</div>
<script type="text/javascript">
	var shippingprice = '';
	var arrsize = [];

	@foreach($ArrSize as $obj)
	arrsize[{{$obj['SizeVariantID']}}] = {{$obj['Qty']}};
	@endforeach

	function ordershow() {
		var ShippingID			= $('[name="ShippingID"]').val();
		var IDDistrict			= $('#IDDistrict').html();
		var Weight 				= $('#Weight').html();
		var Qty 				= $('[name="Qty"]').val();
		var Price 				= $('#realprice').html();
		var PickupDistrictID	= '{{$Product->PickupDistrictID}}';

		var imgLinkView = $('.imgLinkView').find('li a img').attr('src');
    	$('#showtempimg').html('<img src="'+imgLinkView+'">');

    	$('#popcolor').html($('#data-color-name').html());
		$('#popsize').html($('#box_variasi').find("a.active").text());
		$('#popqty').html($('[name="Qty"]').val());

		if(ShippingID) {
			$('#showprice').html(_formatamount(((Price * Qty) + parseInt(shippingprice[$('[name="pilihpaket"]:checked').val()]['price'])), 'Rupiah', 'IDR '));
		} else {
			$('#showprice').html(_formatamount((Price * Qty), 'Rupiah', 'IDR '));
		}
		openPopup('popup-order');
	}

	function changeshipping(ShippingID) {
		var shippingpackage 	= '';
		var IDDistrict			= $('#IDDistrict').html();
		var Weight 				= $('#Weight').html();
		var Qty 				= $('[name="Qty"]').val();
		var Price 				= $('#realprice').html();
		var PickupDistrictID	= '{{$Product->PickupDistrictID}}';
		if(ShippingID && IDDistrict) {
			$.ajax({
	            url         : '{{$basesite}}product-beauty/ajaxpost',
	            type        : 'POST',
	            data        : {'ajaxpost':"GetShippingPrice",'_token':'{{csrf_token()}}','ShippingID':ShippingID,'PickupDistrictID':PickupDistrictID,'IDDistrict':IDDistrict,'Weight':(Weight*Qty)},
	            success     : function(data) {
	                var data = JSON.parse(data);
	                if(data['response'] == 'OK') {
                		shippingprice = data['data'];
	                	$.each(data['data'], function(keys, vals) {
							shippingpackage = shippingpackage + '<div class="form-group">' +
								'<input id="'+vals['service_code']+'" class="radio-custom" name="pilihpaket" onclick="_pilihpaket('+keys+')" value="'+keys+'" type="radio" '+(keys == 0?'checked':'')+' >' +
					            '<label for="'+vals['service_code']+'" class="radio-custom-label">' +
					            	'<span class="ico"></span>' +
					            	'<div class="label_inner">'+vals['service_display']+' - <b>'+_formatamount(vals['price'], 'Rupiah', 'IDR ')+'</b> <br/> Estimasi '+vals['etd_from']+' - '+vals['etd_thru']+' Hari</div>' +
								'</label>' +
						    '</div>';

						    if(keys == 0) {
						    	$('#showprice').html(_formatamount(((Price * Qty) + parseInt(vals['price'])), 'Rupiah', 'IDR '));
						    }
						});

						$('.pilihpaket').html(shippingpackage);
	                } else {
	                	$('.pilihpaket').html(shippingpackage);

                		var messageerror = '';
                		$.each(data['data']['error'], function(keys, vals) {
							messageerror = messageerror + '<div class="control-label"><span class="colorred">*</span> '+vals+'</div>';
						});

				    	_alertvalidation(messageerror);
	                }
	            }
	        });
		} else {
			$('#showprice').html(_formatamount((Price * Qty), 'Rupiah', 'IDR '));
			$('.pilihpaket').html(shippingpackage);
		}
	}

	function sendorder() {
		var ShippingID			= $('[name="ShippingID"]').val();
		var ShippingPackageID	= $('[name="pilihpaket"]:checked').attr('id');
		var IDDistrict			= $('#IDDistrict').html();

		if(!IDDistrict) _alertvalidation('<div class="control-label"><span class="colorred">*</span> Please Input Address</div>');
		else if(!ShippingID) _alertvalidation('<div class="control-label"><span class="colorred">*</span> Please Select Delivery</div>');
		else if(!ShippingPackageID) _alertvalidation('<div class="control-label"><span class="colorred">*</span> Please Select Package Delivery</div>');
		else {
			$.ajax({
	            url         : '{{$basesite}}product-beauty/ajaxpost',
	            type        : 'POST',
	            data        : {'ajaxpost':"sendorder",'_token':'{{csrf_token()}}','ProductID':'{{$Product->ID}}','ColorID':$("#color_text").val(),'SizeVariantID':$("#size_text").val(),'Qty':$('[name="Qty"]').val(),'ShippingID':ShippingID,'ShippingPackageID':ShippingPackageID,'IDCustomerAddress':$('#IDCustomerAddress').html(),'TextAddressInfo':$('#TextAddressInfo').html(),'TextRecepientName':$('#TextRecepientName').html(),'TextRecepientPhone':$('#TextRecepientPhone').html(),'TextAddress':$('#TextAddress').html(),'IDProvince':$('#IDProvince').html(),'TextDistrictName':$('#TextDistrictName').html(),'IDDistrict':IDDistrict,'TextCityName':$('#TextCityName').html(),'IDCity':$('#IDCity').html(),'TextPostalCode':$('#TextPostalCode').html(),'Notes':$('[name="Notes"]').val()},
	            success     : function(data) {
	                var data = JSON.parse(data);
	                
	                if(data['response'] == 'OK') {
						@if(!is_object($SelectCustomerAddress))
						$('#IDCustomerAddress').html('');
						$('#TextAddressInfo').html('');
						$('#TextRecepientName').html('');
						$('#TextRecepientPhone').html('');
						$('#TextAddress').html('');
						$('#IDProvince').html('');
						$('#TextDistrictName').html('');
						$('#IDDistrict').html('');
						$('#TextCityName').html('');
						$('#IDCity').html('');
						$('#TextPostalCode').html('');
						@endif

						var ViewCart = '';
						var ViewCartCount = 0;
						$.each(data['data'], function(keys, vals) {
							if(keys != 'TotalPrice') {
								ViewCart = ViewCart + '<div class="listBag after_clear" id="'+vals['ProductLink']+'">' +
		                            '<a href="javascript:;" class="remove_bag" data-id="'+vals['ProductLink']+'">x</a>' +
		                            '<div class="img">' +
		                                '<img src="{{$basesite}}assets/frontend/images/content/product/small_'+vals['ProductImage']+'">' +
		                            '</div>' +
		                            '<div class="desc">' +
		                                '<div class="titledesc">'+vals['ProductBrand']+'</div>' +
		                                '<div class="textdesc">'+vals['ProductName']+'</div>' +
		                                '<div class="otherdet">COLOR : '+vals['ProductColor']+'</div>' +
		                                '<div class="otherdet">SIZE : '+vals['ProductSize']+'</div>' +
		                                '<div class="otherdet">Quantity : '+vals['ProductQty']+'</div>' +
		                                '<div class="price">'+vals['ProductPrice']+'</div>' +
		                            '</div>' +
		                        '</div>';
		                        ViewCartCount = ViewCartCount + 1;
							} else {
								$('#ViewCartTotal').html(vals);
							}
							messageerror = messageerror + '<div class="control-label"><span class="colorred">*</span> '+vals+'</div>';
						});
						$('#ViewCart').html(ViewCart).show();
						$('#ViewCartCount1').html(ViewCartCount).show();
						$('#ViewCartCount2').html(ViewCartCount).show();
						$('.boxShoppingBag').show();

						closePopup('popup-order');
						openPopup('popup-berhasil');
	                } else {
	                	var messageerror = '';
                		$.each(data['data']['error'], function(keys, vals) {
							messageerror = messageerror + '<div class="control-label"><span class="colorred">*</span> '+vals+'</div>';
						});

						_alertvalidation(messageerror);
	                }
	            }
	        });
		}
	}

	function setwishlist() {
		$.ajax({
            url         : '{{$basesite}}product-beauty/ajaxpost',
            type        : 'POST',
            data        : {'ajaxpost':"setwishlist",'_token':'{{csrf_token()}}','ID':'{{$Product->ID}}','SizeVariantID':$("#size_text").val()},
            success     : function(data) {
                var data = JSON.parse(data);
                
                if(data['response'] == 'OK' || data['response'] == 'CANCEL') {
					if(data['response'] == 'OK') {
						$("#addtoWish").addClass("active");
					} else {
						$("#addtoWish").removeClass("active");
					}
                } else {
                	$('#popup .titlenew').contents()[0].nodeValue = 'Add to WISHLIST';

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

	function getsize(ModelType, CategoryID, SubCategoryID, ProductID) {
		$.ajax({
            url         : '{{$basesite}}product-beauty/ajaxpost',
            type        : 'POST',
            data        : {'ajaxpost':"getsize",'_token':'{{csrf_token()}}','ModelType':ModelType,'CategoryID':CategoryID,'SubCategoryID':SubCategoryID,'ProductID':ProductID},
            success     : function(data) {
                var data = JSON.parse(data);
                
                if(data['response'] == 'OK') {
                	var box_variasi = '',
                		active = '';
                	var i = 0;
                	arrsize = [];
					$.each(data['data'], function(key, val) {
						active = '';
						if (i == 0) { active = 'class="active"'; }
                		box_variasi = box_variasi + '<li><a href="javascript:;" data-size="'+val['SizeVariantID']+'" '+active+' >'+val['SizeName']+'</a></li>';
                		arrsize[val['SizeVariantID']] = val['SizeQty'];
                		i = i + 1;
                	});
            		box_variasi = box_variasi + '<input type="hidden" name="size_text" id="size_text" value="'+data['data'][0]['SizeVariantID']+'">';

            		$('#box_variasi').html(box_variasi);

            		var listqty = '';
					for(var number=1; number<=arrsize[data['data'][0]['SizeVariantID']]; ++number) {
						listqty = listqty + '<option value="'+number+'">'+number+'</option>';
						if(number == 10) break;
					};
					$('[name="Qty"]').html(listqty);

					if(data['link_size']) $('#link_size').show();
					else $('#link_size').hide();
                }
            }
        });
	}

	function AskSeller() {
        $.ajax({
            url         : '{{$basesite}}api/checking',
            type        : 'POST',
            data        : {'ajaxpost':"CheckLogin"},
            success     : function(data) {
                var data = JSON.parse(data);
                
                if(data['response'] == 'OK') {
                    openPopup('popup-message');
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
    
    function ReportThis() {
    	openPopup('popup-report');
    	
    	$('[name="SendReport"]').click(function() {
    		var Reason = $('[name="Reason"]');
    		var Detail = $('[name="Detail"]');

    		Reason.attr('style', 'border: 1px solid black;');
    		Detail.attr('style', 'border: 1px solid black;');

    		if(Reason.val() && Detail.val()) {
    			$.ajax({
		            url         : '{{$basesite}}api/insert',
		            type        : 'POST',
		            data        : {'ajaxpost':"ReportItem", 'ProductID':'{{$Product->ID}}', 'Reason':Reason.val(), 'Detail':Detail.val()},
		            success     : function(data) {
		                var data = JSON.parse(data);
		                
		                if(data['response'] == 'OK') {
		                	Reason.val(1);
		                	Detail.val('');
		                    closePopup('popup-report');
		                    openPopup('popup-thanks');
		                } else {
		                    var messageerror = '';
		            		$.each(data['data']['error'], function(keys, vals) {
								messageerror = messageerror + '<div class="control-label"><span class="colorred">*</span> '+vals+'</div>';
							});
					    	_alertvalidation(messageerror);
		                }
		            }
		        });
    		} else {
    			if(!Reason.val()) Reason.attr('style', 'border: 1px solid red;');
    			if(!Detail.val()) Detail.attr('style', 'border: 1px solid red;');
    		}
    	})
    }

    $("#box_variasi").on("click","li a", function(){
		var variasi = $(this).attr("data-variasi");
		$("#variasi_text").val(variasi);
		$("#box_variasi li a").removeClass("active");
		$(this).addClass("active");
	});	

	$(".boxFile").on("click", ".btn_file", function() {
		var $id = $(this).attr("data-id");
        $("#"+$id).click();
    });

	$("#box_variasi").on("click","li a", function() {
		var size = $(this).attr("data-size");

		var listqty = '';
		for(var number=1; number<=arrsize[size]; ++number) {
			listqty = listqty + '<option value="'+number+'">'+number+'</option>';
			if(number == 10) break;
		};
		$('[name="Qty"]').html(listqty);

		$("#size_text").val(size);
		$("#box_variasi li a").removeClass("active");
		$(this).addClass("active");
	});

	$(".boxTabDesc").on("click", ".tab_menu li a", function() {
		var $id = $(this).attr("data-id");
		$(".boxTabDesc .tab_menu li a").removeClass("active");
		$(".boxTabDescContentInner").hide();

		if(!$(this).hasClass("active")) {
			$("#"+$id).slideDown();
			$(this).addClass("active");
		} else {
			$("#"+$id).slideUp();
			$(this).removeClass("active");
		}
	});

	$(".text_catatan").focus(function() {
		var $id = $(this).attr("data-id");

		$("#"+$id).css({
			visibility: "hidden",
			opacity: 0
		});
	});

	$(".text_catatan").blur(function() {
		var $id = $(this).attr("data-id");
		$val = $(this).val();

		console.log($val);

		if($val.length == 0){
			$("#"+$id).css({
				visibility: "visible",
				opacity: 1
			});

		}else{
			$("#"+$id).css({
				visibility: "hidden",
				opacity: 0
			});

		}
	});

    $("#addaddress").on('click', function() {
		$('#popup .titlenew').contents()[0].nodeValue = 'TAMBAH ALAMAT';

		var arrprovince = JSON.parse($('[name="arrprovince"]').val());
		var province = '<option value="">Pilih Propinsi</option>';
    	$.each(arrprovince, function(key, val) {
    		province = province + '<option value="'+val['ID']+'">'+val['Name']+'</option>';
    	});

    	var contentnew = 
		'<div class="boxFormInline register after_clear" style="width: 100%; margin-top: 0px;"><div class="form-group">' +
			'<div class="control-label">Alamat Sebagai <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<input type="text" class="form-control" name="AddressInfo" placeholder="Alamat Sebagai">' +
			'</div>' +
		'</div>' +
	    '<div class="form-group">' +
			'<div class="control-label">Nama Penerima <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<input type="text" class="form-control" name="RecepientName" placeholder="Nama Penerima">' +
			'</div>' +
	    '</div>' +
	    '<div class="form-group">' +
			'<div class="control-label">Telepon Penerima <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<input type="text" class="form-control numberonly" name="RecepientPhone" placeholder="Telepon Penerima">' +
			'</div>' +
	    '</div>' +
	    '<div class="form-group">' +
			'<div class="control-label">Alamat <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<textarea type="text" class="form-control" name="Address" placeholder="Alamat"></textarea>' +
			'</div>' +
	    '</div>' +
	    '<div class="form-group">' +
			'<div class="control-label">Kode Pos <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<input type="text" class="form-control numberonly" maxlength="5" name="PostalCode" placeholder="Kode Pos">' +
			'</div>' +
	    '</div>' +
	    '<div class="form-group">' +
			'<div class="control-label">Propinsi <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<select name="ProvinceID" onchange="GetCity(this.value)" style="width:100%;">' +
				province +
				'</select>' +
			'</div>' +
	    '</div>' +
	    '<div class="form-group">' +
			'<div class="control-label">Kota / Kabupaten <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<select name="CityID" onchange="GetDistrict(this.value)" style="width:100%;">' +
				'<option value="">Pilih Kota / Kabupaten</option>' +
				'</select>' +
			'</div>' +
	    '</div>' +
	    '<div class="form-group">' +
			'<div class="control-label">Desa / Kelurahan <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<select name="DistrictID" style="width:100%;">' +
				'<option value="">Pilih Desa / Kelurahan</option>' +
				'</select>' +
			'</div>' +
	    '</div>' +
	    '<div class="form-group">' +
			'<button onclick="SetAddress()" class="btn black" style="top: auto;">TAMBAH ALAMAT</button>' +
		'</div></div>';

		$('#popup .contentnew').css('height', 'auto');
		$('#popup .contentnew').html(contentnew);

		$('.numberonly').numberOnly();
		openPopup('popup');
	});

    $("#editaddress").on('click', function() {
		$('#popup .titlenew').contents()[0].nodeValue = 'UBAH ALAMAT';

		var arrprovince = JSON.parse($('[name="arrprovince"]').val());
		var province = '<option value="">Pilih Propinsi</option>';
    	$.each(arrprovince, function(key, val) {
    		if($('#IDProvince').html() == val['ID'])
    			province = province + '<option value="'+val['ID']+'" selected >'+val['Name']+'</option>';
    		else
    			province = province + '<option value="'+val['ID']+'">'+val['Name']+'</option>';
    	});

    	var contentnew = 
		'<div class="boxFormInline register after_clear" style="width: 100%; margin-top: 0px;"><div class="form-group">' +
			'<div class="control-label">Alamat Sebagai <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<input type="text" class="form-control" name="AddressInfo" placeholder="Alamat Sebagai" value="'+$('#TextAddressInfo').html()+'">' +
			'</div>' +
		'</div>' +
	    '<div class="form-group">' +
			'<div class="control-label">Nama Penerima <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<input type="text" class="form-control" name="RecepientName" placeholder="Nama Penerima" value="'+$('#TextRecepientName').html()+'">' +
			'</div>' +
	    '</div>' +
	    '<div class="form-group">' +
			'<div class="control-label">Telepon Penerima <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<input type="text" class="form-control numberonly" name="RecepientPhone" placeholder="Telepon Penerima" value="'+$('#TextRecepientPhone').html()+'">' +
			'</div>' +
	    '</div>' +
	    '<div class="form-group">' +
			'<div class="control-label">Alamat <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<textarea type="text" class="form-control" name="Address" placeholder="Alamat">'+$('#TextAddress').html().replace(/<br\s*\/?>/gi,'\n')+'</textarea>' +
			'</div>' +
	    '</div>' +
	    '<div class="form-group">' +
			'<div class="control-label">Kode Pos <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<input type="text" class="form-control numberonly" maxlength="5" name="PostalCode" placeholder="Kode Pos" value="'+$('#TextPostalCode').html()+'">' +
			'</div>' +
	    '</div>' +
	    '<div class="form-group">' +
			'<div class="control-label">Propinsi <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<select name="ProvinceID" onchange="GetCity(this.value)" style="width:100%;">' +
				province +
				'</select>' +
			'</div>' +
	    '</div>' +
	    '<div class="form-group">' +
			'<div class="control-label">Kota / Kabupaten <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<select name="CityID" onchange="GetDistrict(this.value)" style="width:100%;">' +
				'<option value="">Pilih Kota / Kabupaten</option>' +
				'</select>' +
			'</div>' +
	    '</div>' +
	    '<div class="form-group">' +
			'<div class="control-label">Desa / Kelurahan <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<select name="DistrictID" style="width:100%;">' +
				'<option value="">Pilih Desa / Kelurahan</option>' +
				'</select>' +
			'</div>' +
	    '</div>' +
	    '<div class="form-group">' +
			'<button onclick="SetAddress()" class="btn black" style="top: auto;">UBAH ALAMAT</button>' +
		'</div></div>';

		$('#popup .contentnew').css('height', 'auto');
		$('#popup .contentnew').html(contentnew);

		GetCityDistrict($('#IDProvince').html(), $('#IDCity').html(), $('#IDDistrict').html());

		$('.numberonly').numberOnly();

		openPopup('popup');
	});

	function GetCity(obj, CityID = '') {
		$.ajax({
	        url         : '{{$basesite}}product-beauty/ajaxpost',
	        type        : 'POST',
	        data        : {'ajaxpost':"GetCity",'_token':'{{csrf_token()}}','ProvinceID':obj},
	        success     : function(data) {
	            var data = JSON.parse(data);
	            
	            if(data['response']) {
	    			var city = '<option value="">Pilih Kota / Kabupaten</option>';
	    			var district = '<option value="">Pilih Desa / Kelurahan</option>';
	            	$.each(data['response'], function(key, val) {
	            		if(CityID == val['ID'])
	            			city = city + '<option value="'+val['ID']+'" selected >'+val['Name']+'</option>';
	            		else
	            			city = city + '<option value="'+val['ID']+'">'+val['Alias'].replace('Kabupaten', 'Kab.')+' '+val['Name']+'</option>';
	            	});
	            	$('[name="CityID"]').html(city);
	            	$('[name="DistrictID"]').html(district);
	            }
	        }
	    });
	}

	function GetDistrict(obj, DistrictID = '') {
		$.ajax({
	        url         : '{{$basesite}}product-beauty/ajaxpost',
	        type        : 'POST',
	        data        : {'ajaxpost':"GetDistrict",'_token':'{{csrf_token()}}','CityID':obj},
	        success     : function(data) {
	            var data = JSON.parse(data);
	            
	            if(data['response']) {
	    			var city = '<option value="">Pilih Desa / Kelurahan</option>';
	            	$.each(data['response'], function(key, val) {
	            		if(DistrictID == val['ID'])
	            			city = city + '<option value="'+val['ID']+'" selected >'+val['Name']+'</option>';
	            		else
	            			city = city + '<option value="'+val['ID']+'">'+val['Name']+'</option>';
	            	});
	            	$('[name="DistrictID"]').html(city);
	            }
	        }
	    });
	}

	function GetCityDistrict(ProvinceID, CityID = '', DistrictID = '') {
		$.ajax({
	        url         : '{{$basesite}}product-beauty/ajaxpost',
	        type        : 'POST',
	        data        : {'ajaxpost':"GetCityDistrict",'_token':'{{csrf_token()}}','ProvinceID':ProvinceID,'CityID':CityID},
	        success     : function(data) {
	            var data = JSON.parse(data);
	            
    			var city = '<option value="">Pilih Kota / Kabupaten</option>';
    			var district = '<option value="">Pilih Desa / Kelurahan</option>';
            	$.each(data['arrcity'], function(key, val) {
            		if(CityID == val['ID'])
            			city = city + '<option value="'+val['ID']+'" selected >'+val['Name']+'</option>';
            		else
            			city = city + '<option value="'+val['ID']+'">'+val['Alias'].replace('Kabupaten', 'Kab.')+' '+val['Name']+'</option>';
            	});
            	$('[name="CityID"]').html(city);
            	$('[name="DistrictID"]').html(district);

            	var city = '<option value="">Pilih Desa / Kelurahan</option>';
            	$.each(data['arrdistrict'], function(key, val) {
            		if(DistrictID == val['ID'])
            			city = city + '<option value="'+val['ID']+'" selected >'+val['Name']+'</option>';
            		else
            			city = city + '<option value="'+val['ID']+'">'+val['Name']+'</option>';
            	});
            	$('[name="DistrictID"]').html(city);
	        }
	    });
	}

	function SetAddress() {
		var AddressInfo = $('[name="AddressInfo"]').val();
		var RecepientName = $('[name="RecepientName"]').val();
		var RecepientPhone = $('[name="RecepientPhone"]').val();
		var Address = $('[name="Address"]').val();
		var PostalCode = $('[name="PostalCode"]').val();
		var ProvinceID = $('[name="ProvinceID"]').val();
		var CityID = $('[name="CityID"]').val();
		var DistrictID = $('[name="DistrictID"]').val();

		var check = false;

		if(!AddressInfo) {
			$('[name="AddressInfo"]').focus();
			$('[name="AddressInfo"]').attr('style', 'border:1px solid red;');
			check = true;
		} else {
			$('[name="AddressInfo"]').attr('style', 'border:1px solid black;');
		}

		if(!RecepientName) {
			$('[name="RecepientName"]').focus();
			$('[name="RecepientName"]').attr('style', 'border:1px solid red;');
			check = true;
		} else {
			$('[name="RecepientName"]').attr('style', 'border:1px solid black;');
		}

		if(!RecepientPhone) {
			$('[name="RecepientPhone"]').focus();
			$('[name="RecepientPhone"]').attr('style', 'border:1px solid red;');
			check = true;
		} else {
			$('[name="RecepientPhone"]').attr('style', 'border:1px solid black;');
		}

		if(!Address) {
			$('[name="Address"]').focus();
			$('[name="Address"]').attr('style', 'border:1px solid red;');
			check = true;
		} else {
			$('[name="Address"]').attr('style', 'border:1px solid black;');
		}

		if(!PostalCode) {
			$('[name="PostalCode"]').focus();
			$('[name="PostalCode"]').attr('style', 'border:1px solid red;');
			check = true;
		} else {
			$('[name="PostalCode"]').attr('style', 'border:1px solid black;');
		}

		if(!ProvinceID) {
			$('[name="ProvinceID"]').focus();
			$('[name="ProvinceID"]').attr('style', 'border:1px solid red; width:100%;');
			check = true;
		} else {
			$('[name="ProvinceID"]').attr('style', 'border:1px solid black; width:100%;');
		}

		if(!CityID) {
			$('[name="CityID"]').focus();
			$('[name="CityID"]').attr('style', 'border:1px solid red; width:100%;');
			check = true;
		} else {
			$('[name="CityID"]').attr('style', 'border:1px solid black; width:100%;');
		}

		if(!DistrictID) {
			$('[name="DistrictID"]').focus();
			$('[name="DistrictID"]').attr('style', 'border:1px solid red; width:100%;');
			check = true;
		} else {
			$('[name="DistrictID"]').attr('style', 'border:1px solid black; width:100%;');
		}

		if(!check) {
			$.ajax({
		        url         : '{{$basesite}}product-beauty/ajaxpost',
		        type        : 'POST',
		        data        : {'ajaxpost':"SetAddress",'_token':'{{csrf_token()}}','AddressInfo':AddressInfo,'RecepientName':RecepientName,'RecepientPhone':RecepientPhone,'Address':Address,'PostalCode':PostalCode,'ProvinceID':ProvinceID,'CityID':CityID,'DistrictID':DistrictID},
		        success     : function(data) {
		            var data = JSON.parse(data);

		            if(data['response'] == 'OK') {
		            	$('#TextAddressInfo').html(AddressInfo);
		            	$('#TextRecepientName').html(RecepientName);
		            	$('#TextRecepientPhone').html(RecepientPhone);
		            	$('#TextAddress').html(Address.replace(/\r?\n/g, '<br />'));
		            	$('#IDProvince').html($('[name="ProvinceID"]').val());
		            	$('#TextDistrictName').html($('[name="DistrictID"] option:selected').text()+",");
		            	$('#IDDistrict').html($('[name="DistrictID"]').val());
		            	$('#TextCityName').html($('[name="CityID"] option:selected').text());
		            	$('#IDCity').html($('[name="CityID"]').val());
		            	$('#TextPostalCode').html(PostalCode);

		            	if($('[name="SelectShippingAddress"]')[0]) {
		            		$('[name="SelectShippingAddress"]').find('option:selected').removeAttr("selected");
		            		$('[name="SelectShippingAddress"]').append('<option value="'+data['data']['ID']+'" selected >'+AddressInfo+'</option>');
		            	} else {
		            		if(data['data']['ID']) {
		            			$('#ElementSelectShippingAddress').html('<select name="SelectShippingAddress" onchange="SelectShippingAddress(this.value)" style="width:150px;margin-right: 10px;">' +
									'<option value="'+data['data']['ID']+'" selected >'+AddressInfo+'</option>' +
								'</select>');
		            		}
		            	}

		            	if(!data['data']['ID']) {
		            		$('#addaddress').hide();
		            		$('#editaddress').show();
		            	}
		            	
		            	$('[name="ShippingID"]').attr('disabled', false);

		            	var shippingpackage		= '';
		            	var ShippingID			= $('[name="ShippingID"]').val();
		            	var IDDistrict			= $('#IDDistrict').html();
						var Weight 				= $('#Weight').html();
						var Qty 				= $('[name="Qty"]').val();
						var Price 				= $('#realprice').html();
						var PickupDistrictID	= '{{$Product->PickupDistrictID}}';

	            		if(ShippingID && IDDistrict) {
							$.ajax({
					            url         : '{{$basesite}}product-beauty/ajaxpost',
					            type        : 'POST',
					            data        : {'ajaxpost':"GetShippingPrice",'_token':'{{csrf_token()}}','ShippingID':ShippingID,'PickupDistrictID':PickupDistrictID,'IDDistrict':IDDistrict,'Weight':(Weight*Qty)},
					            success     : function(data) {
					                var data = JSON.parse(data);
					                if(data['response'] == 'OK') {
				                		shippingprice = data['data'];
					                	$.each(data['data'], function(keys, vals) {
											shippingpackage = shippingpackage + '<div class="form-group">' +
												'<input id="'+vals['service_code']+'" class="radio-custom" name="pilihpaket" onclick="_pilihpaket('+keys+')" value="'+keys+'" type="radio" '+(keys == 0?'checked':'')+' >' +
									            '<label for="'+vals['service_code']+'" class="radio-custom-label">' +
									            	'<span class="ico"></span>' +
									            	'<div class="label_inner">'+vals['service_display']+' - <b>'+_formatamount(vals['price'], 'Rupiah', 'IDR ')+'</b> <br/> Estimasi '+vals['etd_from']+' - '+vals['etd_thru']+' Hari</div>' +
												'</label>' +
										    '</div>';

										    if(keys == 0) {
										    	$('#showprice').html(_formatamount(((Price * Qty) + parseInt(vals['price'])), 'Rupiah', 'IDR '));
										    }
										});

										$('.pilihpaket').html(shippingpackage);
					                } else {
					                	$('.pilihpaket').html(shippingpackage);

				                		var messageerror = '';
				                		$.each(data['data']['error'], function(keys, vals) {
											messageerror = messageerror + '<div class="control-label"><span class="colorred">*</span> '+vals+'</div>';
										});

								    	_alertvalidation(messageerror);
					                }
					            }
					        });
						} else {
							$('#showprice').html(_formatamount((Price * Qty), 'Rupiah', 'IDR '));
							$('.pilihpaket').html(shippingpackage);
						}

					    closePopup('popup');
		            }
		        }
		    });
		}
	}

	function SelectShippingAddress(obj) {
		$.ajax({
	        url         : '{{$basesite}}product-beauty/ajaxpost',
	        type        : 'POST',
	        data        : {'ajaxpost':"SelectShippingAddress",'_token':'{{csrf_token()}}','ID':obj},
	        success     : function(data) {
	            var data = JSON.parse(data);

	            if(data['response'] == 'OK') {
	            	$('#IDCustomerAddress').html(data['data']['ID']);
	            	$('#TextAddressInfo').html(data['data']['AddressInfo']);
	            	$('#TextRecepientName').html(data['data']['RecepientName']);
	            	$('#TextRecepientPhone').html(data['data']['RecepientPhone']);
	            	$('#TextAddress').html(data['data']['Address'].replace(/\r?\n/g, '<br />'));
	            	$('#IDProvince').html(data['data']['ProvinceID']);
	            	$('#TextDistrictName').html(data['data']['DistrictName']+",");
	            	$('#IDDistrict').html(data['data']['DistrictID']);
	            	$('#TextCityName').html(data['data']['CityName']);
	            	$('#IDCity').html(data['data']['CityID']);
	            	$('#TextPostalCode').html(data['data']['PostalCode']);
	            }
	        }
	    });
	}

	function _pilihpaket(key) {
		var Qty		= $('[name="Qty"]').val();
		var Price	= $('#realprice').html();
	    $('#showprice').html(_formatamount(((Price * Qty) + parseInt(shippingprice[key]['price'])), 'Rupiah', 'IDR '));
	}

    function AddToBag() {
    	$.ajax({
            url         : '{{$basesite}}product-beauty/ajaxpost',
            type        : 'POST',
            data        : {'ajaxpost':"CheckLogin",'_token':'{{csrf_token()}}'},
            success     : function(data) {
                var data = JSON.parse(data);
                if(data['response'] == 'OK') {
                	ordershow();
                } else {
			    	$('#popup .titlenew').contents()[0].nodeValue = 'LOGIN, BUAT AKUN BARU / GUEST';

					var contentnew = 
						'<div id="loginview">' +
							'<div style="text-align: center; font-family: \'robotoboldcondensed\'; font-size: 16px; line-height: 26px; margin-bottom: 30px;">' +
								'<div style="margin-bottom: 10px; text-align: center; font-family: \'robotoboldcondensed\'; font-size: 23px;">ANDA TELAH TERDAFTAR</div>' +
								'<p style="text-align: center; font-family: \'robotoreguler\'; font-size: 16px; line-height: 26px;">Silahkan masuk menggunakan akun Lacigue Anda</p>' +
							'</div>' +
							'<div class="boxForm login" style="width: 500px;">' +
							    '<div class="form-group">' +
									'<div class="control-input">' +
										'<input type="text" class="form-control" name="lemail" placeholder="Email">' +
									'</div>' +
							    '</div>' +
							    '<div class="form-group">' +
									'<div class="control-input">' +
										'<input type="password" class="form-control" name="lpassword" placeholder="Password">' +
									'</div>' +
							    '</div>	' +
							    '<div id="errorlogin" class="colorred">' +
								'</div>' +
							    '<div class="form-group">' +
									'<div class="control-input">' +
										'<span class="note" style="left: 0px;">' +
											'<a href="javascript:;" id="forgotpass">Lupa Password / Email Anda?</a>' +
										'</span>' +
									'</div>' +
							    '</div>	' +
							    '<div class="form-group">' +
									'<input id="lremember" class="checkbox-custom" name="lremember" type="checkbox" >' +
									'<label for="lremember" class="checkbox-custom-label">' +
										'<span></span>' +
										'Saya ingin tetap Login' +
									'</label>' +
								'</div>' +
							    '<div class="form-group">' +
									'<div class="boxButton" style="margin-left: 0px;text-align: right;">' +
										'<button name="login" type="submit" class="btn black" style="top: -60px;">MASUK</button>' +
									'</div>' +
							    '</div>' +
								'<div class="boxSociallogin">' +
									'<div class="title">ANDA MEMILIKI AKUN LAIN ?</div>' +
									'<div class="boxButtonSocial after_clear" style="text-align:center;">' +
										'<a href="javascript:;" class="btn soc_btn">FACEBOOK</a>' +
										'<a href="javascript:;" class="btn soc_btn google">GOOGLE</a>' +
										'<a href="javascript:;" class="btn soc_btn yahoo">YAHOO</a>' +
									'</div>' +
									'<div class="desc">' +
										'Kami tidak akan pernah posting dengan mengatas-namakan atau membagi informasi apapun tanpa persetujuan Anda' +
									'</div>' +
								'</div>' +
							'</div>' +
						'</div>' +
						'<div id="registerview" style="display:none;">' +
							'<div class="boxRegister">' +
								'<div class="boxFormInline register after_clear" style="width: 500px;margin-top:0px;">' +
								    '<div class="boxinput2 after_clear">' +
										'<div class="form-group">' +
											'<div class="control-label">Nama Depan <span class="colorred">*</span></div>' +
											'<div class="control-input">' +
												'<input type="text" class="form-control" name="rfirstname" placeholder="Nama Depan">' +
											'</div>' +
										'</div>' +
										'<div class="form-group">' +
											'<div class="control-label">Nama Belakang <span class="colorred">*</span></div>' +
											'<div class="control-input">' +
												'<input type="text" class="form-control" name="rlastname" placeholder="Nama Belakang">' +
											'</div>' +
										'</div>' +
								    '</div>' +
								    '<div class="boxinput2 after_clear">' +
								    	'<div class="form-group">' +
								    		'<div class="control-label">Jenis Kelamin <span class="colorred">*</span></div>' +
									    '</div>' +
										'<div class="form-group">' +
											'<input id="radiomen" class="radio-custom" name="rgender" value="1" type="radio" checked >' +
											'<label for="radiomen" class="radio-custom-label">' +
												'<span class="ico"></span>' +
												'Pria' +
											'</label>' +
									    '</div>' +
										'<div class="form-group">' +
											'<input id="radiowomen" class="radio-custom" name="rgender" value="0" type="radio" >' +
											'<label for="radiowomen" class="radio-custom-label">' +
												'<span class="ico"></span>' +
												'Wanita' +
											'</label>' +
									    '</div>' +
								    '</div>' +
								    '<div class="form-group">' +
										'<div class="control-label">No. Telp <span class="colorred">*</span></div>' +
										'<div class="control-input">' +
											'<input type="text" class="form-control numberonly" name="rphone" placeholder="No. Telp">' +
										'</div>' +
								    '</div>	' +
								    '<div class="form-group">' +
										'<div class="control-label">Email <span class="colorred">*</span></div>' +
										'<div class="control-input">' +
											'<input type="text" class="form-control" name="remail" placeholder="Email">' +
										'</div>' +
								    '</div>' +
								    '<div class="form-group">' +
										'<div class="control-label">Password <span class="colorred">*</span></div>' +
										'<div class="control-input">' +
											'<input type="password" class="form-control" name="rpassword" placeholder="Ketik Max. 8 Karakter Password Anda">' +
										'</div>' +
								    '</div>' +
								    '<div class="form-group">' +
										'<div class="control-label">Ketik Ulang Password <span class="colorred">*</span></div>' +
										'<div class="control-input">' +
											'<input type="password" class="form-control" name="rrepassword" placeholder="Ketik Ulang Password Anda">' +
											'<span class="note"><b><span class="colorred">*</span> Wajib diisi</b></span>' +
										'</div>' +
								    '</div>	' +
								    '<div id="errorregister" class="colorred">' +
									'</div>' +
								    '<div class="form-group" style="margin-bottom: 0px;">' +
										'<input id="rremember" class="checkbox-custom" name="rremember" type="checkbox">' +
										'<label for="rremember" class="checkbox-custom-label">' +
											'<span></span>' +
											'<div class="c_label">Saya ingin tetap Login</div>' +
										'</label>' +
								    '</div>' +
								    '<div class="form-group">' +
										'<input id="rsubscribe" class="checkbox-custom" name="rsubscribe" type="checkbox">' +
										'<label for="rsubscribe" class="checkbox-custom-label">' +
											'<span></span>' +
											'<div class="c_label">' +
												'Dapatkan penawaran EKSKLUSIF<br/>' +
												'LACIGUE & info fashion terbaru' +
											'</div>' +
										'</label>' +
								    '</div>' +
									'<div class="form-group">' +
										'<div class="boxButton" style="margin-left: 0px;text-align: right;">' +
											'<button name="register" type="submit" class="btn black" style="top: -130px;">DAFTAR AKUN</button>' +
										'</div>' +
									'</div>' +
									'<div class="boxHelp">' +
										'<div class="text">' +
											'<div><b>Butuh Bantuan?</b></div>' +
											'Hubungi Layanan Pelanggan<br/>' +
											'+ 62 22 751 4100<br/><br/>' +
											'<b>Senin - Jumat:</b> 08.00 - 17.30 WIB<br/>' +
										'</div>' +
									'</div>' +
								'</div>' +
							'</div>' +
						'</div>' +
						'<div id="guestview" style="display:none;">' +
							'<div style="text-align: center; font-family: \'robotoboldcondensed\'; font-size: 16px; line-height: 26px; margin-bottom: 30px;">' +
								'<div style="margin-bottom: 10px; text-align: center; font-family: \'robotoboldcondensed\'; font-size: 23px;">MASUKKAN EMAIL UNTUK MELANJUTKAN PESANAN TANPA LOGIN / REGISTER</div>' +
							'</div>' +
							'<div class="boxForm login" style="width: 500px;">' +
							    '<div class="form-group">' +
									'<div class="control-input">' +
										'<input type="text" class="form-control" name="gemail" placeholder="Email">' +
									'</div>' +
							    '</div>' +
							    '<div id="errorguest" class="colorred">' +
								'</div>' +
							    '<div class="form-group">' +
									'<div class="boxButton" style="margin-left: 0px;text-align: right;">' +
										'<button name="guest" type="submit" class="btn black" style="top: 0px;">GUEST</button>' +
									'</div>' +
							    '</div>' +
								'<div class="boxSociallogin">' +
									'<div style="text-align: center; font-family: \'robotoboldcondensed\'; font-size: 16px; line-height: 26px; margin-bottom: 30px;">' +
										'<div style="margin-bottom: 10px; text-align: center; font-family: \'robotoboldcondensed\'; font-size: 23px;">ATAU DENGAN</div>' +
									'</div>' +
									'<div class="boxButtonSocial after_clear" style="text-align:center;">' +
										'<a href="javascript:;" class="btn soc_btn">FACEBOOK</a>' +
										'<a href="javascript:;" class="btn soc_btn google">GOOGLE</a>' +
										'<a href="javascript:;" class="btn soc_btn yahoo">YAHOO</a>' +
									'</div>' +
									'<div class="desc">' +
										'Kami tidak akan pernah posting dengan mengatas-namakan atau membagi informasi apapun tanpa persetujuan Anda' +
									'</div>' +
								'</div>' +
							'</div>' +
						'</div>' +
						'<div style="text-align: center; font-family: \'robotoboldcondensed\'; font-size: 16px; line-height: 26px; margin-bottom: 30px;">' +
							'<a href="javascript:;" id="linklogin" style="margin-bottom: 10px; text-align: center; font-family: \'robotoboldcondensed\'; font-size: 23px; padding-right:7px; margin-right:3px; border-right: 2px solid black;">LOGIN</a> ' +
							'<a href="javascript:;" id="linkregister" style="margin-bottom: 10px; text-align: center; font-family: \'robotoboldcondensed\'; font-size: 23px; padding-right:7px; margin-right:3px; border-right: 2px solid black;">REGISTER</a> ' +
							'<a href="javascript:;" id="linkguest" style="margin-bottom: 10px; text-align: center; font-family: \'robotoboldcondensed\'; font-size: 23px;">GUEST</a> ' +
						'</div>';


					$('#popup .contentnew').css('height', 'auto');
					$('#popup .contentnew').html(contentnew);

					openPopup('popup');

					$('.numberonly').numberOnly();

					$('#linklogin').css({ color: '#a8aaad' });

					$('#linklogin').click(function() {
						$('#linklogin').css({ color: '#a8aaad' });
						$('#linkregister').css({ color: 'black' });
						$('#linkguest').css({ color: 'black' });
						$('#loginview').show();
						$('#registerview').hide();
						$('#guestview').hide();
					});
					
					$('#linkregister').click(function() {
						$('#linklogin').css({ color: 'black' });
						$('#linkregister').css({ color: '#a8aaad' });
						$('#linkguest').css({ color: 'black' });
						$('#loginview').hide();
						$('#registerview').show();
						$('#guestview').hide();
					});
					
					$('#linkguest').click(function() {
						$('#linklogin').css({ color: 'black' });
						$('#linkregister').css({ color: 'black' });
						$('#linkguest').css({ color: '#a8aaad' });
						$('#loginview').hide();
						$('#registerview').hide();
						$('#guestview').show();
					});

					$('[name="login"]').click(function() {
						$('#errorlogin').html('');

						var email = $('[name="lemail"]').val();
						var password = $('[name="lpassword"]').val();
						var remember = $('[name="lremember"]:checked').val();
						
						$.ajax({
				            url         : '{{$basesite}}product-beauty/ajaxpost',
				            type        : 'POST',
				            data        : {'ajaxpost':"Login",'_token':'{{csrf_token()}}','email':email,'password':password,'remember':remember},
				            success     : function(data) {
				            	if(IsJsonString(data)) {
				            		var data = JSON.parse(data);
				            		var messageerror = '';
				            		$.each(data['data']['error'], function(keys, vals) {
										messageerror = messageerror + vals + '<br/>';
									});
							    	$('#errorlogin').html(messageerror);
				            	} else {
									location.reload();
				            	}
				            }
				        });
					});

					$('[name="register"]').click(function() {
						$('#errorregister').html('');
						$('#registerview').find('input[type="text"],input[type="password"]').css({border:'1px solid black'});

						var firstname = $('[name="rfirstname"]').val();
						var lastname = $('[name="rlastname"]').val();
						var gender = $('[name="rgender"]:checked').val();
						var phone = $('[name="rphone"]').val();
						var email = $('[name="remail"]').val();
						var password = $('[name="rpassword"]').val();
						var repassword = $('[name="rrepassword"]').val();
						var remember = $('[name="rremember"]:checked').val();
						var subscribe = $('[name="rsubscribe"]:checked').val();
						
						$.ajax({
				            url         : '{{$basesite}}product-beauty/ajaxpost',
				            type        : 'POST',
				            data        : {'ajaxpost':"Register",'_token':'{{csrf_token()}}','firstname':firstname,'lastname':lastname,'gender':gender,'phone':phone,'email':email,'password':password,'repassword':repassword,'remember':remember,'subscribe':subscribe},
				            success     : function(data) {
				            	if(IsJsonString(data)) {
				            		var data = JSON.parse(data);
				            		var messageerror = '';
				            		$.each(data['data']['error'], function(keys, vals) {
				            			if(vals.indexOf("--") != -1) {
				            				messageerror = messageerror + vals.replace('--', '') + '<br/>';
				            			} else {
				            				$('[name="'+vals+'"]').css({border:'1px solid red'});
				            			}
									});
							    	$('#errorregister').html(messageerror + '<br/>');
				            	} else {
									location.reload();
				            	}
				            }
				        });
					});

					$('[name="guest"]').click(function() {
						$('#errorguest').html('');

						var email = $('[name="gemail"]').val();
						
						$.ajax({
				            url         : '{{$basesite}}product-beauty/ajaxpost',
				            type        : 'POST',
				            data        : {'ajaxpost':"Guest",'_token':'{{csrf_token()}}','email':email},
				            success     : function(data) {
			            		var data = JSON.parse(data);
			            		if(data['response'] == 'OK') {
			            			location.reload();
			            		} else {
			            			var messageerror = '';
				            		$.each(data['data']['error'], function(keys, vals) {
			            				messageerror = messageerror + vals;
									});
							    	$('#errorguest').html(messageerror + '<br/>');
			            		}
				            }
				        });
					});

					$("#forgotpass").click(function() {
						$('#popup .titlenew').contents()[0].nodeValue = 'Lupa Password / Email Anda?';

				    	var contentnew = 
						'<div class="boxFormInline register after_clear" style="width: 100%; margin-top: 0px;"><div class="form-group">' +
							'<div class="control-label"><input type="text" name="Email" class="form-control" placeholder="Enter Your Email" style="width: 520px;"></div>' +
						'</div>' +
					    '<div class="form-group">' +
							'<button id="btnok" class="btn black" style="top: auto;">OK</button> <button id="btncancel" class="btn white" style="top: auto;">Cancel</button>' +
						'</div></div>';

						$('#popup .contentnew').css('height', 'auto');
						$('#popup .contentnew').html(contentnew);

						openPopup('popup');
						
						$("#btnok").on('click', function() {
							$('[name="Email"]').attr('style', 'border:1px solid black;width: 520px;');
							var Email = $('[name="Email"]').val();
							if(Email) {
								$.ajax({
						            url         : '{{$basesite}}login/ajaxpost',
						            type        : 'POST',
						            data        : {'ajaxpost':"ForgotPass",'_token':'{{csrf_token()}}','Email':Email},
						            success     : function(data) {
						                var data = JSON.parse(data);
						                if(data['response'] == 'OK') {
						                	closePopup('popup');
						                	_alertvalidation('We have send new password in your email !');
						                } else {
						                	$('[name="Email"]').attr('style', 'border:1px solid red;width: 520px;');
						                }
						            }
						        });
							} else {
								$('[name="Email"]').attr('style', 'border:1px solid red;width: 520px;');
							}
						});

						$("#btncancel").on('click', function() { closePopup('popup'); });
					});
                }
            }
        });
	}

	function IsJsonString(str) {
	    try {
	        JSON.parse(str);
	    } catch (e) {
	        return false;
	    }
	    return true;
	}

	$(document).on('click', '.sharedPopup > a', function(e){
        var type = $(this).attr('data-type');
        console.log(type);
		popupWidth = 780;
		popupHeight = 550;
        var
            verticalPos = Math.floor(($(window).width() - popupWidth) / 2),
            horisontalPos = Math.floor(($(window).height() - popupHeight) / 2);

        var popup = window.open($(this).prop('href'), 'social',
            'width='+popupWidth+',height='+popupHeight+
            ',left='+verticalPos+',top='+horisontalPos+
            ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

        if (popup) {
            popup.focus();
            e.preventDefault();
        }

    });
</script>