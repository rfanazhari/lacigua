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
						<div></div>
						<div></div>
						<div>
							<div class="boxOrder menu_pembayaran">
								<div class="menuOrder after_clear">
									<ul class="after_clear">
										<li><a href="{{$basesite}}wallet" data-id="content_store_credit" @if(!isset($getaction)) class="active" @endif >STORE KREDIT</a></li>
										<li><a href="{{$basesite}}wallet/action_voucher" data-id="content_voucher" @if(isset($getaction) && $getaction == 'voucher') class="active" @endif >VOUCHER</a></li>
										<li><a href="{{$basesite}}wallet/action_points" data-id="content_points" @if(isset($getaction) && $getaction == 'points') class="active" @endif >MY POINTS</a></li>
									</ul>
								</div>
								<div class="contentDynamic">
									<div id="content_store_credit" class="content_dynamic" @if(!isset($getaction)) style="display: inherit;" @else style="display: none;" @endif >
										@if(!isset($getaction)) @include('frontend1.content_store_credit') @endif
									</div>
									<div id="content_voucher" class="content_dynamic" @if(isset($getaction) && $getaction == 'voucher') style="display: inherit;" @else style="display: none;" @endif >
										@if(isset($getaction) && $getaction == 'voucher') @include('frontend1.content_voucher') @endif
									</div>
									<div id="content_points" class="content_dynamic" @if(isset($getaction) && $getaction == 'points') style="display: inherit;" @else style="display: none;" @endif >
										@if(isset($getaction) && $getaction == 'points') @include('frontend1.content_points') @endif
									</div>
								</div>
							</div>
						</div>
						<div></div>
						<div></div>
					</div>
				</div>
			</div>
		</section>
	</div>	
</section>
<script type="text/javascript">
$(document).ready(function() {
	
});
</script>