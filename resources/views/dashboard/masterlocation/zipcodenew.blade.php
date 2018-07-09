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
						<div class="@if ($errorPostalCode != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['PostalCode'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm numberonly" name="PostalCode" value="{{$PostalCode}}">
							<span class="help-block">{{$errorPostalCode}}</span>
						</div>
						<div class="@if ($errorCityID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['CityName'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="CityID" onchange="getaccess(this.value, '{{$action}}');">
								<option value=''>Select {{$alias['CityID'][0]}}</option>
								@foreach ($arrcity as $cityval)
									<option value="{{$cityval['ID']}}" @if ($cityval['ID'] == $CityID) selected @endif>{{$cityval['Name']}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorCityID}}</span>
						</div>
						<div class="@if ($errorLongitude != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Longitude'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="Longitude" value="{{$Longitude}}">
							<span class="help-block">{{$errorLongitude}}</span>
						</div>
						<div class="@if ($errorLatitude != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Latitude'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="Latitude" value="{{$Latitude}}">
							<span class="help-block">{{$errorLatitude}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errorDistrict != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['District'][0]}} <span class="red">*</span></label>
							<textarea type="text" class="form-control input-sm" name="District">{{$District}}</textarea>
							<span class="help-block">{{$errorDistrict}}</span>
						</div>
						<div class="@if ($errorVillage != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Village'][0]}} <span class="red">*</span></label>
							<textarea type="text" class="form-control input-sm" name="Village">{{$Village}}</textarea>
							<span class="help-block">{{$errorVillage}}</span>
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