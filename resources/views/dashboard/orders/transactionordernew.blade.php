@if (isset($messageerror) && $messageerror != '')
<span class='red bold'>{!!$messageerror!!}</span><br/><br/>
@endif
@if (isset($messagesuccess) && $messagesuccess != '')
<span class='green bold'>{!!$messagesuccess!!}</span><br/><br/>
@endif
<form method="post" class="horizontal-form" enctype="multipart/form-data">
	<div class="form-body">
		<div class="row">
			<fieldset class='fieldset'><legend class='legend' rel="stylesheet">{{explode(' / ', $pagename)[count(explode(' / ', $pagename)) - 1]}} Information <span class="red">{{$TransactionCode}}</span></legend>
				<div class="col-md-4">
					<div class="form-group">
						<div>
							<label class="control-label input-sm marlm10">Customer Name @if($AsGuest)<label class="badge badge-roundless badge-success">GUEST</label>@endif</label>
							<input type="text" class="form-control input-sm" name="CustomerName" value="{{$CustomerName}}">
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Currency</label>
							<input type="text" class="form-control input-sm" name="CurrencyCode" value="{{$CurrencyCode}}">
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Store Credit Use</label>
							<input type="text" class="form-control input-sm" name="StoreCreditAmount" value="{{$StoreCreditAmount}}">
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Voucher Code</label>
							<input type="text" class="form-control input-sm" name="VoucherCode" value="{{$VoucherCode}}">
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Voucher Amount</label>
							<input type="text" class="form-control input-sm" name="VoucherAmount" value="{{$VoucherAmount}}">
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Discount Name</label>
							<input type="text" class="form-control input-sm" name="DiscountName" value="{{$DiscountName}}">
							<span class="help-block"></span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<div>
							<label class="control-label input-sm marlm10">Discount Amount</label>
							<input type="text" class="form-control input-sm" name="DiscountAmount" value="{{$DiscountAmount}}">
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Payment Type</label>
							<input type="text" class="form-control input-sm" name="Type" value="{{$Type}}">
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Payment Detail</label>
							<div>
								{!!$PaymentDetail!!}
							</div>
							<span class="help-block"></span>
						</div>
						@if($Type == 'Bank Transfer')
						<div>
							<label class="control-label input-sm marlm10">Unique Order</label>
							<input type="text" class="form-control input-sm" name="UniqueOrder" value="{{$UniqueOrder}}">
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Grand Total</label>
							<input type="text" class="form-control input-sm bold" name="GrandTotalUnique" value="{{$GrandTotalUnique}}">
							<span class="help-block"></span>
						</div>
						@else
						<div>
							<label class="control-label input-sm marlm10">Grand Total</label>
							<input type="text" class="form-control input-sm bold" name="GrandTotal" value="{{$GrandTotal}}">
							<span class="help-block"></span>
						</div>
						@endif
						@if($Type == 'Virtual Account')
						<div>
							<label class="control-label input-sm marlm10">VA Number</label>
							<input type="text" class="form-control input-sm" name="VANumber" value="{{$VANumber}}">
							<span class="help-block"></span>
						</div>
						@endif
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						
						<div>
							<label class="control-label input-sm marlm10">Notes</label>
							<textarea type="text" class="form-control input-sm" name="Notes" rows="3">{{$Notes}}</textarea>
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Status Order</label>
							<input type="text" class="form-control input-sm" name="StatusOrder" value="{{$StatusOrder}}">
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Status Paid</label>
							<div>
								@if($StatusPaid == 'PAID')
								<label class="badge badge-roundless badge-success">PAID</label>
								@else
								<label class="badge badge-roundless badge-warning">UNPAID</label>
								@endif
							</div>
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Created Date</label>
							<div>
								{!!$CreatedDate!!}
							</div>
							<span class="help-block"></span>
						</div>
					</div>
				</div>
			</fieldset>
			@if(count($ArrOrderTransactionSeller))
			@foreach($ArrOrderTransactionSeller as $key1 => $val1)
			<fieldset class='fieldset'><legend class='legend' rel="stylesheet">{{explode(' / ', $pagename)[count(explode(' / ', $pagename)) - 1]}} Seller Information <span class="red">{{$val1['TransactionSellerCode']}}</span></legend>
				<div class="col-md-4">
					<div class="form-group">
						<div>
							<label class="control-label input-sm marlm10">Seller Name</label>
							<input type="text" class="form-control input-sm" name="SellerName" value="{{$val1['SellerName']}}">
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Shipping</label>
							<input type="text" class="form-control input-sm" name="ShippingName" value="{{$val1['ShippingName']}}">
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Shipping Package</label>
							<input type="text" class="form-control input-sm" name="ShippingPackage" value="{{$val1['ShippingPackageID']}}">
							<span class="help-block"></span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<div>
							<label class="control-label input-sm marlm10">Shipping Location</label>
							<div>
								{!!$val1['DistrictName']!!}
							</div>
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Total QTY</label>
							<input type="text" class="form-control input-sm" name="TotalQTY" value="{{$val1['QtyProductShip']}}">
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Total Weight</label>
							<input type="text" class="form-control input-sm" name="TotalWeight" value="{{$val1['WeightProductShip']}}">
							<span class="help-block"></span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<div>
							<label class="control-label input-sm marlm10">Shipping Price</label>
							<input type="text" class="form-control input-sm" name="ShippingPrice" value="{{$val1['ShippingPrice']}}">
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">AWB Number</label>
							<input type="text" class="form-control input-sm" name="AWBNumber" value="{{$val1['AWBNumber']}}">
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Status Shipment</label>
							<input type="text" class="form-control input-sm" name="StatusShipment" value="{{$arraystatusshipment[$val1['StatusShipment']]}}">
							<span class="help-block"></span>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<table class="bordered" width="100%">
							<thead>
								<th class="pad10">Product Code</th>
								<th class="pad10">SKU Seller</th>
								<th class="pad10">Product Name</th>
								<th class="pad10">Product Detail</th>
								<th class="pad10">Size Variant</th>
								<th class="pad10">Qty</th>
								<th class="pad10">Weight</th>
								<th class="pad10">Price</th>
								<th class="pad10">Image</th>
							</thead>
							<tbody>
							@php $i=0 @endphp
							@foreach($val1['ListProduct'] as $key2 => $val2)
							<tr @if ($i==0) @php $i=1 @endphp
								class="bottom"
							@else @php $i=0 @endphp
							@endif >
								<td>{{$val2['SKUPrinciple']}}</td>
								<td>{{$val2['SKUSeller']}}</td>
								<td>{{$val2['NameShow']}}</td>
								<td>{{$val2['ColorName']}}</td>
								<td>{{$val2['SizeVariantName']}}</td>
								<td>{{$val2['Qty']}}</td>
								<td>{{$val2['Weight']}}</td>
								<td>{{$val2['ProductPrice']}}</td>
								<td><img src="{{$basesite.'assets/frontend/images/content/product/small_' . $val2['Image1'] . '?'. uniqid()}}" /></td>
							</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						@php
						if($CurrencyCode == 'IDR')
	                        $SubGrandTotal = $inv->_formatamount($val1['PriceProductShip'] + $val1['ShippingPrice'], 'Rupiah', $CurrencyCode.' ');
	                    else
	                        $SubGrandTotal = $inv->_formatamount($val1['PriceProductShip'] + $val1['ShippingPrice'], 'Dollar', $CurrencyCode.' ');
                        @endphp
						<div>
							<label class="control-label input-sm marlm10">Grand Total</label>
							<input type="text" class="form-control input-sm bold" name="SubGrandTotal" value="{{$SubGrandTotal}}">
							<span class="help-block"></span>
						</div>
					</div>
				</div>
			</fieldset>
			@endforeach
			@endif
		</div>
	</div>
	<div class="form-actions right">
		<input type="text" class="hide" name="action" value="{{$action}}">
		<a class="btn btn-sm default" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}">Cancel</a>
		@if ($action == 'edit')
		<button type="submit" class="btn btn-sm blue" name="edit">Edit <i class="fa fa-arrow-circle-right"></i></button>
		@else
		<button type="submit" class="btn btn-sm blue" name="addnew">Save <i class="fa fa-arrow-circle-right"></i></button>
		@endif
	</div>
</form>