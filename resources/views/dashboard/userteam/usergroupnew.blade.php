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
						<div class="@if ($errorgroupname != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['groupname'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="groupname" value="{{$groupname}}">
							<span class="help-block">{{$errorgroupname}}</span>
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset class='fieldset'><legend class='legend' rel="stylesheet">Access for this Group</legend>
				<div class="col-md-12">
					<div class="form-group">
						@foreach ($arrmenu as $key => $val)
						<div style='clear:both;'>
							<span class='bold'>
								{{$val['name']}}
							</span>
							@if (isset($arrmenu[$key][$arrmenu[$key]['permalink']]) && is_array($arrmenu[$key][$arrmenu[$key]['permalink']]))
								@include('dashboard.userteam.usergroupnewmenu1', ['parents' => [
									'values' => $arrmenu[$key][$arrmenu[$key]['permalink']],
									'optmenu' => $optmenu,
								]])
							@endif
							<br/>
						</div>
						@endforeach
						<span class="help-block"></span>
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