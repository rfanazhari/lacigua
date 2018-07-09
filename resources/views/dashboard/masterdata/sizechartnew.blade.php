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
						<div>
							<label class="control-label input-sm marlm10">Model Type <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="ModelType">
								@foreach ($arrModelType as $key => $value)
								<option value="{{$key}}" @if ($key == $ModelType) selected @endif>{{$value}}</option>
								@endforeach
							</select>
						</div>

						<div class="@if ($errorCategoryID != '') has-error @endif">
							<label class="control-label input-sm marlm10">
								{{$alias['CategoryName'][0]}} 
								<span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="CategoryID">
								<option value=''>Select {{$alias['CategoryName'][0]}}</option>
								@foreach ($arrCategory as $obj)
									<option value="{{$obj['ID']}}" @if ($obj['ID'] == $CategoryID) selected @endif>{{$obj['Name']}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorCategoryID}}</span>
						</div>
						<div id="error" class="@if ($errorSubCategoryID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['SubCategoryName'][0]}} 
								<span id="mandatori" class="red">@if ($errorSubCategoryID != '') * @endif</span></label>
							<select class="form-control input-sm select2me" name="SubCategoryID">
								<option value=''>Select {{$alias['SubCategoryName'][0]}}</option>
								@foreach ($arrSubCategory as $obj)
									<option value="{{$obj['ID']}}" @if (isset($SubCategoryID) && $obj['ID'] == $SubCategoryID) selected @endif>{{$obj['Name']}}</option>
								@endforeach
							</select>
							<span id="help" class="help-block">{{$errorSubCategoryID}}</span>
						</div>

					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errorGroupSizeID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['GroupSizeName'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="GroupSizeID">
								<option value=''>Select {{$alias['GroupSizeName'][0]}}</option>
								@foreach ($arrGroupSize as $obj)
								<option value="{{$obj['ID']}}" @if ($obj['ID'] == $GroupSizeID) selected @endif> {{ $obj['Name'] }}
								</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorGroupSizeID}}</span>
						</div>

						<div class="fileinput fileinput-new @if ($errorImage != '') has-error @endif" data-provides="fileinput">
							<label class="control-label input-sm marlm10">{{$alias['Image'][0]}} <span class="red">*</span></label>
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
	window.onload = (function() {
		$('#deleteImage').css('width', $('#showImage').css('width'));

		var sub = $('[name="CategoryID"]').val();
		if(sub == ''){
			$('#mandatori').text('*');
		}

		$('[name="ModelType"]').change(function(){
		    var ModelType = $(this).val();
		    $.ajax({
					url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
					type		: 'POST',
					data		: {'ajaxpost':"getCategory",'ModelType': ModelType},
					success		: function(data) {
						var tampung = JSON.parse(data);

							if(tampung['response'] == 'OK') {
								$('[name="CategoryID"]').empty();
								$('[name="SubCategoryID"]').empty();
								$('[name="CategoryID"]')
										.append($("<option></option>")
			    						.attr("selected",'')
								        .val('')
								        .text('Please Select Category'));
								$('[name="SubCategoryID"]')
										.append($("<option></option>")
			    						.attr("selected",'')
								        .val('')
								        .text('Please Select Sub Category'));
									$.each(tampung['data'], function(key, value) {
									     $('[name="CategoryID"]')
									         .append($("<option></option>")
									         .attr("value",value['ID'])
									         .val(value['ID'])
									         .text(value['Name']));
									});      
								$('[name="CategoryID"]').select2("val", null);
								$('[name="SubCategoryID"]').select2("val", null);

			            	}
						}
				});
			});

			$('[name="CategoryID"]').change(function(){
		    var Category = $(this).val();
		    if(Category != ''){ 
			    $.ajax({
						url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
						type		: 'POST',
						data		: {'ajaxpost':"getSubCategory",'Category': Category},
						success		: function(data) {
							var tampung = JSON.parse(data);
			    			var jumlah = Object.keys(tampung['data']).length;
							if(tampung['response'] == 'OK') {
								$('[name="SubCategoryID"]').empty();
								$('[name="SubCategoryID"]')
									.append($("<option></option>")
		    						.attr("selected",'')
							        .val('')
							        .text('Please Select Sub Category'));
							        $('[name="SubCategoryID"]').select2("val", null);
								if(jumlah > 0){
									$.each(tampung['data'], function(key, value) {
									     $('[name="SubCategoryID"]')
									         .append($("<option></option>")
									         .attr("value",value['ID'])
									         .val(value['ID'])
									         .text(value['Name']));
									});
									$('#mandatori').addClass('red').text('*');
								}
								else{
									$('#mandatori').empty();
									$('#help').empty();	
									$('#error').removeAttr('class');
									$('[name="SubCategoryID"]').select2("val", null);
								}
			            	}
						}
				});
			 }
		    else{
		    	$('[name="SubCategoryID"]').empty();
		    	$('[name="SubCategoryID"]')
				.append($("<option></option>")
				.attr("selected",'')
		        .val('')
		        .text('Please Select Sub Category'));
		        $('[name="SubCategoryID"]').select2("val", null);
				$('#mandatori').text('*');
		    }
		});
	});

	@if ($action == 'edit')
	function deleteImage() {
		bootbox.confirm($('#deleteImage').attr('value'), function(result) {
			if(result) {
				$.ajax({
					url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
					type		: 'POST',
					data		: {'ajaxpost':"deleteImage",'value':'{{$SizeChartID}}'},
					success		: function(data) {
						if(!data) $('#Image').html('');
					}
				});
			}
		});
	}
	@endif
</script>