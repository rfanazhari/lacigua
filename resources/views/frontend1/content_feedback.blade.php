@if(count($OrderTransaction))
@foreach($OrderTransaction as $key1 => $val1)
<div class="boxPesananList feedback">
	<div class="title">PESANAN {{$val1['TransactionCode']}}</div>
	@foreach($val1['ListSeller'] as $key2 => $val2)
	<div class="seller_text">Seller : <a href="javascript:;">{{$val2['SellerName']}}</a></div>
	<div class="boxTrack boxtrackMulti after_clear">
		@foreach($val2['ListProduct'] as $key3 => $val3)
		<div class="boxTrackBorder after_clear">
			<div class="boxtrackMultiInner">
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
			</div>
			<div class="boxtrackMultiInner">
				<div class="boxTrackInner">
					<div class="status">
						<div class="label_status">
							Pesanan diterima : <span>{{$inv->_dateformysql($val3['FeedbackDate'])->format('d/m/Y')}}</span>
						</div>
						<div class="boxRating">
							<ul>
								<li>
									<div class="ratingbox after_clear">
										<div class="label">Accuration</div>
										<div class="boxstars">
											<div class="rating {{$arrayrate[$val3['FeedbackAccuration']]}}"></div>
										</div>
									</div>
								</li>
								<li>
									<div class="ratingbox after_clear">
										<div class="label">Quality</div>
										<div class="boxstars">
											<div class="rating {{$arrayrate[$val3['FeedbackQuality']]}}"></div>
										</div>
									</div>
								</li>
								<li>
									<div class="ratingbox after_clear">
										<div class="label">Service</div>
										<div class="boxstars">
											<div class="rating {{$arrayrate[$val3['FeedbackService']]}}"></div>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>
	@endforeach
</div>
@endforeach
@else
<div width="100%" style="text-align: center;"><h4 style="color:red">Anda tidak memiliki feedback saat ini.</h4></div>
@endif