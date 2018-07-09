<style type="text/css">
	.wrap-popup .box-popup .title .closepop {
		padding-right: 5px;
	}
</style>

<div class="alertInfo">Pesanan Anda akan otomatis kami batalkan, dan dana akan kami kembalikan, bila Seller tidak merespon order Anda dalam 2 Hari kerja atau tidak mengkonfirmasi pesanan Anda dalam batas waktu 5 hari.
</div>

<div id="checkpemesanan">
	@if(count($OrderTransaction))
	@foreach($OrderTransaction as $key1 => $val1)
	<div id="{{$val1['TransactionCode']}}" class="boxPesananList pemesanan">
		<div class="title">PESANAN {{$val1['TransactionCode']}}</div>
		@foreach($val1['ListSeller'] as $key2 => $val2)
		<div class="seller_text">Seller : <a href="javascript:;">{{$val2['SellerName']}}</a></div>
		<div class="boxTrack boxtrackMulti after_clear">
			<div class="boxTrackBorder after_clear">
				<div class="boxtrackMultiInner">
					@php $TotalPriceProductQty = 0; @endphp
					@php $SubTotal = 0; @endphp
					@foreach($val2['ListProduct'] as $key3 => $val3)
					<div class="boxTrackInner after_clear">
						<div class="detail">
							<div class="detail_inner after_clear">
								<div class="det1">
									<img src="{{$basesite}}assets/frontend/images/content/product/medium_{{$val3['Image1']}}">
								</div>
								<div class="det1">
									<div class="desc">{{strtoupper($val3['Name'])}}</div>
									<div class="name">{{strtoupper($val3['BrandName'])}}</div>
									@php
										$ProductPrice = $val3['ProductPrice'];

										if($val1['CurrencyCode'] == 'IDR')
					                        $ProductPrice = $inv->_formatamount($ProductPrice, 'Rupiah', $val1['CurrencyCode'].' ');
					                    else
					                        $ProductPrice = $inv->_formatamount($ProductPrice, 'Dollar', $val1['CurrencyCode'].' ');

					                    $TotalPriceProductQty += $val3['ProductPrice'] * $val3['Qty'];
									@endphp
									<div class="price">{{$ProductPrice}}</div>
									<table class="other_det">
										<tr>
											<td style="width: 80px;">COLOR</td>
											<td>{{$val3['ColorName']}}</td>
										</tr>
										<tr>
											<td>SIZE</td>
											<td>{{$val3['SizeName']}}</td>
										</tr>
										<tr>
											<td>Quantity</td>
											<td>{{$val3['Qty']}}</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
				<div class="boxtrackMultiInner">
					<div class="boxTrackInner">
						<div class="status">
							<div id="status{{$val2['TransactionSellerCode']}}" class="label_status">
								Status Pesanan : <span>{{$arraystatusshipment[$val2['StatusShipment']]}}</span>
							</div>
							<div id="date{{$val2['TransactionSellerCode']}}" class="tgl_status">
								@if($val2['StatusShipment'] == 0)
								{{substr($val2['CreatedDate'],0,strlen($val2['CreatedDate'])-3)}}
								@else
								{{substr($val2['UpdatedDate'],0,strlen($val2['UpdatedDate'])-3)}}
								@endif
							</div>
							<div class="shipment after_clear">
								<div class="confirm @if($val2['StatusShipment'] >= 0) done @endif">
							        <div class="imgcircle">
							        	@if($val2['StatusShipment'] >= 0)
							            <img src="{{$basesite}}assets/frontend/images/material/proses_done.png" alt="Proses">
							        	@else
							            <img src="{{$basesite}}assets/frontend/images/material/proses.png" alt="Proses">
							        	@endif
							    	</div>
									<span class="line"></span>
								</div>
								<div class="packing @if($val2['StatusShipment'] >= 1) done @endif">
							   	 	<div class="imgcircle">
							   	 		@if($val2['StatusShipment'] >= 1)
							            <img src="{{$basesite}}assets/frontend/images/material/packing_done.png" alt="Proses">
							        	@else
							            <img src="{{$basesite}}assets/frontend/images/material/packing.png" alt="Proses">
							        	@endif
							    	</div>
									<span class="line"></span>
								</div>
								<div class="delivery @if($val2['StatusShipment'] >= 2) done @endif">
									<div class="imgcircle">
										@if($val2['StatusShipment'] >= 2)
							            <img src="{{$basesite}}assets/frontend/images/material/kirim_done.png" alt="Proses">
							        	@else
							            <img src="{{$basesite}}assets/frontend/images/material/kirim.png" alt="Proses">
							        	@endif
							    	</div>
									<span class="line"></span>
								</div>
								<div id="done{{$val2['TransactionSellerCode']}}" class="selesai @if($val2['StatusShipment'] >= 3) done @endif">
									<div class="imgcircle">
										@if($val2['StatusShipment'] >= 3)
							            <img src="{{$basesite}}assets/frontend/images/material/selesai_done.png" alt="Proses">
							        	@else
							            <img src="{{$basesite}}assets/frontend/images/material/selesai.png" alt="Proses">
							        	@endif
									</div>
								</div>
							</div>
							<div class="buttonAction after_clear">
								@if($val2['StatusShipment'] == 2)
								<a id="{{$val2['TransactionSellerCode']}}" href="javascript:;" class="btn small" onclick="_alertvalidation('Silahkan check nomor resi anda di website resmi {{$val2['ShippingName']}} : <b>{{$val2['AWBNumber']}}</b>')">Lacak Pesanan</a>
								<a id="{{$val2['TransactionSellerCode']}}" href="javascript:;" class="btn small" onclick="DeliveryTransaction('{{$val2['TransactionSellerCode']}}')">Sudah Terima</a>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="boxSum after_clear">
				<div class="textsum">Metode pembayaran {{$val1['PaymentTypeName']}} {{$arraypaymenttype[$val1['Type']]}}</div>
				<div class="boxTotal after_clear">
					<div>TOTAL COST</div>
					@php
		                $TotalTransaction = $TotalPriceProductQty + $val2['ShippingPrice'];
		                $SubTotal += $TotalTransaction;

						if($val1['CurrencyCode'] == 'IDR')
		                    $tmpTotalTransaction = $inv->_formatamount($TotalTransaction, 'Rupiah', $val1['CurrencyCode'].' ');
		                else
		                    $tmpTotalTransaction = $inv->_formatamount($TotalTransaction, 'Dollar', $val1['CurrencyCode'].' ');
					@endphp
					<div>{{$tmpTotalTransaction}}</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>
	@endforeach
	@else
	<div width="100%" style="text-align: center;"><h4 style="color:red">Anda tidak memiliki pemesanan yang sedang berlangsung.</h4></div>
	@endif
</div>