<div class="boxSaldo after_clear storecredit">
	<div class="inner">
		<div class="title">SALDO STORE KREDIT ANDA:</div>
		<div class="rp">{{$inv->_formatamount($CustomerData->StoreCredit, 'Rupiah', 'Rp. ')}}</div>
	</div>
	<div class="inner">
		<div class="list">{{$CustomerData->CountReferral}} teman sudah mendaftar,</div>
		<div class="list">{{$CustomerData->CountReferralTransaction}} teman sudah membeli barang</div>
	</div>
	<div class="box_syarat">
		<a href="{{$basesite}}affiliate#termsconditions" target="_blank" class="link_syarat">Persyaratan & Ketentuan</a>				
	</div>
</div>