<style type="text/css">
	.borderred {
		border: 1px solid red !important;
	}
</style>
<section class="akun_profile shopping_bag">
	<div class="wrapper">
		<h1>MY RETURNS</h1>
		<div class="boxInfoReturn after_clear">
			<div class="boxInfoReturnInner">
				<div class="text">Berlaku 7 hari setelah barang diterima</div>
			</div>
			<div class="boxInfoReturnInner">
				<div class="text">Tempel destinasi dibagian luar paket</div>
			</div>
			<div class="boxInfoReturnInner">
				<div class="text">Kondisi produk asli dengan tag label tertera</div>
			</div>
			<div class="boxInfoReturnInner">
				<div class="text">Gunakan kemasan original Lacigue</div>
			</div>
		</div>
		<div class="boxAirWay">
			<div class="title">Rincian Retur</div>
			@foreach($ListReturn as $key1 => $val1)
			<form method="post">
				<div class="desc">RETUR {{$val1['ReturCode']}}</div>
				{{csrf_field()}}
				<input type="text" name="ReturCode" value="{{$val1['ReturCode']}}" style="display: none;">
				<div class="desc2">Total barang dalam pesanan : {{count($val1['ListProduct'])}}</div>
				@foreach($val1['ListProduct'] as $key2 => $val2)
				<div class="boxDetailImg after_clear">
					<div class="boxImgDesc after_clear">
						<div class="boxImg">
							<img src="{{$basesite}}assets/frontend/images/content/product/medium_{{$val2['Image1']}}">
						</div>
						<div class="desc">
							<div class="name_prod">{{strtoupper($val2['BrandName'])}}</div>
							<div class="desc_prod">{{strtoupper($val2['Name'])}}</div>
							<div class="det_prod">Qty : {{$val2['Qty']}}</div>
							<div class="det_prod">Size : {{$val2['SizeName']}}</div>
						</div>
					</div>
					<div class="boxDescription" style="width: 373px;">
						<div class="boxForm" style="margin-left: 0px;width: 100%;">
							@if(!$val2['FeedbackDate'])
							<div style="text-align: left; font-size: 14px; color:red;">Silahkan melakukan penerimaan barang terlebih dahulu.</div>
							@endif
							@if($val2['TotalReturnQty']==$val2['Qty'])
							<div style="text-align: left; font-size: 14px; color:red;">Barang ini telah di retur semua.</div>
							@endif
							@if($val2['TotalReturnQty'] && ($val2['TotalReturnQty']!=$val2['Qty']))
							<div style="text-align: left; font-size: 14px; color:red;">{{$val2['TotalReturnQty']}} Barang ini telah di retur.</div>
							@endif
							<div class="form-group" style="text-align: left; margin-bottom: 5px;">
								<input id="retur{{$val2['ID']}}" class="checkbox-custom" name="retur[]" value="{{$val2['ID']}}" type="checkbox" @if(!$val2['FeedbackDate'] || ($val2['TotalReturnQty']==$val2['Qty'])) disabled @endif @if(count($retur) && in_array($val2['ID'], $retur)) checked @endif >
					            <label for="retur{{$val2['ID']}}" class="checkbox-custom-label">
					            	<span class="img"></span>
					            	<div style="font-size: 22px;margin-top: 10px; @if(!$val2['FeedbackDate'] || ($val2['TotalReturnQty']==$val2['Qty'])) color:#c1c1c1; @endif">Retur</div>
					        	</label>
						    </div>
							<div class="desc" @if(!$val2['FeedbackDate'] || ($val2['TotalReturnQty']==$val2['Qty'])) style="color:#c1c1c1;" @endif>Alasan Pengembalian</div>
							<div class="form-group">
								<div class="control-input">
								<select name="reason[{{$val2['ID']}}]" @if(!$val2['FeedbackDate'] || ($val2['TotalReturnQty']==$val2['Qty'])) disabled style="color:#c1c1c1; border: 1px solid #c1c1c1;" @endif @if(isset($errorreason[$val2['ID']])) class="{{$errorreason[$val2['ID']]}}" @endif>
									<option value="0">Pilih Alasan Pengembalian</option>
									<option value="1" @if(isset($reason[$val2['ID']]) && $reason[$val2['ID']] == 1) selected @endif>Kebesaran / Kekecilan</option>
									<option value="2" @if(isset($reason[$val2['ID']]) && $reason[$val2['ID']] == 2) selected @endif>Cacat</option>
									<option value="3" @if(isset($reason[$val2['ID']]) && $reason[$val2['ID']] == 3) selected @endif>Rusak Saat Pengiriman</option>
								</select>
								</div>
							</div>					
							<div class="desc" @if(!$val2['FeedbackDate'] || ($val2['TotalReturnQty']==$val2['Qty'])) style="color:#c1c1c1;" @endif>Solusi Pengembalian</div>
							<div class="form-group">
								<div class="control-input">
								<select name="solution[{{$val2['ID']}}]" @if(!$val2['FeedbackDate'] || ($val2['TotalReturnQty']==$val2['Qty'])) disabled style="color:#c1c1c1; border: 1px solid #c1c1c1;" @endif @if(isset($errorsolution[$val2['ID']])) class="{{$errorsolution[$val2['ID']]}}" @endif>
									<option value="0">Pilih Solusi Pengembalian</option>
									<option value="1" @if(isset($solution[$val2['ID']]) && $solution[$val2['ID']] == 1) selected @endif>Tukar Produk Baru</option>
									<option value="2" @if(isset($solution[$val2['ID']]) && $solution[$val2['ID']] == 2) selected @endif>Tukar Produk Lain</option>
									<option value="3" @if(isset($solution[$val2['ID']]) && $solution[$val2['ID']] == 3) selected @endif>Pengembalian Dana</option>
								</select>
								</div>
							</div>
							<div class="form-group" style="margin:0;">
								<div class="desc" @if(!$val2['FeedbackDate'] || ($val2['TotalReturnQty']==$val2['Qty'])) style="color:#c1c1c1;" @endif>Jumlah Pengembalian <select name="qty[{{$val2['ID']}}]" @if(!$val2['FeedbackDate'] || ($val2['TotalReturnQty']==$val2['Qty'])) disabled style="color:#c1c1c1; border: 1px solid #c1c1c1; float:right;" @else style="float:right;" @endif @if(isset($errorqty[$val2['ID']])) class="{{$errorqty[$val2['ID']]}}" @endif>
									@if(($val2['TotalReturnQty']==$val2['Qty']))
									<option value="{{$val2['Qty']}}">{{$val2['Qty']}}</option>
									@else
									@php for($i=1; $i<=($val2['Qty']-$val2['TotalReturnQty']); $i++) { @endphp
									<option value="{{$i}}" @if(isset($qty[$val2['ID']]) && $qty[$val2['ID']] == $i) selected @endif>{{$i}}</option>
									@php } @endphp
									@endif
								</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				@endforeach
				
		    	<div class="boxForm" style="width: 1200px;">
		    		<div class="boxFormInline register after_clear" style="margin-top: 0px; float: left; width: 580px;">
					    <div class="form-group">
							<div class="control-label">Nama Pengirim <span class="colorred">*</span></div>
							<div class="control-input">
								<input type="text" class="form-control @if(isset($errorSenderName)) {{$errorSenderName}} @endif" name="SenderName" placeholder="Nama Pengirim" value="{{$SenderName}}" style="height: 38px; text-align: left;">
							</div>
					    </div>
					    <div class="form-group">
							<div class="control-label">Telepon Pengirim <span class="colorred">*</span></div>
							<div class="control-input">
								<input type="text" class="form-control numberonly @if(isset($errorSenderPhone)) {{$errorSenderPhone}} @endif" name="SenderPhone" placeholder="Telepon Pengirim" value="{{$SenderPhone}}" style="height: 38px; text-align: left;">
							</div>
					    </div>
					    <div class="form-group">
							<div class="control-label">Alamat <span class="colorred">*</span></div>
							<div class="control-input">
								<textarea type="text" class="form-control @if(isset($errorSenderAddress)) {{$errorSenderAddress}} @endif" name="SenderAddress" placeholder="Alamat Pengirim">{{$SenderAddress}}</textarea>
							</div>
					    </div>
					    <div class="form-group">
							<div class="control-label">Propinsi <span class="colorred">*</span></div>
							<div class="control-input">
								<select name="ProvinceID" onchange="GetCity(this.value)" style="width:100%;" class="@if(isset($errorProvinceID)) {{$errorProvinceID}} @endif">
									<option value="">Pilih Propinsi</option>
									@foreach($arrprovince as $obj)
									<option value="{{$obj['ID']}}" @if($ProvinceID == $obj['ID']) selected @endif >{{$obj['Name']}}</option>
									@endforeach
								</select>
							</div>
					    </div>
				    </div>
		    		<div class="boxFormInline register after_clear" style="margin-top: 0px; float: right; width: 580px;">
					    <div class="form-group">
							<div class="control-label">Kota / Kabupaten <span class="colorred">*</span></div>
							<div class="control-input">
								<select name="CityID" onchange="GetDistrict(this.value)" style="width:100%;" class="@if(isset($errorCityID)) {{$errorCityID}} @endif">
									<option value="">Pilih Kota / Kabupaten</option>
									@foreach($arrcity as $obj)
									<option value="{{$obj['ID']}}" @if($CityID == $obj['ID']) selected @endif >{{$obj['Name']}}</option>
									@endforeach
								</select>
							</div>
					    </div>
					    <div class="form-group">
							<div class="control-label">Desa / Kelurahan <span class="colorred">*</span></div>
							<div class="control-input">
								<select name="DistrictID" style="width:100%; text-align: left;" class="@if(isset($errorDistrictID)) {{$errorDistrictID}} @endif">
									<option value="">Pilih Desa / Kelurahan</option>
									@foreach($arrdistrict as $obj)
									<option value="{{$obj['ID']}}" @if($DistrictID == $obj['ID']) selected @endif >{{$obj['Name']}}</option>
									@endforeach
								</select>
							</div>
					    </div>
					    <div class="form-group">
							<div class="control-label">Kode Pos <span class="colorred">*</span></div>
							<div class="control-input">
								<input type="text" class="form-control numberonly @if(isset($errorPostalCode)) {{$errorPostalCode}} @endif" maxlength="5" name="PostalCode" placeholder="Kode Pos" value="{{$PostalCode}}" style="height: 38px; text-align: left;">
							</div>
					    </div>
					    <div class="form-group">
							<div class="control-label">Nomor Paket Pengiriman</div>
							<div class="control-input">
								<input type="text" class="form-control" name="AWBNumber" placeholder="Nomor Paket Pengiriman" value="{{$SenderPhone}}" style="height: 38px; text-align: left;">
							</div>
					    </div>
				    </div>
				    <div style="clear: both;"></div>
		    	</div>
		    	<div class="boxForm" style="width: 1200px;">
		    		<div class="form-group">
						<input id="AcceptTerm" class="checkbox-custom" name="AcceptTerm" type="checkbox" @if($AcceptTerm) checked @endif >
						<label for="AcceptTerm" class="checkbox-custom-label">
							<span></span>
							<div class="c_label" style="top:0px;margin-left:0px;">
								Saya setuju dengan syarat dan ketentuan<br/>
								pengembalian barang di <a href="{{$basesite}}term-condition#pengembalian" target="_blank">LACIGUE</a>
							</div>
						</label>
				    </div>
		    	</div>
		    	<div class="boxButton">
		    		<a href="{{$basesite}}return" class="btn">LIST MY RETURNS</a>
		    		<button type="submit" name="submit" class="btn black">LANJUTKAN</button>
		    	</div>
	    	</form>
			@endforeach
		</div>
	</div>
</section>
<script type="text/javascript">

	function GetCity(obj, CityID = '') {
		$.ajax({
	        url         : '{{$basesite}}product-detail/ajaxpost',
	        type        : 'POST',
	        data        : {'ajaxpost':"GetCity",'_token':'{{csrf_token()}}','ProvinceID':obj},
	        success     : function(data) {
	            var data = JSON.parse(data);
	            
	            if(data['response']) {
	    			var city = '<option value="">Pilih Kota / Kabupaten</option>';
	    			var district = '<option value="">Pilih Desa / Kelurahan</option>';
	            	$.each(data['response'], function(key, val) {
	            		if(CityID == val['ID'])
	            			city = city + '<option value="'+val['ID']+'" selected >'+val['Name']+'</option>';
	            		else
	            			city = city + '<option value="'+val['ID']+'">'+val['Alias'].replace('Kabupaten', 'Kab.')+' '+val['Name']+'</option>';
	            	});
	            	$('[name="CityID"]').html(city);
	            	$('[name="DistrictID"]').html(district);
	            }
	        }
	    });
	}

	function GetDistrict(obj, DistrictID = '') {
		$.ajax({
	        url         : '{{$basesite}}product-detail/ajaxpost',
	        type        : 'POST',
	        data        : {'ajaxpost':"GetDistrict",'_token':'{{csrf_token()}}','CityID':obj},
	        success     : function(data) {
	            var data = JSON.parse(data);
	            
	            if(data['response']) {
	    			var city = '<option value="">Pilih Desa / Kelurahan</option>';
	            	$.each(data['response'], function(key, val) {
	            		if(DistrictID == val['ID'])
	            			city = city + '<option value="'+val['ID']+'" selected >'+val['Name']+'</option>';
	            		else
	            			city = city + '<option value="'+val['ID']+'">'+val['Name']+'</option>';
	            	});
	            	$('[name="DistrictID"]').html(city);
	            }
	        }
	    });
	}

	$(document).ready(function() {
		@if($Message) _alertvalidation('{{$Message}}'); @endif
	});
</script>