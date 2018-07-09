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
						<div class="@if ($errorSellerID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['SellerName'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="SellerID" onchange="getcategory(this.value)">
								@foreach ($arrSeller as $value)
								<option value="{{$value['ID']}}" @if ($value['ID'] == $SellerID) selected @endif>
									{{$value['FullName']}}
								</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorSellerID}}</span>
						</div>
						<div class="@if ($errorBrandID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['BrandName'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="BrandID">
								<option value=''>Select {{$alias['BrandName'][0]}}</option>
								@foreach ($arrBrand as $value)
								<option value="{{$value['ID']}}" @if ($value['ID'] == $BrandID) selected @endif>
									{{$value['Name']}}
								</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorBrandID}}</span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">Model Type <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="ModelType">
								@foreach ($arrModelType as $key => $value)
								<option value="{{$key}}" @if ($key == $ModelType) selected @endif>{{$value}}</option>
								@endforeach
							</select>
						</div>
						<div class="@if ($errorCategoryID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['CategoryName'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="CategoryID">
								<option value=''>Select {{$alias['CategoryName'][0]}}</option>
								@foreach ($arrCategory as $obj)
									<option value="{{$obj['ID']}}" @if ($obj['ID'] == $CategoryID) selected @endif>{{$obj['Name']}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorCategoryID}}</span>
						</div>
						<div id="errorSub" class="@if ($errorSubCategoryID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['SubCategoryName'][0]}} <span id="mandatoriSub" class="red">@if ($errorSubCategoryID != '') * @endif @if (isset($SubCategoryID) && $SubCategoryID)* @endif</span></label>
							<select class="form-control input-sm select2me" name="SubCategoryID">
								<option value=''>Select {{$alias['SubCategoryName'][0]}}</option>
								@foreach ($arrSubCategory as $obj)
									<option value="{{$obj['ID']}}" @if (isset($SubCategoryID) && $obj['ID'] == $SubCategoryID) selected @endif>{{$obj['Name']}}</option>
								@endforeach
							</select>
							<span id="helpSub" class="help-block">{{$errorSubCategoryID}}</span>
						</div>
						<div class="@if ($errorColorID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['ColorName'][0]}} <span class="red">*</span></label>
							<select class="bs-select form-control input-sm" name="ColorID" data-show-subtext="true">
								<option value=''>Select {{$alias['ColorName'][0]}}</option>
								@foreach ($arrColor as $obj)
									@if($obj['Hexa'] == '#FFFFFF')
									<option value="{{$obj['ID']}}" data-content="<span class='label lable-sm' style='background-color:{{$obj['Hexa']}}; color:black;'>{{$obj['Name']}}</span>" @if (isset($ColorID) && $obj['ID'] == $ColorID) selected @endif>{{$obj['Name']}}</option>
									@else
									<option value="{{$obj['ID']}}" data-content="<span class='label lable-sm' style='background-color:{{$obj['Hexa']}}'>{{$obj['Name']}}</span>" @if (isset($ColorID) && $obj['ID'] == $ColorID) selected @endif>{{$obj['Name']}}</option>
									@endif
								@endforeach
							</select>
							<span id="helpSub" class="help-block">{{$errorColorID}}</span>
						</div>
						<div class="@if ($errorTypeProduct != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['TypeProduct'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="TypeProduct" onchange="checktypeproduct(this.value);">
								@foreach ($arrTypeProduct as $key => $value)
								<option value="{{$key}}" @if ($key == $TypeProduct) selected @endif>{{$value}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorTypeProduct}}</span>
						</div>
						<div class="@if ($errorGroupSizeID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['GroupSizeName'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="GroupSizeID">
								<option value=''>Select {{$alias['GroupSizeName'][0]}}</option>
								@foreach ($arrGroupSize as $obj)
									<option value="{{$obj['ID']}}" @if ($obj['ID'] == $GroupSizeID) selected @endif>{{$obj['Name']}}</option>
								@endforeach
							</select>
							<span id="helpSub" class="help-block">{{$errorGroupSizeID}}</span>
						</div>
						<div class="@if ($errorSKUSeller != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['SKUSeller'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="SKUSeller" value="{{$SKUSeller}}">
							<span class="help-block">{{$errorSKUSeller}}</span>
						</div>
						<div class="@if ($errorName != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Name'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="Name" value="{{$Name}}">
							<span class="help-block">{{$errorName}}</span>
						</div>
						<div class="@if ($errorNameShow != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['NameShow'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="NameShow" value="{{$NameShow}}">
							<span class="help-block">{{$errorNameShow}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errorWeight != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Weight'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm numberonly" name="Weight" value="{{$Weight}}">
							<span class="help-block">{{$errorWeight}}</span>
						</div>
						<div class="@if ($errorSellingPrice != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['SellingPrice'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm numberonly" name="SellingPrice" value="{{$SellingPrice}}">
							<span class="help-block">{{$errorSellingPrice}}</span>
						</div>
						<div class="@if ($errorProductGender != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['ProductGender'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="ProductGender">
								@foreach ($arrProductGender as $key => $value)
									<option value="{{$key}}" @if ($key == $ProductGender) selected @endif>{{$value}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorProductGender}}</span>
						</div>
						<div class="@if ($errorMeasurement != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Measurement'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="Measurement" value="{{$Measurement}}">
							<span class="help-block">{{$errorMeasurement}}</span>
						</div>
						<div class="@if ($errorCompositionMaterial != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['CompositionMaterial'][0]}}</label>
							<input type="text" class="form-control input-sm" name="CompositionMaterial" value="{{$CompositionMaterial}}">
							<span class="help-block">{{$errorCompositionMaterial}}</span>
						</div>
						<div class="@if ($errorCareLabel != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['CareLabel'][0]}}</label>
							<input type="text" class="form-control input-sm" name="CareLabel" value="{{$CareLabel}}">
							<span class="help-block">{{$errorCareLabel}}</span>
						</div>
						<div class="@if ($errorStatusNew != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['StatusNew'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="StatusNew">
								@foreach ($arrStatusNew as $key => $value)
								<option value="{{$key}}" @if ($key == $StatusNew) selected @endif>{{$value}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorStatusNew}}</span>
						</div>
						<div class="@if ($errorStatusSale != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['StatusSale'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="StatusSale" onchange="checkstatussale(this.value);">
								@foreach ($arrStatusSale as $key => $value)
								<option value="{{$key}}" @if ($key == $StatusSale) selected @endif>{{$value}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorStatusSale}}</span>
						</div>
						<div class="@if ($errorSalePrice != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['SalePrice'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm numberonly" name="SalePrice" value="{{$SalePrice}}">
							<span class="help-block">{{$errorSalePrice}}</span>
						</div>
						<div class="@if ($errorProductLinkGroup != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['ProductLinkGroup'][0]}}</label>
							<div class="clearfix"></div>
							<button type="button" class="btn2 btn2-sm default green-stripe" style="height:30px; color:black;" onclick="return popup('{{$basesite}}{{$config['backend']['aliaspage']}}dashboard/masterproduct/product/popup/@if ($action == 'edit'){{'productid_'.$getid.'/'}}@endif', 'single', 'ProductID', 'callbackpopup', 'ProductLinkGroup', 'removelinked');">Select {{$alias['ProductLinkGroup'][0]}} <i class="fa fa-check-square-o"></i></button>
							<input type="text" class="form-control input-sm hide" name="ProductLinkGroup" value="{{$ProductLinkGroup}}">
							<span id="callbackpopup">{{$ProductLinkDisplay}}</span>
							<button id="removelinked" type="button" class="btn2 btn2-sm default green-stripe @if(!$ProductLinkDisplay) hide @endif" style="height:30px; color:black;" onclick="deleteSinglePopup('callbackpopup', 'ProductLinkGroup', 'removelinked')"><i class="fa fa-times"></i></button>
							<span class="help-block">{{$errorProductLinkGroup}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-6">
						<div class="form-group">
							<div class="@if ($errorDescription != '') has-error @endif">
								<label class="control-label input-sm marlm10">{{$alias['Description'][0]}} <span class="red">*</span></label>
								<textarea type="text" class="ckeditor form-control input-sm" name="Description" rows="50">{{$Description}}</textarea>
								<span class="help-block">{{$errorDescription}}</span>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<div id="errorSize" class="@if ($errorSizingDetail != '') has-error @endif">
								<label class="control-label input-sm marlm10">{{$alias['SizingDetail'][0]}} <span class="red">*</span></label>
								<textarea type="text" class="ckeditor form-control input-sm" name="SizingDetail" rows="50">{{$SizingDetail}}</textarea>
								<span class="help-block">{{$errorSizingDetail}}</span>
							</div>
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset class='fieldset'><legend class='legend' rel="stylesheet">Product Image</legend>
				<div class="col-md-12">
					<div class="form-group">
						<div class="fileinput fileinput-new @if ($errorImage1 != '') has-error @endif" data-provides="fileinput">
							<label class="control-label input-sm marlm10">{{$alias['Image1'][0]}} <span class="red">* <sup class="red">Best (Width 570 x Height 850)</sup></span></label>
							<div id="Image1">
								@if (($action == 'edit' || $action == 'detail') && $Image1 != '')
								<div class="contentimage">
									<img src='{{$Image1}}?{{uniqid()}}'/>
									<a id="deleteBankLogo" class="btn btn-sm red" onclick="deleteBankLogo();" value="Are you sure to remove {{$alias['Image1'][0]}} ?"><i class="fa fa-trash-o"></i></a>
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
									Select {{$alias['Image1'][0]}} </span>
									<span class="fileinput-exists">
									Change {{$alias['Image1'][0]}} </span>
									<input type="file" name="Image1">
								</span>
								<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
								Remove </a>
							</div>
							<span class="help-block">{{$errorImage1}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="fileinput fileinput-new @if ($errorImage2 != '') has-error @endif" data-provides="fileinput">
							<label class="control-label input-sm marlm10">{{$alias['Image2'][0]}} <span class="red">* <sup class="red">Best (Width 570 x Height 850)</sup></span></label>
							<div id="Image2">
								@if (($action == 'edit' || $action == 'detail') && $Image2 != '')
								<div class="contentimage">
									<img src='{{$Image2}}?{{uniqid()}}'/>
									<a id="deleteBankLogo" class="btn btn-sm red" onclick="deleteBankLogo();" value="Are you sure to remove {{$alias['Image2'][0]}} ?"><i class="fa fa-trash-o"></i></a>
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
									Select {{$alias['Image2'][0]}} </span>
									<span class="fileinput-exists">
									Change {{$alias['Image2'][0]}} </span>
									<input type="file" name="Image2">
								</span>
								<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
								Remove </a>
							</div>
							<span class="help-block">{{$errorImage2}}</span>
						</div>
						<div class="fileinput fileinput-new @if ($errorImage3 != '') has-error @endif" data-provides="fileinput">
							<label class="control-label input-sm marlm10">{{$alias['Image3'][0]}} <span class="red">* <sup class="red">Best (Width 570 x Height 850)</sup></span></label>
							<div id="Image3">
								@if (($action == 'edit' || $action == 'detail') && $Image3 != '')
								<div class="contentimage">
									<img src='{{$Image3}}?{{uniqid()}}'/>
									<a id="deleteBankLogo" class="btn btn-sm red" onclick="deleteBankLogo();" value="Are you sure to remove {{$alias['Image3'][0]}} ?"><i class="fa fa-trash-o"></i></a>
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
									Select {{$alias['Image3'][0]}} </span>
									<span class="fileinput-exists">
									Change {{$alias['Image3'][0]}} </span>
									<input type="file" name="Image3">
								</span>
								<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
								Remove </a>
							</div>
							<span class="help-block">{{$errorImage3}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="fileinput fileinput-new @if ($errorImage4 != '') has-error @endif" data-provides="fileinput">
							<label class="control-label input-sm marlm10">{{$alias['Image4'][0]}} <span class="red">* <sup class="red">Best (Width 570 x Height 850)</sup></span></label>
							<div id="Image4">
								@if (($action == 'edit' || $action == 'detail') && $Image4 != '')
								<div class="contentimage">
									<img src='{{$Image4}}?{{uniqid()}}'/>
									<a id="deleteBankLogo" class="btn btn-sm red" onclick="deleteBankLogo();" value="Are you sure to remove {{$alias['Image4'][0]}} ?"><i class="fa fa-trash-o"></i></a>
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
									Select {{$alias['Image4'][0]}} </span>
									<span class="fileinput-exists">
									Change {{$alias['Image4'][0]}} </span>
									<input type="file" name="Image4">
								</span>
								<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
								Remove </a>
							</div>
							<span class="help-block">{{$errorImage4}}</span>
						</div>
						<div class="fileinput fileinput-new @if ($errorImage5 != '') has-error @endif" data-provides="fileinput">
							<label class="control-label input-sm marlm10">{{$alias['Image5'][0]}} <span class="red">* <sup class="red">Best (Width 570 x Height 850)</sup></span></label>
							<div id="Image5">
								@if (($action == 'edit' || $action == 'detail') && $Image5 != '')
								<div class="contentimage">
									<img src='{{$Image5}}?{{uniqid()}}'/>
									<a id="deleteBankLogo" class="btn btn-sm red" onclick="deleteBankLogo();" value="Are you sure to remove {{$alias['Image5'][0]}} ?"><i class="fa fa-trash-o"></i></a>
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
									Select {{$alias['Image5'][0]}} </span>
									<span class="fileinput-exists">
									Change {{$alias['Image5'][0]}} </span>
									<input type="file" name="Image5">
								</span>
								<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
								Remove </a>
							</div>
							<span class="help-block">{{$errorImage5}}</span>
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset class='fieldset'><legend class='legend' rel="stylesheet">Product Style</legend>
				<div class="col-md-12">
					<div class="form-group">
						<div class="@if ($errorStyleList != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['StyleList'][0]}} <span class="red">*</span>
							</label>
							<div style="margin-left: -10px !important;">
								@foreach ($arrStyle as $value)
								<label class="hover input-sm" style="width:200px;">
									<input type="checkbox" name="StyleList[]" value="{{ $value['ID'] }}" @if($StyleList && in_array($value['ID'], $StyleList)) checked @endif >
									{{ $value['Name'] }}
								</label>
								@endforeach
							</div>
							<span class="help-block">{{$errorStyleList}}</span>
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
		checkstatussale('{{$StatusSale}}');
		checktypeproduct('{{$TypeProduct}}');

		var category = $('[name="CategoryID"]').val();
		if(category == '') {
			$('#mandatoriSub').text('*');
		}

		$('[name="SellerID"]').change(function() {
		    var SellerID = $(this).val();
		    $.ajax({
				url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
				type		: 'POST',
				data		: {'ajaxpost':"getBrand",'SellerID': SellerID},
				success		: function(data) {
					var tampung = JSON.parse(data);
					if(tampung['response'] == 'OK') {
						$('[name="BrandID"]').empty();
						$('[name="BrandID"]')
							.append($("<option></option>")
    						.attr("selected",'')
					        .val('')
					        .text('Please Select {{$alias['BrandName'][0]}}'));
						$.each(tampung['data'], function(key, value) {
							$('[name="BrandID"]')
								.append($("<option></option>")
								.attr("value",value['ID'])
								.val(value['ID'])
								.text(value['Name']));
						});      
						$('[name="BrandID"]').select2("val", null);
	            	}
				}
			});
		});

		$('[name="ModelType"]').change(function() {
		    var ModelType = $(this).val();
		    $.ajax({
				url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
				type		: 'POST',
				data		: {'ajaxpost':"getCategory",'ModelType': ModelType},
				success		: function(data) {
					var tampung = JSON.parse(data);
					if(tampung['response'] == 'OK') {
						$('[name="CategoryID"]').empty();
						$('[name="CategoryID"]')
						.append($("<option></option>")
						.attr("selected",'')
				        .val('')
				        .text('Please Select Category'));
						$.each(tampung['data'], function(key, value) {
							$('[name="CategoryID"]')
							.append($("<option></option>")
							.attr("value",value['ID'])
							.val(value['ID'])
							.text(value['Name']));
						});
						$('[name="CategoryID"]').select2("val", null);
	            	}
				}
			});
		});

		$('[name="CategoryID"]').change(function() {
		    var Category = $(this).val();
		    if(Category != '') {
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
						        .text('Please Select {{$alias['SubCategoryName'][0]}}'));
					        $('[name="SubCategoryID"]').select2("val", null);

							if(jumlah > 0) {
								$.each(tampung['data'], function(key, value) {
									$('[name="SubCategoryID"]')
										.append($("<option></option>")
										.attr("value",value['ID'])
										.val(value['ID'])
										.text(value['Name']));
								});
								$('#mandatoriSub').addClass('red').text('*');
							} else {
								$('#mandatoriSub').empty();
								$('#helpSub').empty();	
								$('#errorSub').removeAttr('class');
								$('[name="SubCategoryID"]').select2("val", null);
								$('#helpSize').empty();	
								$('#errorSize').removeAttr('class');
							}
		            	}
					}
				});
			} else {
		    	$('[name="SubCategoryID"]').empty();
				$('#mandatoriSub').text('*');
		    }
		});
	});

	function checkstatussale(val) {
		if(val == 1) {
			$('[name="SalePrice"]').parent().find('span.red').html('*');
		} else {
			$('[name="SalePrice"]').parent().find('span.red').html('');
		}
	}

	function checktypeproduct(val) {
		if(val == 1) {
			$('[name="GroupSizeID"],[name="ColorID"]').parent().find('span.red').html('');
			$('[name="GroupSizeID"],[name="ColorID"]').attr('disabled', true);
		} else {
			$('[name="GroupSizeID"],[name="ColorID"]').parent().find('span.red').html('*');
			$('[name="GroupSizeID"],[name="ColorID"]').attr('disabled', false);
		}
	}
</script>	