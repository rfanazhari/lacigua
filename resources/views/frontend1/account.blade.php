<style>
	.ui-widget.ui-widget-content{
		border: none;
	}
	.ui-tabs .ui-tabs-panel{
		border: 1px solid lightgrey;
		margin-left: 3px;
		min-height: 520px;
		padding:0px;
	}
	.ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited{
		color:black;
		border:none;
		border-top: 1px solid lightgrey;
		border-left: 1px solid lightgrey;
		border-right: 1px solid lightgrey;
	}
	section.akun_profile p {
		margin-bottom: 20px;
	}
	section.akun_profile .boxAccount .boxAccounWidget .boxKotakAccount .boxAlamat {
		width: 100%;
	}
	section.akun_profile .boxAccount .boxAccounWidget .boxKotakAccount .boxAlamat .text p {
		width:250px;
		float:left;
	}
	section.akun_profile .boxAccount .boxAccounWidget .boxKotakAccount .boxAlamat .text p + p {
		padding-left: 70px;
	}
	.SetFirstAddress {
		font-size: 11px;
		margin: 0;
		color: red;
		font-weight: normal;
	}
	.SetFirstAddress:hover {
		text-decoration: none;
	}
	.newlink {
		font-size: 21px;
	    font-family: "robotoboldcondensed";
	    text-transform: uppercase;
	    display: inline-block;
	    margin: 0 4px 0 0;
	    list-style: none;
	    cursor: pointer;
	    color: #898989;
	    text-decoration: none;
	}
	.newlink:hover {
		font-size: 21px;
	    font-family: "robotoboldcondensed";
	    text-transform: uppercase;
	    display: inline-block;
	    margin: 0 4px 0 0;
	    list-style: none;
	    cursor: pointer;
	    color: #898989;
	    text-decoration: none;
	}
</style>
<section class="akun_profile akun_saya">
	<div class="wrapper">
		<h1>MY PROFILE</h1>
		<p style="text-align: center;">TERAKHIR LOGIN : {{strtoupper($LastLogin)}}</p>
		<section class="spottab" style="padding-bottom: 40px;">
			<div class="wrapper">
				<div class="tab_akun" id="parentHorizontalTab">
					<ul class="resp-tabs-list hor_1">
						<li><a href="{{$basesite}}account" class="newlink">ACCOUNT</a></li>
						<li><a href="{{$basesite}}order" class="newlink">ORDER</a></li>
						<li><a href="{{$basesite}}wishlist" class="newlink">WISHLIST</a></li>
						<li><a href="{{$basesite}}wallet" class="newlink">WALLET</a></li>
						<li><a href="{{$basesite}}message" class="newlink">MESSAGE</a></li>
						<li><a href="{{$basesite}}favlabel" class="newlink">FAV LABEL</a></li>
					</ul>
					<div class="resp-tabs-container hor_1">
						<div>
							<div class="boxAccount">
								<div class="boxAccounWidget">
									<div class="title">INFORMASI KONTAK</div>
									<div class="boxKotakAccount">
										<div class="ava">
											<img src="{{$basesite}}assets/frontend/images/material/ava.png">
										</div>
										<table>
											<tr>
												<td style="width: 150px;">Nama</td>
												<td id="datafullname">{{$CustomerData->FullName}}</td>
												<td id="editfullname" style="display:none;"><input type="text" name="FirstName" value="{{$CustomerData->FirstName}}"/> <input type="text" name="LastName" value="{{$CustomerData->LastName}}"/></td>
											</tr>
											<tr>
												<td>Email</td>
												<td id="dataemail">{{$CustomerData->Email}}</td>
												<td id="editemail" style="display:none;"><input type="email" name="Email" value="{{$CustomerData->Email}}"/></td>
											</tr>
											<tr>
												<td>Password</td>
												<td><span class="pwd">*******</span> <span class="link"><a href="javascript:;" id="updatepassword">Ganti Password</a></span></td>
											</tr>
											<tr>
												<td>Tanggal Lahir</td>
												<td id="datadob">{{date('Y/m/d', strtotime($CustomerData->DOB))}}</td>
												<td id="editdob" style="display:none;"><input type="text" name="DOB" value="{{date('Y/m/d', strtotime($CustomerData->DOB))}}"/></td>
											</tr>
											<tr>
												<td>No. Telp</td>
												<td id="datamobile">{{$CustomerData->Mobile}}</td>
												<td id="editmobile" style="display:none;"><input type="text" name="Mobile" value="{{$CustomerData->Mobile}}"/></td>
											</tr>
										</table>
										<div class="boxEdit">
											<a href="javascript:;" id="editcontact" class="btn white">UBAH</a>
											<a href="javascript:;" id="donecontact" class="btn white" style="display:none;">SELESAI</a>
										</div>
									</div>
								</div>				
							</div>
							<div class="boxAccount">
								<div class="boxAccounWidget" id="BoxAddress">
									<div class="title">ALAMAT PENGIRIMAN</div>
									@foreach($CustomerAddress as $obj)
									<div id="Address{{$obj->ID}}" class="boxKotakAccount after_clear">
										<div class="boxAlamat">
											<div class="text">
												<b><span id="TextAddressInfo">{{$obj->AddressInfo}}</span> <span id="NotFirstAddress1">
													@if($obj->IsActive != 1)
													<a href="javarscript:;" onclick="SetFirstAddress('{{$obj->ID}}')" class="SetFirstAddress">Jadikan Alamat Pengiriman Utama</a>
													@endif
												</span></b><br/>
												<p>
													<span id="TextAddress">{!!nl2br($obj->Address)!!}</span><br/>
													<span id="TextDistrictName">{{$obj->DistrictName}}</span>, <span id="TextCityName">{{$obj->CityName}}</span> <span id="TextPostalCode">{{$obj->PostalCode}}</span>
												</p>
												<p>
													Penerima : <span id="TextRecepientName">{{$obj->RecepientName}}</span><br/>
													Telepon : <span id="TextRecepientPhone">{{$obj->RecepientPhone}}</span>
												</p>
												<span id="NotFirstAddress2" class="title">
												@if($obj->IsActive == 1)
												UTAMA
												@endif
												</span>
											</div>
										</div>
										<div class="boxEdit">
											<a href="javarscript:;" onclick="EditAddress('{{$obj->ID}}')" class="btn white">UBAH</a>
											<a href="javarscript:;" onclick="DeleteAddress('{{$obj->ID}}')" class="btn white">HAPUS</a>
										</div>
									</div>
	                                @endforeach
									<div id="NewAddress" class="boxNewAdd">
										<a href="javascript:;" id="addaddress">+ TAMBAH ALAMAT</a>
									</div>
								</div>
							</div>
							<div class="boxAccount">
								<div class="boxAccounWidget">
									<div class="title">INFORMASI KARTU KREDIT</div>
									@foreach($CustomerCc as $obj)
									<div id="BlockCC{{$obj->ID}}" class="boxKotakAccount after_clear">
										<div class="boxAlamat">
											<div class="text">
												<span id="NotFirstAddress1">
													@if($obj->IsActive != 1)
													<a href="javarscript:;" onclick="SetFirstAddress('{{$obj->ID}}')" class="SetFirstAddress">Jadikan Kartu Kredit Utama</a>
													@endif
												</span>
												<p>
													{{$obj->CCType}}, {{$obj->CCName}}<br/>
													{{$obj->CCNumber}}<br/>
													{{$obj->CCMonth}}/{{$obj->CCYear}}
												</p>
												<span id="NotFirstAddress2" class="title">
												@if($obj->IsActive == 1)
												UTAMA
												@endif
												</span>
											</div>
										</div>
										<div class="boxEdit">
											<a href="javarscript:;" onclick="EditCC('{{$obj->ID}}')" class="btn white">UBAH</a>
											<a href="javarscript:;" onclick="DeleteCC('{{$obj->ID}}')" class="btn white">HAPUS</a>
										</div>
									</div>
	                                @endforeach
									<div class="boxNewAdd">
										<a href="javascript:;" id="addcc">+ TAMBAH BARU</a>
									</div>
								</div>				
							</div>
						</div>
						<div></div>
						<div></div>
						<div></div>
						<div></div>
						<div></div>
					</div>
				</div>
			</div>
		</section>
	</div>	
</section>
<script type="text/javascript">
$(document).ready(function() {
	$('[name="DOB"]').datepicker({ dateFormat: 'yy/mm/dd' });

	$("#editcontact").on('click', function() {
		$("#editcontact").hide();
		$("#datafullname").hide();
		$("#dataemail").hide();
		$("#datadob").hide();
		$("#datamobile").hide();

		$("#donecontact").show();
		$("#editfullname").show();
		$("#editemail").show();
		$("#editdob").show();
		$("#editmobile").show();
	});

	$("#donecontact").on('click', function() {
		$.ajax({
            url         : '{{$basesite}}account/ajaxpost',
            type        : 'POST',
            data        : {'ajaxpost':"updatecontact",'_token':'{{csrf_token()}}','FirstName':$('[name="FirstName"]').val(),'LastName':$('[name="LastName"]').val(),'Email':$('[name="Email"]').val(),'DOB':$('[name="DOB"]').val(),'Mobile':$('[name="Mobile"]').val()},
            success     : function(data) {
                var data = JSON.parse(data);
                
                if(data['response'] == 'OK') {
					$("#datafullname").html($('[name="FirstName"]').val() + ' ' + $('[name="LastName"]').val());
					$("#dataemail").html($('[name="Email"]').val());
					$("#datadob").html($('[name="DOB"]').val());
					$("#datamobile").html($('[name="Mobile"]').val());

                	$("#donecontact").hide();
					$("#editfullname").hide();
					$("#editemail").hide();
					$("#editdob").hide();
					$("#editmobile").hide();

					$("#editcontact").show();
					$("#datafullname").show();
					$("#dataemail").show();
					$("#datadob").show();
					$("#datamobile").show();
                } else {
                	$('#popup .titlenew').contents()[0].nodeValue = 'Pesan';

                	var response = '<span class="colorred">';
                	$.each(data['response'], function(key, val) {
                		response = response + val;
                		if (!(key === data['response'].length - 1))
                			response = response + '<br/>';
                	});
        			response = response + '</span>';
                	
                	$('#popup .contentnew').html(response);

                	openPopup('popup');
                }
            }
        });
	});

	$("#updatepassword").on('click', function() {
		$('#popup .titlenew').contents()[0].nodeValue = 'Ganti Password';

		var contentnew = 
		'<div class="boxFormInline register after_clear" style="width: 100%; margin-top: 0px;"><div class="form-group">' +
			'<div class="control-label">Old Password <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<input type="password" class="form-control" name="OldPassword" placeholder="Password Anda">' +
			'</div>' +
		'</div>' +
	    '<div class="form-group">' +
			'<div class="control-label">New Password <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<input type="password" class="form-control" name="NewPassword" placeholder="Ketik Max. 8 Karakter Password Anda">' +
			'</div>' +
	    '</div>' +
	    '<div class="form-group">' +
			'<div class="control-label">Ketik Ulang New Password <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<input type="password" class="form-control" name="ReNewPassword" placeholder="Ketik Ulang Password Anda">' +
			'</div>' +
	    '</div>' +
	    '<div class="form-group">' +
			'<button id="btnupdatepassword" class="btn black" style="top: auto;">GANTI PASSWORD</button>' +
		'</div></div>';

		$('#popup .contentnew').css('height', 'auto');
		$('#popup .contentnew').html(contentnew);

    	openPopup('popup');

    	$("#btnupdatepassword").on('click', function() {
			$.ajax({
	            url         : '{{$basesite}}account/ajaxpost',
	            type        : 'POST',
	            data        : {'ajaxpost':"updatepassword",'_token':'{{csrf_token()}}','OldPassword':$('[name="OldPassword"]').val(),'NewPassword':$('[name="NewPassword"]').val(),'ReNewPassword':$('[name="ReNewPassword"]').val()},
	            success     : function(data) {
	                var data = JSON.parse(data);
	                
	                if(data['response'] == 'OK') {
						closePopup('popup');
	                } else {
            			$('.boxFormInline.register').find('div.colorred').remove();
	                	$.each(data['response'], function(key, val) {
	                		$('[name="'+key+'"]').parent().parent().append('<div class="colorred" style="padding-top:10px;">'+val+'</div>');
	                	});
	                }
	            }
	        });
		});
	});

	$("#addaddress").on('click', function() {
		$.ajax({
            url         : '{{$basesite}}account/ajaxpost',
            type        : 'POST',
            data        : {'ajaxpost':"GetProvince",'_token':'{{csrf_token()}}'},
            success     : function(data) {
            	var data = JSON.parse(data);

            	if(data['response']) {
            		$('#popup .titlenew').contents()[0].nodeValue = 'TAMBAH ALAMAT';

            		var province = '<option value="">Pilih Propinsi</option>';
                	$.each(data['response'], function(key, val) {
                		province = province + '<option value="'+val['ID']+'">'+val['Name']+'</option>';
                	});

                	var contentnew = 
					'<div class="boxFormInline register after_clear" style="width: 100%; margin-top: 0px;"><div class="form-group">' +
						'<div class="control-label">Alamat Sebagai <span class="colorred">*</span></div>' +
						'<div class="control-input">' +
							'<input type="text" class="form-control" name="AddressInfo" placeholder="Alamat Sebagai">' +
						'</div>' +
					'</div>' +
				    '<div class="form-group">' +
						'<div class="control-label">Nama Penerima <span class="colorred">*</span></div>' +
						'<div class="control-input">' +
							'<input type="text" class="form-control" name="RecepientName" placeholder="Nama Penerima">' +
						'</div>' +
				    '</div>' +
				    '<div class="form-group">' +
						'<div class="control-label">Telepon Penerima <span class="colorred">*</span></div>' +
						'<div class="control-input">' +
							'<input type="text" class="form-control numberonly" name="RecepientPhone" placeholder="Telepon Penerima">' +
						'</div>' +
				    '</div>' +
				    '<div class="form-group">' +
						'<div class="control-label">Alamat <span class="colorred">*</span></div>' +
						'<div class="control-input">' +
							'<textarea type="text" class="form-control" name="Address" placeholder="Alamat"></textarea>' +
						'</div>' +
				    '</div>' +
				    '<div class="form-group">' +
						'<div class="control-label">Kode Pos <span class="colorred">*</span></div>' +
						'<div class="control-input">' +
							'<input type="text" class="form-control numberonly" maxlength="5" name="PostalCode" placeholder="Kode Pos">' +
						'</div>' +
				    '</div>' +
				    '<div class="form-group">' +
						'<div class="control-label">Propinsi <span class="colorred">*</span></div>' +
						'<div class="control-input">' +
							'<select name="ProvinceID" onchange="GetCity(this.value)" style="width:100%;">' +
							province +
							'</select>' +
						'</div>' +
				    '</div>' +
				    '<div class="form-group">' +
						'<div class="control-label">Kota / Kabupaten <span class="colorred">*</span></div>' +
						'<div class="control-input">' +
							'<select name="CityID" onchange="GetDistrict(this.value)" style="width:100%;">' +
							'<option value="">Pilih Kota / Kabupaten</option>' +
							'</select>' +
						'</div>' +
				    '</div>' +
				    '<div class="form-group">' +
						'<div class="control-label">Desa / Kelurahan <span class="colorred">*</span></div>' +
						'<div class="control-input">' +
							'<select name="DistrictID" style="width:100%;">' +
							'<option value="">Pilih Desa / Kelurahan</option>' +
							'</select>' +
						'</div>' +
				    '</div>' +
				    '<div class="form-group">' +
						'<button onclick="CreateAddress()" class="btn black" style="top: auto;">TAMBAH ALAMAT</button>' +
					'</div></div>';

					$('#popup .contentnew').css('height', 'auto');
					$('#popup .contentnew').html(contentnew);

					$('.numberonly').numberOnly();
					openPopup('popup');
                }
            }
        });
	});

	$("#addcc").on('click', function() {
    	$('#popup .titlenew').contents()[0].nodeValue = 'TAMBAH KARTU KREDIT';

		var contentnew = 
		'<div class="boxFormInline register after_clear" style="width: 100%; margin-top: 0px;"><div class="form-group">' +
			'<div class="control-label">Type Kartu Kredit <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<input type="text" class="form-control" name="CCType" placeholder="Type Kartu Kredit">' +
			'</div>' +
		'</div>' +
		'<div class="form-group">' +
			'<div class="control-label">Nomor Kartu Kredit <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<input type="text" class="form-control" name="CCNumber" placeholder="Nomor Kartu Kredit">' +
			'</div>' +
		'</div>' +
	    '<div class="form-group">' +
			'<div class="control-label">Nama Pemilik <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<input type="text" class="form-control" name="CCName" placeholder="Nama Pemilik">' +
			'</div>' +
	    '</div>' +
	    '<div class="form-group">' +
			'<div class="control-label">Bulan Kadaluarsa <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<input type="text" class="form-control" name="CCMonth" placeholder="Bulan Kadaluarsa">' +
			'</div>' +
	    '</div>' +
	    '<div class="form-group">' +
			'<div class="control-label">Tahun Kadaluarsa <span class="colorred">*</span></div>' +
			'<div class="control-input">' +
				'<input type="password" class="form-control" name="CCYear" placeholder="Tahun Kadaluarsa">' +
			'</div>' +
	    '</div>' +
	    '<div class="form-group">' +
			'<button id="btnaddcc" class="btn black" style="top: auto;">TAMBAH KARTU KREDIT</button>' +
		'</div></div>';

		$('#popup .contentnew').css('height', 'auto');
		$('#popup .contentnew').html(contentnew);

		openPopup('popup');
	});
});

function GetCity(obj) {
	$.ajax({
        url         : '{{$basesite}}account/ajaxpost',
        type        : 'POST',
        data        : {'ajaxpost':"GetCity",'_token':'{{csrf_token()}}','ProvinceID':obj},
        success     : function(data) {
            var data = JSON.parse(data);
            
            if(data['response']) {
    			var city = '<option value="">Pilih Kota / Kabupaten</option>';
    			var district = '<option value="">Pilih Desa / Kelurahan</option>';
            	$.each(data['response'], function(key, val) {
            		city = city + '<option value="'+val['ID']+'">'+val['Name']+'</option>';
            	});
            	$('[name="CityID"]').html(city);
            	$('[name="DistrictID"]').html(district);
            }
        }
    });
}

function GetDistrict(obj) {
	$.ajax({
        url         : '{{$basesite}}account/ajaxpost',
        type        : 'POST',
        data        : {'ajaxpost':"GetDistrict",'_token':'{{csrf_token()}}','CityID':obj},
        success     : function(data) {
            var data = JSON.parse(data);
            
            if(data['response']) {
    			var city = '<option value="">Pilih Desa / Kelurahan</option>';
            	$.each(data['response'], function(key, val) {
            		city = city + '<option value="'+val['ID']+'">'+val['Name']+'</option>';
            	});
            	$('[name="DistrictID"]').html(city);
            }
        }
    });
}

function CreateAddress() {
	var AddressInfo = $('[name="AddressInfo"]').val();
	var RecepientName = $('[name="RecepientName"]').val();
	var RecepientPhone = $('[name="RecepientPhone"]').val();
	var Address = $('[name="Address"]').val();
	var PostalCode = $('[name="PostalCode"]').val();
	var ProvinceID = $('[name="ProvinceID"]').val();
	var CityID = $('[name="CityID"]').val();
	var DistrictID = $('[name="DistrictID"]').val();

	var check = false;

	if(!AddressInfo) {
		$('[name="AddressInfo"]').focus();
		$('[name="AddressInfo"]').attr('style', 'border:1px solid red;');
		check = true;
	} else {
		$('[name="AddressInfo"]').attr('style', 'border:1px solid black;');
	}

	if(!RecepientName) {
		$('[name="RecepientName"]').focus();
		$('[name="RecepientName"]').attr('style', 'border:1px solid red;');
		check = true;
	} else {
		$('[name="RecepientName"]').attr('style', 'border:1px solid black;');
	}

	if(!RecepientPhone) {
		$('[name="RecepientPhone"]').focus();
		$('[name="RecepientPhone"]').attr('style', 'border:1px solid red;');
		check = true;
	} else {
		$('[name="RecepientPhone"]').attr('style', 'border:1px solid black;');
	}

	if(!Address) {
		$('[name="Address"]').focus();
		$('[name="Address"]').attr('style', 'border:1px solid red;');
		check = true;
	} else {
		$('[name="Address"]').attr('style', 'border:1px solid black;');
	}

	if(!PostalCode) {
		$('[name="PostalCode"]').focus();
		$('[name="PostalCode"]').attr('style', 'border:1px solid red;');
		check = true;
	} else {
		$('[name="PostalCode"]').attr('style', 'border:1px solid black;');
	}

	if(!ProvinceID) {
		$('[name="ProvinceID"]').focus();
		$('[name="ProvinceID"]').attr('style', 'border:1px solid red; width:100%;');
		check = true;
	} else {
		$('[name="ProvinceID"]').attr('style', 'border:1px solid black; width:100%;');
	}

	if(!CityID) {
		$('[name="CityID"]').focus();
		$('[name="CityID"]').attr('style', 'border:1px solid red; width:100%;');
		check = true;
	} else {
		$('[name="CityID"]').attr('style', 'border:1px solid black; width:100%;');
	}

	if(!DistrictID) {
		$('[name="DistrictID"]').focus();
		$('[name="DistrictID"]').attr('style', 'border:1px solid red; width:100%;');
		check = true;
	} else {
		$('[name="DistrictID"]').attr('style', 'border:1px solid black; width:100%;');
	}

	if(!check) {
		$.ajax({
	        url         : '{{$basesite}}account/ajaxpost',
	        type        : 'POST',
	        data        : {'ajaxpost':"SetAddress",'_token':'{{csrf_token()}}','AddressInfo':AddressInfo,'RecepientName':RecepientName,'RecepientPhone':RecepientPhone,'Address':Address,'PostalCode':PostalCode,'ProvinceID':ProvinceID,'CityID':CityID,'DistrictID':DistrictID},
	        success     : function(data) {
	            var data = JSON.parse(data);

	            if(data['response'] == 'OK') {
	            	var addSetFirstAddress1 = '';
	            	var addSetFirstAddress2 = '';

	            	if($("div[id^='Address']").length == 0) {
	            		addSetFirstAddress1 = '';
	            		addSetFirstAddress2 = 'UTAMA';
	            	} else {
	            		addSetFirstAddress1 = '<a href="javarscript:;" onclick="SetFirstAddress(\''+data['data']['ID']+'\')" class="SetFirstAddress">Jadikan Alamat Pengiriman Utama</a>';
	            		addSetFirstAddress2 = '';
	            	}

	            	var CreateAddress = '<div id="Address'+data['data']['ID']+'" class="boxKotakAccount after_clear">' +
											'<div class="boxAlamat">' +
												'<div class="text">' +
													'<b><span id="TextAddressInfo">'+AddressInfo+'</span> <span id="NotFirstAddress1">' +
														addSetFirstAddress1 +
													'</span></b><br/>' +
													'<p>' +
														'<span id="TextAddress">'+Address+'</span>' + '<br/>' +
														'<span id="TextDistrictName">'+$('[name="DistrictID"] option:selected').text()+'</span>' + ', ' + '<span id="TextCityName">'+$('[name="CityID"] option:selected').text()+'</span>' + ' ' + '<span id="TextPostalCode">'+PostalCode+'</span>' +
													'</p>'+
													'<p>' +
														'Penerima : <span id="TextRecepientName">'+RecepientName+'</span><br/>' +
														'Telepon : <span id="TextRecepientPhone">'+RecepientPhone+'</span>' +
													'</p>' +
													'<span id="NotFirstAddress2" class="title">' +
													addSetFirstAddress2 +
													'</span>' +
												'</div>' +
											'</div>' +
											'<div class="boxEdit">' +
												'<a href="javarscript:;" onclick="EditAddress(\''+data['data']['ID']+'\')" class="btn white">UBAH</a>' +
												'<a href="javarscript:;" onclick="DeleteAddress(\''+data['data']['ID']+'\')" class="btn white">HAPUS</a>' +
											'</div>' +
										'</div>';
					// $('[name="ProvinceID"] option:selected').text()
					$(CreateAddress).insertBefore("#NewAddress");
				    closePopup('popup');
	            }
	        }
	    });
	}
}

function SetFirstAddress(obj) {
	$('#popup .titlenew').contents()[0].nodeValue = 'Jadikan Alamat Pengiriman Utama';

	var contentnew =
    '<div class="form-group">' +
		'<button id="btnupdatepassword" class="btn black" style="top: auto;">OK</button>' +
    	' <button id="btncancel" class="btn white" style="top: auto;">Cancel</button>' +
	'</div></div>';

	$('#popup .contentnew').css('height', 'auto');
	$('#popup .contentnew').html(contentnew);

	openPopup('popup');

	$("#btnupdatepassword").on('click', function() {
		$.ajax({
	        url         : '{{$basesite}}account/ajaxpost',
	        type        : 'POST',
	        data        : {'ajaxpost':"SetFirstAddress",'_token':'{{csrf_token()}}','ID':obj},
	        success     : function(data) {
	            var data = JSON.parse(data);

	            if(data['response'] == 'OK') {
	            	$('#BoxAddress').find('.boxKotakAccount').each(function() {
	            		var id = $(this).attr('id').replace('Address', '');
	            		if(id != obj) {
							$(this).find('#NotFirstAddress1').html('<a href="javarscript:;" onclick="SetFirstAddress(\''+id+'\')" class="SetFirstAddress">Jadikan Alamat Pengiriman Utama</a>');
							$(this).find('#NotFirstAddress2').html('');
	            		} else {
	            			$(this).find('#NotFirstAddress1').html('');
				    		$(this).find('#NotFirstAddress2').html('UTAMA');
	            		}
				    });

				    closePopup('popup');
	            }
	        }
	    });
	});

	$("#btncancel").on('click', function() {
		closePopup('popup');
	});
}

function DeleteAddress(obj) {
	$('#popup .titlenew').contents()[0].nodeValue = 'Hapus Alamat Pengiriman ?';

	var contentnew =
    '<div class="form-group">' +
		'<button id="btnupdatepassword" class="btn black" style="top: auto;">OK</button>' +
    	' <button id="btncancel" class="btn white" style="top: auto;">Cancel</button>' +
	'</div></div>';

	$('#popup .contentnew').css('height', 'auto');
	$('#popup .contentnew').html(contentnew);

	openPopup('popup');

	$("#btnupdatepassword").on('click', function() {
		$.ajax({
	        url         : '{{$basesite}}account/ajaxpost',
	        type        : 'POST',
	        data        : {'ajaxpost':"DeleteAddress",'_token':'{{csrf_token()}}','ID':obj},
	        success     : function(data) {
	            var data = JSON.parse(data);

	            if(data['response'] == 'OK') {
	            	$('#Address'+obj).remove();
				    closePopup('popup');
	            }
	        }
	    });
	});

	$("#btncancel").on('click', function() {
		closePopup('popup');
	});
}

function EditAddress(obj) {
	$.ajax({
        url         : '{{$basesite}}account/ajaxpost',
        type        : 'POST',
        data        : {'ajaxpost':"EditAddress",'_token':'{{csrf_token()}}','ID':obj},
        success     : function(data) {
            var data = JSON.parse(data);

            if(data['response'] == 'OK') {
            	var dataaccount = data['data'];
            	$.ajax({
		            url         : '{{$basesite}}account/ajaxpost',
		            type        : 'POST',
		            data        : {'ajaxpost':"GetLocation",'_token':'{{csrf_token()}}','ProvinceID':dataaccount['ProvinceID'],'CityID':dataaccount['CityID']},
		            success     : function(data) {
		            	var data = JSON.parse(data);

		            	if(data['response']) {
		            		var province = '<option value="">Pilih Propinsi</option>';
		                	$.each(data['data']['province'], function(key, val) {
		                		if(val['ID'] == dataaccount['ProvinceID'])
		                			province = province + '<option value="'+val['ID']+'" selected >'+val['Name']+'</option>';
		                		else
		                			province = province + '<option value="'+val['ID']+'">'+val['Name']+'</option>';
		                	});
		            		var city = '<option value="">Pilih Kota / Kabupaten</option>';
		                	$.each(data['data']['city'], function(key, val) {
		                		if(val['ID'] == dataaccount['CityID'])
		                			city = city + '<option value="'+val['ID']+'" selected >'+val['Name']+'</option>';
		                		else
		                			city = city + '<option value="'+val['ID']+'">'+val['Name']+'</option>';
		                	});
		            		var district = '<option value="">Pilih Desa / Kelurahan</option>';
		                	$.each(data['data']['district'], function(key, val) {
		                		if(val['ID'] == dataaccount['DistrictID'])
		                			district = district + '<option value="'+val['ID']+'" selected >'+val['Name']+'</option>';
		                		else
		                			district = district + '<option value="'+val['ID']+'">'+val['Name']+'</option>';
		                	});

		                	$('#popup .titlenew').contents()[0].nodeValue = 'UBAH ALAMAT';

							var contentnew = 
							'<div class="boxFormInline register after_clear" style="width: 100%; margin-top: 0px;"><div class="form-group">' +
								'<div class="control-label">Alamat Sebagai <span class="colorred">*</span></div>' +
								'<div class="control-input">' +
									'<input type="text" class="form-control" name="AddressInfo" placeholder="Alamat Sebagai" value="'+dataaccount['AddressInfo']+'">' +
								'</div>' +
							'</div>' +
						    '<div class="form-group">' +
								'<div class="control-label">Nama Penerima <span class="colorred">*</span></div>' +
								'<div class="control-input">' +
									'<input type="text" class="form-control" name="RecepientName" placeholder="Nama Penerima" value="'+dataaccount['RecepientName']+'">' +
								'</div>' +
						    '</div>' +
						    '<div class="form-group">' +
								'<div class="control-label">Telepon Penerima <span class="colorred">*</span></div>' +
								'<div class="control-input">' +
									'<input type="text" class="form-control numberonly" name="RecepientPhone" placeholder="Telepon Penerima" value="'+dataaccount['RecepientPhone']+'">' +
								'</div>' +
						    '</div>' +
						    '<div class="form-group">' +
								'<div class="control-label">Alamat <span class="colorred">*</span></div>' +
								'<div class="control-input">' +
									'<textarea type="text" class="form-control" name="Address" placeholder="Alamat">'+dataaccount['Address']+'</textarea>' +
								'</div>' +
						    '</div>' +
						    '<div class="form-group">' +
								'<div class="control-label">Kode Pos <span class="colorred">*</span></div>' +
								'<div class="control-input">' +
									'<input type="text" class="form-control numberonly" maxlength="5" name="PostalCode" placeholder="Kode Pos" value="'+dataaccount['PostalCode']+'">' +
								'</div>' +
						    '</div>' +
						    '<div class="form-group">' +
								'<div class="control-label">Propinsi <span class="colorred">*</span></div>' +
								'<div class="control-input">' +
									'<select name="ProvinceID" onchange="GetCity(this.value)" style="width:100%;">' +
									province +
									'</select>' +
								'</div>' +
						    '</div>' +
						    '<div class="form-group">' +
								'<div class="control-label">Kota / Kabupaten <span class="colorred">*</span></div>' +
								'<div class="control-input">' +
									'<select name="CityID" onchange="GetDistrict(this.value)" style="width:100%;">' +
									'<option value="">Pilih Kota / Kabupaten</option>' +
									city +
									'</select>' +
								'</div>' +
						    '</div>' +
						    '<div class="form-group">' +
								'<div class="control-label">Desa / Kelurahan <span class="colorred">*</span></div>' +
								'<div class="control-input">' +
									'<select name="DistrictID" style="width:100%;">' +
									district +
									'</select>' +
								'</div>' +
						    '</div>' +
						    '<div class="form-group">' +
								'<button id="btneditaccount" class="btn black" style="top: auto;">UBAH ALAMAT</button>' +
							'</div></div>';

							$('#popup .contentnew').css('height', 'auto');
							$('#popup .contentnew').html(contentnew);

							$('.numberonly').numberOnly();
							openPopup('popup');

							$("#btneditaccount").on('click', function() {
								var AddressInfo = $('[name="AddressInfo"]').val();
								var RecepientName = $('[name="RecepientName"]').val();
								var RecepientPhone = $('[name="RecepientPhone"]').val();
								var Address = $('[name="Address"]').val();
								var PostalCode = $('[name="PostalCode"]').val();
								var ProvinceID = $('[name="ProvinceID"]').val();
								var CityID = $('[name="CityID"]').val();
								var DistrictID = $('[name="DistrictID"]').val();

								$.ajax({
							        url         : '{{$basesite}}account/ajaxpost',
							        type        : 'POST',
							        data        : {'ajaxpost':"UpdateAddress",'_token':'{{csrf_token()}}','ID':dataaccount['ID'],'AddressInfo':AddressInfo,'RecepientName':RecepientName,'RecepientPhone':RecepientPhone,'Address':Address,'PostalCode':PostalCode,'ProvinceID':ProvinceID,'CityID':CityID,'DistrictID':DistrictID},
							        success     : function(data) {
							            var data = JSON.parse(data);

							            if(data['response'] == 'OK') {
							            	$('#Address'+obj).find('#TextAddressInfo').html(AddressInfo);
							            	$('#Address'+obj).find('#TextAddress').html(Address);
							            	$('#Address'+obj).find('#TextDistrictName').html($('[name="DistrictID"] option:selected').text());
							            	$('#Address'+obj).find('#TextCityName').html($('[name="CityID"] option:selected').text());
							            	$('#Address'+obj).find('#TextPostalCode').html(PostalCode);
							            	$('#Address'+obj).find('#TextRecepientName').html(RecepientName);
							            	$('#Address'+obj).find('#TextRecepientPhone').html(RecepientPhone);

										    closePopup('popup');
							            }
							        }
							    });
							});

							$("#btncancel").on('click', function() {
								closePopup('popup');
							});
		                }
		            }
		        });
            }
        }
    });
}
</script>