<style type="text/css">
	section.akun_profile .boxGift {
		padding-top: 0px;
	}
</style>
<div class="voucher">
	<div class="boxGift after_clear">
		<div class="boxFormInline register after_clear" style="width: auto;margin-top: 0px;">
			<form class="form-horizontal" method="post">
				{{csrf_field()}}
				<div class="boxinput2 after_clear">
				    <div class="form-group" style="width: 729px;">
						<div class="control-label">
							GIFT CARD
						</div>
						<div class="control-input">
							<input type="text" class="form-control" name="vouchercode" value="{{$vouchercode}}" placeholder="Masukan Kode Gift Card Anda">
							<span class="note">1 Kode Gift Card Hanya bisa dimasukan 1 kali</span>
							<div style="color:red; margin-top: 10px; width: 100%;"> @if($errorvouchercode != 'null') {{$errorvouchercode}} @endif </div>
						</div>
				    </div>
				    <div class="form-group" style="width: 130px;">        
						<div class="boxButton" style="margin-left: 0px;text-align: right;margin-top: 5px;">
							<button type="submit" name="submit" class="btn black" style="height: 54px;">MASUKAN</button>
						</div>
				    </div>
				</div>
			</form>
		</div>
	</div>
	<div class="boxVoucher">
		@if(count($CustomerVoucher))
		<div class="title">VOUCHER</div>
		<table class="tb_tarif">
			<thead>
				<tr>
					<th scope="col" align="center">KODE</th>
					<th scope="col" align="left">JUMLAH</th>
					<th scope="col" align="center">VALID SAMPAI</th>
					<th scope="col" align="center">STATUS</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($CustomerVoucher as $key1 => $val1)
				<tr>
					<td data-label="KODE" align="center" style="width: 20%">{{$val1->VoucherCode}}</td>
					<td data-label="JUMLAH" style="width: 20%">- {{$inv->_formatamount($val1->VoucherAmount, 'Rupiah', 'Rp. ')}}</td>
					<td data-label="VALID SAMPAI" align="center" style="width: 20%">{{substr($inv->_datetimeforhtml($val1->ValidDate), 0, -3)}}</td>
					<td data-label="STATUS" align="center">
						@if($val1->IsUsed == 0) BELUM PAKAI @endif
						@if($val1->IsUsed == 1) SUDAH PAKAI @endif
						@if($val1->IsUsed == 2) HANGUS @endif
					</td>
					<td>
						@if($val1->IsUsed == 1)
						<a href="{{$basesite}}order/action_history#{{$val1->TransactionCode}}" class="link_pesan">Lihat Pesanan</a>
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else
		<div width="100%" style="text-align: center;"><h4 style="color:red">Anda tidak memiliki VOUCHER saat ini.</h4></div>
		@endif
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		@if($errorvouchercode == 'null')
		$('[name="vouchercode"]').attr('style', 'border: 1px solid red;');
		$('[name="vouchercode"]').foucs();
		@endif
	});
</script>