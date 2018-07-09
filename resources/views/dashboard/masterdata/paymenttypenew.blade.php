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
						<div class="@if ($errorType != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Type'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="Type" onchange="CheckOurBank(this.value)">
								<option value=''>Select {{$alias['Type'][0]}}</option>
								@foreach ($arrtype as $key => $val)
									<option value="{{$key}}" @if (is_numeric($Type) && $key == $Type) selected @endif>{{$val}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorType}}</span>
						</div>
						<div class="@if ($errorOurBankID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['OurBankName'][0]}} @if (is_numeric($Type) && $Type == 0)<span class="red"> *</span>@endif</label>
							<select class="form-control input-sm select2me" name="OurBankID">
								<option value=''>Select {{$alias['OurBankName'][0]}}</option>
								@foreach ($arrourbank as $obj)
									<option value="{{$obj['ID']}}" @if ($obj['ID'] == $OurBankID) selected @endif>{{$obj['BankName']}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorOurBankID}}</span>
						</div>
						<div class="@if ($errorName != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Name'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="Name" value="{{$Name}}">
							<span class="help-block">{{$errorName}}</span>
						</div>
						<div class="fileinput fileinput-new @if ($errorImage != '') has-error @endif" data-provides="fileinput">
							<label class="control-label input-sm marlm10">{{$alias['Image'][0]}} <span class="red">* <sup>Height 100px</sup></span></label>
							<div id="Image">
								@if (($action == 'edit' || $action == 'detail') && $Image != '')
								<div class="contentimage">
									<img src='{{$Image}}?{{uniqid()}}'/>
									<a id="deleteImage" class="btn btn-sm red" onclick="deleteImage();" value="Are you sure to remove {{$alias['Image'][0]}} ?"><i class="fa fa-trash-o"></i></a>
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
									Select {{$alias['Image'][0]}} </span>
									<span class="fileinput-exists">
									Change {{$alias['Image'][0]}} </span>
									<input type="file" name="Image">
								</span>
								<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
								Remove </a>
							</div>
							<span class="help-block">{{$errorImage}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errorNotes != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Notes'][0]}} <span class="red">*</span></label>
							<textarea type="text" class="ckeditor form-control input-sm" name="Notes">{{$Notes}}</textarea>
							<span class="help-block">{{$errorNotes}}</span>
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
	function CheckOurBank(val) {
		if($.isNumeric(val) && val == 0) {
			$.ajax({
				url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
				type		: 'POST',
				data		: {'ajaxpost':"GetOurBank"},
				success		: function(data) {
					var data = JSON.parse(data);
	                if(data['response'] == 'OK') {
	                	var listOurBank = '';

	                	$.each(data['data'], function(keys, vals) {
							listOurBank = listOurBank + '<option value="'+vals['ID']+'">'+vals['BankName']+'</option>';
						});

						$('[name="OurBankID"]').append(listOurBank);
						$('[name="OurBankID"]').parent().find('label').append('<span class="red"> *</span>');
	                } else {
                		$('[name="OurBankID"]').parent().find('label span.red').remove();
                		$('[name="OurBankID"]').html('<option value="">Select {{$alias['OurBankName'][0]}}</option>');
	                }
				}
			});
		} else {
			$('[name="OurBankID"]').parent().find('label span.red').remove();
			$('[name="OurBankID"]').html('<option value="">Select {{$alias['OurBankName'][0]}}</option>');
		}
	}
	@if ($action == 'edit')
	function deleteImage() {
		bootbox.confirm($('#deleteImage').attr('value'), function(result) {
			if(result) {
				$.ajax({
					url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
					type		: 'POST',
					data		: {'ajaxpost':"deleteImage",'value':'{{$PaymentTypeID}}'},
					success		: function(data) {
						if(!data) $('#Image').html('');
					}
				});
			}
		});
	}
	@endif
</script>