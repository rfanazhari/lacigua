<section class="akun_profile shopping_bag">
	<div class="wrapper">
		<h1>MY RETURNS</h1>
		<div class="boxInfoReturn after_clear">
			<div class="boxInfoReturnInner">
				<div class="text">Berlaku 7 hari setelah barang diterima</div>
			</div>
			<div class="boxInfoReturnInner">
				<div class="text">Tempel destinasi dibagian luar paket</div>
			</div>
			<div class="boxInfoReturnInner">
				<div class="text">Kondisi produk asli dengan tag label tertera</div>
			</div>
			<div class="boxInfoReturnInner">
				<div class="text">Gunakan kemasan original Lacigue</div>
			</div>
		</div>
		<div class="tab_akun" id="parentHorizontalTab">
			<div class="boxOrder">
				<div class="contentDynamic">
					<div class="boxAirWay" style="margin: 0px;">
						@if(count($OrderTransaction))
						<table class="tb_order">
							<thead>
								<tr>
									<th scope="col">NO. Order</th>
									<th scope="col" style="width: 20%;">Tanggal</th>
									<th scope="col">Jumlah</th>
									<th scope="col"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($OrderTransaction as $key1 => $val1)
								<tr>
									<td data-label="No. Order">{{$val1['TransactionCode']}}</td>
									<td data-label="Tanggal">{{$inv->_dateformysql($val1['CreatedDate'])->format('d/m/y')}}</td>
									@php
										$GrandTotal = $val1['GrandTotal'];
										if($val1['Type'] == 0) $GrandTotal = $val1['GrandTotalUnique'];

										if($val1['CurrencyCode'] == 'IDR')
					                        $GrandTotal = $inv->_formatamount($GrandTotal, 'Rupiah', $val1['CurrencyCode'].' ');
					                    else
					                        $GrandTotal = $inv->_formatamount($GrandTotal, 'Dollar', $val1['CurrencyCode'].' ');
									@endphp
									<td data-label="Jumlah">{{$GrandTotal}}</td>
									<td data-label=""><a href="{{$basesite}}return-detail/code_{{$val1['TransactionCode']}}" class="lihat_pesan">Lihat Pesanan</a></td>
								</tr>
								@endforeach
							</tbody>
						</table>
						@else
						<div width="100%" style="text-align: center;"><h4 style="color:red">Anda tidak memiliki pemesanan dalam 7 hari kebelakang.</h4></div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</section>