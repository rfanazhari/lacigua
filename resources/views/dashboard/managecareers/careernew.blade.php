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
				<div class="col-md-4">
					<div class="form-group">
						<div class="@if ($errorCareerDivisionID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['CareerDivisionID'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="CareerDivisionID" onchange="GetMode(this.value)">
								<option value=''>Select {{$alias['CareerDivisionID'][0]}}</option>
								@foreach ($ArrCareerDivision as $obj)
								<option value="{{$obj['ID']}}" @if ($obj['ID'] == $CareerDivisionID) selected @endif>{{$obj['Name']}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorCareerDivisionID}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<div class="@if ($errorPosition != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Position'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="Position" value="{{$Position}}">
							<span class="help-block">{{$errorPosition}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<div class="@if ($errorClosedDate != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['ClosedDate'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm dateonly" name="ClosedDate" value="{{$ClosedDate}}">
							<span class="help-block">{{$errorClosedDate}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<div class="@if ($errorSimpleRequirement != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['SimpleRequirement'][0]}} <span class="red">*</span></label>
							<textarea type="text" class="form-control input-sm ckeditor" name="SimpleRequirement">{{$SimpleRequirement}}</textarea>
							<span class="help-block">{{$errorSimpleRequirement}}</span>
						</div>
						<div class="@if ($errorRequirement != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Requirement'][0]}} <span class="red">*</span></label>
							<textarea type="text" class="form-control input-sm ckeditor" name="Requirement">{{$Requirement}}</textarea>
							<span class="help-block">{{$errorRequirement}}</span>
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
