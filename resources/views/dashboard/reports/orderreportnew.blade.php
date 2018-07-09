@if (isset($messageerror) && $messageerror != '')
<span class='red bold'>{!!$messageerror!!}</span><br/><br/>
@endif
@if (isset($messagesuccess) && $messagesuccess != '')
<span class='green bold'>{!!$messagesuccess!!}</span><br/><br/>
@endif
<form method="post" class="horizontal-form" enctype="multipart/form-data">
	<div class="form-body">
		<div class="row">
			<fieldset class='fieldset'><legend class='legend' rel="stylesheet">{{explode(' / ', $pagename)[count(explode(' / ', $pagename)) - 1]}} Information</legend>
				<div class="col-md-6">
					<div class="form-group">
						<div>
							<label class="control-label input-sm marlm10">{{$alias['SellerID'][0]}}</label>
							<select class="form-control input-sm select2me" name="SellerID">
								<option value=''>Select {{$alias['SellerID'][0]}}</option>
								@foreach ($arrseller as $obj)
									<option value="{{$obj['ID']}}" @if ($obj['ID'] == $SellerID) selected @endif>{{$obj['FullName']}}</option>
								@endforeach
							</select>
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">{{$alias['BrandID'][0]}}</label>
							<select class="form-control input-sm select2me" name="BrandID">
								<option value=''>Select {{$alias['BrandID'][0]}}</option>
								{{-- @foreach ($arrbrand as $obj)
									<option value="{{$obj['ID']}}" @if ($obj['ID'] == $BrandID) selected @endif>{{$obj['Name']}}</option>
								@endforeach --}}
							</select>
							<span class="help-block"></span>
                        </div>
                        <div>
							<label class="control-label input-sm marlm10">{{$alias['ModelID'][0]}}</label>
							<select class="form-control input-sm select2me" name="ModelID" >
								<option value=''>Select {{$alias['ModelID'][0]}}</option>
								@foreach ($arrModel as $obj)
									<option value="{{$obj['ModelType']}}" @if ($obj['ModelType'] == $ModelID) selected @endif>{{$obj['Title']}}</option>
								@endforeach
							</select>
							<span class="help-block"></span>
                        </div>
						<div>
							<label class="control-label input-sm marlm10">{{$alias['CategoryID'][0]}}</label>
							<select class="form-control input-sm select2me" name="CategoryID">
								<option value=''>Select {{$alias['CategoryID'][0]}}</option>
                                    @foreach ($arrcategory as $obj)
                                        <option value="{{$obj['ID']}}" @if ($obj['ID'] == $CategoryID) selected @endif>{{$obj['Name']}}</option>
                                    @endforeach
							</select>
							<span class="help-block"></span>
						</div>
                        <div>
							<label class="control-label input-sm marlm10">{{$alias['SubCategoryID'][0]}}</label>
							<select class="form-control input-sm select2me" name="SubCategoryID" >
								<option value=''>Select {{$alias['SubCategoryID'][0]}}</option>
								{{-- @foreach ($arrcategory as $obj)
									<option value="{{$obj['ID']}}" @if ($obj['ID'] == $CategoryID) selected @endif>{{$obj['Name']}}</option>
								@endforeach --}}
							</select>
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">{{$alias['ReportDateFrom'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm dateonly" name="ReportDateFrom" value="{{$ReportDateFrom}}">
							<span class="help-block"></span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div>
							<label class="control-label input-sm marlm10">{{$alias['ShippingID'][0]}}</label>
							<select class="form-control input-sm select2me" name="ShippingID">
								<option value=''>Select {{$alias['ShippingID'][0]}}</option>
								@foreach ($arrshipping as $obj)
									<option value="{{$obj['ID']}}" @if ($obj['ID'] == $ShippingID) selected @endif>{{$obj['Name']}}</option>
								@endforeach
							</select>
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">{{$alias['PaymentTypeID'][0]}}</label>
							<select class="form-control input-sm select2me" name="PaymentTypeID">
								<option value=''>Select {{$alias['PaymentTypeID'][0]}}</option>
								@foreach ($arrpaymenttype as $obj)
									<option value="{{$obj['ID']}}" @if ($obj['ID'] == $PaymentTypeID) selected @endif>{{$obj['Name']}}</option>
								@endforeach
							</select>
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">{{$alias['StatusOrder'][0]}}</label>
							<select class="form-control input-sm select2me" name="StatusOrder">
								<option value=''>Select {{$alias['StatusOrder'][0]}}</option>
								@foreach ($arrstatusorder as $objkey => $objval)
									<option value="{{$objkey}}" @if (is_numeric($StatusOrder) && $objkey == $StatusOrder) selected @endif>{{$objval}}</option>
								@endforeach
							</select>
							<span class="help-block"></span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">{{$alias['StatusPaid'][0]}}</label>
							<select class="form-control input-sm select2me" name="StatusPaid">
								<option value=''>Select {{$alias['StatusPaid'][0]}}</option>
								@foreach ($arrstatuspaid as $objkey => $objval)
									<option value="{{$objkey}}" @if (is_numeric($StatusPaid) && $objkey == $StatusPaid) selected @endif>{{$objval}}</option>
								@endforeach
							</select>
							<span class="help-block"></span>
                        </div>
                        <div style="margin-bottom: 14.555555555%;"></div>
						<div>
							<label class="control-label input-sm marlm10">{{$alias['ReportDateTo'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm dateonly" name="ReportDateTo" value="{{$ReportDateTo}}">
							<span class="help-block"></span>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
	<div class="form-actions right">
		<input type="text" class="hide" name="action" value="{{$action}}">
		<button type="submit" class="btn btn-sm blue" name="download">Download <i class="fa fa-arrow-circle-right"></i></button>
	</div>	
</form>


<script type="text/javascript">
window.onload = (function() {
    $('[name="SellerID"]').change(function() {
       
       var BrandID = $(this).val();
       $.ajax({
           url		: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
           type		: 'POST',
           data		: {'ajaxpost':"getBrand",'BrandID': BrandID},
           success		: function(data) {
              
               var tampung = JSON.parse(data);
               if(tampung['response'] == 'OK') {
                   $('[name="BrandID"]').empty();
                   $('[name="BrandID"]')
                       .append($("<option></option>")
                       .attr("selected",'')
                       .val('')
                       .text('Please Select {{$alias['BrandID'][0]}}'));
                   $.each(tampung['data'], function(key, value) {
                       $('[name="BrandID"]')
                           .append($("<option></option>")
                           .attr("value",value['ID'])
                           .val(value['ID'])
                           .text(value['Name']));
                   });      
                   $('[name="BrandID"]').select2("val", null);
               }
           }
       });
   });
        $('[name="CategoryID"]').change(function() {
       
		    var CatID = $(this).val();
		    $.ajax({
				url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
				type		: 'POST',
				data		: {'ajaxpost':"getSubCat",'CatID': CatID},
				success		: function(data) {
                   
					var tampung = JSON.parse(data);
					if(tampung['response'] == 'OK') {
						$('[name="SubCategoryID"]').empty();
						$('[name="SubCategoryID"]')
							.append($("<option></option>")
    						.attr("selected",'')
					        .val('')
					        .text('Please Select {{$alias['SubCategoryID'][0]}}'));
						$.each(tampung['data'], function(key, value) {
							$('[name="SubCategoryID"]')
								.append($("<option></option>")
								.attr("value",value['ID'])
								.val(value['ID'])
								.text(value['Name']));
						});      
						$('[name="SubCategoryID"]').select2("val", null);
	            	}
				}
			});
        });
    });
</script>