<section class="contact affiliate">
	<div class="wrapper">
		<h1>LACIGUE AFFILIATE</h1>
		<div class="text" style="width: 100%;">
			<div style="font-size: 36px;">Undang teman Anda untuk berbelanja di Lacigue!</div>
			<p style="font-size: 30px;line-height: 40px;">Dapatkan store kredit senilai IDR 50,000 ketika teman anda melakukan <br/>pembelian pertama
			</p>
		</div>
		<div class="boxDisplay after_clear">
			<div>
				<img src="{{$basesite}}assets/frontend/images/material/lacigue_box.png">
			</div>
			<div>
				<h4>Lacigue - Destinasi fashion online terkini</h4>
				<p>
					100+ produk baru setiap minggu! <br/>
					Pengiriman gratis dan 7 hari pengembalian. <br/>
					Tunggu apa lagi!?
				</p>
			</div>
		</div>
		<div class="boxShare after_clear">
			<div>
				<input type="text" id="CustomerShareLink" value="{{$basesite}}reff/code_{{$CustomerData->CustomerShareLink}}" style="background-color: #EBEBE4;" readonly >
				<button onclick="CopyLink()" class="btn black" style="padding: 7px;height:10px;line-height: 0;font-size:10px;">Copy Link</button> <span id="linkcopied" style="color:red;display:none;padding-top: 3px !important;">Link Copied !</span>
			</div>
			<div>
				<a href="javascript:;" class="btn fb">SHARE</a>
			</div>
		</div>
		<hr/>
		<div class="boxShare after_clear">
			<form method="post">
				{{csrf_field()}}
				<div>
					<label>Undangan Melalui Email</label>
					<input type="text" class="input2" name="listemail" placeholder="Masukan Alamat Email Teman Anda" value="{{$listemail}}" @if($errorlistemail != 'null' && $errorlistemail) style="border: 1px solid red;" @endif >
					<span class="note">Setiap email dipisah dengan tanda koma</span>
					<div style="color:red; margin-top: 10px; width: 100%;"> @if($errorlistemail != 'null') {{$errorlistemail}} @endif </div>
				</div>
				<div>
					<button type="submit" name="submit" class="btn black" style="margin-top: 44px;line-height: 50px;height: 50px;font-size: 20px;font-family: $font_creguler;">KIRIM</button>
				</div>
			</form>
		</div>
		<div class="boxSaldo after_clear">
			<div class="inner">
				<div class="title">SALDO STORE KREDIT ANDA:</div>
				<div class="rp">{{$inv->_formatamount($CustomerData->StoreCredit, 'Rupiah', 'Rp. ')}}</div>
			</div>
			<div class="inner">
				<div class="list">{{$CustomerData->CountReferral}} teman sudah mendaftar,</div>
				<div class="list">{{$CustomerData->CountReferralTransaction}} teman sudah membeli barang</div>
			</div>
		</div>
		<div class="link_syarat">
			<a href="javascript:;">Persyaratan & Ketentuan</a>
		</div>
		<div id="termsconditions" class="content_syarat">
			<h1>PROGRAM UNDANG TEMAN</h1>
			<p>Dapatkan hadiah untuk bergabung dalam Program Undang Teman <b>Lacigue</b>. Untuk berpartisipasi, masuk ke URL www.lacigue.com/invite dan ikuti panduan untuk mengundang teman Anda!</p>

			<h3>Syarat</h3>
			<ul>
				<li>Undang teman Anda untuk menjadi anggota baru dengan mengirimkan link pribadi, berbagi melalui <br/>Facebook, ataupun email.</li>
				<li>Untuk pembelian pertama dari hasil undangan Anda, Anda akan menerima Referral Kredit sebesar <br/>Rp. 50.000,- yang dapat digunakan untuk pembelian Anda berikutnya.</li>
			</ul>

			<h3>Anggota Baru Yang Memenuhi Syarat</h3>
			<p>Untuk memenuhi syarat dari program ini, maka teman yang Anda undang haruslah baru dengan <br/>
			<b>Lacigue</b>, belum pernah berbelanja atau membuat akun di website kami. Teman Anda kemudian harus<br/>
			mendaftar / membuat akun <b>Lacigue</b> dengan mengikuti link undangan (referral link) yang Anda <br/>
			cantumkan di Facebook, email, dan lain-lain.</p>

			<h3>Referral Order yang Berkualitas</h3>
			<p>Teman undangan Anda yang baru mendaftar di <b>Lacigue</b> harus melakukan pembelian pertama sebesar<br/>
			Rp. 200.000,- melalui website kami, yang beralamat di www.lacigue.com, dalam kurun waktu 30 hari <br/>
			sejak membuat akun. Pembelian yang sudah dilakukan tidak boleh dibatalkan atau dikembalikan. <br/>Setelah 30 hari sejak pemesanan oleh teman Anda, maka Anda akan mendapatkan hadiah berupa <br/>Store Kredit yang dapat digunakan untuk pembelian berikutnya.</p>

			<h3>Penggunaan Referral Kredit</h3>
			<p>Store Kredit dapat digunakan saat Anda melakukan checkout. Store Credit(s) ini hanya dapat tidak <br/> dapat dikembalikan (non-refundable), tidak dapat dialihkan dan diberikan ke orang lain, serta tidak <br/>dapat ditukar dengan uang tunai.</p>
			<p>Store Kredit tidak bisa didapatkan dengan membuat banyak akun <b>Lacigue</b>. Store Kredit yang berada di akun-akun berbeda tidak dapat digabungkan ke dalam satu akun.</p>

			<h3>Penggunaan Referral Kredit</h3>
			<p><b>Lacigue</b> dapat memberhentikan Program Undang Teman ini sewaktu-waktu untuk alasan apa pun. <br/><b>Lacigue</b> juga dapat melakukan perubahan pada syarat ketentuan dan bentuk hadiah sewaktu-waktu.</p>
			<p>Store Kredits yang didapatkan dari segala bentuk aktivitas penipuan akan dianggap tidak sah dan <br/>tidak berlaku. <b>Lacigue</b> berhak untuk menangguhkan akun dan menghapus referensi yang diyakini <br/>terkait aktivitas penipuan. <b>Lacigue</b> berwenang untuk melakukan investigasi dan melakukan <br/>peninjauan untuk semua aktivitas berkaitan dengan program referensi ini, untuk menangguhkan akun <br/>dan membatalkan referensi sesuai dengan pertimbangan yang adil dan layak. Store Kredit yang <br/>bukan hasil penipuan dan sudah menjadi hak pelanggan tidak akan terkena dampak dari <br/>penangguhan atau pemberhentian program Undang Teman.</p>
		</div>
	</div>
</section>

<script type="text/javascript">
	$(".link_syarat").on("click", "a", function() {
		if($(this).hasClass("active")) {
			$(".content_syarat").css({
				display: 'none',
				visibility: 'hidden',
				opacity: 0
			})
			$(this).removeClass("active");
		} else {
			$(".content_syarat").css({
				display: 'inherit',
				visibility: 'visible',
				opacity: 1
			})
			$(this).addClass("active");
		}
	});

	$(document).ready(function() {
		@if($errorlistemail == 'null')
		$('[name="listemail"]').attr('style', 'border: 1px solid red;');
		$('[name="listemail"]').foucs();
		@endif
		@if($messagesuccess == 'success')
		_alertvalidation('Email undangan telah dikirim !');
		@endif
		if (location.hash === "#termsconditions") {
			$(".content_syarat").css({
				display: 'inherit',
				visibility: 'visible',
				opacity: 1
			})
			$(".content_syarat").addClass("active");

			if(location.hash != '') 
        		location.hash = location.hash;;
		}
	});

	function CopyLink() {
		var Url = document.getElementById("CustomerShareLink");
		Url.innerHTML = window.location.href;
		console.log(Url.innerHTML)
		Url.select();
		document.execCommand("copy");
		$('#linkcopied').show();
		setTimeout(function(){ $('#linkcopied').fadeOut(); }, 1000);
	}
</script>