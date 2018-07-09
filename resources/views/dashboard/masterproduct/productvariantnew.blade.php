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
						<div class="@if ($errorProductID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['ProductName'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="ProductID" onchange="_getvariant(this.value)">
								<option value=''>Select {{$alias['ProductName'][0]}}</option>
								@foreach ($arrProduct as $obj)
									<option value="{{$obj['ID']}}" @if ($obj['ID'] == $ProductID) selected @endif>{{$obj['SKUPrinciple'].' - '.$obj['Name']}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorProductID}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<div class="@if ($errorVariantID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['VariantName'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="VariantID">
								<option value=''>Select {{$alias['VariantName'][0]}}</option>
								@foreach ($arrVariant as $obj)
								<option value="{{$obj['ID']}}" @if ($obj['ID'] == $VariantID) selected @endif> {{ $obj['Name'] }}
								</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorVariantID}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<div class="@if ($errorQty != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Qty'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm numberonly" name="Qty" value="{{$Qty}}">
							<span class="help-block">{{$errorQty}}</span>
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
	function _getvariant(obj) {
		$.ajax({
			url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
			type		: 'POST',
			data		: {'ajaxpost':"_getvariant",'value': obj},
			success		: function(data) {
				var data = JSON.parse(data);

				var listsize = "<option value=''>Select {{$alias['ProductName'][0]}}</option>";
				if(data['response'] == 'OK') {
					$.each(data['data'], function(key, value) {
						listsize = listsize + '<option value="'+value['ID']+'" >'+value['Name']+'</option>';
					});
				}

				$('[name="VariantID"]').html(listsize);
			}
		});
	}
</script>	