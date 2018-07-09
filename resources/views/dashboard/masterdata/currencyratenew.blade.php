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
					<div class="@if ($errorCurrencyCodeFrom != '') has-error @endif">
						<label class="control-label input-sm marlm10">{{$alias['CurrencyCodeFrom'][0]}} <span class="red">*</span></label>
						<select class="form-control input-sm select2me" name="CurrencyCodeFrom">
							<option value=''>Select {{$alias['CurrencyCodeFrom'][0]}}</option>
							@foreach ($arrCurrency as $obj)
								<option value="{{$obj['Code']}}" @if ($obj['Code'] == $CurrencyCodeFrom) selected @endif>{{$obj['Name']}}</option>
							@endforeach
						</select>
						<span class="help-block">{{$errorCurrencyCodeFrom}}</span>
					</div>
				</div>

				<div class="col-md-4">
					<div class="@if ($errorCurrencyCodeTo != '') has-error @endif">
						<label class="control-label input-sm marlm10">{{$alias['CurrencyCodeTo'][0]}} <span class="red">*</span></label>
						<select class="form-control input-sm select2me" name="CurrencyCodeTo">
							<option value=''>Select {{$alias['CurrencyCodeTo'][0]}}</option>
							@foreach ($arrCurrency as $obj)
								<option value="{{$obj['Code']}}" @if ($obj['Code'] == $CurrencyCodeTo) selected @endif>{{$obj['Name']}}</option>
							@endforeach
						</select>
						<span class="help-block">{{$errorCurrencyCodeTo}}</span>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<div class="@if ($errorValue != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Value'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="Value" value="{{$Value}}">
							<span class="help-block">{{$errorValue}}</span>
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
