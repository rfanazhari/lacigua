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
						<div class="@if ($errorBankBeneficiaryName!= '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['BankBeneficiaryName'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="BankBeneficiaryName" value="{{$BankBeneficiaryName}}">
							<span class="help-block">{{$errorBankBeneficiaryName}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errorBankBranch!= '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['BankBranch'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="BankBranch" value="{{$BankBranch}}">
							<span class="help-block">{{$errorBankBranch}}</span>
						</div>
						<div class="@if ($errorBankCode!= '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['BankCode'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm numberonly" name="BankCode" value="{{$BankCode}}">
							<span class="help-block">{{$errorBankCode}}</span>
						</div>
						<div class="fileinput fileinput-new @if ($errorBankLogo != '') has-error @endif" data-provides="fileinput">
							<label class="control-label input-sm marlm10">{{$alias['BankLogo'][0]}} <span class="red">* <sup>Height 100px</sup></span></label>
							<div id="BankLogo">
								@if (($action == 'edit' || $action == 'detail') && $BankLogo != '')
								<div class="contentimage">
									<img src='{{$BankLogo}}?{{uniqid()}}'/>
									<a id="deleteBankLogo" class="btn btn-sm red" onclick="deleteBankLogo();" value="Are you sure to remove {{$alias['BankLogo'][0]}} ?"><i class="fa fa-trash-o"></i></a>
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
									Select {{$alias['BankLogo'][0]}} </span>
									<span class="fileinput-exists">
									Change {{$alias['BankLogo'][0]}} </span>
									<input type="file" name="BankLogo">
								</span>
								<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
								Remove </a>
							</div>
							<span class="help-block">{{$errorBankLogo}}</span>
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
<script type="text/javascript">
	@if ($action == 'edit')
	function deleteBankLogo() {
		bootbox.confirm($('#deleteBankLogo').attr('value'), function(result) {
			if(result) {
				$.ajax({
					url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
					type		: 'POST',
					data		: {'ajaxpost':"deleteBankLogo",'value':'{{$OurBankID}}'},
					success		: function(data) {
						if(!data) $('#BankLogo').html('');
					}
				});
			}
		});
	}
	@endif
</script>