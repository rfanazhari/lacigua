<style type="text/css">
	.width150 {
		width:250px;
	}
</style>
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
						<div>
							<label class="control-label input-sm marlm10 width150">Your Seller Code</label>
							<span>:</span>
							<b class="red">{{$SellerUniqueID}}</b>
						</div>
						<div>
							<label class="control-label input-sm marlm10 width150">Your Brand</label>
							<span>:</span>
							<a class="btn btn-sm default" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/downloadbrand">Download Brand</a>
						</div>
						<div>
							<label class="control-label input-sm marlm10 width150">Main Menu, Category & Sub Category</label>
							<span>:</span>
							<a class="btn btn-sm default red-stripe" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/downloadmainmenucategorysubcategory">Download Main Menu, Category & Sub Category</a>
						</div>
						<div>
							<label class="control-label input-sm marlm10 width150">Color</label>
							<span>:</span>
							<a class="btn btn-sm default yellow-stripe" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/downloadcolor">Download Color</a>
						</div>
						<div>
							<label class="control-label input-sm marlm10 width150">Group Size</label>
							<span>:</span>
							<a class="btn btn-sm default green-stripe" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/downloadgroupsize">Download Group Size</a>
						</div>
						<div>
							<label class="control-label input-sm marlm10 width150">Style</label>
							<span>:</span>
							<a class="btn btn-sm default blue-stripe" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/downloadstyle">Download Style</a>
						</div>
					</div>
				</div>
			</fieldset>

			<fieldset class='fieldset'><legend class='legend' rel="stylesheet">Tutorial</legend>
				<div class="col-md-12">
					<div class="portlet-body">
						<div class="tabbable">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab_uploadbulkproduct" data-toggle="tab">Upload B. Product</a></li>
								<li><a href="#tab_updatebulkimage" data-toggle="tab">Upload B. Image</a></li>
								<li><a href="#tab_updatebulkproductsizevariant" data-toggle="tab">Update B. Size Variant</a></li>
								<li><a href="#tab_updatebulkproductreguler" data-toggle="tab">Update B. Product Reguler</a></li>
								<li><a href="#tab_updatebulkproductsale" data-toggle="tab">Update B. Product Sale</a></li>
							</ul>
							<div class="tab-content no-space">
								<div class="tab-pane active" id="tab_uploadbulkproduct">
									<div class="col-md-12">
										<div class="form-group">
											<div>
												<label class="control-label input-sm marlm10">1. Download Template Upload Bulk Product</label><span>:</span>
												<div class="red" style="margin-left: -9px;">
													<ul style="float:left;">
														<li>	
															<a class="btn btn-sm default" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/downloadtemplateuploadbulkproductregulerfashion" style="background: #D84A38 !important; color: white;">Download Template Upload Bulk Product Reguler Fashion</a>
														</li>
														<li>
														<a class="btn btn-sm default" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/downloadtemplateuploadbulkproductregulerbeauty" style="background: #FFB848 !important; color: white;">Download Template Upload Bulk Product Reguler Beauty</a>
														</li>
													</ul>
													<ul style="float:left;">
														<li>
															<a class="btn btn-sm default" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/downloadtemplateuploadbulkproductsalefashion" style="background: #35AA47 !important; color: white;">Download Template Upload Bulk Product Sale Fashion</a>
														</li>
														<li>
															<a class="btn btn-sm default" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/downloadtemplateuploadbulkproductsalebeauty" style="background: #8E44AD !important; color: white;">Download Template Upload Bulk Product Sale Beauty</a>
														</li>
													</ul>
													<div style="clear:both;"></div>
												</div>
											</div>
											<div>
												<label class="control-label input-sm marlm10">2. Download All Template In The Top <span class="red">*</span></label>
												<div class="red" style="margin-left: -9px;">
													<ul style="float:left;">
														<li><b>Your Brand</b></li>
														<li><b>Main Menu, Category & Sub Category</b></li>
													</ul>
													<ul style="float:left;">
														<li><b>Color</b></li>
														<li><b>Group Size</b></li>
													</ul>
													<ul style="float:left;">
														<li><b>Style</b></li>
													</ul>
													<div style="clear:both;"></div>
												</div>
											</div>
											<div>
												<label class="control-label input-sm marlm10">3. Input Type <span class="red">*</span></label>
												<div class="red" style="margin-left: -9px;">
													<ul style="float:left;">
														<li><b>1 for Product Reguler Fashion</b></li>
														<li><b>2 for Product Reguler Beauty</b></li>
													</ul>
													<ul style="float:left;">
														<li><b>3 for Product Sale Fashion</b></li>
														<li><b>4 for Product Sale Beauty</b></li>
													</ul>
													<div style="clear:both;"></div>
												</div>
												<div>
													<img src="{{$basesite}}/assets/backend/images/tutorial/type.jpg" width="800px">
												</div>
											</div><br/>
											<div>
												<label class="control-label input-sm marlm10">4. Input Your Seller Code <span class="red">*</span></label>
												<div class="red" style="margin-left: -9px;">
													<ul style="float:left;">
														<li><b>Your Code : {{$SellerUniqueID}}</b></li>
													</ul>
													<div style="clear:both;"></div>
												</div>
												<div>
													<img src="{{$basesite}}/assets/backend/images/tutorial/sellercode.jpg" width="800px">
												</div>
											</div><br/>
											<div>
												<label class="control-label input-sm marlm10">5. Input Your Brand ID <span class="red">*</span></label>
												<div class="red" style="margin-left: -9px;">
													<ul style="float:left;">
														<li><b>See Data ID in file Your_Brand.xls</b></li>
													</ul>
													<div style="clear:both;"></div>
												</div>
												<div>
													<img src="{{$basesite}}/assets/backend/images/tutorial/brandid.jpg" width="800px">
												</div>
											</div><br/>
											<div>
												<label class="control-label input-sm marlm10">6. Input Main Menu, Category & Sub Category <span class="red">*</span></label>
												<div class="red" style="margin-left: -9px;">
													<ul style="float:left;">
														<li><b>See Data ID in file Main_Menu_Category_Sub_Category.xls</b></li>
													</ul>
													<div style="clear:both;"></div>
												</div>
												<div>
													<img src="{{$basesite}}/assets/backend/images/tutorial/mscid.jpg" width="800px">
												</div>
											</div><br/>
											<div>
												<label class="control-label input-sm marlm10">7. Input Group Size ID <span class="red">*</span></label>
												<div class="red" style="margin-left: -9px;">
													<ul style="float:left;">
														<li><b>See Data ID in file Our_Group_Size.xls</b></li>
													</ul>
													<div style="clear:both;"></div>
												</div>
												<div>
													<img src="{{$basesite}}/assets/backend/images/tutorial/groupsizeid.jpg" width="800px">
												</div>
											</div><br/>
											<div>
												<label class="control-label input-sm marlm10">8. Input Color ID <span class="red">*</span></label>
												<div class="red" style="margin-left: -9px;">
													<ul style="float:left;">
														<li><b>See Data ID in file Our_Color.xls</b></li>
													</ul>
													<div style="clear:both;"></div>
												</div>
												<div>
													<img src="{{$basesite}}/assets/backend/images/tutorial/colorid.jpg" width="800px">
												</div>
											</div><br/>
											<div>
												<label class="control-label input-sm marlm10">9. Input Your SKU <span class="red">*</span></label>
												<div class="red" style="margin-left: -9px;">
													<ul style="float:left;">
														<li><b>Your SKU for unique Product</b></li>
													</ul>
													<div style="clear:both;"></div>
												</div>
												<div>
													<img src="{{$basesite}}/assets/backend/images/tutorial/skuseller.jpg" width="800px">
												</div>
											</div><br/>
											<div>
												<label class="control-label input-sm marlm10">10. Input Your Detail Product 1</label>
												<div class="red" style="margin-left: -9px;">
													<ul style="float:left;">
														<li><b>Name for Your Unique Product Name (Example: Lacigue T-Shirt Blue)</b></li>
														<li><b>Name Show for Your General Product Name (Example: Lacigue T-Shirt)</b></li>
														<li><b>Weight for Weight Product <sup>KG</sup> (Example: 0.01)</b></li>
														<li><b>Selling Price for Your Product Price <sup>NUMBER</sup> (Example: 500000)</b></li>
														<li><b>Sale Price for Your Sale Product Price <sup>NUMBER</sup> (Example: 300000)</b></li>
														<li><b>Product Gender : 0 for All, 1 for Male, 2 for Female, 3 for Kids</b></li>
														<li><b>Measurement, Composition Material, Care Label is Free Text</b></li>
													</ul>
													<div style="clear:both;"></div>
												</div>
												<div>
													<img src="{{$basesite}}/assets/backend/images/tutorial/detailproduct1.jpg" width="800px">
												</div>
											</div><br/>
											<div>
												<label class="control-label input-sm marlm10">11. Input Your Detail Product 2</label>
												<div class="red" style="margin-left: -9px;">
													<ul style="float:left;">
														<li><b>Status New : 0 for Old Product, 1 for New Product</b></li>
														<li><b>Description, Sizing Detail is Free Text and Available HTML Code</b></li>
														<li><b>Style for Your Product Style ( <small>See Data ID in file Our_Style.xls. If You Want to add Multiple Style, You can separate them with Coma (,)</small> )</b></li>
														<li><b>Product Link for Your Product Linked to any Product ( <small>If you want link to any product, you can use Your SKU or set empty for not link</small> )</b></li>
													</ul>
													<div style="clear:both;"></div>
												</div>
												<div>
													<img src="{{$basesite}}/assets/backend/images/tutorial/detailproduct2.jpg" width="800px">
												</div>
											</div><br/>
											<div>
												<label class="control-label input-sm marlm10">12. Upload Bulk Product</label>
												<div class="red" style="margin-left: -9px;">
													<ul style="float:left;">
														<li><b>Click Menu Add a Product</b></li>
														<li><b>Click Button Upload Bulk Product</b></li>
														<li><b>Select Upload Bulk Product</b></li>
														<li><b>Save</b></li>
													</ul>
													<div style="clear:both;"></div>
												</div>
												<div>
													<img src="{{$basesite}}/assets/backend/images/tutorial/uploadbulkproduct.jpg" width="800px">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="tab_updatebulkimage">
									<div class="col-md-12">
										<div class="form-group">
											<div>
												<label class="control-label input-sm marlm10">1. Download Template Upload Bulk Image</label><span>:</span>
												<div class="red" style="margin-left: -9px;">
													<ul style="float:left;">
														<li>	
															<a class="btn btn-sm default" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/downloadtemplateuploadbulkimage" style="background: #D84A38 !important; color: white;">Download Template Upload Bulk Image</a>
														</li>
													</ul>
													<div style="clear:both;"></div>
												</div>
											</div>
											<div>
												<label class="control-label input-sm marlm10">1. Input Your SKU Seller <span class="red">*</span></label>
												<div class="red" style="margin-left: -9px;">
													<ul style="float:left;">
														<li><b>Your SKU Product</b></li>
													</ul>
													<div style="clear:both;"></div>
												</div>
												<div>
													<img src="{{$basesite}}/assets/backend/images/tutorial/skusellerimage.jpg" width="800px">
												</div>
											</div><br/>
											<div>
												<label class="control-label input-sm marlm10">2. Input Your Link Image 1 (Primary Image) <span class="red">*</span></label>
												<div>
													<img src="{{$basesite}}/assets/backend/images/tutorial/1image.jpg" width="800px">
												</div>
											</div><br/>
											<div>
												<label class="control-label input-sm marlm10">3. Input Your Link Image 2 (Secondary Image) <span class="red">*</span></label>
												<div>
													<img src="{{$basesite}}/assets/backend/images/tutorial/2image.jpg" width="800px">
												</div>
											</div><br/>
											<div>
												<label class="control-label input-sm marlm10">4. Input Your Link Image 3, Image 4 and Image 5</label>
												<div>
													<img src="{{$basesite}}/assets/backend/images/tutorial/345image.jpg" width="800px">
												</div>
											</div><br/>
											<div>
												<label class="control-label input-sm marlm10">5. Upload Bulk Image</label>
												<div class="red" style="margin-left: -9px;">
													<ul style="float:left;">
														<li><b>Click Menu Add a Product</b></li>
														<li><b>Click Button Upload Bulk Image</b></li>
														<li><b>Select Upload Bulk Image</b></li>
														<li><b>Save</b></li>
													</ul>
													<div style="clear:both;"></div>
												</div>
												<div>
													<img src="{{$basesite}}/assets/backend/images/tutorial/uploadbulkimage.jpg" width="800px">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="tab_updatebulkproductsizevariant">
									<div class="col-md-12">
										<div class="form-group">
											<div>
												<div class="red" style="margin-left: -9px;">
													<ul style="float:left;">
														<li><b>Click Menu Add a Product Size Variant</b></li>
														<li><b>Click Button Download Bulk Size Variant</b></li>
														<li><b>Edit Your Qty in file Bulk_Size_Variant.xls</b></li>
														<li><b>Click Button Upload Bulk Size Variant</b></li>
														<li><b>Select Upload Bulk Size Variant</b></li>
														<li><b>Save</b></li>
													</ul>
													<div style="clear:both;"></div>
												</div>
												<div>
													<img src="{{$basesite}}/assets/backend/images/tutorial/bulksizevariant.jpg" width="800px">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="tab_updatebulkproductreguler">
									<div class="col-md-12">
										<div class="form-group">
											<div>
												<div class="red" style="margin-left: -9px;">
													<ul style="float:left;">
														<li><b>Click Menu Manage Product Reguler</b></li>
														<li><b>Click Button Download Bulk Product Reguler Beauty or Button Download Bulk Product Reguler Fashion</b></li>
														<li><b>Edit Your Product Reguler Beauty in file Bulk_Product_Reguler_Beauty.xls or Your Product Reguler Fashion in file Bulk_Product_Reguler_Non_Beauty.xls</b></li>
														<li><b>Click Button Upload Bulk Product</b></li>
														<li><b>Select Upload Bulk Product</b></li>
														<li><b>Save</b></li>
													</ul>
													<div style="clear:both;"></div>
												</div>
												<div>
													<img src="{{$basesite}}/assets/backend/images/tutorial/updateproductreguler.jpg" width="800px">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="tab_updatebulkproductsale">
									<div class="col-md-12">
										<div class="form-group">
											<div>
												<div class="red" style="margin-left: -9px;">
													<ul style="float:left;">
														<li><b>Click Menu Manage Product Sale</b></li>
														<li><b>Click Button Download Bulk Product Sale Beauty or Button Download Bulk Product Sale Fashion</b></li>
														<li><b>Edit Your Product Sale Beauty in file Bulk_Product_Sale_Beauty.xls or Your Product Sale Fashion in file Bulk_Product_Sale_Non_Beauty.xls</b></li>
														<li><b>Click Button Upload Bulk Product</b></li>
														<li><b>Select Upload Bulk Product</b></li>
														<li><b>Save</b></li>
													</ul>
													<div style="clear:both;"></div>
												</div>
												<div>
													<img src="{{$basesite}}/assets/backend/images/tutorial/updateproductsale.jpg" width="800px">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
</form>