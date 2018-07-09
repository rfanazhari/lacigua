<section class="contact">
	<div class="wrapper">
		<h1>KONTAK KAMI</h1>
		<div class="text">
			<div>Customer Service kami selalu siap membantu Anda.</div>
			<p>
				1. Anda mungkin menemukan beberapa pertanyaan Anda di <a href="{{$basesite}}faq">FAQ</a> kami<br/>
				2. Anda dapat menghubungi kami di <b>+62 22 751 4100</b>,<br/>setiap <b>Senin-Jumat : 8.30-17.30 WIB</b><br/>
				3. Tidak suka menelepon? Tinggalkan pesan anda pada form dibawah ini, dan kami akan merespon dalam waktu 24 jam pada hari kerja,<br/>atau 48 jam pada hari libur.
			</p>
		</div>
		<div class="boxForm">
			<form class="form-horizontal" method="post">
				{{csrf_field()}}
				<div class="form-group">
					<label class="control-label" for="nama">Nama Lengkap</label>
					<div class="control-input">
						<input type="text" class="form-control" id="nama" name="fullname" value="{{$fullname}}" @if(isset($error['fullname'])) style="border:1px solid red;" @endif >
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="email">Email</label>
					<div class="control-input">          
						<input type="text" class="form-control" id="email" name="email" value="{{$email}}" @if(isset($error['email'])) style="border:1px solid red;" @endif >
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="no_hp">No. Handphone</label>
					<div class="control-input">          
						<input type="text" class="form-control numberonly" id="no_hp" name="mobile" value="{{$mobile}}" @if(isset($error['mobile'])) style="border:1px solid red;" @endif >
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="pesan">Pesan</label>
					<div class="control-input">          			     
						<textarea class="form-control" id="pesan" name="message" @if(isset($error['message'])) style="border:1px solid red;" @endif rows="6" maxlength="255">{{$message}}</textarea>
						<span class="textarea_max">Characters <span id="count">0</span> / 255</span>
					</div>
				</div>
				<div class="form-group">        
					<div class="boxButton">
						<button type="submit" name="submit" class="btn black">KIRIM</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
<script type="text/javascript">
	$(document).ready(function() {
		$("#pesan").keyup(function() {
			$("#count").text($(this).val().length);
		});
		@if($success == 'OK')
		_alertvalidation('Pesan anda akan kami proses. Terima Kasih');
		@endif
	});
</script>