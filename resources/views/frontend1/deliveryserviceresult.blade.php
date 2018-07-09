<section class="tarif hasil_tarif">
	<div class="wrapper">
		<h1>TARIF PENGIRIMAN</h1>

		@if($errormessage)
		<p style="color:red;">{{$errormessage}}</p>
		@else
		<p>Untuk memudahkan Anda memprediksi tarif pengiriman ke alamat yang Anda tuju <br/>silahkan cek tarif disini</p>

		<table class="tb_tarif" style="margin-top: 100px;">
			<thead>
				<tr>
					<td>
						<b>Asal</b>: {{$From}}
					</td>
					<td>
						<b>Tujuan</b>: {{$To}}
					</td>
					<td align="right">
						<b>Berat</b>: {{$Weight}} Kg
					</td>
				</tr>
				<tr>
					<th colspan="3" align="center">DAFTAR TARIF</th>
				</tr>				
			</thead>
		</table>
		<table class="tb_tarif">
			<tbody>
				@foreach($ListArray as $obj)
				<tr>
					<th style="width: 43.9%">{{$obj[0]}}</th>
					<td style="width: 20%">{{$obj[1]}}</td>
					<td style="width: 40%">{{$obj[2]}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@endif
		
		<div class="boxButton">
			<a href="{{$basesite}}delivery-service" class="btn large">CEK TUJUAN LAIN</a>
		</div>
	</div>
</section>