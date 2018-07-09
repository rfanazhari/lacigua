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
				<div class="col-md-12">
					<div class="form-group">
						<div class="@if ($errorgroupname != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['groupname'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="groupname" onchange="getaccess(this.value, '{{$action}}');">
								<option value=''>Select {{$alias['groupname'][0]}}</option>
								@foreach ($arrgroup as $groupval)
									<option value="{{$groupval['permalink']}}" @if ($groupval['permalink'] == $groupname) selected @endif>{{$groupval[$flip['groupname']]}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorgroupname}}</span>
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
	<br/>
	<div class="form-body">
		<div class="row">
			<input type="text" class="hide" id="listoptmenu" value="{{json_encode($optmenu, JSON_FORCE_OBJECT)}}">
			<div id='listmenu'></div>
		</div>
	</div>	
</form>
<script type="text/javascript">
	window.onload = (function() {
		@if (isset($groupname) && $groupname != '')
		getaccess('{{$groupname}}', '{{$action}}');
		@endif
	});
	
	function getaccess(value, action) {
		if(value) {
			$.ajax({
				url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
				type		: 'POST',
				data		: {'ajaxpost':"getaccess",'value':value,'action':action,'optmenu':$('#listoptmenu').val()},
				success		: function(data) {
					$('#listmenu').html(data);
				}
			});
		}
	}
</script>