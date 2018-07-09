<section class="general konfirmasi">
	<div class="wrapper">
		@if($OrderTransaction)
		<h1>KONFIRMASI PEMBAYARAN</h1>
		<div class="text" style="margin-left: 60px;margin-top: 60px;">
			<p style="text-align: left;margin-bottom: 40px;">
			<b>Terima kasih telah melakukan konfirmasi pembayaran.</b><br/>
			Proses verifikasi pembayaran akan memakan waktu maksimal 2 hari kerja. Silahkan <br/>
			melakukan pengecekan status pembayaran disini<br/></p>

			<p style="text-align: left;">
			Jika status pembayaran belum berubah diatas <b>2 hari kerja</b>, mohon menghubungi <br/>
			Customer Service kami di:<br/>
			No. Telp +62 22 751 4100. <br/>
			Senin - Jumat : 08.00-17.30 WIB
			</p>
		</div>

		<div class="boxRingkasan" style="margin: 60px 0 60px;">
			<h3 style="text-align: center;">RINGKASAN PESANAN ANDA</h3>
			<table class="tb_shop with_border_total">
				<thead>
					<tr>
						<th scope="col" style="width: 40%">DETAIL PRODUK</th>
						<th scope="col" class="th_qty" align="left" style="width: 20%">QTY</th>
						<th scope="col" align="left" style="width: 20%">HARGA</th>
					</tr>
				</thead>
				<tbody>
		@php $TotalTransactionProduct = 0; @endphp
		@php $TotalShippingPrice = 0; @endphp
		@foreach($OrderTransaction as $key1 => $val1)
			@foreach($val1['ListSeller'] as $key2 => $val2)
				@php $TotalPriceProductQty = 0; @endphp
				@foreach($val2['ListProduct'] as $key3 => $val3)
					<tr>
						<td class="td_produk" data-label="DETAIL PRODUK">
							<div class="boxTrack type_table">
								<div class="boxTrackInner after_clear">
									<div class="detail" style="padding-bottom: 0px;">
										<div class="detail_inner after_clear">
											<div class="det1">
												<img src="{{$basesite}}assets/frontend/images/content/product/medium_{{$val3['Image1']}}">
											</div>
											<div class="det1">
												<div class="name">{{strtoupper($val3['BrandName'])}}</div>
												<div class="desc">{{strtoupper($val3['Name'])}}</div>
												@php
													$ProductPrice = $val3['ProductPrice'];

													if($val1['CurrencyCode'] == 'IDR')
								                        $ProductPrice = $inv->_formatamount($ProductPrice, 'Rupiah', $val1['CurrencyCode'].' ');
								                    else
								                        $ProductPrice = $inv->_formatamount($ProductPrice, 'Dollar', $val1['CurrencyCode'].' ');
												@endphp
												<div class="price">{{$ProductPrice}}</div>
												<table class="other_det">
													<tr>
														<td style="width: 80px;">COLOR</td>
														<td>{{$val3['ColorName']}}</td>
													</tr>
													<tr>
														<td>SIZE</td>
														<td>{{$val3['SizeName']}}</td>
													</tr>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</td>
						<td data-label="QTY" align="left" style="vertical-align: top;">{{$val3['Qty']}}</td>
						@php
		                    $TotalPriceProductQty += $val3['ProductPrice'] * $val3['Qty'];

							if($val1['CurrencyCode'] == 'IDR')
		                        $tmpTotalPriceProductQty = $inv->_formatamount($TotalPriceProductQty, 'Rupiah', $val1['CurrencyCode'].' ');
		                    else
		                        $tmpTotalPriceProductQty = $inv->_formatamount($TotalPriceProductQty, 'Dollar', $val1['CurrencyCode'].' ');
						@endphp
						<td data-label="HARGA" align="left" style="vertical-align: top;">{{$tmpTotalPriceProductQty}}</td>
					</tr>
					@if($val3['ShippingPrice'])
						@php
		                    $TotalTransactionProduct += $TotalPriceProductQty;
		                    $TotalShippingPrice += $val3['ShippingPrice'];
						@endphp
					@endif
				@endforeach
			@endforeach
		@endforeach
					<tr class="border_double">
						<td colspan="3" style="margin: 0; padding: 0;"></td>
					</tr>
					<tr class="total_bot">
						<th style=""></th>
						<th align="left" style="">TOTAL</th>
						@php
							if($val1['CurrencyCode'] == 'IDR')
		                        $TotalTransactionProduct = $inv->_formatamount($TotalTransactionProduct, 'Rupiah', $val1['CurrencyCode'].' ');
		                    else
		                        $TotalTransactionProduct = $inv->_formatamount($TotalTransactionProduct, 'Dollar', $val1['CurrencyCode'].' ');
						@endphp
						<th align="left" style="">{{$TotalTransactionProduct}}</th>
					</tr>
					<tr class="total_bot">
						<th></th>
						<th align="left">BIAYA KIRIM</th>
						@php
							if($val1['CurrencyCode'] == 'IDR')
		                        $TotalShippingPrice = $inv->_formatamount($TotalShippingPrice, 'Rupiah', $val1['CurrencyCode'].' ');
		                    else
		                        $TotalShippingPrice = $inv->_formatamount($TotalShippingPrice, 'Dollar', $val1['CurrencyCode'].' ');
						@endphp
						<th align="left">{{$TotalShippingPrice}}</th>
					</tr>
					<tr class="total_bot">
						<th></th>
						<th align="left">JUMLAH TOTAL</th>
						@php
							$GrandTotal = $val1['GrandTotal'];
							if($val1['Type'] == 0) $GrandTotal = $val1['GrandTotalUnique'];

							if($val1['CurrencyCode'] == 'IDR')
		                        $GrandTotal = $inv->_formatamount($GrandTotal, 'Rupiah', $val1['CurrencyCode'].' ');
		                    else
		                        $GrandTotal = $inv->_formatamount($GrandTotal, 'Dollar', $val1['CurrencyCode'].' ');
						@endphp
						<th align="left">{{$GrandTotal}}</th>
					</tr>
				</tbody>
			</table>
		</div>
		@else
		<h1>KONFIRMASI PEMBAYARAN</h1>
		<p style="text-align: center;margin-bottom: 40px;">Terima kasih telah berbelanja di Lacigue<br/>Bila Anda telah melakukan pembayaran secara <b>BANK TRANSFER</b>,<br/>konfirmasikan pembayaran Anda disini agar dapat kami proses segera</p>
		<div class="boxForm" style="width: 600px;">
			<form method="post" class="form-horizontal" enctype="multipart/form-data">
				{{csrf_field()}}
			    <div class="form-group w2">
					<label class="control-label " for="TransactionCode">No Order *</label>
					<div class="control-input">
						<input type="text" class="form-control" id="TransactionCode" name="TransactionCode" value="{{$TransactionCode}}">
						<span class="info">
							<a href="javascript:openPopup('popup-order-info')">Apa itu No.Order?</a>
						</span>
						@if($errorTransactionCode)
						<script type="text/javascript">$('[name="TransactionCode"]').attr('style', 'border: 1px solid red');</script>
						<div style="padding-top: 5px; margin-bottom: -15px !important; color:red;">{{$errorTransactionCode}}</div>
						@endif
					</div>
			    </div>
			    <div class="form-group w2">
					<label class="control-label " for="BankName">Bank Anda *</label>
					<div class="control-input">
						<input type="text" class="form-control" id="BankName" name="BankName" value="{{$BankName}}">
						@if($errorBankName)
						<script type="text/javascript">$('[name="BankName"]').attr('style', 'border: 1px solid red');</script>
						<div style="padding-top: 5px; margin-bottom: -15px !important; color:red;">{{$errorBankName}}</div>
						@endif
					</div>
			    </div>
			    <div class="form-group w2">
					<label class="control-label " for="BankBeneficiaryName">Rekening Atas Nama *</label>
					<div class="control-input">
						<input type="text" class="form-control" id="BankBeneficiaryName" name="BankBeneficiaryName" value="{{$BankBeneficiaryName}}">
						<span class="info ico tooltip" data-tooltip-content="#tooltip-an" data-tooltipster='{"side":"right","animation":"fade","maxWidth":"160", "trigger": "click", "theme": ["tooltipster-noir","tooltipster-noir-customized"]}'></span>
						<div class="tooltip-template">
							<div id="tooltip-an">
								<p style="font-size: 12px;">
									Nama pemilik rekening yang mengirim
								</p>
							</div>
						</div>
						@if($errorBankBeneficiaryName)
						<script type="text/javascript">$('[name="BankBeneficiaryName"]').attr('style', 'border: 1px solid red');</script>
						<div style="padding-top: 5px; margin-bottom: -15px !important; color:red;">{{$errorBankBeneficiaryName}}</div>
						@endif
		      		</div>
			    </div>
			    <div class="form-group w2">
					<label class="control-label " for="Total">Nominal Transfer *</label>
					<div class="control-input">
			        	<input type="text" class="form-control numberonly" id="Total" name="Total" value="{{$Total}}">
						<span class="info ico tooltip" data-tooltip-content="#tooltip-nominal" data-tooltipster='{"side":"right","animation":"fade","maxWidth":"170", "trigger": "click", "theme": ["tooltipster-noir","tooltipster-noir-customized"]}'></span>
						<div class="tooltip-template">
							<div id="tooltip-nominal">
								<p style="font-size: 12px;">
									Jumlah pembayaran yang Anda kirim/transfer
								</p>
							</div>
						</div>
						@if($errorTotal)
						<script type="text/javascript">$('[name="Total"]').attr('style', 'border: 1px solid red');</script>
						<div style="padding-top: 5px; margin-bottom: -15px !important; color:red;">{{$errorTotal}}</div>
						@endif
					</div>
			    </div>
			    <div class="form-group w2">
					<label class="control-label " for="TransferDate">Tanggal Transfer *</label>
					<div class="control-input">          
						<input type="text" class="form-control date_range" id="TransferDate" name="TransferDate" value="{{$TransferDate}}" placeholder="Choose specific date">
						<input type="hidden" name="start_date" id="start_date">
						@if($errorTransferDate)
						<script type="text/javascript">$('[name="TransferDate"]').attr('style', 'border: 1px solid red');</script>
						<div style="padding-top: 5px; margin-bottom: -15px !important; color:red;">{{$errorTransferDate}}</div>
						@endif
					</div>
			    </div>
			    <div class="form-group w2">
					<label class="control-label " for="BankID">Bank Tujuan *</label>
					<div class="control-input">
						<select class="select2" id="BankID" name="BankID">
							@foreach($OurBank as $val)
							<option value="{{$val['ID']}}" @if($BankID == $val['ID']) selected @endif >{{$val['BankName']}}</option>
							@endforeach
						</select>
						@if($errorBankID)
						<script type="text/javascript">$('[name="BankID"]').attr('style', 'border: 1px solid red');</script>
						<div style="padding-top: 5px; margin-bottom: -15px !important; color:red;">{{$errorBankID}}</div>
						@endif
					</div>
			    </div>
			    <div class="form-group w2">
					<label class="control-label " for="ImageTransfer">Upload Bukti Transfer</label>
					<div class="control-input">
						<div class="boxFile">
							<input type="file" class="form-control" id="ImageTransfer" name="ImageTransfer">
							<a class="btn_file" data-id="ImageTransfer">PILIH FILE</a>
						</div>
						@if($errorImageTransfer)
						<script type="text/javascript">$('[name="ImageTransfer"]').attr('style', 'border: 1px solid red');</script>
						<div style="padding-top: 5px; margin-bottom: -15px !important; color:red;">{{$errorImageTransfer}}</div>
						@endif
					</div>
			    </div>
			    <div style="margin:60px 0px;" class="info_pertanyaan">
			    	<p >Pertanyaan atau Masalah? +62 22 751 4100. <br/>Senin - Jumat : 08.00-17.30 WIB</p>
			    </div>
			    <div class="form-group">        
					<div class="boxButton" style="margin-left: 226px;">
						<button type="submit" name="submit" class="btn medium black" style="height:50px;line-height: 50px; ">KONFIRMASI</button>
					</div>
			    </div>
			</form>			
		</div>
		@endif
	</div>
</section>

<div class="wrap-popup" id="popup-order-info">
    <div class="overlay-pop2"></div>
    <div class="box-popup type_2 konfirmasi_pembayaran">
    	<div class="title">Nomor Order / Nomor Pesanan
    		<span class="closepop">x</span>
    	</div>
    	<div class="content" style="height: 210px;">
			<p style="text-align: center;">
				Nomor Order / Nomor Pesanan terdiri dari 16 digit nomor<br/>
				yang Anda terima ketika Anda mengkonfirmasi pesanan Anda.<br/><br/>
				<b style="margin-top: 10px;">CONTOH : EMRKAG1509134417</b>				
			</p>
			<p style="text-align: center;">
				Anda menemukan ID Pesanan Anda<br/>
				di email Anda (dikirim secara otomatis setelah pesanan konfirmasi)<br/>
			</p>
			<p style="text-align: center;">
				Jika anda memiliki kesulitan menemukannya silahkan <br/>
				hubungi kami. <a href="{{$basesite}}contact" target="_blank">DISINI</a>
			</p>
		</div>
    </div>
</div>

<script type="text/javascript">
	// daterangepicker dropdown-menu  ltr show-calendar opensright
	// daterangepicker dropdown-menu ltr show-calendar opensright
	$('.date_range').daterangepicker({
		singleDatePicker: true,
	    showDropdowns: true,
		locale: {
			format: 'ddd, DD MMM YYYY',
	    },
	});

	$('.date_range').on('apply.daterangepicker', function(ev, picker) {
		$("#start_date").val(picker.startDate.format('YYYY-MM-DD'));
	});

	$(".boxFile").on("click", ".btn_file", function() {
		var $id = $(this).attr("data-id");
		
	    $("#"+$id).click();
	});
</script>