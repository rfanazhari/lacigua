<div class="boxAirWay">
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
				<td data-label=""><a href="javascript:;" class="lihat_pesan open_detail" data-id="detail_pesanan{{$val1['TransactionCode']}}">Lihat Pesanan</a></td>
			</tr>
			<tr id="detail_pesanan{{$val1['TransactionCode']}}" class="tr_detail_pesan">
				<td colspan="5">
					@foreach($val1['ListSeller'] as $key2 => $val2)
					<div class="boxPesananList pembayaran">
						<div class="boxSeller">
							<div class="boxTrack boxtrackMulti after_clear">
								<div class="seller_text">Seller : <a href="javascript:;">{{$val2['SellerName']}}</a></div>
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
											<div class="status" style="width:100% !important;">
												<div class="label_status">
													<span>SHIPPING ADDRESS</span>
													@if(!$val3['TypeProduct'])
													<a href="{{$basesite}}product-detail/id_{{$val3['ProductPermalink']}}" target="_blank" class="order_again btn black">Order Kembali</a>
													@else
													<a href="{{$basesite}}product-beauty/id_{{$val3['ProductPermalink']}}" target="_blank" class="order_again btn black">Order Kembali</a>
													@endif
												</div>
												<table class="tb_address" style="width:100% !important;">
													<tr>
														<td style="width:80px !important;">Name</td><td style="width:10px !important;">:</td><td>
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
								<div class="boxSum2 ship after_clear">
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
						</div>
					</div>
					@endforeach
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	@else
	<div width="100%" style="text-align: center;"><h4 style="color:red">Anda tidak memiliki history order saat ini.</h4></div>
	@endif
</div>
<script type="text/javascript">
	$(document).ready(function(){
		var w_width = $(window).width();
		$(".open_detail").click(function() {
			var $id = $(this).attr("data-id"),
				$tr = $(this).closest("tr");
				$trtd = $(this).closest("tr").find("td");

			if(!$(this).hasClass("opened_detail_box")) {
				$("#"+$id).addClass("actived");
				$(this).addClass("opened_detail_box");
				$(this).html("Tutup detail");
				if(w_width > 690) {
					$($trtd).css({borderBottom:"0px"});
				}
			} else {
				$("#"+$id).removeClass("actived");
				$(this).removeClass("opened_detail_box");
				$(this).html("Lihat Pesanan");
				if(w_width > 690) {
					$($trtd).css({borderBottom:"1px solid #b2b2b2"});
				}
			}
		});
	});
</script>
