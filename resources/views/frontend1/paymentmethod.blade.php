<style type="text/css">
	.tb_tagih tfoot {
		border: none;
	}
	.tb_tagih tfoot tr {
		border: none;
	}
</style>
<form id="formpaymentmethod" action="{{$basesite}}processing" method="post">
	{{csrf_field()}}
	<section class="akun_profile shopping_bag">
		<div class="wrapper">
			<h1>PAYMENT METHOD</h1>
			<!-- 
			<ul class="widget_shopping after_clear">
				<li><a href="{{$basesite}}shopping-bag">Shopping Bag</a></li>
				<li class="active"><a href="{{$basesite}}payment-method" class="active">Payment Method</a></li>
				<li><a href="{{$basesite}}purchase-completed">Purchase Completed</a></li>
			</ul>
			 -->
			<div class="boxPaymentMethod">
				<div class="BoxTotalCost after_clear">
					<div class="boxCost">
						<div class="label_saldo">TOTAL COST</div>
						<div class="value_saldo">{{$Cart['GrandTotalTransaction']}}</div>
					</div>
					<div class="boxDetailTagihan">
						<a href="javascript:;">Detail Tagihan</a>
					</div>
				</div>
				<div class="boxMethod after_clear">
					<div class="boxChangeMethod">
						<div class="title">Pilih Metode Pembayaran</div>
						@if(count($arrTransferPaymentType))
						<div class="boxOption">
							<div class="label">Transfer Bank</div>
							@foreach($arrTransferPaymentType as $key => $val)
							<div class="form-group">
								<input id="radio-{{$val['ID']}}" class="radio-custom" name="PaymentMethod" value="{{$val['Type'].'-'.$val['ID']}}" type="radio" @if($key == 0) checked @endif>
								<label for="radio-{{$val['ID']}}" class="radio-custom-label" data-id="box-transfer-{{$val['ID']}}">
									<span class="ico"></span>
									{{$val['Name']}}
								</label>
							</div>
							@endforeach
						</div>
						@endif
						@if(count($arrVirtualPaymentType))
						<div class="boxOption">
							<div class="label">Virtual Account</div>
							@foreach($arrVirtualPaymentType as $key => $val)
							<div class="form-group">
								<input id="radio-{{$val['ID']}}" class="radio-custom" name="PaymentMethod" value="{{$val['Type'].'-'.$val['ID']}}" type="radio">
								<label for="radio-{{$val['ID']}}" class="radio-custom-label" data-id="box-virtual-{{$val['ID']}}">
									<span class="ico"></span>
									{{$val['Name']}}
								</label>
							</div>
							@endforeach
						</div>
						@endif
						@if(count($arrInternetPaymentType))
						<div class="boxOption">
							<div class="label">Internet Banking</div>
							@foreach($arrInternetPaymentType as $key => $val)
							<div class="form-group">
								<input id="radio-{{$val['ID']}}" class="radio-custom" name="PaymentMethod" value="{{$val['Type'].'-'.$val['ID']}}" type="radio">
								<label for="radio-{{$val['ID']}}" class="radio-custom-label" data-id="box-internet-{{$val['ID']}}">
									<span class="ico"></span>
									{{$val['Name']}}
								</label>
							</div>
							@endforeach
						</div>
						@endif
						@if(count($arrCreditPaymentType))
						<div class="boxOption">
							<div class="label">Credit Card / Virtual Card</div>
							@foreach($arrCreditPaymentType as $key => $val)
							<div class="form-group">
								<input id="radio-{{$val['ID']}}" class="radio-custom" name="PaymentMethod" value="{{$val['Type'].'-'.$val['ID']}}" type="radio">
								<label for="radio-{{$val['ID']}}" class="radio-custom-label" data-id="box-another-{{$val['ID']}}">
									<span class="ico"></span>
									{{$val['Name']}}
								</label>
							</div>
							@endforeach
						</div>
						@endif
						@if(count($arrAnotherPaymentType))
						<div class="boxOption">
							<div class="label">Another / Gerai</div>
							@foreach($arrAnotherPaymentType as $key => $val)
							<div class="form-group">
								<input id="radio-{{$val['ID']}}" class="radio-custom" name="PaymentMethod" value="{{$val['Type'].'-'.$val['ID']}}" type="radio">
								<label for="radio-{{$val['ID']}}" class="radio-custom-label" data-id="box-another-{{$val['ID']}}">
									<span class="ico"></span>
									{{$val['Name']}}
								</label>
							</div>
							@endforeach
						</div>
						@endif
					</div>
					<div class="boxDetailPayment">
						<div class="boxDetailPaymentOuter">
							<div class="boxDetailPaymentInner">
								<div class="title">DETAIL PEMBAYARAN</div>
								<div style="display: inherit;">
									<div class="boxStore after_clear" style="display:none;">
										<div class="box_cek">
											<div class="form-group">
										      <input id="store_kredit" class="checkbox-custom" name="checkbox-method" type="checkbox" checked >
									            <label for="store_kredit" class="checkbox-custom-label">
									            	<span class="img"></span>
									            </label>
										    </div>
										</div>
										<div class="boxImgMoney">
											<span>IDR</span>
										</div>
										<div class="boxLabelName">
											Store Kredit
										</div>
										<div class="boxPrice">
											IDR 500.000
										</div>
										<div class="boxQuestion tooltip" data-tooltip-content="#tooltip-content" data-tooltipster='{"side":"top","animation":"fade","maxWidth":"250", "trigger": "click", "theme": ["tooltipster-noir","tooltipster-noir-customized"]}'>
											<img src="{{$basesite}}assets/frontend/images/material/question_grey.png">
											<div class="tooltip-template">
												<div id="tooltip-content">
													<p>Gunakan store kredit seperti voucher belanja untuk memesan produk. Store kredit hanya dapat digunakan 1x transaksi dan berlaku sampai akhir tahun</p>
												</div>
											</div>
										</div>
									</div>

									@if(count($arrTransferPaymentType))
									@foreach($arrTransferPaymentType as $key => $val)
									<div class="dynamic_content_payment" id="box-transfer-{{$val['ID']}}" @if($key != 0) style="display: none;" @endif>
										<div class="label_visa after_clear">
											<div class="label">Transfer Bank {{$val['Name']}}</div>
											<div class="boxVer">
												<a href="javascript:;">
													<img style="height:30px;" src="{{$basesite}}assets/frontend/images/content/paymenttype/{{$val['Image'].'?'.uniqid()}}">
												</a>
											</div>
										</div>
										<div class="boxIsi">
											<div class="boxInput">
												<div class="label">Nomor Rekening Anda</div>
												<div class="input after_clear">
													<input type="text" name="AccountNumber{{$val['ID']}}" class="numberonly" placeholder="Masukkan nomor rekening sesuai rekening asli" autocomplete="off">						
												</div>
											</div>
											<div class="boxInput">
												<div class="label">Nama Pemilik Rekening</div>
												<div class="input after_clear">
													<input type="text" name="BeneficiaryName{{$val['ID']}}" placeholder="Masukkan nama pemilik rekening sesuai buku tabungan" autocomplete="off">						
												</div>
											</div>				
										</div>
										<div class="boxDesc">
											{!! str_replace("{ACCOUNTNUMBER}", "<b>".$val['BankAccountNumber']."</b>", $val['Notes']) !!}
										</div>
									</div>
									@endforeach
									@endif
									
									@if(count($arrVirtualPaymentType))
									@foreach($arrVirtualPaymentType as $key => $val)
									<div class="dynamic_content_payment" id="box-virtual-{{$val['ID']}}" style="display: none;">
										<div class="label_visa after_clear">
											<div class="label">Virtual Account {{$val['Name']}}</div>
											<div class="boxVer">
												<a href="javascript:;">
													<img style="height:30px;" src="{{$basesite}}assets/frontend/images/content/paymenttype/{{$val['Image'].'?'.uniqid()}}">
												</a>
											</div>
										</div>
										<div class="boxDesc">
											{!! str_replace("{METHODNAME}", "<b>".$val['Name']."</b>", $val['Notes']) !!}
										</div>
									</div>
									@endforeach
									@endif

									@if(count($arrInternetPaymentType))
									@foreach($arrInternetPaymentType as $key => $val)
									<div class="dynamic_content_payment" id="box-internet-{{$val['ID']}}" style="display: none;">
										<div class="label_visa after_clear">
											<div class="label">{{$val['Name']}}</div>
											<div class="boxVer">
												<a href="javascript:;">
													<img style="height:30px;" src="{{$basesite}}assets/frontend/images/content/paymenttype/{{$val['Image'].'?'.uniqid()}}">
												</a>
											</div>
										</div>
										<div class="boxDesc">
											{!! str_replace("{METHODNAME}", "<b>".$val['Name']."</b>", $val['Notes']) !!}
										</div>
									</div>
									@endforeach
									@endif

									<div class="dynamic_content_payment" id="box-internet-2-" style="display: none;">
										<div class="label_visa after_clear">
											<div class="label">Visa / Master Card</div>
											<div class="boxVer">
												<a href="javascript:;">
													<img src="{{$basesite}}assets/frontend/images/material/verified.png">
												</a>
											</div>
										</div>
										<div class="boxIsi">
											<div class="boxInput">
												<div class="label">Nomor Kartu Kredit</div>
												<div class="input after_clear">
													<input type="text" name="nomor" placeholder="Contoh : 1234 4678 9012 3456" autocomplete="off">
													<span class="img img_kredit" style="width: 104px;"><img src="{{$basesite}}assets/frontend/images/material/visa_master.png"></span>
												</div>
											</div>
											<div class="boxInput">
												<div class="label">Masa Berlaku Kartu</div>
												<div class="input after_clear">
													<div class="berlaku_kartu">
														<input type="number" name="nomor" placeholder="MM" maxlength="2" autocomplete="off">
													</div>
													<div class="berlaku_kartu">
														<input type="number" name="nomor" placeholder="YY" maxlength="2" autocomplete="off">
													</div>
												</div>
											</div>
											<div class="boxInput">
												<div class="label">CVV</div>
												<div class="input input_cvv after_clear">
													<input type="text" name="nomor" placeholder="Contoh : 1234" style="width: 122px;" autocomplete="off">
													<span class="img tooltip" data-tooltip-content="#tooltip-cvv" data-tooltipster='{"side":"right","animation":"fade","maxWidth":"200", "trigger": "click", "theme": ["tooltipster-noir","tooltipster-noir-customized"]}'>
														<img src="{{$basesite}}assets/frontend/images/material/question_grey.png">
														<div class="tooltip-template">
															<div id="tooltip-cvv">
																<p>3 Nomor yang tertera di belakang kartu</p>
															</div>
														</div>
													</span>
												</div>
											</div>
										</div>
										<div class="boxDesc">
											<p>* Periksa kembali data pembayaran Anda sebelum melanjutkan transaksi</p>
										</div>
									</div>
									
									<div class="dynamic_content_payment" id="box-another-3-" style="display: none;">
										<div class="label_visa after_clear">
											<div class="label">Alfamart</div>
											<div class="boxVer">
												<a href="javascript:;">
													<img src="{{$basesite}}assets/frontend/images/material/alfamart.png">
												</a>
											</div>
										</div>
										<div class="boxDesc">
											<p>Dapatkan kode pembayaran setelah menekan tombol Order Now, tunjukkan ke kasir dan bayar sesuai tagihan</p>
											<p>* Periksa kembali data pembayaran Anda sebelum melanjutkan transaksi</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="boxButton">
							<button type="submit" name="submit" class="btn black">ORDER NOW</button>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</section>
</form>
<div class="wrap-popup" id="popup-alert">
    <div class="overlay-pop2"></div>
    <div class="box-popup type_2" style="max-width: 650px;padding:20px;position: relative;">
        <span class="closepop" style="color: #000;position: absolute;right: 20px;font-family:'robotomedium';font-size: 18px;">X</span>

        <div class="content" style="height: auto;padding-left: 40px;padding-right: 40px;margin-top: 20px;">
        	<p style="line-height: 35px;text-align: center;font-size: 27px;font-family: 'robotocondensedreguler'">
        		Anda tidak memiliki saldo Store Kredit.<br/>Mohon gunakan metode pembayaran lain
        	</p>
        </div>
    </div>
</div>

<div class="wrap-popup" id="popup-tagihan">
    <div class="overlay-pop2"></div>
    <div class="box-popup type_2 tagihan" style="max-width: 650px;padding:20px;position: relative;">
        <span class="closepop" style="color: #000;position: absolute;right: 20px;font-family:'robotomedium';font-size: 18px;cursor:pointer;">X</span>
        <div class="content" style="height: auto;padding-left: 20px;padding-right: 20px;margin-top: 20px;">
			<div class="boxDetailTagihan">
				<div class="title_tagih">DETAIL TAGIHAN</div>
				<table class="tb_tagih">
					@foreach($Cart as $key => $val)
					@if(is_numeric($key))
						@foreach($val['Shipping'] as $key1 => $val1)
							@foreach($val1['ShippingPackage'] as $key2 => $val2)
								@foreach($val2['District'] as $key3 => $val3)
									@foreach($val3['Product'] as $key4 => $val4)
										<tr>
											<th align="left">
												{{strtoupper($val4['ProductName'])}} - {{strtoupper($val4['ProductBrand'])}}
												<div class="detail">{{$val4['ProductQty']}} x {{$val4['ProductPrice']}}</div>
												@if($val4['ShippingPrice'])
												<div class="detail">
													DELIVERY - {{$val1['ShippingName']}} {{$val4['ShippingPackage']}} {{$val4['ShippingPrice']}}
												</div>
												@endif
											</th>
											@if($val4['ShippingPrice'])
											<th align="center" style="width: 100px;">
												{{explode(' ', $val4['SubTotalPrice'])[0]}}
											</th>
											<th align="right">
												{{explode(' ', $val4['SubTotalPrice'])[1]}}
											</th>
											@endif
										</tr>
									@endforeach
								@endforeach
							@endforeach
						@endforeach
					@endif
					@endforeach
					<tr style="border-top: 1px solid black;">
						<th align="left" style="padding-top: 30px;">TOTAL COST</th>
						<th align="center" style="width: 100px;">{{explode(' ', $Cart['SubTotalTransaction'])[0]}}</th>
						<th align="right">{{explode(' ', $Cart['SubTotalTransaction'])[1]}}</th>
					</tr>
				</table>
			</div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(".form-group").on("click", "label.radio-custom-label", function(){
	var $id = $(this).attr("data-id");
	$(".dynamic_content_payment").slideUp();
	$("#"+$id).slideDown();
});

$(".boxDetailTagihan").on("click", "a", function() {
	var idPop = $("#popup-tagihan"),
    	contentPop = idPop.find('.box-popup');

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

$('[name="PaymentMethod"]').click(function() {
	$('input[type^="text"],input[type^="number"]').val('').attr('disabled', true);
	var PaymentMethod = $('[name="PaymentMethod"]:checked');
	var ID = PaymentMethod.parent().find('label').attr('data-id').split('-').pop(-1);
	
	if(PaymentMethod.parent().find('label').attr('data-id').indexOf("box-transfer-") != -1) {
		$('[name="AccountNumber'+ID+'"]').attr('disabled', false);
		$('[name="BeneficiaryName'+ID+'"]').attr('disabled', false);
	} else {
		
	}
});

$(document).ready(function() {
	$('input[type^="text"],input[type^="number"]').val('').attr('disabled', true);
	var PaymentMethod = $('[name="PaymentMethod"]:checked');
	var ID = PaymentMethod.parent().find('label').attr('data-id').split('-').pop(-1);
	
	if(PaymentMethod.parent().find('label').attr('data-id').indexOf("box-transfer-") != -1) {
		$('[name="AccountNumber'+ID+'"]').attr('disabled', false);
		$('[name="BeneficiaryName'+ID+'"]').attr('disabled', false);
	}

	$('#formpaymentmethod').submit(function() {
		var PaymentMethod = $('[name="PaymentMethod"]:checked');
		var ID = PaymentMethod.parent().find('label').attr('data-id').split('-').pop(-1);
		var messageerror = '';
		if(PaymentMethod.parent().find('label').attr('data-id').indexOf("box-transfer-") != -1) {
			var AccountNumber = $('[name="AccountNumber'+ID+'"]').val();
			var BeneficiaryName = $('[name="BeneficiaryName'+ID+'"]').val();

			if(!AccountNumber) messageerror = messageerror + '<div class="control-label"><span class="colorred">*</span> Nomor Rekening Anda harus diisi !</div>';
			if(!BeneficiaryName) messageerror = messageerror + '<div class="control-label"><span class="colorred">*</span> Nama Pemilik Rekening harus diisi !</div>';
		} else {
			
		}

		if(!messageerror) {
			
		} else {
			_alertvalidation(messageerror);
			return false;
		}
	});
});
</script>