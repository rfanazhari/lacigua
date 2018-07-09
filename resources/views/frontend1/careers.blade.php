<section class="story karir">
	<div class="wrapper">
		<div class="boxCaption karirCaption">
			<div class="title1"><span>LACIGUE CAREER</span></div>
			<div class="title2"><span>We're changing the way people think about style, and the way they experience</span></div>
			<div class="title2"><span>fashion online. We're setting the pace in a global online revolution</span></div>
			<div class="title2"><span>this is your chance to be at the heart of it</span></div>
		</div>
	</div>
	<div class="slider karir after_clear"></div>
	<div class="wrapper">
		<div class="choose_back after_clear">
			@if(count($ArrCareerDivision))
			<div class="boxValue after_clear">
				@foreach($ArrCareerDivision as $key => $val)
				<a href="{{$basesite}}careers/detail_{{$val['permalink']}}">{{$val['Name']}}</a>
				@endforeach
			</div>
			@else
			<div width="100%" style="text-align: center;"><h4 style="color:red">Belum ada career saat ini.</h4></div>
			@endif
		</div>
		@if(isset($getdetail))
		<div class="boxList" id="boxAreaPop">
			@php $i = 1; @endphp
			@foreach($ArrCareer as $key => $val)
			<div id="PositionID{{$val['permalink']}}" style="display: none;">{{$val['ID']}}</div>
			<div class="listInner">
				<div class="title">{{$i}}. <span id="Position{{$val['permalink']}}">{{$val['Position']}}</span></div>
				<span class="date" id="ClosedDate{{$val['permalink']}}">Close Date : {{$inv->_dateformysql($val['ClosedDate'])->format('d-m-Y')}}</span>
				<div class="text" id="SimpleRequirement{{$val['permalink']}}">{!! $val['SimpleRequirement'] !!}</div>
				<div style="display: none;" id="Requirement{{$val['permalink']}}">{!! $val['Requirement'] !!}</div>
				<a href="javascript:;" class="link_detail" data-title="{{$val['Position']}}" onclick="PopUp('{{$val['permalink']}}')">Lihat Lebih Detail ></a>
			</div>
			@php $i++; @endphp
			@endforeach
		</div>
		@endif
	</div>
</section>
<div class="wrap-popup" id="popup-detail-karir">
    <div class="overlay-pop2"></div>
    <div class="box-popup type_2" style="max-width: 850px;">
        <div class="title"><span class="tp" id="title"></span>
            <span class="closepop">x</span>
        </div>
        <div class="content" style="height: auto;padding-left: 60px;padding-right: 60px;">
        	<span class="date" id="date"></span>
        	<h3>REQUIREMENT</h3>
        	<p id="SimpleRequirement"></p>
        	<div id="Requirement"></div>
            <div class="boxForm" style="width: 100%;margin-left:0px;margin-top: 40px;">
            	<form class="form-horizontal" enctype="multipart/form-data">
					<input type="text" name="ajaxpost" value="ApplyPosition" style="display:none;">
					<input type="text" name="PositionID" style="display:none;">
					<div class="form-group">
						<label class="control-label" for="CVFile">Upload CV</label>
						<div class="control-input">
							<div class="boxFile">
								<input type="file" class="form-control" id="CVFile" name="CVFile">
								<a class="btn_file" data-id="CVFile">PILIH FILE</a>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="PortfolioFile">Upload Portofolio</label>
						<div class="control-input">
							<div class="boxFile">
								<input type="file" class="form-control" id="PortfolioFile" name="PortfolioFile">
								<a class="btn_file" data-id="PortfolioFile">PILIH FILE</a>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="Note">Catatan</label>
						<div class="control-input" style="width: 380px;">
							<textarea class="form-control" id="Note" name="Note" rows="6" maxlength="255"></textarea>
							<span class="textarea_max">Characters <span id="count">0</span> / 255</span>
						</div>
						<div class="boxButton" style="position: absolute;right: 0px;bottom: 34px;">
							<button type="submit" name="Submit" class="btn black">SUBMIT</button>
						</div>
					</div>
				</form>
			</div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$("#Note").keyup(function() {
			$("#count").text($(this).val().length);
		});
	});
	function PopUp(obj) {
		var check = true;

		$('#title').html($('#Position'+obj).html());
		$('#date').html($('#ClosedDate'+obj).html());
		$('#SimpleRequirement').html($('#SimpleRequirement'+obj).html());
		$('#Requirement').html($('#Requirement'+obj).html());
		$('#Requirement').find('ul').addClass('list strip');
		$('[name="PositionID"]').val($('#PositionID'+obj).html());

		openPopup("popup-detail-karir");

		$("form").submit(function(evt) {
			evt.preventDefault();
			var formData = new FormData($(this)[0]);

			if(check) {
				$.ajax({
		            url         : '{{$basesite}}api/insert',
		            type        : 'POST',
		            data        : formData,
		            async		: false,
					cache		: false,
					contentType	: false,
					enctype		: 'multipart/form-data',
					processData	: false,
		            success     : function(data) {
		                check = false;
		                var data = JSON.parse(data);
		                if(data['response'] == 'OK') {
		                	closePopup("popup-detail-karir");

		                	$('[name="CVFile"]').val('');
		                	$('[name="PortfolioFile"]').val('');
		                	$('[name="Note"]').val('');

		                	_alertvalidation('Apply Job Position is Success.');
		                } else {
		            		var messageerror = '';
		            		$.each(data['data']['error'], function(keys, vals) {
								messageerror = messageerror + '<div class="control-label"><span class="colorred">*</span> '+vals+'</div>';
							});
					    	_alertvalidation(messageerror);
		                }
		            }
		        });
			}
		});
	}

	$(".boxFile").on("click", ".btn_file", function() {
		var $id = $(this).attr("data-id");
        $("#"+$id).click();
    });
</script>