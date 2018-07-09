<style>
	.boxPoin .title, .boxPoin .date {
		text-align: left !important;
	}
</style>
<div class="boxPoin point">
	<div class="title">TOTAL POIN SAAT INI : <span class="poinred"><span id="Point">{{$CustomerData->Point?$CustomerData->Point:0}}</span> POIN</span></div>
	<div class="date">Berlaku sampai {{date('d F Y', strtotime('12/31'))}}</div>

	<div class="listPoint">
		@if(count($ExchangePoint))
		@foreach($ExchangePoint as $key1 => $val1)
		<div class="listPointInner">
			<div class="circlePoint">
				<div class="poin_number">{{$val1->Point}} <div>POIN</div></div>
			</div>
			<div class="textPoint">
				<div class="text">STORE CREDIT</div>
				<div class="price">{{$inv->_formatamount($val1->StoreCredit, 'Rupiah', 'IDR ')}}</div>
				<div class="link"><a href="{{$basesite}}affiliate#termsconditions" target="_blank">* Syarat dan ketentuan berlaku</a></div>
			</div>
			<div class="boxButton">
				<a href="javascript:;" onclick="RedeemPoint('{{$val1->Point}}');" class="btn">REDEEM POIN</a>
			</div>
		</div>
		@endforeach
		@else
		<div width="100%" style="text-align: center;"><h4 style="color:red">Belum ada Redeem Point yang dibuat.</h4></div>
		@endif
	</div>

	<div class="boxAktifitasPoint" style="margin:0;">
		@if(count($CustomerPointHistory))
		<div class="titleaktifitas">AKTIFITAS POIN ANDA</div>
		<table class="tb_aktifitas">
			<thead>
				<tr>
					<td scope="col">Tanggal</td>
					<td scope="col" align="center">Jumlah Poin</td>
					<td scope="col" align="center">Order Code</td>
					<td scope="col" align="center">Total Payment</td>
				</tr>
			</thead>
			<tbody>
				@foreach($CustomerPointHistory as $key1 => $val1)
				<tr>
					<td data-label="Tanggal">{{$inv->_dateformysql($val1['CreatedDate'])->format('d/m/y')}}</td>
					<td data-label="Jumlah Poin" align="center" @if(!$val1['TransactionCode']) class="minus" @endif>@if($val1['TransactionCode'])+ {{$val1['Total']}}@else - {{$val1['Total']}}@endif</td>
					<td data-label="Order Code" align="center">@if($val1['TransactionCode']){{$val1['TransactionCode']}}@else - @endif</td>
					<td data-label="Total Payment" align="center">
						@php
							if($val1['CurrencyCode'] == 'IDR')
		                        $TransactionTotal = $inv->_formatamount($val1['TransactionTotal'], 'Rupiah', 'Rp. ').',-';
		                    else
		                        $TransactionTotal = $inv->_formatamount($val1['TransactionTotal'], 'Dollar', 'Rp. ').',-';
						@endphp
						@if($val1['TransactionCode']){{$TransactionTotal}}@else - @endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else
		<div width="100%" style="text-align: center;"><h4 style="color:red">Belum ada Aktifitas Poin saat ini.</h4></div>
		@endif	
	</div>
</div>

<script type="text/javascript">
	function RedeemPoint(point) {
		$('#popup .titlenew').contents()[0].nodeValue = 'Redeem Point ?';

		var contentnew = 
		'<div class="boxFormInline register after_clear" style="width: 100%; margin-top: 0px;"><div class="form-group">' +
			'<div class="control-label colorred">Anda yakin akan Redeem Point ' + point + ' ?</div>' +
		'</div>' +
	    '<div class="form-group">' +
			'<button id="btnok" class="btn black" style="top: auto;">OK</button> <button id="btncancel" class="btn white" style="top: auto;">Cancel</button>' +
		'</div></div>';

		$('#popup .contentnew').css('height', 'auto');
		$('#popup .contentnew').html(contentnew);

		openPopup('popup');

		$("#btnok").on('click', function() {
			$.ajax({
	            url         : '{{$basesite}}wallet/ajaxpost',
	            type        : 'POST',
	            data        : {'ajaxpost':"RedeemPoint",'_token':'{{csrf_token()}}','Point':point},
	            success     : function(data) {
	                var data = JSON.parse(data);
	                if(data['response'] == 'OK') {
	                	_alertvalidation('Redeem Point berhasil.');

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