<style type="text/css">
	.tbaddress {
		height: 25px;
	    font-family: "robotoreguler";
	    font-size: 15px;
	    color: #111111;
	}
	.tbaddress tr {
		height: 25px;
	}
	.boxForm .form-group .checkbox-custom + .checkbox-custom-label:before, .boxForm .form-group .radio-custom + .radio-custom-label:before {
		content: '';
		background: #a8aaad;
		border: 1px solid #ddd;
		display: inline-block;
		vertical-align: middle;
		width: 15px;
		height: 15px;
		padding: 2px;
		margin-right: 10px;
		text-align: center;
		position: relative;
	}
</style>
<section class="akun_profile shopping_bag">
	<div class="wrapper">
		@if(!isset($Cart))
		<h1 style="color:red">SHOPPING BAG NOT FOUND</h1>
		@else
		<h1>SHOPPING BAG</h1>
		<!-- 
		<ul class="widget_shopping after_clear">
			<li class="active"><a href="{{$basesite}}shopping-bag" class="active">Shopping Bag</a></li>
			<li class=""><a href="{{$basesite}}payment-method" class="">Payment Method</a></li>
			<li class=""><a href="{{$basesite}}purchase-completed" class="">Purchase Completed</a></li>
		</ul>
		 -->
		<div class="boxOrder">
			<div class="contentDynamic">
				<div class="content_dynamic" style="display: inherit">

					<div class="boxPesananList pembayaran">
						<div class="title" style="text-align: left;padding-left: 20px;">YOUR ORDER DETAILS</div>

						@foreach($Cart as $key => $val)
						@if(is_numeric($key))
						<div class="boxSeller">
							<div class="seller_text">
								Seller : <a href="javascript:;">{{$val['SellerName']}}</a>
							</div>

							@foreach($val['Shipping'] as $key1 => $val1)
							<div class="boxTrack boxtrackMulti after_clear">
								@foreach($val1['ShippingPackage'] as $key2 => $val2)
									@foreach($val2['District'] as $key3 => $val3)
										@foreach($val3['Product'] as $key4 => $val4)
								<div class="boxTrackBorder after_clear" id="list{{$val4['ProductLink']}}">
									<div class="boxtrackMultiInner">
										<div class="boxTrackInner bordered after_clear">
											<div class="detail">
												<div class="detail_inner after_clear">
													<div class="det1">
														<img id="image{{$val4['ProductLink']}}" src="{{$basesite}}assets/frontend/images/content/product/medium_{{$val4['ProductImage']}}">
														<div class="boxChange" style="margin-left: 20px;">
															<a href="javascript:;" data-table="table_edit{{$val4['ProductLink']}}">CHANGE DETAILS</a>
														</div>
													</div>
													<div class="det1">
														<div class="desc">{{strtoupper($val4['ProductName'])}}</div>
														<div class="name">{{strtoupper($val4['ProductBrand'])}}</div>
														<div class="price">{{$val4['ProductPrice']}}</div>
														<table class="other_det" id="table_edit{{$val4['ProductLink']}}" style="width: 100%; !important;">
															@if(!$val4['ProductType'])
															<tr>
																<td style="width: 30px; !important;">COLOR<span id="ProductColorID{{$val4['ProductLink']}}" style="display:none;">{{$val4['ProductColorID']}}</span></td>
																<td>
																	<span class="label_edit enable">{{$val4['ProductColor']}}</span>
																	<div class="input_edit enable">
																		{{$val4['ProductColor']}}
																	</div>
																</td>
															</tr>
															@endif
															<tr>
																<td>SIZE VARIANT<span id="ProductSizeVariantID{{$val4['ProductLink']}}" style="display:none;">{{$val4['ProductSizeVariantID']}}</span></td>
																<td>
																	<span class="label_edit enable">{{$val4['ProductSize']}}</span>
																	<div class="input_edit enable">
																		<select id="selectsize{{$val4['ProductLink']}}" onchange="GetQty(this.value)">
																		</select>
																	</div>
																</td>
															</tr>
															<tr>
																<td>Quantity<span id="ProductQty{{$val4['ProductLink']}}" style="display:none;">{{$val4['ProductQty']}}</span></td>
																<td>
																	<span class="label_edit enable">{{$val4['ProductQty']}}</span>
																	<div class="input_edit enable after_clear">
																		<select id="selectqty{{$val4['ProductLink']}}" style="width:70px;height:22px;">
																		</select>
																		<button class="btn black small update_order" style="margin-top: 1px;" onclick="Update('{{$val4['ProductLink']}}')">UPDATE</button>
																	</div>
																</td>
															</tr>
														</table>
													</div>
													<div class="det1">
														<div class="boxCatatan">
															<span class="catatan" id="catat{{$val4['ProductLink']}}">Catatan untuk penjual</span>
															<textarea class="text_catatan" data-id="catat{{$val4['ProductLink']}}" disabled >{!!$val4['ProductNotes']!!}</textarea>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="boxtrackMultiInner">
										<div class="boxTrackInner ship_address after_clear">
											<div class="status" style="width:100% !important;">
												<div class="label_status">
													<span>SHIPPING ADDRESS</span>
													<a href="javascript:;" class="remove_ship" onclick="Remove('{{$val4['ProductLink']}}')">X Remove</a>
												</div>
												<table class="tbaddress">
													<span id="IDCustomerAddress" style="display: none;">{{$val4['IDCustomerAddress']}}</span>
													<!-- <tr>
														<td width="100px">Address Info</td><td width="10px">:</td><td>
															<span id="TextAddressInfo">{{$val4['TextAddressInfo']}}</span>
														</td>
													</tr> -->
													<tr>
														<td width="100px">Name</td><td width="10px">:</td><td>
															<span id="TextRecepientName">{{$val4['TextRecepientName']}}</span>
														</td>
													</tr>
													<tr>
														<td>Phone</td><td>:</td><td>
															<span id="TextRecepientPhone">{{$val4['TextRecepientPhone']}}</span>
														</td>
													</tr>
													<tr>
														<td>Address</td><td>:</td><td>
															<span id="TextAddress">{!!$val4['TextAddress']!!}</span><br/>
															<span id="IDProvince" style="display: none;">{{$val4['IDProvince']}}</span>
															<span id="TextDistrictName">{{$val4['TextDistrictName'].', '}}</span><span id="IDDistrict" style="display: none;">{{$val4['IDDistrict']}}</span> <span id="TextCityName">{{$val4['TextCityName']}}</span><span id="IDCity" style="display: none;">{{$val4['IDCity']}}</span> <span id="TextPostalCode">{{$val4['TextPostalCode']}}</span>
														</td>
													</tr>
												</table>
												@if($val4['ShippingPrice'])
												<table class="tb_subtotal" style="bottom: 0;">
													<tr>
														<th>DELIVERY - {{$val1['ShippingName']}} {{$val4['ShippingPackage']}}</th>
														<td align="right">{{$val4['ShippingPrice']}}</td>
													</tr>
													<tr>
														<th>SUB TOTAL</th>
														<td align="right">{{$val4['SubTotalPrice']}}</td>
													</tr>
												</table>
												@endif
											</div>
										</div>
									</div>
								</div>
										@endforeach
									@endforeach
								@endforeach
								<div class="boxSum2 ship after_clear">
									<ul>
										<li>
											<div class="boxTotal after_clear">
												<div>
													<div>Total per Tagihan :</div>
													<div>{{$val['SubTotalSeller']}}</div>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
							@endforeach
						</div>
						@endif
						@endforeach

						<div class="alertInfo">
							You've qualified for Free Express Shipping. Don't forget to enter the promo code <b>LACIEXPRESS</b> at checkout
							<span class="ico_delivery"></span>
						</div>
						<div class="boxAllTotal after_clear">
							<div class="boxVoucher">
								<form method="post">
									<div class="boxFormInline">
										<div class="form-group" style="float: none;width: 100%;margin-right: 0px;display: block;">
											<div class="control-label">
												VOUCHER CODE
											</div>
											<div class="control-input">
												<input type="text" name="voucher_code" class="form-control" placeholder="Enter Your Voucher Code Here">
											</div>						
										</div>
										<div class="form-group"" style="float: none;width: 100%;margin-right: 0px;">
											<div class="boxButton" style="margin-left: 0px;padding:0px 0px 0px 0px;">
												<button type="submit" class="btn black">USE VOUCHER</button>
												@if(\Session::get('customerdata'))
												<a href="javascript:;" class="use_voucher tooltip" data-tooltip-content="#tooltip-content" data-tooltipster='{"side":"right","animation":"fade","maxWidth":"900", "trigger": "click", "theme": ["tooltipster-shadow","tooltipster-lightmenu-customized"]}'>See your voucher</a>
												<div class="tooltip-template">
													<div id="tooltip-content">
														<table class="tb_voucher">
															<tr>
																<th>Kode</th>
																<th>Jumlah</th>
																<th>Valid Sampai</th>
																<th>
																	<span onclick="$('.tooltip').tooltipster('close');" style="position: absolute;right: 10px;cursor:pointer;">X</span>
																</th>
															</tr>
															<tr>
																<td>IVA1QKJY0</td>
																<td>RP 100.000</td>
																<td>14 May 2014 23:59</td>
																<td><a href="" class="btn black small">PAKAI</a></td>
															</tr>
															<tr>
																<td>IVA1QKJY0</td>
																<td>RP 100.000</td>
																<td>14 May 2014 23:59</td>
																<td><a href="" class="btn black small">PAKAI</a></td>
															</tr>
															<tr>
																<td>IVA1QKJY0</td>
																<td>RP 100.000</td>
																<td>14 May 2014 23:59</td>
																<td><a href="" class="btn black small">PAKAI</a></td>
															</tr>
														</table>
													</div>
												</div>
												@endif
											</div>
										</div>
									</div>
								</form>
							</div>
							<div class="boxTotal after_clear">
								<table class="boxDetailPrice">
									<tr>
										<th>QUANTITY Total</th><td>{{$Cart['CountProduct']}}</td>
									</tr>
									<tr>
										<th>Sub Total</th><td>{{$Cart['SubTotalTransaction']}}</td>
									</tr>
								</table>
								<div class="total_cost">TOTAL COST :</div>
								<div class="total_price">{{$Cart['SubTotalTransaction']}}</div>
							</div>	
						</div>
						<div class="boxButton pay_now after_clear">
							<a href="{{$basesite}}" class="btn medium">CONTINUE SHOPPING</a>
							<a href="{{$basesite}}payment-method" class="btn black medium">PAY NOW</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif
	</div>
</section>
<script type="text/javascript">
	$(document).ready(function() {
		$(".boxChange a").click(function() {
			var $table = $(this).attr("data-table"),
				$label = $("#"+$table).find(".label_edit.enable"),
				$input = $("#"+$table).find(".input_edit.enable");
			var thisa = $(this);

			if(!thisa.parent().hasClass("active")) {
				$.ajax({
		            url         : '{{$basesite}}shopping-bag/ajaxpost',
		            type        : 'POST',
		            data        : {'ajaxpost':"ChangeDetail",'_token':'{{csrf_token()}}','ID':$table},
		            success     : function(data) {
		                var data = JSON.parse(data);
		                if(data['response'] == 'OK') {
		                	var selectsize = '';
		                	var arrsize = [];
		                	$.each(data['data']['ArrSize'], function(keys, vals) {
		                		if(vals['SizeVariantID'] == data['data']['selectsize'])
									selectsize = selectsize + '<option value="'+vals['SizeVariantID']+'-'+data['data']['ProductLink']+'" selected >'+vals['SizeName']+'</option>';
		                		else
									selectsize = selectsize + '<option value="'+vals['SizeVariantID']+'-'+data['data']['ProductLink']+'">'+vals['SizeName']+'</option>';
								arrsize[vals['SizeVariantID']] = vals['SizeQty'];
							});
							$('#selectsize'+data['data']['ProductLink']).html(selectsize);

							var selectqty = '';
		                	for (var i=1; i<=arrsize[data['data']['selectsize']]; i++) {
		                		if(i == data['data']['selectqty'])
									selectqty = selectqty + '<option value="'+i+'" selected >'+i+'</option>';
		                		else
									selectqty = selectqty + '<option value="'+i+'">'+i+'</option>';
								if(i == 10) break;
		                	}

							$('#selectqty'+data['data']['ProductLink']).html(selectqty);

							$label.hide();
							$input.show();
							$('[data-id="catat'+$table.replace('table_edit','')+'"]').attr("disabled", false);
							thisa.html("CANCEL DETAIL");
							thisa.parent().addClass("active");
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
				$label.show();
				$input.hide();
				$('[data-id="catat'+$table.replace('table_edit','')+'"]').attr("disabled", true);
				thisa.html("CHANGE DETAIL");
				thisa.parent().removeClass("active");
			}
		});

		$('[data-id^="catat"]').each(function() {
			if(this.value.length == 0) {
				$('#'+this.getAttribute('data-id')).css({
					visibility: "visible",
					opacity: 1
				});
			} else {
				$('#'+this.getAttribute('data-id')).css({
					visibility: "hidden",
					opacity: 0
				});
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

			if($val.length == 0){
				$("#"+$id).css({
					visibility: "visible",
					opacity: 1
				});
			} else {
				$("#"+$id).css({
					visibility: "hidden",
					opacity: 0
				});
			}
		}); 
    });

    function GetQty(ID) {
		$.ajax({
            url         : '{{$basesite}}shopping-bag/ajaxpost',
            type        : 'POST',
            data        : {'ajaxpost':"GetQty",'_token':'{{csrf_token()}}','ID':ID},
            success     : function(data) {
                var data = JSON.parse(data);
                if(data['response'] == 'OK') {
                	var selectqty = '';
                	alert(data['data']['ProductLink']);
                	for (var i=1; i<=data['data']['SizeQty']; i++) {
						selectqty = selectqty + '<option value="'+i+'">'+i+'</option>';
						if(i == 10) break;
                	}
                	$('#selectqty'+data['data']['ProductLink']).html(selectqty);
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

    function Remove(ID) {
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
	            url         : '{{$basesite}}shopping-bag/ajaxpost',
	            type        : 'POST',
	            data        : {'ajaxpost':"Remove",'_token':'{{csrf_token()}}','ID':ID},
	            success     : function(data) {
	                var data = JSON.parse(data);
	                if(data['response'] == 'OK') {
	                	location.reload();
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

    function Update(ID) {
    	$('#popup .titlenew').contents()[0].nodeValue = 'Update ?';

		var contentnew = 
		'<div class="boxFormInline register after_clear" style="width: 100%; margin-top: 0px;"><div class="form-group">' +
			'<div class="control-label colorred">Anda yakin akan mengubah ?</div>' +
		'</div>' +
	    '<div class="form-group">' +
			'<button id="btnok" class="btn black" style="top: auto;">OK</button> <button id="btncancel" class="btn white" style="top: auto;">Cancel</button>' +
		'</div></div>';

		$('#popup .contentnew').css('height', 'auto');
		$('#popup .contentnew').html(contentnew);

		openPopup('popup');

		var SizeVariantID = $('#selectsize'+ID).val();
		var Qty = $('#selectqty'+ID).val();
		var Notes = $('[data-id="catat'+ID+'"]').val();

		$("#btnok").on('click', function() {
			$.ajax({
	            url         : '{{$basesite}}shopping-bag/ajaxpost',
	            type        : 'POST',
	            data        : {'ajaxpost':"Update",'_token':'{{csrf_token()}}','ID':ID,'SizeVariantID':SizeVariantID,'Qty':Qty,'Notes':Notes},
	            success     : function(data) {
	                var data = JSON.parse(data);
	                if(data['response'] == 'OK') {
	                	location.reload();
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