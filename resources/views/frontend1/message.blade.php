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
	#tabs ul{
		background-color: white;
		border:none;
	}
	#tabs ul li{
		border:none;
		background-color: white;
		color:grey;
	}
	#tabs ul li:active{
		color: lightgrey;
	}
	#tabs ul li:hover{
		color: lightgrey;
	}
	.ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited{
		color:black;
		border:none;
		border-top: 1px solid lightgrey;
		border-left: 1px solid lightgrey;
		border-right: 1px solid lightgrey;
	}
	#chat #info{
		z-index: 999 !important;
	}
	#chat{
		border-right: 1px solid lightgrey !important;
	}
	.pesan{
		float: left;
		width: 25%;
		height: 500px;
		padding:10px;
		border-right: 1px solid lightgrey !important;
		overflow-y: auto;
	}
	.isi{
		float: left;
		width: 73%;
		height: 500px;
	}
	.cari{
		border:1px solid lightgrey;
		font-style: italic;
	}
	#form button{
		background-color: white;
		border: none;
		position: absolute;
		height: 35px;
		width:35px;
		right: 10px;
		top: 4px;
	}
	.person{
		margin-top: 20px;
		padding-left: 10px;
		padding-right: 10px;
	}
	.person h5{
		margin-top: 10px;
		margin-bottom: 10px;
		color: #898989;
	}
	.person span{
		color:#c1c1c1;
	}
	.person hr{
		margin-top: 30px;
		margin-bottom: 30px !important;
		border:0.4px solid #c1c1c1; 
		margin-left: 0px;
	}
	.isi_header{
		border-bottom: 1px solid lightgrey;
		padding:20px;
	}
	.logo{
		float: left;
	}
	.logo h2{
		margin-bottom: 10px;
	}
	.jam{
		float: right;
		text-align: right;
	}
	.jam a{
		margin-top:10px;
		border: 1px solid lightgrey;
	}
	.isi_pesan{
		padding: 20px; 
		overflow-y: auto;
		height: 300px;
	}
	.own{
		width: 50%;
		text-align: left;
	}
	.you{
		width: 50%;
		float: right;
		text-align: right;
	}
	.own h4{
		margin-bottom: 10px;
	}
	.own p{
		background-color: lightgrey;
		padding:15px;
		margin-top:10px;
		border-top-right-radius: 20px;
		border-bottom-left-radius: 20px;
		border-bottom-right-radius: 20px;
	}
	section.akun_profile p{
		margin-bottom: 20px;
	}
	.own span{
		position: relative;
		top: -10px;
	}
	.you p{
		background-color: #ffd3d3;
		padding:15px;
		margin-top:10px;
		border-top-left-radius: 20px;
		border-bottom-left-radius: 20px;
		border-bottom-right-radius: 20px;
	}
	.you h4{
		margin-bottom: 20px;
	}
	.you span{
		position: relative;
		top: -10px;
	}
	.ketikan input{
		height: 37px;
		width: 800px;
		margin:0px;
		margin-left: -10px;
		margin-top: -10px;
		border: 1px solid lightgrey;
		text-align: right;
	}
	.ketikan img{
		float: right;
		height: 59px;
		width: 30px;
		margin-top: -10px;
		margin-right: -15px;	
	}
	.isi_ketikan{
		clear: both;
		border-top: 1px solid lightgrey;
		padding:20px;
		position: relative;
		bottom: 0px;
	}
	#style-1::-webkit-scrollbar-track
	{
		border-radius: 10px;
		background-color: #fff;
	}
	#style-1::-webkit-scrollbar
	{
		width: 3px;
		background-color: #fff;
	}
	#style-1::-webkit-scrollbar-thumb
	{
		border-radius: 10px;
		background-color: lightgrey;
	}
	section.akun_profile .boxAccount .boxAccounWidget .boxKotakAccount .boxAlamat {
		width: 100%;
	}
	section.akun_profile .boxAccount .boxAccounWidget .boxKotakAccount .boxAlamat .text p {
		width:250px;
		float:left;
	}
	section.akun_profile .boxAccount .boxAccounWidget .boxKotakAccount .boxAlamat .text p + p {
		padding-left: 70px;
	}
	.SetFirstAddress {
		font-size: 11px;
		margin: 0;
		color: red;
		font-weight: normal;
	}
	.SetFirstAddress:hover {
		text-decoration: none;
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
						<div></div>
						<div>
							<div class="boxOrder Pesan">
								<div id="tabs">
									<form action="" id="form" style="float: right;">
										<input type="text" class="cari" placeholder="Search Message">
										<button type="submit">
											<img class="button_cari" src="{{$basesite}}assets/frontend/images/material/pencarian.png">
										</button>
									</form>
									<ul>
										<li><a href="#chat">Seller Chat</a></li>
										<li><a href="#info">Lacigue Info</a></li>
									</ul>
									<div id="chat">
										<div id="style-1" class="pesan">
											<div class="person">
												<h2>Logo Jeans</h2>
												<h5>Awesome Navy Tee</h5>
												<span>
													Pesanan Kamu akan di proses besok
												</span>
												<hr>
											</div>

											<div class="person">
												<h2>Logo Jeans</h2>
												<h5>Awesome Navy Tee</h5>
												<span>
													Pesanan Kamu akan di proses besok
												</span>
												<hr>
											</div>

											<div class="person">
												<h2>Logo Jeans</h2>
												<h5>Awesome Navy Tee</h5>
												<span>
													Pesanan Kamu akan di proses besok
												</span>
												<hr>
											</div>

											<div class="person">
												<h2>Logo Jeans</h2>
												<h5>Awesome Navy Tee</h5>
												<span>
													Pesanan Kamu akan di proses besok
												</span>
												<hr>
											</div>
											
											<div class="person">
												<h2>Logo Jeans</h2>
												<h5>Awesome Navy Tee</h5>
												<span>
													Pesanan Kamu akan di proses besok
												</span>
												<hr>
											</div>

											<div class="person">
												<h2>Logo Jeans</h2>
												<h5>Awesome Navy Tee</h5>
												<span>
													Pesanan Kamu akan di proses besok
												</span>
												<hr>
											</div>
										</div>
										<div class="isi">
											<div class="isi_header">
												<div class="logo">
													<h2>Logo Jeans</h2>
													<span>Awesome Navy Themes</span>
												</div>
												<div class="jam">
													<span>
														Terakhir online 8/11/2017
													</span>
													<br>
													<a class="btn btn-default" href="">Visit Label</a>
												</div>
												<div style="clear: both;"></div>
											</div>
											<div class="isi_pesan" id="style-1">
												<div class="own">
													<h4>
														Logo Jeans
													</h4>
													<p class="chat_own">
														Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat, veritatis, quas qui dolore impedit praesentium, suscipit voluptatem perferendis velit corporis dignissimos sequi ex nesciunt harum obcaecati magnam corrupti temporibus nemo.
													</p>
													<span>
														01:01 WIB
													</span>
												</div>
												<div class="you">
													<h4>
														Cinta Laura
													</h4>
													<p class="chat_you">
														Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat, veritatis, quas qui dolore impedit praesentium, suscipit voluptatem perferendis velit corporis dignissimos sequi ex nesciunt harum obcaecati magnam corrupti temporibus nemo.
													</p>
													<p>
														Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat, veritatis, quas qui dolore impedit praesentium, suscipit voluptatem perferendis velit corporis dignissimos sequi ex nesciunt harum obcaecati magnam corrupti temporibus nemo.
													</p>
													<span>
														01:01 WIB
													</span>
												</div>
											</div>
											<div class="isi_ketikan">
												<div class="ketikan">
													<input type="text" name="" id="">
													<img class="button_cari" src="{{$basesite}}assets/frontend/images/material/cursor.png">
												</div>
												<div style="clear: both;"></div>
											</div>
										</div>
									</div>
									<div id="info">
										<div id="style-1" class="pesan">
											<div class="person">
												<h2>Lacigue Admin</h2>
												<h5>Awesome Navy Tee</h5>
												<span>
													Pesanan Kamu akan di proses besok
												</span>
												<hr>
											</div>

											<div class="person">
												<h2>Lacigue Admin</h2>
												<h5>Awesome Navy Tee</h5>
												<span>
													Pesanan Kamu akan di proses besok
												</span>
												<hr>
											</div>

											<div class="person">
												<h2>Lacigue Admin</h2>
												<h5>Awesome Navy Tee</h5>
												<span>
													Pesanan Kamu akan di proses besok
												</span>
												<hr>
											</div>

											<div class="person">
												<h2>Lacigue Admin</h2>
												<h5>Awesome Navy Tee</h5>
												<span>
													Pesanan Kamu akan di proses besok
												</span>
												<hr>
												<hr>
											</div>
											
											<div class="person">
												<h2>Lacigue Admin</h2>
												<h5>Awesome Navy Tee</h5>
												<span>
													Pesanan Kamu akan di proses besok
												</span>
												<hr>
											</div>

											<div class="person">
												<h2>Lacigue Admin</h2>
												<h5>Awesome Navy Tee</h5>
												<span>
													Pesanan Kamu akan di proses besok
												</span>
												<hr>
											</div>
										</div>
										<div class="isi">
											<div class="isi_header">
												<div class="logo">
													<h2>Lacigue Admin</h2>
													<span>Awesome Navy Themes</span>
												</div>
												<div class="jam">
													<span>
														Terakhir online 8/11/2017
													</span>
													<br>
													<a class="btn btn-default" href="">Visit Label</a>
												</div>
												<div style="clear: both;"></div>
											</div>
											<div class="isi_pesan" id="style-1">
												<div class="own">
													<h4>
														Lacigue Admin
													</h4>
													<p class="chat_own">
														Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat, veritatis, quas qui dolore impedit praesentium, suscipit voluptatem perferendis velit corporis dignissimos sequi ex nesciunt harum obcaecati magnam corrupti temporibus nemo.
													</p>
													<span>
														01:01 WIB
													</span>
												</div>
												<div class="you">
													<h4>
														Cinta Laura
													</h4>
													<p class="chat_you">
														Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat, veritatis, quas qui dolore impedit praesentium, suscipit voluptatem perferendis velit corporis dignissimos sequi ex nesciunt harum obcaecati magnam corrupti temporibus nemo.
													</p>
													<p>
														Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat, veritatis, quas qui dolore impedit praesentium, suscipit voluptatem perferendis velit corporis dignissimos sequi ex nesciunt harum obcaecati magnam corrupti temporibus nemo.
													</p>
													<span>
														01:01 WIB
													</span>
												</div>
											</div>
											<div class="isi_ketikan">
												<div class="ketikan">
													<input type="text" name="" id="">
													<img class="button_cari" src="{{$basesite}}assets/frontend/images/material/cursor.png">
												</div>
												<div style="clear: both;"></div>
											</div>
										</div>
									</div>
								</div>
							</div><!--BOX ORDER-->
						</div>
						<div></div>
					</div>
				</div>
			</div>
		</section>
	</div>	
</section>
<script type="text/javascript">
$(document).ready(function() {
	$( "#tabs" ).tabs();

	$(".Pesan").on("click", "ul li a", function() {
		var $id = $(this).attr("data-id"),
		$content = "#"+$id;

		$(".Pesan ul li a").removeClass("active");
		$(".content_dynamic").hide();


		if(!$(this).hasClass('active')){
			$($content).slideDown();
			$(this).addClass("active");
		} else {
			$($content).hide();
			$(this).removeClass("active");
		}
	});
});
</script>