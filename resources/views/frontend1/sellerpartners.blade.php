<style type="text/css">
	section.story.seller .boxCount .boxCountInner .ct {
		font-size: 50px;
	}
</style>
<section class="story seller">
	<div class="wrapper">
		<div class="boxCaption karirCaption">
        	<div class="title3">
        		<div>WE ARE AUTHENTIC, BRAVE<br/>AND CREATIVE TO OUR CORE</div>
        	</div>
        	<div class="title2"><span>We focus on fashion as a force for good, inspiring young people to express their best selves</span></div>
        	<div class="title2" style="margin-bottom: 100px;"><span>and achieve amazing things. We believe fashion thrives on individuality and should be fun for everyone </span></div>
        	<div class="title_link">
        		<a href="{{$basesite}}our-story">DISCOVER OUR STORY ></a>
        	</div>
        </div>		
	</div>
	<div class="slider seller after_clear"></div>

	<div class="wrapper">
		<div class="boxSeller">
			<p>We don’t just live and breathe our customers – we are our customers. Lacigue’ 1,000+ employees are immersed in the creative worlds, live <br/> on their mobiles and have a truly entrepreneurial attitude. As a company, we’re not trying to mimic or profit from youth culture – we are <br/> part of that youth culture. .</p>
			
			<div class="boxCount after_clear">
				<div class="boxCountInner">
					<div class="ct">{{round($DataSetting->SocialFollowers / 1000000, 2)}}m</div>
					<div><p>Social Followers</p></div>
				</div>
				<div class="boxCountInner">
					<div class="ct">{{round($DataSetting->ActiveCustomer / 1000000, 2)}}m</div>
					<div><p>Active customer</p></div>
				</div>
				<div class="boxCountInner">
					<div class="ct">{{round($DataSetting->ListBrand / 100, 2)}}%</div>

					<div><p>Of label on Lacigue<br/>is exclusive</p></div>
				</div>
				<div class="boxCountInner">
					<div class="ct">{{number_format(round($DataSetting->ActiveCustomer / 1000, 2), 2, '.', ',')}}m</div>
					<div><p>Active product</p></div>
				</div>
			</div>			
		</div>
	</div>
	<div class="boxBackSeller1 after_clear">
		<div class="boxBackSeller1Inner">
			<div class="boxCaption">
				<div class="title">
					Be part of the future of fashion commerce
				</div>
				<div class="desc">
					<p>
						Offering over 4 million fashion products<br/>
						from thousands of the Indonesia’s leading fashion brands<br/>
						and stores, Lacigue brings together the widest inventory<br/>
						and local designer in urban and high fashion online.
					</p>
				</div>
				<div class="boxlink">
					<a href="{{$basesite}}seller-partners#register">JOIN US NOW</a>
				</div>				
			</div>
		</div>
		<div class="boxBackSeller1Inner"></div>
	</div>
	<div class="wrapper">
		<div class="boxNews">
			<div class="title">IN THE NEWS</div>

			<div class="boxGalleryNews after_clear">
				<div class="boxGalleryNewsInner">
					<a href="">
						<div class="boxGalleryNewsHov"></div>
						<div class="boxGalleryNewsText">
							<span>Lacigue and Our people</span>
						</div>

						<img src="{{$basesite}}assets/frontend/images/content/gallery-seller-1.png">						
					</a>
				</div>
				<div class="boxGalleryNewsInner">
					<a href="">
						<div class="boxGalleryNewsHov"></div>
						<div class="boxGalleryNewsText">
							<span>FINAL RESULT OF THE YEAR</span>
							<span>ENDED 31 AGUSTUS 2017</span>
						</div>
						<img src="{{$basesite}}assets/frontend/images/content/gallery-seller-2.png">						
					</a>
				</div>
				<div class="boxGalleryNewsInner">
					<a href="">
						<div class="boxGalleryNewsHov"></div>
						<div class="boxGalleryNewsText">
							<span>LACIGUE LAUNCHES APP</span>
							<span>“LACIGUE ISTANT”</span>
						</div>
						<img src="{{$basesite}}assets/frontend/images/content/gallery-seller-3.png">						
					</a>
				</div>
			</div>
		</div>
	</div>

	<div id="register" class="boxSellerForm after_clear">
		<div class="boxSellerFormInner">
			<div class="title">ISI FORM DI BAWAH INI DENGAN LENGKAP<br/>DAN KAMI AKAN MENGHUBUNGI ANDA DALAM 3-7 HARI!</div>
			<div class="boxForm">
				<form class="form-horizontal" method="post">
					{{csrf_field()}}
				    <div class="form-group">
						<label class="control-label " for="CompanyName" style=" width: 38%;">Nama Perusahaan</label>
						<div class="control-input">
							<input type="text" class="form-control" id="CompanyName" name="CompanyName" value="{{$CompanyName}}" @if($errorCompanyName) style="border: 1px solid red;" @endif>
						</div>
				    </div>
				    <div class="form-group">
						<label class="control-label " for="FullName" style=" width: 38%;">Nama Lengkap *</label>
						<div class="control-input">
							<input type="text" class="form-control" id="FullName" name="FullName" value="{{$FullName}}" @if($errorFullName) style="border: 1px solid red;" @endif>
						</div>
				    </div>
				    <div class="form-group">
						<label class="control-label " for="Email" style=" width: 38%;">Alamat Email *</label>
						<div class="control-input">          
							<input type="text" class="form-control" id="Email" name="Email" value="{{$Email}}" @if($errorEmail) style="border: 1px solid red;" @endif>
						</div>
				    </div>
				    <div class="form-group">
						<label class="control-label " for="Phone" style=" width: 30%;">No. Telepon *</label>
						<div class="control-input">          
							<input type="text" class="form-control numberonly" id="Phone" name="Phone" value="{{$Phone}}" @if($errorPhone) style="border: 1px solid red;" @endif>
						</div>
				    </div>
				    <div class="form-group">
						<label class="control-label " for="Website" style=" width: 38%;">Website</label>
						<div class="control-input">          
							<input type="text" class="form-control" id="Website" name="Website" value="{{$Website}}" @if($errorWebsite) style="border: 1px solid red;" @endif>
						</div>
				    </div>
				    <div class="form-group">
						<label class="control-label " for="Note" style=" width: 38%;">Pertanyaan/Lainnya</label>
						<div class="control-input">          			     
						<textarea class="form-control" id="Note" name="Note" rows="6" maxlength="255" @if($errorNote) style="border: 1px solid red;" @endif>{{$Note}}</textarea>
							<span class="textarea_max">Characters <span id="count">0</span> / 255</span>
						</div>
				    </div>
				    <div class="form-group">        
						<div class="boxButton" style="margin-left: 243px;">
							<button type="submit" name="submit" class="btn black">KIRIM</button>
						</div>
				    </div>
				</form>			
			</div>
		</div>
		<div class="boxSellerFormInner"></div>
	</div>
</section>
<script type="text/javascript">
	$(document).ready(function() {
		@if($Message == 'error') window.location.hash = 'register'; @endif
		@if($Message == 'success') _alertvalidation('Terima Kasih. Kami akan segera menghubungi anda.'); @endif
		$("#Note").keyup(function(){
			$("#count").text($(this).val().length);
		});
	});
</script>