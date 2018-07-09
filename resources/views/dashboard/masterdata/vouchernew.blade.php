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
						<div class="@if ($errorVoucherCode != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['VoucherCode'][0]}} <span class="red">*</span> <button type="button" class="btn btn-sm red" onclick='$("[name=\"VoucherCode\"]").val(uniqid().toUpperCase())'>Auto Generate</button></label>
							<input type="text" class="form-control input-sm" name="VoucherCode" value="{{$VoucherCode}}">
							<span class="help-block">{{$errorVoucherCode}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<div class="@if ($errorVoucherAmount != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['VoucherAmount'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm numberonly" name="VoucherAmount" value="{{$VoucherAmount}}">
							<span class="help-block">{{$errorVoucherAmount}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<div class="@if ($errorValidDate != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['ValidDate'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control datetimeoneminute input-sm" name="ValidDate" value="{{$ValidDate}}">
							<span class="help-block">{{$errorValidDate}}</span>
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