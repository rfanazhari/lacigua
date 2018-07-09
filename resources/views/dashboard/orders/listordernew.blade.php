@if (isset($messageerror) && $messageerror != '')
<span class='red bold'>{!!$messageerror!!}</span><br/><br/>
@endif
@if (isset($messagesuccess) && $messagesuccess != '')
<span class='green bold'>{!!$messagesuccess!!}</span><br/><br/>
@endif
<form method="post" class="horizontal-form" enctype="multipart/form-data">
	<div class="form-body">
		<div class="row">
			<fieldset class='fieldset'><legend class='legend' rel="stylesheet">{{explode(' / ', $pagename)[count(explode(' / ', $pagename)) - 1]}} Information <span class="red">{{$OrderTransactionSeller['TransactionSellerCode']}}</span></legend>
				<div class="col-md-4">
					<div class="form-group">
						<div>
							<label class="control-label input-sm marlm10">Seller Name</label>
							<input type="text" class="form-control input-sm" name="SellerName" value="{{$OrderTransactionSeller['SellerName']}}">
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Shipping</label>
							<input type="text" class="form-control input-sm" name="ShippingName" value="{{$OrderTransactionSeller['ShippingName']}}">
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Shipping Package</label>
							<input type="text" class="form-control input-sm" name="ShippingPackage" value="{{$OrderTransactionSeller['ShippingPackageID']}}">
							<span class="help-block"></span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<div>
							<label class="control-label input-sm marlm10">Shipping Location</label>
							<div>
								{!!$OrderTransactionSeller['DistrictName']!!}
							</div>
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Total QTY</label>
							<input type="text" class="form-control input-sm" name="TotalQTY" value="{{$OrderTransactionSeller['QtyProductShip']}}">
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Total Weight</label>
							<input type="text" class="form-control input-sm" name="TotalWeight" value="{{$OrderTransactionSeller['WeightProductShip']}}">
							<span class="help-block"></span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<div>
							<label class="control-label input-sm marlm10">Shipping Price</label>
							<input type="text" class="form-control input-sm" name="ShippingPrice" value="{{$OrderTransactionSeller['ShippingPrice']}}">
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">AWB Number</label>
							<input type="text" class="form-control input-sm" name="AWBNumber" value="{{$OrderTransactionSeller['AWBNumber']}}">
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Status Shipment</label>
							<input type="text" class="form-control input-sm" name="StatusShipment" value="{{$arraystatusshipment[$OrderTransactionSeller['StatusShipment']]}}">
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
								<th class="pad10">Color</th>
								<th class="pad10">Qty</th>
								<th class="pad10">Weight</th>
								<th class="pad10">Price</th>
								<th class="pad10">Image</th>
							</thead>
							<tbody>
							@php $i=0 @endphp
							@foreach($OrderTransactionSeller['ListProduct'] as $key2 => $val2)
							<tr @if ($i==0) @php $i=1 @endphp
								class="bottom"
							@else @php $i=0 @endphp
							@endif >
								<td>{{$val2['SKUPrinciple']}}</td>
								<td>{{$val2['SKUSeller']}}</td>
								<td>{{$val2['NameShow']}}</td>
								<td>{{$val2['ColorName']}}</td>
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
						if($OrderTransactionSeller['CurrencyCode'] == 'IDR')
	                        $SubGrandTotal = $inv->_formatamount($OrderTransactionSeller['PriceProductShip'] + $OrderTransactionSeller['ShippingPrice'], 'Rupiah', $OrderTransactionSeller['CurrencyCode'].' ');
	                    else
	                        $SubGrandTotal = $inv->_formatamount($OrderTransactionSeller['PriceProductShip'] + $OrderTransactionSeller['ShippingPrice'], 'Dollar', $OrderTransactionSeller['CurrencyCode'].' ');
                        @endphp
						<div>
							<label class="control-label input-sm marlm10">Grand Total</label>
							<input type="text" class="form-control input-sm bold" name="SubGrandTotal" value="{{$SubGrandTotal}}">
							<span class="help-block"></span>
						</div>
					</div>
				</div>
			</fieldset>
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