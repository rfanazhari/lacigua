<style>
	#list {
		list-style-type: decimal;
		margin-left: 20px;
	}

	#list li {
		font-weight: bold;
		margin-top: 20px;
	}

	#list p {
		line-height: 20px;
		margin-top: -5px;
	}

	.note.tooltip {
		width: 21px;
	    height: 20px;
	    top: 20px;
	    background: url({{$basesite}}assets/frontend/images/material/question.png) no-repeat;
	    text-indent: -99999;
	    color: transparent;
	}
</style>

<section class="general">
	<div class="wrapper">
		<h1>DELIVERY AND RETURN</h1>
		<p>
			Lacigue menyediakan Gratis Penukaran dan Pemgemblian Produk. Pastikan produk yang ingin kamu kembaliakan tidak lebih dari 7 hari setelah kamu menerima produk dan proses penukaran dari pengembalian memenuhi kebijakan pengembalian produk di LACIGUE
		</p>

		<p>PENTING ! Ongkos Kirim Pengembalian akan ditanggung pelanggan yang akan melakukan pengembalian atau penukaran produk.</p>

		<ul id="list">
			<li>
				<p>Isi dan tempel permohonan pada slip penukaran & pemgembalian.</p>
				<p>Jika stiker atau slip pengembalian kamu hilang/rusak, download <a href="javascript:;" onclick="GoSlipReturn()">di sini</a>.</p>
				<img src="{{$basesite}}assets/frontend/images/content/pengembalian.jpeg" alt="">
			</li>
			<li>
				<p>Masuk ke My Returns yang ada didalam My Laci dan lihat detail pesanan.</p>
				<img src="{{$basesite}}assets/frontend/images/content/listpesanan.jpeg" alt="">
			</li>
			<li>
				<p style="display: inline;"">Pilih barang yang akan kamu kembalikan dengan mengklik</p>
				<img style="position: absolute;margin-left: 10px;margin-top: -5px;" src="{{$basesite}}assets/frontend/images/content/listproduct.png" alt="">
				<p style="margin-top: 15px;">Pastikan kamu memberikan solusi dan solusi pengembalian.</p>
				<img src="{{$basesite}}assets/frontend/images/content/myreturn.jpeg" alt="">
			</li>
			<li>
				<p>Isi detail / upload detail yang dibutuhkan dalam pengembalian / penukaran.</p>
				<img src="{{$basesite}}assets/frontend/images/content/myreturn.jpeg" alt="">
			</li>
			<li>
				<p>Kirimkan produk yang ingin dikembalikan lewat expedisi pilihan kamu. Jangan lupa tempelkan</p>
				<p>slip pengembalian dibagian depan kemasan.</p>
			</li>
			<li>
				<p>Masukan no resi produk yang kamu kembalikan disini agar kami dapat mengecek status dan melacak paket kiriman Anda.</p>
				<img src="{{$basesite}}assets/frontend/images/content/airbill.jpeg" alt="">
			</li>
			<li>
				<p>Kamu akan menerima email notifikasi saat produk telah diterima di kami. Setelah produk diterima,</p>
				<p>kami akan melakukan proses Quality Control (QC) dan hanya produk yang sudah melewati proses QC saja</p>
				<p>yang dapat dilakukan pengembalian dana atau proses penukaran produk.</p>
				<br>
				<p>Kamu akan menerima notifikasi lagi saat pengembalian dana atau penukaran produk sudah di proses dan dikirim kembali.</p>
			</li>
		</ul> 
	</div>
</section>
<div class="wrap-popup" id="popup-deliveryreturn">
    <div class="overlay-pop2"></div>
    <div class="box-popup type_2 track_order">
        <div class="title">PESAN
            <span class="closepop">x</span>
        </div>
        <div class="content" style="height: auto;">
            <div class="boxFormInline register after_clear" style="width: 100%; margin-top: 0px;">
            	<div class="form-group">
					<div class="control-label">Silahkan Isi No. Order Anda 
					<span class="newtooltip note tooltip" style="cursor: pointer;" data-tooltip-content="#tooltip-content-lacak" data-tooltipster='{"side":"right","animation":"fade","maxWidth":"300", "trigger": "click", "theme": ["tooltipster-noir","tooltipster-noir-customized"]}'>ico</span>
	                    <div class="tooltip-template">
	                        <div id="tooltip-content-lacak">
	                            <p>Nomer Order/ Nomor Pesanan terdiri dari 16 digit nomor yang Anda terima ketika Anda mengkonfirmasi pesanan Anda. CONTOH: EMRKAG1509134417</p>
	                            <p>Anda dapat menemukan ID Pesanan Anda di email Anda (dikirim secara otomatis setelah pesanan konfirmasi).</p>
	                        </div>
	                    </div>
					</div>
					<div class="control-input">
						<input type="text" class="form-control" name="OrderID">
					</div>
				</div>
			    <div class="form-group">
					<button id="btnprint" class="btn black" style="top: auto;">Cetak Slip Retur</button>
				</div>
			</div>
        </div>
    </div>
</div>

<script type="text/javascript">
	function GoSlipReturn() {
		check = true;

        $.ajax({
            url         : '{{$basesite}}api/checking',
            type        : 'POST',
            data        : {'ajaxpost':"CheckLogin"},
            success     : function(data) {
                var data = JSON.parse(data);
                
                if(data['response'] == 'OK') {
            		openPopup('popup-deliveryreturn');
                	
			    	$("#btnprint").on('click', function() {
			    		var OrderID = $('[name="OrderID"]');
			    		OrderID.attr('style', 'border : 1px solid black;');

            			if(OrderID.val()) {
							$.ajax({
					            url         : '{{$basesite}}delivery-returns/ajaxpost',
					            type        : 'POST',
					            data        : {'ajaxpost':"GoSlipReturn",'_token':'{{csrf_token()}}','OrderID':OrderID.val()},
					            success     : function(data) {
					                var data = JSON.parse(data);
					                
					                if(data['response'] == 'OK' && check) {
					                	check = false;
										closePopup('popup-deliveryreturn');
										window.open(data['data'], '_blank');
					                } else {
				            			OrderID.attr('style', 'border : 1px solid red;');
					                	if(!check) OrderID.attr('style', 'border : 1px solid black;');
					                	OrderID.val('');
					                }
					            }
					        });
				        } else OrderID.attr('style', 'border : 1px solid red;');
					});
                } else {
                    $('#popup .titlenew').contents()[0].nodeValue = 'Daftar atau Login';

                    var contentnew = 
                    '<div class="boxFormInline register after_clear" style="width: 100%; margin-top: 0px;"><div class="form-group">' +
                        '<div class="control-label colorred">' + data['response'] + '</div>' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<button id="btnok" class="btn black" style="top: auto;">OK</button> <button id="btncancel" class="btn white" style="top: auto;">Cancel</button>' +
                    '</div></div>';

                    $('#popup .contentnew').css('height', 'auto');
                    $('#popup .contentnew').html(contentnew);

                    openPopup('popup');

                    $("#btnok").on('click', function() { window.location.href = '{{$basesite}}login'; });
                    $("#btncancel").on('click', function() { closePopup('popup'); });
                }
            }
        });
    }
</script>