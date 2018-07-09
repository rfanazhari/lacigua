<!DOCTYPE html>
<html>
    <head>
        <title>Invoice</title>
        <link rel="icon" href="favicon.ico">
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
<body>

<section class="invoice after_clear">
	<div class="invoiceInner">
		<div class="title"></div>
		<div class="content after_clear">
			<div class="header_invoice after_clear">
				<div class="text">MERCHANT INVOICE</div>
				<div class="logo"><img src="{{$basesite}}assets/frontend/images/material/logo_merchant.png"></div>
			</div>
			<div class="boxDetail after_clear">
				<div class="penerima" style="width: 240px;">
					<div class="title_penerima">Penerima :</div>
					<div class="alamat_penerima">
						Cinta Laura<br/>
						Jl. Soekarno Hatta 207A
						Kiaracondong, Bandung<br/>
						Jawa Barat<br/>
						Indonesia<br/>
						40285<br/><br/>
						085659061222
					</div>
				</div>
				<div class="detail_order" style="margin-left: 20px;">
					<table>
						<tr>
							<th style="width:30%;">Tanggal</th><th style="width: 5%">:</th><td>09 May 2017</td>
						</tr>
						<tr>
							<th>Order Code</th><th>:</th><td>BDG1710171942356</td>
						</tr>
					</table>
					<table style="margin-top: 30px;">
						<tr>
							<th style="width:40%;">Invoice</th><th style="width: 10%">:</th><td>2541</td>
						</tr>
						<tr>
							<th>Package</th><th>:</th><td>MPDS-2626578</td>
						</tr>
						<tr>
							<th>Payment Method</th><th>:</th><td>BCA VIRTUAL ACCOUNT</td>
						</tr>
					</table>
				</div>
			</div>
			<table class="detail_produk">
				<tr>
					<th style="width: 25%;">Produk</th><th>SKU</th><th>Harga</th><th align="center" style="width: 5%;">Qty</th><th align="center">Sub Total</th>
				</tr>
				<tr>
					<td>Lost Tee</td><td>1443LOH-ML</td><td>269.900</td><td align="center">1</td><td align="center">269.900</td>
				</tr>
				<tr>
					<td>Awesome Navy Tee</td><td>26816NV-XL</td><td>150.000</td><td align="center">2</td><td align="center">300.000</td>
				</tr>				
			</table>
			<div class="box_table_total after_clear">
				<table class="sum_total">
					<tr>
						<th style="width:60%;">Total Sebelum PPN</th><th>:</th>
						<td align="right">569.900</td>
					</tr>
					<tr>
						<th>Shipping</th><th>:</th>
						<td align="right">10.000</td>
					</tr>
					<tr>
						<th>Asuransi</th><th>:</th>
						<td align="right">2.000</td>
					</tr>
					<tr>
						<th style="padding-top:30px;">TOTAL</th><th>:</th>
						<td align="right" style="padding-top:30px;">581.900</td>
					</tr>
				</table>
			</div>
			<div class="help">
				Anda butuh bantuan? Hubungi tim customer service kami<br/>
				telp : (022)7514100 | email : cservice@lacigue.com
			</div>
		</div>
	</div>
	<div class="invoiceInner slip_kembali">
		<div class="title"></div>
		<div class="content after_clear">
			<div class="title_pengembalian">SLIP PENGEMBALIAN</div>
			<div class="desc_pengembalian">
				Jika kamu merasa kebesaran / kekecilan dengan produk<br/>
yang diterima atau barang ada cacat dan rusak saat pengiriman,<br/>
jangan khawatir karena kamu dapat mengembalikannya.  
			</div>
			<div class="title_pengembalian" style="margin-top: 40px;">PROSES PENGEMBALIAN</div>
			<div class="proses_pengembalian after_clear">
				<div class="boxProses">
					<div class="text">STEP 1<br/>
Masuk ke akun kamu di <br/>
Lacigue.com, kemudian pilih <br/>
‘My Return’, lalu pilih produk <br/>
dan alasan pengembalian. 
 
</div>
				</div>
				<div class="boxProses">
					<div class="text">STEP 2<br/>
Kemas produk dan tempel<br/>
slip pengembalian<br/>
pada bagian depan
</div>
				</div>
				<div class="boxProses">
					<div class="text">STEP 3<br/>
Kirim ke warehouse<br/>
Lacigue dan tunggu<br/>
info pengembalian</div>
				</div>
			</div>

			<div class="borOrderCode after_clear">
				<div class="ordBox" style="width: 239px;">
					Order Code : <span>BDG1710171942356</span>
				</div>
				<div class="ordBox">
					Package : <span>MPDS-2626578</span>
					
				</div>
			</div>
			<div class="boxDetail after_clear">
				<div class="penerima">
					<div class="title_penerima">Pengirim :</div>
					<div class="alamat_penerima">
						Cinta Laura<br/>
						Jl. Soekarno Hatta 207A
						Kiaracondong, Bandung<br/>
						Jawa Barat<br/>
						Indonesia<br/>
						40285<br/><br/>

						085659061222
					</div>
				</div>
				<div class="penerima">
					<div class="title_penerima">Penerima :</div>
					<div class="alamat_penerima">
						LACIGUE INDONESIA<br/>
						Gedung Utaran<br/>
						Jl. Gegerkalong 255<br/>
						Baleendah<br/>
						Jakarta Pusat<br/>
						22684<br/><br/>

						085659061222
					</div>
				</div>
			</div>
			<div class="boxInfoPengembalian">
				<div class="label">Pastikan produk yang kamu ingin kembalikan memenuhi standar kebijakan ini:</div>
				<ul>
					<li>Pengembalian produk tidak berlaku untuk produk underwear, swimwear, produk beauty,<br/>
  anting, jam tangan dan kacamata.</li>
  					<li>Produk yang dikembalikan harus dalam kondisi yang sama saat diterima, hangtag dan label<br/>
  masih menempel, tidak pernah dicuci dan bersih</li>
  					<li>Pengembalian produk tidak lebih dari 7 hari.</li>
				</ul>
			</div>
			<div class="info_tempel">
				<span class="ico"></span>
				TEMPEL SLIP INI PADA PACKAGING
			</div>


			
		</div>
	</div>

</section>
<!-- SECTION 2 -->
<section class="invoice sec_barcode after_clear">
	<div class="invoiceInner">
		<div class="content after_clear">
			<div class="header_invoice after_clear">
				<div class="text"><img src="{{$basesite}}assets/frontend/images/material/lacigue_invoice.png"></div>
				<div class="logo"><img src="{{$basesite}}assets/frontend/images/material/logo_merchant.png"></div>
			</div>
			<div class="text_airway">AIR WAY BILL</div>

			<div class="boxBorderBarcode">
				<div class="barcodeReader after_clear">
					<div class="label">Package ID</div>
					<div class="barcodeScanner">
						<img src="{{$basesite}}assets/frontend/images/material/barcode_1.png">
					</div>
				</div>
				<div class="barcodeReader after_clear">
					<div class="label">Tracking ID</div>
					<div class="barcodeScanner">
						<img src="{{$basesite}}assets/frontend/images/material/barcode_2.png">
					</div>
				</div>
			</div>

			<div class="boxDetail after_clear">
				<div class="penerima" style="width: 240px;">
					<div class="title_penerima">Penerima :</div>
					<div class="alamat_penerima">
						Cinta Laura<br/>
						Jl. Soekarno Hatta 207A
						Kiaracondong, Bandung<br/>
						Jawa Barat<br/>
						Indonesia<br/>
						40285<br/><br/>

						085659061222
					</div>
				</div>
				<div class="detail_order" style="margin-left: 20px;">
					<table>
						<tr>
							<th style="width:30%;">Tanggal</th><th style="width: 5%">:</th><td>09 May 2017</td>
						</tr>
						<tr>
							<th>Order Code</th><th>:</th><td>BDG1710171942356</td>
						</tr>
					</table>
					<table style="margin-top: 30px;">
						<tr>
							<th style="width:40%;">Invoice</th><th style="width: 10%">:</th><td>2541</td>
						</tr>
						<tr>
							<th>Package</th><th>:</th><td>MPDS-2626578</td>
						</tr>
						<tr>
							<th>Payment Method</th><th>:</th><td>BCA VIRTUAL ACCOUNT</td>
						</tr>
					</table>
				</div>
			</div>

			
		</div>
	</div>

	<div class="invoiceInner">
		<div class="content after_clear">
			<div class="header_invoice after_clear">
				<div class="text"><img src="{{$basesite}}assets/frontend/images/material/lacigue_invoice.png"></div>
				<div class="logo"><img src="{{$basesite}}assets/frontend/images/material/logo_merchant.png"></div>
			</div>
			<div class="text_airway">AIR WAY BILL</div>

			<div class="boxBorderBarcode">
				<div class="barcodeReader after_clear">
					<div class="label">Package ID</div>
					<div class="barcodeScanner">
						<img src="{{$basesite}}assets/frontend/images/material/barcode_1.png">
					</div>
				</div>
				<div class="barcodeReader after_clear">
					<div class="label">Tracking ID</div>
					<div class="barcodeScanner">
						<img src="{{$basesite}}assets/frontend/images/material/barcode_2.png">
					</div>
				</div>
			</div>

			<div class="boxDetail after_clear">

				<div class="penerima" style="width: 240px;">
					<div class="title_penerima">Penerima :</div>
					<div class="alamat_penerima">
						Cinta Laura<br/>
						Jl. Soekarno Hatta 207A
						Kiaracondong, Bandung<br/>
						Jawa Barat<br/>
						Indonesia<br/>
						40285<br/><br/>

						085659061222
					</div>
				</div>
				<div class="detail_order" style="margin-left: 20px;">
					<table>
						<tr>
							<th style="width:30%;">Tanggal</th><th style="width: 5%">:</th><td>09 May 2017</td>
						</tr>
						<tr>
							<th>Order Code</th><th>:</th><td>BDG1710171942356</td>
						</tr>
					</table>
					<table style="margin-top: 30px;">
						<tr>
							<th style="width:40%;">Invoice</th><th style="width: 10%">:</th><td>2541</td>
						</tr>
						<tr>
							<th>Package</th><th>:</th><td>MPDS-2626578</td>
						</tr>
						<tr>
							<th>Payment Method</th><th>:</th><td>BCA VIRTUAL ACCOUNT</td>
						</tr>
					</table>
				</div>
			</div>

			
		</div>
	</div>

</section>

<table class="boxSign">
	<tr>
		<th>Kurir Pick Up</th>
		<th>Seller</th>
		<th>Kurir Pick Up</th>
		<th>Seller</th>
	</tr>
	<tr>
		<td>( Nama & Tanggal )</td>
		<td>( Nama & Tanggal )</td>
		<td>( Nama & Tanggal )</td>
		<td>( Nama & Tanggal )</td>
	</tr>
</table>


</body>