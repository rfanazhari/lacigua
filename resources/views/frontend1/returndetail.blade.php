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
			<div class="title">Rincian Pesanan</div>
			@foreach($OrderTransaction as $key1 => $val1)
			<form method="post">
				<div class="desc">PESANAN {{$val1['TransactionCode']}}</div>
				{{csrf_field()}}
				<input type="text" name="TransactionCode" value="{{$val1['TransactionCode']}}" style="display: none;">
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
								<input id="listsize{{$val2['ID']}}" name="listsize{{$val2['ID']}}" value="{{$val2['ListSize']}}" type="text" style="display: none;">
								<input id="currentsize{{$val2['ID']}}" name="currentsize{{$val2['ID']}}" value="{{$val2['SizeVariantID']}}" type="text" style="display: none;">
								<input id="retur{{$val2['ID']}}" class="checkbox-custom" name="retur[]" value="{{$val2['ID']}}" type="checkbox" @if(!$val2['FeedbackDate'] || ($val2['TotalReturnQty']==$val2['Qty'])) disabled @endif @if(count($retur) && in_array($val2['ID'], $retur)) checked @endif onchange="ChangeReturn('{{$val2['ID']}}')">
					            <label for="retur{{$val2['ID']}}" class="checkbox-custom-label">
					            	<span class="img"></span>
					            	<div style="font-size: 22px;margin-top: 10px; @if(!$val2['FeedbackDate'] || ($val2['TotalReturnQty']==$val2['Qty'])) color:#c1c1c1; @endif">Retur</div>
					        	</label>
						    </div>
							<div class="desc" @if(!$val2['FeedbackDate'] || ($val2['TotalReturnQty']==$val2['Qty'])) style="color:#c1c1c1;" @endif>Alasan Pengembalian</div>
							<div class="form-group">
								<div class="control-input">
								<select name="reason[{{$val2['ID']}}]" @if(!$val2['FeedbackDate'] || ($val2['TotalReturnQty']==$val2['Qty'])) disabled style="color:#c1c1c1; border: 1px solid #c1c1c1;" @endif @if(isset($errorreason[$val2['ID']])) class="{{$errorreason[$val2['ID']]}}" @endif onchange="ChangeReturn('{{$val2['ID']}}')">
									<option value="0">Pilih Alasan Pengembalian</option>
									<option value="1" @if(isset($reason[$val2['ID']]) && $reason[$val2['ID']] == 1) selected @endif>Kebesaran / Kekecilan</option>
									<option value="2" @if(isset($reason[$val2['ID']]) && $reason[$val2['ID']] == 2) selected @endif>Cacat</option>
								</select>
								</div>
							</div>					
							<div class="desc" @if(!$val2['FeedbackDate'] || ($val2['TotalReturnQty']==$val2['Qty'])) style="color:#c1c1c1;" @endif>Solusi Pengembalian</div>
							<div class="form-group">
								<div class="control-input">
								<select name="solution[{{$val2['ID']}}]" @if(!$val2['FeedbackDate'] || ($val2['TotalReturnQty']==$val2['Qty'])) disabled style="color:#c1c1c1; border: 1px solid #c1c1c1;" @endif @if(isset($errorsolution[$val2['ID']])) class="{{$errorsolution[$val2['ID']]}}" @endif onchange="ChangeReturn('{{$val2['ID']}}')">
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
					<div id="ResponReturn{{$val2['ID']}}" class="boxDescription" style="width: 100%; display: none;">
						<div class="judul"><span id="ReasonReturn{{$val2['ID']}}"></span></div>
						<div id="ReturnBroken{{$val2['ID']}}"></div>
						<div class="desc" id="ReturnSolution{{$val2['ID']}}"></div>
						<div class="desc2" id="ReturnDesc{{$val2['ID']}}"></div>
						<div id="ReturnNewProduct{{$val2['ID']}}"></div>
						<div id="ReturnSize{{$val2['ID']}}"></div>
					</div>
				</div>
				@endforeach
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
	var listdesc = {
		1 : 'Produk pengganti akan dikirimkan 1 - 2 hari terhitung sejak produk yang dikembalikan sampai di gudang kami',
		2 : 'Produk pengganti akan dikirimkan 1 - 2 hari terhitung sejak produk yang dikembalikan sampai di gudang kami',
		3 : 'Dana akan dikembalikan melalui Store Kredit kamu dalam waktu 2 - 4 hari kerja terhitung sejak produk lolos quality control'
	};

	function ChangeReturn(obj) {
		var reasontext = $('[name="reason['+obj+']"] option:selected');
		var solutiontext = $('[name="solution['+obj+']"] option:selected');

		if($('#retur'+obj).is(':checked') && reasontext.val() != 0 && solutiontext.val() != 0) {
			if(solutiontext.val() == 1) {
				var listsizeselectid = '';
				var listsizeselect = '';
				var listsizetext = '';
				var listsize = $('#listsize'+obj).val();
				listsize = listsize.split(',');
				$.each(listsize, function( index, value ) {
					var value = value.split('-');
					if(index == 0) {
						listsizeselectid = value[0];
						listsizeselect = 'class="active"';
					} else listsizeselect = '';
					
					if(value[0] != $('#currentsize'+obj).val())
						listsizetext = listsizetext + '<li><a href="javascript:void(0)" data-size="'+value[0]+'" '+listsizeselect+'>'+value[1]+'</a></li>';
				});

				listsizetext = listsizetext + '<input type="hidden" name="NewSizeID'+obj+'" id="size" value="'+listsizeselectid+'">';

				NextReturn(obj, listsizetext);
			} else {
				NextReturn(obj);
			}
		} else $('#ResponReturn'+obj).fadeOut();
	}

	function NextReturn(obj, listsize = '') {
		var reasontext = $('[name="reason['+obj+']"] option:selected');
		var solutiontext = $('[name="solution['+obj+']"] option:selected');

		$('#ReasonReturn'+obj).html(reasontext.text());
		$('#ReturnSolution'+obj).html(solutiontext.text());
		$('#ReturnDesc'+obj).html(listdesc[solutiontext.val()]);

		var returnbroken = '';

		if(reasontext.val() == 2) {
			returnbroken = '<div class="desc">Upload bagian barang yang cacat</div>' +
							'<div class="boxForm" style="margin-left: 0px;">' +
								'<div class="form-group">' +
									'<div class="control-input">' +
										'<div class="boxFile boxFileNew'+obj+'">' +
									        '<input type="file" class="form-control" id="ImageBroken'+obj+'" name="ImageBroken'+obj+'">' +
									        '<a class="btn_file" data-id="ImageBroken'+obj+'">Choose File</a>' +
									        '<div class="file_return">File not chosen</div>' +
								      	'</div>' +
							      	'</div>' +
								'</div>' +
							'</div>';
		}

		$('#ReturnBroken'+obj).html(returnbroken);

		var newproduct = '';

		if(solutiontext.val() == 2) {
			newproduct = '<div class="desc">Masukkan kode produk lain <input type="text" class="form-control" name="NewProductID'+obj+'"></div>';
		}
		
		$('#ReturnNewProduct'+obj).html(newproduct);

		var newsize = '';

		if((reasontext.val() != 2 && solutiontext.val() != 3) || (reasontext.val() == 2 && solutiontext.val() == 2)) {
			newsize = '<div class="desc">Pilih size yang diinginkan</div>' +
					'<ul class="circle_size circlesize'+obj+' after_clear">' +
						listsize +
					'</ul>';
		}
		
		$('#ReturnSize'+obj).html(newsize);

		$(".circlesize"+obj).on("click","li a", function() {
			var $size = $(this).attr("data-size");

			$(".circlesize"+obj+" li a").removeClass("active");

			if(!$(this).hasClass("active")) {
				$("#size").val($size);
				$(this).addClass("active");
			} else {
				$(this).removeClass("active");
			}
		});

		$(".boxFileNew"+obj).on("click", ".btn_file", function() {
			var $id = $(this).attr("data-id");

			$("#"+$id).click();
			$("#"+$id).change(function() {
		        var filename = $("#"+$id).val();
		        $('.file_return').html(filename);
		    });
	    });

		$('#ResponReturn'+obj).fadeIn();
	}
	$(document).ready(function() {
		@if($Message) _alertvalidation('{{$Message}}'); @endif
	});
</script>