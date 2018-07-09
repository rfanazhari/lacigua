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
						<div class="@if ($errorCompanyName != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['CompanyName'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="CompanyName" value="{{$CompanyName}}">
							<span class="help-block">{{$errorCompanyName}}</span>
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
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errorPhone != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Phone'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="Phone" value="{{$Phone}}">
							<span class="help-block">{{$errorPhone}}</span>
						</div>
						<div class="@if ($errorWebsite != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Website'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="Website" value="{{$Website}}">
							<span class="help-block">{{$errorWebsite}}</span>
						</div>
						<div class="@if ($errorNote != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Note'][0]}} <span class="red">*</span></label>
							<textarea type="text" class="form-control input-sm" name="Note">{{$Note}}</textarea>
							<span class="help-block">{{$errorNote}}</span>
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