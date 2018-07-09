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
						<div class="@if ($errorCustomerUniqueID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['CustomerUniqueID'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="CustomerUniqueID" value="{{$CustomerUniqueID}}">
							<span class="help-block">{{$errorCustomerUniqueID}}</span>
						</div>

						<div class="@if ($errorFullName != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['FullName'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="FullName" value="{{$FullName}}">
							<span class="help-block">{{$errorFullName}}</span>
						</div>

						<div class="@if ($errorEmail != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Email'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="Email" value="{{$Email}}">
							<span class="help-block">{{$errorEmail}}</span>
						</div>

						<div class="@if ($errorMobile != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Mobile'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="Mobile" value="{{$Mobile}}">
							<span class="help-block">{{$errorMobile}}</span>
						</div>

					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errorReferralCustomerID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['ReferralCustomerID'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="ReferralCustomerID" value="{{$Referal}}">
							<span class="help-block">{{$errorReferralCustomerID}}</span>
						</div>

						<div class="@if ($errorPhone != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Phone'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="Phone" value="{{$Phone}}">
							<span class="help-block">{{$errorPhone}}</span>
						</div>

						<div class="@if ($errorDOB != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['DOB'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control dateonly input-sm" name="DOB" value="{{$DOB}}">
							<span class="help-block">{{$errorDOB}}</span>
						</div>

						<div class="@if ($errorUsername != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Username'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="Username" value="{{$Username}}">
							<span class="help-block">{{$errorUsername}}</span>
						</div>
					</div>
				</div>
			</fieldset>
			@if(!empty($Address))
			<fieldset class='fieldset'>
			<legend class='legend' rel="stylesheet">Address List</legend>
			@foreach($Address as $alamat)
				<div class="col-md-12">
					<div class="form-group">
						<div>
							<label class="control-label input-sm">{{$alamat['AddressInfo']}}</label>
							<textarea type="text" class="form-control input-sm" name="Address">{{$alamat['Address']}}</textarea>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div>
							<label class="control-label input-sm">Province</label>
							<input type="text" class="form-control" value="{{ $alamat['ProvinceName'] }}" name="" id="">
						</div>
						<div>
							<label class="control-label input-sm">District</label>
							<input type="text" class="form-control" value="{{ $alamat['DistrictName'] }}" name="" id="">
						</div>
					</div>
				</div>		
				<div class="col-md-6">
					<div class="form-group">
						<div>
							<label class="control-label input-sm">City</label>
							<input type="text" class="form-control" value="{{ $alamat['CityName'] }}" name="" id="">
						</div>
						<div>
							<label class="control-label input-sm">Postal Code</label>
							<input type="text" class="form-control" value="{{ $alamat['PostalCode'] }}" name="" id="">
						</div>
					</div>
				</div>
				<div class="col-md-12">
				<hr style="border:1px solid #eeeeee;">		
				</div>
			@endforeach
			</fieldset>
			@else
			<fieldset class='fieldset'>
				<legend class='legend text-center' rel="stylesheet">
					<div class="form-body">
						<span class="help-block">Anda belum menambahkan alamat !</span>
					</div>
				</legend>
			</fieldset>	
			@endif
			
			@if(!empty($CC))
			<fieldset class='fieldset'>
			<legend class='legend' rel="stylesheet">Credit Card</legend>
			@foreach($CC as $cc)
				<div class="col-md-6">
					<div class="form-group">
						<div>
							<label class="control-label input-sm">Type Card</label>
							<input type="text" class="form-control" value="{{ $cc['CCType'] }}" name="" id="">
						</div>
						<div>
							<label class="control-label input-sm">Number Card</label>
							<input type="text" class="form-control" value="{{ $cc['CCNumber'] }}" name="" id="">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div>
							<label class="control-label input-sm">Name Card</label>
							<input type="text" class="form-control" value="{{ $cc['CCName'] }}" name="" id="">
						</div>
						<div>
							<label class="control-label input-sm">Month and Year</label>
							<input type="text" class="form-control" value="{{ date("F", mktime(0, 0, 0, $cc['CCMonth'], 10)) }} {{ $cc['CCYear'] }}" name="" id="">
						</div>
					</div>
				</div>
				<hr style="border:1px solid #eeeeee;">		
			@endforeach
			</fieldset>
			@else
			<fieldset class='fieldset'>
				<legend class='legend text-center' rel="stylesheet">
					<div class="form-body">
						<span class="help-block">Anda belum menambahkan Kartu !</span>
					</div>
				</legend>
			</fieldset>
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
