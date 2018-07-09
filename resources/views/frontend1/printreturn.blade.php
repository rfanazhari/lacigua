<!DOCTYPE html>
<html>
    <head>
        <title>Print Retur {{$getcode}}</title>
        <link rel="icon" href="favicon.ico">
        <link rel="stylesheet" href="{{$basesite}}assets/frontend/css/reset.css">
        <link rel="stylesheet" href="{{$basesite}}assets/frontend/css/style.css">
    </head>
    <style type="text/css">
        @page { 
            size: auto;
            margin: 0mm 0mm 0mm 0mm;  
        } 
        @media print {
        body {-webkit-print-color-adjust: exact;}
        }
    </style>
    <body>
        <section class="invoice inv-2 after_clear">
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
                            <div class="text">
                                STEP 1<br/>
                                Masuk ke akun kamu di <br/>
                                Lacigue.com, kemudian pilih <br/>
                                ‘My Return’, lalu pilih produk <br/>
                                dan alasan pengembalian.
                            </div>
                        </div>
                        <div class="boxProses">
                            <div class="text">
                                STEP 2<br/>
                                Kemas produk dan tempel<br/>
                                slip pengembalian<br/>
                                pada bagian depan
                            </div>
                        </div>
                        <div class="boxProses">
                            <div class="text">
                                STEP 3<br/>
                                Kirim ke warehouse<br/>
                                Lacigue dan tunggu<br/>
                                info pengembalian
                            </div>
                        </div>
                    </div>
                    <div class="borOrderCode after_clear">
                        <div class="ordBox">
                            Return Code : <span>BDG1710171942356</span>
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
                            <li>Pengembalian produk tidak berlaku untuk produk underwear, swimwear, produk beauty,<br/>anting, jam tangan dan kacamata.</li>
                            <li>Produk yang dikembalikan harus dalam kondisi yang sama saat diterima, hangtag dan label<br/>masih menempel, tidak pernah dicuci dan bersih</li>
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
    </body>
</html>