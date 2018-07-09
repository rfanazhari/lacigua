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
	section.akun_profile p{
		margin-bottom: 20px;
	}
	section.akun_profile .boxOrder .menuOrder ul li
	{
		margin: 0px;
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
	.tbaddress {
		height: 25px;
	    font-family: "robotoreguler";
	    font-size: 15px;
	    color: #111111;
	}
	.tbaddress tr {
		height: 25px;
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
						<div></div>
						<div>
							<div class="boxOrder menu_pembayaran">
								<div class="menuOrder after_clear">
									<ul class="after_clear">
										<li><a href="{{$basesite}}order" data-id="content_bayar" @if(!isset($getaction)) class="active" @endif >Pembayaran</a></li>
										<li><a href="{{$basesite}}order/action_ordering" data-id="content_pesan" @if(isset($getaction) && $getaction == 'ordering') class="active" @endif >Pemesanan</a></li>
										<li><a href="{{$basesite}}order/action_feedback" data-id="content_feedback" @if(isset($getaction) && $getaction == 'feedback') class="active" @endif >Feedback</a></li>
										<li><a href="{{$basesite}}order/action_history" data-id="content_history" @if(isset($getaction) && $getaction == 'history') class="active" @endif >History Order</a></li>
									</ul>
								</div>
								<div class="contentDynamic">
									<div id="content_bayar" class="content_dynamic pembayaran" @if(!isset($getaction)) style="display: inherit;" @else style="display: none;" @endif >
										@if(!isset($getaction)) @include('frontend1.content_bayar') @endif
									</div>
									<div id="content_pesan" class="content_dynamic pemesanan" @if(isset($getaction) && $getaction == 'ordering') style="display: inherit;" @else style="display: none;" @endif >
										@if(isset($getaction) && $getaction == 'ordering') @include('frontend1.content_pesan') @endif
									</div>
									<div id="content_feedback" class="content_dynamic feedback" @if(isset($getaction) && $getaction == 'feedback') style="display: inherit;" @else style="display: none;" @endif >
										@if(isset($getaction) && $getaction == 'feedback') @include('frontend1.content_feedback') @endif
									</div>
									<div id="content_history" class="content_dynamic pembayaran" @if(isset($getaction) && $getaction == 'history') style="display: inherit;" @else style="display: none;" @endif >
										@if(isset($getaction) && $getaction == 'history') @include('frontend1.content_history') @endif
									</div>
								</div>
							</div>
						</div>
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
    function CancelTransaction(ID) {
    	$('#popup .titlenew').contents()[0].nodeValue = 'Remove ?';

		var contentnew = 
		'<div class="boxFormInline register after_clear" style="width: 100%; margin-top: 0px;"><div class="form-group">' +
			'<div class="control-label colorred">Anda yakin akan menghapus ?</div>' +
		'</div>' +
	    '<div class="form-group">' +
			'<button id="btnok" class="btn black" style="top: auto;">OK</button> <button id="btncancel" class="btn white" style="top: auto;">Cancel</button>' +
		'</div></div>';

		$('#popup .contentnew').css('height', 'auto');
		$('#popup .contentnew').html(contentnew);

		openPopup('popup');

		$("#btnok").on('click', function() {
			$.ajax({
	            url         : '{{$basesite}}order/ajaxpost',
	            type        : 'POST',
	            data        : {'ajaxpost':"CancelTransaction",'_token':'{{csrf_token()}}','ID':ID},
	            success     : function(data) {
	                var data = JSON.parse(data);
	                if(data['response'] == 'OK') {
	                	$('[id^='+ID+']').remove();
	                	var checkpembayaran = $('#checkpembayaran').html().trim();
	                	if(!checkpembayaran)
	                		$('#checkpembayaran').html('<div width="100%" style="text-align: center;"><h4 style="color:red">Anda tidak memiliki pembayaran yang sedang berlangsung.</h4></div>');
	                	closePopup('popup');
	                } else {
	            		var messageerror = '';
	            		$.each(data['data']['error'], function(keys, vals) {
							messageerror = messageerror + '<div class="control-label"><span class="colorred">*</span> '+vals+'</div>';
						});
				    	_alertvalidation(messageerror);
	                }
	            }
	        });
		});

		$("#btncancel").on('click', function() { closePopup('popup'); });
	}
</script>