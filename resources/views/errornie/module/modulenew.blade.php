@if (isset($messageerror) && $messageerror != '')
<span class='red bold'>{!!$messageerror!!}</span><br/><br/>
@endif
@if (isset($messagesuccess) && $messagesuccess != '')
<span class='green bold'>{!!$messagesuccess!!}</span><br/><br/>
@endif
<form method="post" class="horizontal-form">
	<div class="form-body">
		<div class="row">
			<fieldset class='fieldset'><legend class='legend' rel="stylesheet">Module Information</legend>
				<div class="col-md-3">
					<div class="form-group">
						<div class="@if ($errorheadmenu != '') has-error @endif">
							<label class="control-label input-sm marlm10">Head Menu <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="headmenu">
								<option value=''>Select Head Menu</option>
								@foreach ($result['data'] as $val)
								<option value='{{$val["permalink"]}}-{{$val["idMMenu"]}}' @if ($val["permalink"] == $headmenu) selected @endif >x {{$val['name']}}</option>
								@if (isset($val[$val['permalink']]) && is_array($val[$val['permalink']]))
								@include('errornie.module.modulenewmenulist', ['parents' => [
																				'values' => $val[$val['permalink']],
																				'prefix' => '+',
																				'tab' => "&nbsp;&nbsp;&nbsp;"
																			]])
								@endif
								@endforeach
							</select>
							<span class="help-block">{{$errorheadmenu}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<div class="@if ($errorindependent != '') has-error @endif">
							<label class="control-label input-sm marlm10">Click for Independent Menu</label><br/>
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-sm default @if ($independent) active @endif" for="independent">
									<input type="checkbox" class="toggle" name="independent" id="independent" @if ($independent) checked @endif> Independent Menu
								</label>
							</div>
							<span class="help-block">{{$errorindependent}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<div class="@if ($errorname != '') has-error @endif">
							<label class="control-label input-sm marlm10">Menu Name <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="name" value="{{$name}}">
							<span class="help-block">{{$errorname}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<div>
							<label class="control-label input-sm marlm10">Icon</label>
							<select class="bs-select form-control input-sm select2me" name="icon">
								<option value=''>Select Icon</option>
								@foreach ($arrsocialmediaicon as $socialmediaiconval)
									<option value="{{$socialmediaiconval}}" @if ($socialmediaiconval == $icon) selected @endif>{{$socialmediaiconval}}</option>
								@endforeach
							</select>
							<span class="help-block"></span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errordesc_en != '') has-error @endif">
							<label class="control-label input-sm marlm10">Description EN <span class="red">*</span></label>
							<textarea type="text" class="form-control input-sm" name="desc_en" rows="3">{{$desc_en}}</textarea>
							<span class="help-block">{{$errordesc_en}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errordesc_id != '') has-error @endif">
							<label class="control-label input-sm marlm10">Description ID</label>
							<textarea type="text" class="form-control input-sm" name="desc_id" rows="3">{{$desc_id}}</textarea>
							<span class="help-block">{{$errordesc_id}}</span>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
	<div class="form-actions right">
		<a class="btn btn-sm default" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}">Cancel</a>
		@if ($action == 'edit')
		<button type="submit" class="btn btn-sm blue" name="edit">Edit <i class="fa fa-arrow-circle-right"></i></button>
		@else
		<button type="submit" class="btn btn-sm blue" name="addnew">Save <i class="fa fa-arrow-circle-right"></i></button>
		@endif
	</div>
</form>