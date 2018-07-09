<style type="text/css">
	.newicon {
		width: 21px;
		height: 20px;
		margin-left: 10px;
		top: 20px;
		background: url({{$basesite}}assets/frontend/images/material/question.png) no-repeat;
		text-indent: -99999;
		color: transparent;
	}
</style>
<section class="akun_profile shopping_bag">
	<div class="wrapper">
		<h1>PURCHASE COMPLETED</h1>
		<!-- 
		<ul class="widget_shopping after_clear">
			<li class=""><a href="{{$basesite}}shopping-bag" class="">Shopping Bag</a></li>
			<li class=""><a href="{{$basesite}}payment-method" class="">Payment Method</a></li>
			<li class="active"><a href="{{$basesite}}purchase-completed" class="active">Purchase Completed</a></li>
		</ul>
		 -->

		<div class="boxPurchaseCompleted">
			<div class="boxCentered">
				<div class="boxthanks">
					TERIMA KASIH TELAH BERBELANJA DI LACIGUE
				</div>
				<div class="desc">
					Konfirmasi dan rincian pemesanan produk Anda akan dikirimkan ke alamat email
				</div>
				<div class="desc">
					<b>NOMOR TRANSAKSI<br/>{{$FinishCart['TransactionCode']}}</b>
				</div>
				<div class="desc">
					<b>TOTAL PEMBAYARAN<br/>
						@if($FinishCart['Type'] == 0)
						<span style="margin-right: 50px;">&nbsp;</span>
						@endif
						<span id="newprice" class="price">
						@if($FinishCart['Type'] == 0)
						{{$inv->_formatamount($FinishCart['GrandTotalUnique'], 'Rupiah', 'IDR ')}}
						@else
						{{$inv->_formatamount($FinishCart['GrandTotal'], 'Rupiah', 'IDR ')}}
						@endif
						</span> 
						@if($FinishCart['Type'] == 0)
						<span class="newicon tooltip" data-tooltip-content="#tooltip-content" data-tooltipster='{"side":"right","animation":"fade","maxWidth":"300", "trigger": "click", "theme": ["tooltipster-noir","tooltipster-noir-customized"]}'>ico</span>
						<div class="tooltip-template">
							<div id="tooltip-content">
								<p>3 Digit warna merah adalah kode unik transaksi anda.<br/>Akan kami masukkan ke dalam store kredit anda jika anda sudah membayarnya.</p>
							</div>
						</div>
						@endif
					</b>
				</div>
				<div class="boxPembayaran">
					<div class="img"><img src="{{$basesite}}assets/frontend/images/content/paymenttype/{{$FinishCart['PaymentTypeImage'].'?'.uniqid()}}"></div>
					@if($FinishCart['Type'] == 0)
					<div class="name_payment">
						Nomor Rekening {{$FinishCart['PaymentTypeName']}}
					</div>
					<div class="nomor_payment">
						{{$FinishCart['AccountBankNumber']}}
					</div>
					@elseif($FinishCart['Type'] == 1)
					<div class="name_payment">
						Nomor {{$FinishCart['PaymentTypeName']}} Virtual Account
					</div>
					<div class="nomor_payment">
						{{$FinishCart['VANumber']}}
					</div>
					@endif
				</div>
				<div class="desc">
					Silahkan Lihat halaman Order History untuk memantau status dan rincian pesanan Anda.
				</div>
				<div class="desc">
					Ditunggu order selanjutnya :)
				</div>
				<div class="desc">
					<a id="detailtransaction" href="javascript:;" class="btn black">Lihat Detail Pesanan</a>
				</div>
			</div>
			<div class="cara_pembayaran">
				@include('frontend1.procedureofpayment.'.$FinishCart['procedureofpayment'])
	            <div class="info_hub">
					Pertanyaan atau Masalah? +62 22 751 4100. <br/>
					Senin - Jumat : 08.00-17.30 WIB
				</div>
			</div>
		</div>
	</div>
</section>

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
	$("#detailtransaction").on("click", function() {
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
	@if($FinishCart['Type'] == 0)
	var textprice = $('#newprice').text().trim();
	textprice = textprice.substring(0, textprice.length - 3) + '<span style="color:red">' + textprice.substring(textprice.length, textprice.length - 3) + '</span>';
	$('#newprice').html(textprice);
	@endif
</script>