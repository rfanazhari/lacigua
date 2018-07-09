<section class="gift">

	<div class="wrapper">
		<div class="banner">
			<div class="caption">GIVE THE GIFT</div>
			<img src="{{$basesite}}assets/frontend/images/content/gift_banner.png">
		</div>
		<div class="text">
			Choose the value, add your message, then select when you'd like it to arrive.<br/> 
			Lacigue gift vouchers are the answer to all your gift-giving headaches.
		</div>

		<form action="" method="post">
			<div class="choose_back after_clear">
				<h3>VOUCHER VALUE</h3>

				<div class="boxValue after_clear">
					<?php 
					for($i=1;$i<=10;$i++){
						?>
						<a href="javascript:;" data-value="<?=$i?>00000" class="<?=($i==1)? "selected" : ""?>">
							IDR <?=$i?>00.000
						</a>
						<?php } ?>
					</div>
					<div class="boxFormInline after_clear" style="margin-top: 20px;">
						<div class="form-group reguler">
							<label class="control-label">Other ( max IDR 2.000.000 )</label>
							<div class="control-input">
								<input type="number" name="other_max" id="other_max">
								
							</div>
						</div>
						<input type="hidden" id="voucher_value" value="100000">
					</div>
				</div>


				<div class="formList after_clear">
					<div class="boxForm">
						<h3>SEND VOUCHER TO</h3>
						<div class="form-group">
							<label class="control-label " for="email">Receipient's Email</label>
							<div class="control-input">
								<input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label " for="name">Receipient's Name</label>
							<div class="control-input">          
								<input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
							</div>
						</div>
						
					</div>
					<div class="boxForm">
						<h3>YOUR VOUCHER INFO</h3>
						<div class="form-group">
							<label class="control-label " for="your_name">YOUR NAME</label>
							<div class="control-input">
								<input type="text" class="form-control" id="your_name" name="your_name" placeholder="Enter name">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label " for="date">Delivery Date</label>
							<div class="control-input">          
								<input type="text" class="form-control date_range" id="date" name="date" placeholder="Choose specific date">
								<span class="note" style="color:#111;line-height: 30px;top: 10px;font-size: 16px;font-family:'robotoreguler'">We can send your gift voucher on any date <br/>
								within the next three months.</span>
								<input type="hidden" name="start_date" id="start_date">
							</div>
						</div>
						<div class="form-group" style="margin-top: 40px;">
							<label class="control-label " for="pesan">Personal Message</label>
							<div class="control-input">          			     
								<textarea class="form-control" id="pesan" rows="12" maxlength="270"></textarea>
								<span class="textarea_max">Characters 0/270</span>
							</div>
						</div>

						<div class="form-group formButton" style="margin-top: 40px;margin-left: 180px;">
							<div class="control-button">          			     
								<button type="submit" class="btn black large gift">SUBMIT & PAY NOW</button>
							</div>
						</div>
					</div>
				</div>
				
			</form>
		</div>

		
		
	</section>
	<script type="text/javascript">
	// daterangepicker dropdown-menu  ltr show-calendar opensright
	// daterangepicker dropdown-menu ltr show-calendar opensright
	$('.date_range').daterangepicker({
		singleDatePicker: true,
		showDropdowns: true,
		locale: {
			format: 'ddd, DD MMM YYYY',
		},
    // customClass: 'blue_calendar' 
    

});
	$('.date_range').on('apply.daterangepicker', function(ev, picker) {
		$("#start_date").val(picker.startDate.format('YYYY-MM-DD'));
		$("#end_date").val(picker.endDate.format('YYYY-MM-DD'));
	});
</script>
<script type="text/javascript">
	$(".boxChoose").on("click", "a", function(){
		var $val = $(this).attr("data-value");

		$("#voucher_back").val($val);
		$(".boxChoose a").removeClass("selected");
		$(this).addClass("selected");

	});
	$(".boxValue").on("click", "a", function(){
		var $val = $(this).attr("data-value");

		$("#voucher_value").val($val);
		$(".boxValue a").removeClass("selected");
		$(this).addClass("selected");

	});
	$("#other_max").on("keyup",function(){
		var $val = $(this).val();

		$("#voucher_value").val($val);

	});
</script>