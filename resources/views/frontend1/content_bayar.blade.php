<div class="alertInfo">Pesanan Anda akan otomatis kami batalkan, bila Anda tidak melakukan pembayaran selama waktu yang telah ditentukan.</div>

<div id="checkpembayaran" class="boxPesananList pembayaran">
	@if(count($OrderTransaction))
	@foreach($OrderTransaction as $key1 => $val1)
	<div id="{{$val1['TransactionCode']}}" class="title">PESANAN {{$val1['TransactionCode']}}</div>
	<div id="{{$val1['TransactionCode']}}" class="boxSeller">
		@foreach($val1['ListSeller'] as $key2 => $val2)
		<div class="seller_text">
			Seller : <a href="javascript:;">{{$val2['SellerName']}}</a>
		</div>
		<div class="boxTrack boxtrackMulti after_clear">
			@php $TotalPriceProductQty = 0; @endphp
			@php $SubTotal = 0; @endphp
			@foreach($val2['ListProduct'] as $key3 => $val3)
			<div class="boxTrackBorder after_clear">
				<div class="boxtrackMultiInner">
					<div class="boxTrackInner bordered after_clear">
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
									<table class="other_det" id="table_edit1">
										<tr>
											<td style="width: 20px; !important;">COLOR</td>
											<td><span class="label_edit">{{$val3['ColorName']}}</span></td>
										</tr>
										<tr>
											<td>SIZE</td>
											<td><span class="label_edit">{{$val3['SizeName']}}</span></td>
										</tr>
										<tr>
											<td>Quantity</td>
											<td><span class="label_edit">{{$val3['Qty']}}</span></td>
										</tr>
									</table>
								</div>
								<div class="det1">
									<div class="boxCatatan">
										@if(!$val3['Notes'])
										<span class="catatan" id="catat{{$val3['SKUPrinciple']}}">Catatan untuk penjual</span>
										@endif
										<textarea class="text_catatan" data-id="catat{{$val3['SKUPrinciple']}}" disabled>{{$val3['Notes']}}</textarea>
									</div>
								</div>
							</div>
						</div>	
					</div>
				</div>
				<div class="boxtrackMultiInner">
					<div class="boxTrackInner ship_address after_clear">
						<div class="status after_clear" style="width:100% !important;">
							<div class="label_status">
								<span>SHIPPING ADDRESS</span>
							</div>
							<table class="tbaddress" style="width:100% !important;">
								<tr>
									<td width="100px">Name</td><td width="10px">:</td><td>
										<span>{{$val3['RecepientName']}}</span>
									</td>
								</tr>
								<tr>
									<td>Phone</td><td>:</td><td>
										<span>{{$val3['RecepientPhone']}}</span>
									</td>
								</tr>
								<tr>
									<td>Address</td><td>:</td><td>
										<span>{!!$val3['Address']!!}</span><br/>
										<span>{{$val3['DistrictName'].', '}}</span>
										<span>{{$val3['CityName']}}</span> 
										<span>{{$val3['PostalCode']}}</span>
									</td>
								</tr>
							</table>
							@if($val3['ShippingPrice'])
							<table class="tb_subtotal" style="bottom: 0;">
								<tr>
									<th>DELIVERY - {{$val3['ShippingName']}} {{$val3['ShippingPackage']}}</th>
									@php
					                    $tmpShippingPrice = $val3['ShippingPrice'];

										if($val1['CurrencyCode'] == 'IDR')
					                        $tmpShippingPrice = $inv->_formatamount($tmpShippingPrice, 'Rupiah', $val1['CurrencyCode'].' ');
					                    else
					                        $tmpShippingPrice = $inv->_formatamount($tmpShippingPrice, 'Dollar', $val1['CurrencyCode'].' ');
									@endphp
									<td align="right">{{$tmpShippingPrice}}</td>
								</tr>
								<tr>
									<th>SUB TOTAL</th>
									@php
					                    $TotalTransaction = $TotalPriceProductQty + $val3['ShippingPrice'];
					                    $SubTotal += $TotalTransaction;

										if($val1['CurrencyCode'] == 'IDR')
					                        $tmpTotalTransaction = $inv->_formatamount($TotalTransaction, 'Rupiah', $val1['CurrencyCode'].' ');
					                    else
					                        $tmpTotalTransaction = $inv->_formatamount($TotalTransaction, 'Dollar', $val1['CurrencyCode'].' ');
									@endphp
									<td align="right">{{$tmpTotalTransaction}}</td>
								</tr>
							</table>
							@endif
						</div>
					</div>
				</div>
			</div>
			@endforeach
			<div class="boxSum2 ship after_clear" style="border-bottom: 1px solid #a1a1a1;">
				<ul>
					<li>
						<div class="boxTotal after_clear">
							<div>
								<div>Total per Tagihan :</div>
								@php
									if($val1['CurrencyCode'] == 'IDR')
				                        $tmpSubTotal = $inv->_formatamount($SubTotal, 'Rupiah', $val1['CurrencyCode'].' ');
				                    else
				                        $tmpSubTotal = $inv->_formatamount($SubTotal, 'Dollar', $val1['CurrencyCode'].' ');
								@endphp
								<div>{{$tmpSubTotal}}</div>			
							</div>
						</div>
						
					</li>
				</ul>
			</div>
		</div>
		@endforeach

		<div class="boxAllTotal akun_pembayaran after_clear">
			<div class="textsum">
				Bayar sebelum <span class="date">{{date('d/m/Y H:i:s',strtotime($val1['CreatedDate']) + 60*60)}}</span> dengan {{$val1['PaymentTypeName']}} {{$arraypaymenttype[$val1['Type']]}}
			</div>
			<div class="boxTotal after_clear">
				<div>TOTAL COST :</div>
				@php
					$GrandTotal = $val1['GrandTotal'];
					if($val1['Type'] == 0) $GrandTotal = $val1['GrandTotalUnique'];

					if($val1['CurrencyCode'] == 'IDR')
                        $GrandTotal = $inv->_formatamount($GrandTotal, 'Rupiah', $val1['CurrencyCode'].' ');
                    else
                        $GrandTotal = $inv->_formatamount($GrandTotal, 'Dollar', $val1['CurrencyCode'].' ');
				@endphp
				<div id="newprice">{!!substr($GrandTotal, 0, strlen($GrandTotal)-3) . '<span style="color:red">' . substr($GrandTotal, -3) . '</span>'!!}</div>
			</div>	
		</div>
		<div class="boxButton after_clear">
			<a href="javascript:;" class="btn medium" onclick="CancelTransaction('{{$val1['TransactionCode']}}');">HAPUS PESANAN</a>
		</div>
	</div>
	@endforeach
	@else
	<div width="100%" style="text-align: center;"><h4 style="color:red">Anda tidak memiliki pembayaran yang sedang berlangsung.</h4></div>
	@endif
</div>