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
						<div id="error" class="fileinput fileinput-new @if ($errorupdatebulkproductreguler != '') has-error @endif" data-provides="fileinput">
							<label class="control-label input-sm marlm10">{{$alias['updatebulkproductreguler'][0]}} <span class="red">*</span></label>
							<div id="updatebulkproductreguler">
								@if (($action == 'edit' || $action == 'detail') && $updatebulkproductreguler != '')
								<a href="{{$updatebulkproductreguler}}" class="btn btn-sm blue">
									{{$alias['updatebulkproductreguler'][0]}}
								</a>
								<a class="btn btn-sm red" value="Are you sure to remove {{$alias['updatebulkproductreguler'][0]}} ?">
									Delete {{$alias['updatebulkproductreguler'][0]}} <i class="fa fa-trash-o"></i>
								</a>
								@endif
							</div>
							<div class="input-group">
								<div class="form-control uneditable-input input-sm" data-trigger="fileinput">
									<i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
									</span>
								</div>
								<span class="input-group-addon btn btn-sm default btn-file">
									<span class="fileinput-new">
									Select {{$alias['updatebulkproductreguler'][0]}} </span>
									<span class="fileinput-exists">
									Change {{$alias['updatebulkproductreguler'][0]}} </span>
									<input type="file" name="updatebulkproductreguler">
								</span>
								<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
								Remove </a>
							</div>
							<span id="help" class="help-block">{{$errorupdatebulkproductreguler}}</span>
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