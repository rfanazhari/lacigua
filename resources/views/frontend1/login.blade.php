<section class="contact">
	<div class="wrapper">
		<h1>LOG IN ATAU BUAT AKUN BARU </h1>
		<div class="text">
			<div style="margin-bottom: 10px;" class="title_login">ANDA TELAH TERDAFTAR</div>
			<p>Silahkan masuk menggunakan akun Lacigue Anda</p>
		</div>
		<div class="boxForm login" style="width: 500px;">
			<form method="post" class="form-horizontal" enctype="multipart/form-data">
				{{csrf_field()}}
				<div class="colorred">
					@foreach($lerrormessage as $key => $val)
					{{$val}} @if($val)<br/>@endif
					@endforeach
					@if(count($lerrormessage))<br/>@endif
				</div>
			    <div class="form-group">
					<div class="control-input">
						<input type="email" class="form-control" name="lemail" value="{{$lemail}}" placeholder="Email">
					</div>
			    </div>
			    <div class="form-group">
					<div class="control-input">          
						<input type="password" class="form-control" name="lpassword" value="{{$lpassword}}" placeholder="Password">
						<span class="note">
							<a href="javascript:;" id="forgotpass">Lupa Password / Email Anda?</a>
						</span>
					</div>
			    </div>	
			    <div class="form-group">
					<input id="lremember" class="checkbox-custom" name="lremember" type="checkbox" @if($lremember) checked @endif >
					<label for="lremember" class="checkbox-custom-label">
						<span></span>
						Saya ingin tetap Login
					</label>
			    </div>
			    <div class="form-group">        
					<div class="boxButton" style="margin-left: 0px;text-align: right;">
						<button name="login" type="submit" class="btn black">MASUK</button>
					</div>
			    </div>
			</form>
			<div class="boxSociallogin">
				<div class="title">ANDA MEMILIKI AKUN LAIN?</div>
				<div class="boxButtonSocial after_clear" style="text-align:center;">
					<a href="javascript:;" class="btn soc_btn">FACEBOOK</a>
					<a href="javascript:;" class="btn soc_btn google">GOOGLE</a>
					<a href="javascript:;" class="btn soc_btn yahoo">YAHOO</a>
				</div>
				<div class="desc">
					Kami tidak akan pernah posting dengan mengatas-namakan atau membagi informasi apapun tanpa persetujuan Anda
				</div>
			</div>	
		</div>
		<div class="boxRegister">
			<div class="or"><div>atau</div></div>
			<div class="boxFormInline register after_clear" style="width: 500px;">
				<div class="title">DAFTAR AKUN BARU</div>
				<form method="post" class="form-horizontal" enctype="multipart/form-data">
					{{csrf_field()}}
					<div class="colorred">
						@foreach($rerrormessage as $key => $val)
						{{$val}} @if($val)<br/>@endif
						@endforeach
					</div>
				    <div class="boxinput2 after_clear">
						<div class="form-group">
							<div class="control-label">Nama Depan <span class="colorred">*</span></div>
							<div class="control-input">
								<input type="text" class="form-control" name="rfirstname" value="{{$rfirstname}}" placeholder="Nama Depan">
							</div>
						</div>
						<div class="form-group">
							<div class="control-label">Nama Belakang <span class="colorred">*</span></div>
							<div class="control-input">
								<input type="text" class="form-control" name="rlastname" value="{{$rlastname}}" placeholder="Nama Belakang">
							</div>
						</div>
				    </div>
				    <div class="boxinput2 after_clear">
				    	<div class="form-group">
				    		<div class="control-label">Jenis Kelamin <span class="colorred">*</span></div>
					    </div>
						<div class="form-group">
							<input id="radiomen" class="radio-custom" name="rgender" value="1" type="radio" @if(is_numeric($rgender) && $rgender == 1) checked @endif >
							<label for="radiomen" class="radio-custom-label">
								<span class="ico"></span>
								Pria
							</label>
					    </div>
						<div class="form-group">
							<input id="radiowomen" class="radio-custom" name="rgender" value="0" type="radio" @if(is_numeric($rgender) && $rgender == 0) checked @endif >
							<label for="radiowomen" class="radio-custom-label">
								<span class="ico"></span>
								Wanita
							</label>
					    </div>
				    </div>
				    <div class="form-group">
						<div class="control-label">No. Telp <span class="colorred">*</span></div>
						<div class="control-input">          
							<input type="text" class="form-control numberonly" name="rphone" value="{{$rphone}}" placeholder="No. Telp">
						</div>
				    </div>	
				    <div class="form-group">
						<div class="control-label">Email <span class="colorred">*</span></div>
						<div class="control-input">          
							<input type="email" class="form-control" name="remail" value="{{$remail}}" placeholder="Email">
						</div>
				    </div>
				    <div class="form-group">
						<div class="control-label">Password <span class="colorred">*</span></div>
						<div class="control-input">          
							<input type="password" class="form-control" name="rpassword" value="{{$rpassword}}" placeholder="Ketik Max. 8 Karakter Password Anda">
						</div>
				    </div>
				    <div class="form-group">
						<div class="control-label">Ketik Ulang Password <span class="colorred">*</span></div>
						<div class="control-input">          
							<input type="password" class="form-control" name="rrepassword" value="{{$rrepassword}}" placeholder="Ketik Ulang Password Anda">
							<span class="note"><b><span class="colorred">*</span> Wajib diisi</b></span>
						</div>
				    </div>	
				    <div class="form-group" style="margin-bottom: 0px;">
						<input id="rremember" class="checkbox-custom" name="rremember" type="checkbox" @if($rremember) checked @endif >
						<label for="rremember" class="checkbox-custom-label">
							<span></span>
							<div class="c_label">Saya ingin tetap Login</div>
						</label>
				    </div>
				    <div class="form-group">
						<input id="rsubscribe" class="checkbox-custom" name="rsubscribe" type="checkbox" @if($rsubscribe) checked @endif >
						<label for="rsubscribe" class="checkbox-custom-label">
							<span></span>
							<div class="c_label">
								Dapatkan penawaran EKSKLUSIF<br/>
								LACIGUE & info fashion terbaru
							</div>
						</label>
				    </div>
					<div class="form-group">        
						<div class="boxButton" style="margin-left: 0px;text-align: right;">
							<button name="register" type="submit" class="btn black" style="top: -130px;">DAFTAR AKUN</button>
						</div>
					</div>
				</form>
				<div class="boxHelp">
					<div class="text">
						<div><b>Butuh Bantuan?</b></div>
						Hubungi Layanan Pelanggan<br/>
						+ 62 22 751 4100<br/><br/>
						<b>Senin - Jumat:</b> 08.00 - 17.30 WIB<br/>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$(document).ready(function() {
		$("#forgotpass").click(function() {
			$('#popup .titlenew').contents()[0].nodeValue = 'Lupa Password / Email Anda?';

	    	var contentnew = 
			'<div class="boxFormInline register after_clear" style="width: 100%; margin-top: 0px;"><div class="form-group">' +
				'<div class="control-label"><input type="text" name="Email" class="form-control" placeholder="Enter Your Email" style="width: 520px;"></div>' +
			'</div>' +
		    '<div class="form-group">' +
				'<button id="btnok" class="btn black" style="top: auto;">OK</button> <button id="btncancel" class="btn white" style="top: auto;">Cancel</button>' +
			'</div></div>';

			$('#popup .contentnew').css('height', 'auto');
			$('#popup .contentnew').html(contentnew);

			openPopup('popup');
			
			$("#btnok").on('click', function() {
				$('[name="Email"]').attr('style', 'border:1px solid black;width: 520px;');
				var Email = $('[name="Email"]').val();
				if(Email) {
					$.ajax({
			            url         : '{{$basesite}}login/ajaxpost',
			            type        : 'POST',
			            data        : {'ajaxpost':"ForgotPass",'_token':'{{csrf_token()}}','Email':Email},
			            success     : function(data) {
			                var data = JSON.parse(data);
			                if(data['response'] == 'OK') {
			                	closePopup('popup');
			                	_alertvalidation('We have send new password in your email !');
			                } else {
			                	$('[name="Email"]').attr('style', 'border:1px solid red;width: 520px;');
			                }
			            }
			        });
				} else {
					$('[name="Email"]').attr('style', 'border:1px solid red;width: 520px;');
				}
			});

			$("#btncancel").on('click', function() { closePopup('popup'); });
		});
	});
</script>