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
						<div class="@if ($errorFullName != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['FullName'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="FullName" value="{{$FullName}}">
							<span class="help-block">{{$errorFullName}}</span>
						</div>
						<div class="@if ($errorPhone != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Phone'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="Phone" value="{{$Phone}}">
							<span class="help-block">{{$errorPhone}}</span>
						</div>
						<div class="@if ($errorEmail != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Email'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="Email" value="{{$Email}}">
							<span class="help-block">{{$errorEmail}}</span>
						</div>
						<div class="@if ($errorPIC != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['PIC'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="PIC" value="{{$PIC}}">
							<span class="help-block">{{$errorPIC}}</span>
						</div>
						<div class="@if ($errorSellerFetured != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['SellerFetured'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="SellerFetured">
								@foreach ($arrSellerFetured as $key => $value)
									<option value="{{$key}}" @if ($key == $SellerFetured) selected @endif>{{$value}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorSellerFetured}}</span>
						</div>
						<div class="@if ($errorAddress1 != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Address1'][0]}} <span class="red">*</span></label>
							<textarea type="text" class="form-control input-sm" name="Address1">{{$Address1}}</textarea>
							<span class="help-block">{{$errorAddress1}}</span>
						</div>
						<div class="@if ($errorAddress2 != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Address2'][0]}} <span class="red">*</span></label>
							<textarea type="text" class="form-control input-sm" name="Address2">{{$Address2}}</textarea>
							<span class="help-block">{{$errorAddress2}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errorZipcodeID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['ZipcodeID'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="ZipcodeID" value="{{$ZipcodeID}}" maxlength="5">
							<span class="help-block">{{$errorZipcodeID}}</span>
						</div>
						<div class="@if ($errorSupplyGeo != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['SupplyGeo'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="SupplyGeo" value="{{$SupplyGeo}}">
							<span class="help-block">{{$errorSupplyGeo}}</span>
						</div>
						<div class="@if ($errorCountryID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['CountryName'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="CountryID">
								<option value=''>Select {{$alias['CountryName'][0]}}</option>
								@foreach ($arrCountry as $value_county)
									<option value="{{$value_county['ID']}}" @if ($value_county['ID'] == $CountryID) selected @endif>{{$value_county['Name']}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorCountryID}}</span>
						</div>
						<div class="@if ($errorProvinceID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['ProvinceName'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="ProvinceID">
								<option value=''>Select {{$alias['ProvinceName'][0]}}</option>
								@foreach ($arrProvince as $value_province)
									<option value="{{$value_province['ID']}}" @if ($value_province['ID'] == $ProvinceID) selected @endif>{{$value_province['Name']}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorProvinceID}}</span>
						</div>
						<div class="@if ($errorCityID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['CityName'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="CityID">
								<option value=''>Select {{$alias['CityName'][0]}}</option>
								@foreach ($arrCity as $obj)
									<option value="{{$obj['ID']}}" @if ($obj['ID'] == $CityID) selected @endif>{{str_replace('Kabupaten', 'Kab.', $obj['Alias']).' '.$obj['Name']}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorCityID}}</span>
						</div>
						<div class="@if ($errorDistrictID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['DistrictName'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="DistrictID">
								<option value=''>Select {{$alias['DistrictName'][0]}}</option>
								@foreach ($arrDistrict as $obj)
									<option value="{{$obj['ID']}}" @if ($obj['ID'] == $DistrictID) selected @endif>{{$obj['Name']}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorDistrictID}}</span>
						</div>
						<div class="@if ($errorShippingList != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['ShippingList'][0]}} <span class="red">*</span>
							</label>
							<div style="margin-left: -10px !important;">
								@foreach ($ArrShipping as $value)
								<label class="hover input-sm" style="width:200px;">
									<input type="checkbox" name="ShippingList[]" value="{{ $value['ID'] }}" @if($ShippingList && in_array($value['ID'], $ShippingList)) checked @endif >
									{{ $value['Name'] }}
								</label>
								@endforeach
							</div>
							<span class="help-block">{{$errorShippingList}}</span>
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset class='fieldset'><legend class='legend' rel="stylesheet">Company Information</legend>
				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errorLegalType != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['LegalType'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="LegalType" onchange="checklegaltype(this.value)">
								@foreach ($arrLegalType as $key => $value)
									<option value="{{$key}}" @if ($key == $LegalType) selected @endif>{{$value}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorLegalType}}</span>
						</div>
						<div class="@if ($errorCompanyName != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['CompanyName'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="CompanyName" value="{{$CompanyName}}">
							<span class="help-block">{{$errorCompanyName}}</span>
						</div>
						<div class="@if ($errorBusinessRegNumber != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['BusinessRegNumber'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="BusinessRegNumber" value="{{$BusinessRegNumber}}">
							<span class="help-block">{{$errorBusinessRegNumber}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errorSellerVAT != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['SellerVAT'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="SellerVAT" value="{{$SellerVAT}}">
							<span class="help-block">{{$errorSellerVAT}}</span>
						</div>
						<div class="@if ($errorVATReg != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['VATReg'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="VATReg" value="{{$VATReg}}">
							<span class="help-block">{{$errorVATReg}}</span>
						</div>
						<div class="fileinput fileinput-new @if ($errorVATInfoFile != '') has-error @endif" data-provides="fileinput">
							<label class="control-label input-sm marlm10">{{$alias['VATInfoFile'][0]}} <span class="red">*</span></label>
							<div id="VATInfoFile">
								@if ($VATInfoFile != '')
								<div class="contentimage">
									<img src='{{$VATInfoFile}}?{{uniqid()}}'/>
									<a id="deleteVATInfoFile" class="btn btn-sm red" onclick="deleteVATInfoFile();" value="Are you sure to remove {{$alias['VATInfoFile'][0]}} ?"><i class="fa fa-trash-o"></i></a>
								</div>
								@endif
							</div>
							<div class="input-group">
								<div class="form-control uneditable-input input-sm" data-trigger="fileinput">
									<i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
									</span>
								</div>
								<span class="input-group-addon btn btn-sm default btn-file">
									<span class="fileinput-new">
									Select {{$alias['VATInfoFile'][0]}} </span>
									<span class="fileinput-exists">
									Change {{$alias['VATInfoFile'][0]}} </span>
									<input type="file" name="VATInfoFile">
								</span>
								<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
								Remove </a>
							</div>
							<span class="help-block">{{$errorVATInfoFile}}</span>
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset class='fieldset'><legend class='legend' rel="stylesheet">Bank Information</legend>
				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errorBankName != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['BankName'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="BankName" value="{{$BankName}}">
							<span class="help-block">{{$errorBankName}}</span>
						</div>
						<div class="@if ($errorBankAccountNumber != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['BankAccountNumber'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm numberonly" name="BankAccountNumber" value="{{$BankAccountNumber}}">
							<span class="help-block">{{$errorBankAccountNumber}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errorBankBeneficiaryName != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['BankBeneficiaryName'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="BankBeneficiaryName" value="{{$BankBeneficiaryName}}">
							<span class="help-block">{{$errorBankBeneficiaryName}}</span>
						</div>
						<div class="@if ($errorBankBranch != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['BankBranch'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="BankBranch" value="{{$BankBranch}}">
							<span class="help-block">{{$errorBankBranch}}</span>
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset class='fieldset'><legend class='legend' rel="stylesheet">PickUp Information</legend>
				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errorPickupCountryID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['CountryName'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="PickupCountryID">
								<option value=''>Select {{$alias['CountryName'][0]}}</option>
								@foreach ($arrPickupCountry as $obj)
									<option value="{{$obj['ID']}}" @if ($obj['ID'] == $PickupCountryID) selected @endif>{{$obj['Name']}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorPickupCountryID}}</span>
						</div>
						<div class="@if ($errorPickupProvinceID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['ProvinceName'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="PickupProvinceID">
								<option value=''>Select {{$alias['ProvinceName'][0]}}</option>
								@foreach ($arrPickupProvince as $obj)
									<option value="{{$obj['ID']}}" @if ($obj['ID'] == $PickupProvinceID) selected @endif>{{$obj['Name']}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorProvinceID}}</span>
						</div>
						<div class="@if ($errorPickupCityID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['CityName'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="PickupCityID">
								<option value=''>Select {{$alias['CityName'][0]}}</option>
								@foreach ($arrPickupCity as $obj)
									<option value="{{$obj['ID']}}" @if ($obj['ID'] == $PickupCityID) selected @endif>{{str_replace('Kabupaten', 'Kab.', $obj['Alias']).' '.$obj['Name']}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorPickupCityID}}</span>
						</div>
						<div class="@if ($errorPickupDistrictID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['DistrictName'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="PickupDistrictID">
								<option value=''>Select {{$alias['DistrictName'][0]}}</option>
								@foreach ($arrPickupDistrict as $obj)
									<option value="{{$obj['ID']}}" @if ($obj['ID'] == $PickupDistrictID) selected @endif>{{$obj['Name']}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorPickupDistrictID}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="@if ($errorPickupAddress1 != '') has-error @endif">
						<label class="control-label input-sm marlm10">{{$alias['PickupAddress1'][0]}} <span class="red">*</span></label>
						<textarea type="text" class="form-control input-sm" name="PickupAddress1">{{$PickupAddress1}}</textarea>
						<span class="help-block">{{$errorPickupAddress1}}</span>
					</div>
					<div class="@if ($errorPickupZipcodeID != '') has-error @endif">
						<label class="control-label input-sm marlm10">{{$alias['PickupZipcodeID'][0]}} <span class="red">*</span></label>
						<input type="text" class="form-control input-sm" name="PickupZipcodeID" value="{{$PickupZipcodeID}}" maxlength="5">
						<span class="help-block">{{$errorPickupZipcodeID}}</span>
					</div>
					<div class="@if ($errorPickupPhone != '') has-error @endif">
						<label class="control-label input-sm marlm10">{{$alias['PickupPhone'][0]}} <span class="red">*</span></label>
						<input type="text" class="form-control input-sm" name="PickupPhone" value="{{$PickupPhone}}">
						<span class="help-block">{{$errorPickupPhone}}</span>
					</div>
					<div class="@if ($errorPickupPIC != '') has-error @endif">
						<label class="control-label input-sm marlm10">{{$alias['PickupPIC'][0]}} <span class="red">*</span></label>
						<input type="text" class="form-control input-sm" name="PickupPIC" value="{{$PickupPIC}}">
						<span class="help-block">{{$errorPickupPIC}}</span>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
	<div class="form-actions right">
		<input type="text" class="hide" name="action" value="{{$action}}">
		<a class="btn btn-sm default" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}">Cancel</a>
		<button type="submit" class="btn btn-sm blue" name="edit">Edit <i class="fa fa-arrow-circle-right"></i></button>
	</div>
</form>
<script type="text/javascript">
	window.onload = (function() {
		$('[name="CountryID"],[name="PickupCountryID"]').change(function() {
		    var CountryID = $(this).val();

		    var appendname = '';
		    if($(this).attr('name') == 'PickupCountryID') appendname = 'Pickup';

			$('[name="'+appendname+'ProvinceID"]').empty();
			$('[name="'+appendname+'ProvinceID"]').html('<option value="">Select {{$alias['ProvinceName'][0]}}</option>');

		    $.ajax({
				url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
				type		: 'POST',
				data		: {'ajaxpost':"GetProvince",'CountryID': CountryID},
				success		: function(data) {
					var data = JSON.parse(data);

					if(data['response'] == 'OK') {
						var list = '';
						$.each(data['data'], function(key, value) {
							list = list + '<option value="'+value['ID']+'">'+value['Name']+'</option>';
						});
						$('[name="'+appendname+'ProvinceID"]').append(list);
	            	}
				}
			});
		});

		$('[name="ProvinceID"],[name="PickupProvinceID"]').change(function() {
		    var ProvinceID = $(this).val();

		    var appendname = '';
		    if($(this).attr('name') == 'PickupProvinceID') appendname = 'Pickup';

			$('[name="'+appendname+'CityID"]').empty();
			$('[name="'+appendname+'CityID"]').html('<option value="">Select {{$alias['CityName'][0]}}</option>');

		    $.ajax({
				url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
				type		: 'POST',
				data		: {'ajaxpost':"GetCity",'ProvinceID': ProvinceID},
				success		: function(data) {
					var data = JSON.parse(data);

					if(data['response'] == 'OK') {
						var list = '';
						$.each(data['data'], function(key, value) {
							list = list + '<option value="'+value['ID']+'">'+value['Alias'].replace('Kabupaten', 'Kab.')+' '+value['Name']+'</option>';
						});
						$('[name="'+appendname+'CityID"]').append(list);
	            	}
				}
			});
		});

		$('[name="CityID"],[name="PickupCityID"]').change(function() {
		    var CityID = $(this).val();

		    var appendname = '';
		    if($(this).attr('name') == 'PickupCityID') appendname = 'Pickup';

			$('[name="'+appendname+'DistrictID"]').empty();
			$('[name="'+appendname+'DistrictID"]').html('<option value="">Select {{$alias['DistrictName'][0]}}</option>');

		    $.ajax({
				url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
				type		: 'POST',
				data		: {'ajaxpost':"GetDistrict",'CityID': CityID},
				success		: function(data) {
					var data = JSON.parse(data);

					if(data['response'] == 'OK') {
						var list = '';
						$.each(data['data'], function(key, value) {
							list = list + '<option value="'+value['ID']+'">'+value['Name']+'</option>';
						});
						$('[name="'+appendname+'DistrictID"]').append(list);
	            	}
				}
			});
		});

		checklegaltype('{{$LegalType}}');
	});

	function checklegaltype(val) {
		var obj = $('[name="BusinessRegNumber"],[name="SellerVAT"],[name="VATReg"],#VATInfoFile');
		if(val == 0 || val == '') {
			obj.parent().find('span.red').html('');
		} else {
			obj.parent().find('span.red').html('*');
		}
	}

	function deleteVATInfoFile() {
		bootbox.confirm($('#deleteVATInfoFile').attr('value'), function(result) {
			if(result) {
				$.ajax({
					url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
					type		: 'POST',
					data		: {'ajaxpost':"deleteVATInfoFile",'value':'{{$SellerID}}'},
					success		: function(data) {
						if(!data) $('#VATInfoFile').html('');
					}
				});
			}
		});
	}
</script>