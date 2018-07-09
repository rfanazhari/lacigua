<style type="text/css">
	.boxFeedback .boxFeedbackInner .inline .point img {
		width: 25px;
    	height: auto;
    	float:left;
    	padding-right: 10px;
	}
	.boxFeedback .boxFeedbackInner .inline .point {
		font-family: "robotobold";
	    font-size: 24px;
	    color: #000;
	    text-transform: uppercase;
	    margin-bottom: 10px;
	    float:left;
	}
	.boxFeedback .boxFeedbackInner .inline .point span {
		padding-right: 30px;
		letter-spacing: 2px;
	    font-family: "robotoreguler";
	    font-size: 18px;
	    color: #898989;
	    margin-bottom: 20px;
	}
	.holdboxFeedbackInner {
		padding: 0 !important;
		padding-bottom: 50px !important;
	}
	.holdboxFeedbackInnerNext {
		padding: 0 !important;
		padding-top: 50px !important;
		padding-bottom: 40px !important;
	}
	.boxFeedback .boxFeedbackInner .boxPesan .boxPesanIsi .boxStarsQuality .quality .label {
		width: 100px !important;
	}
	.boxFeedback .boxFeedbackInner .boxPesan .boxPesanIsi {
		float: left !important;
		width: 50% !important;
	}
	.boxFeedback .boxFeedbackInner .boxPesan .boxPesanText {
		float: right !important;
	}
	.boxFeedback .boxFeedbackInner .boxPesan .boxPesanText .date {
		margin: 0 !important;
		margin-top: 10px !important;
		letter-spacing: 2px !important;
	    font-family: "robotoreguler" !important;
	    font-size: 18px !important;
	    color: #898989 !important;
	}
	.boxFeedback .boxFeedbackInner .boxPesan .boxPesanText .name {
	    margin-top: 10px !important;
	    font-family: "robotobold" !important;
	    color: #000 !important;
	    font-size: 22px !important;
	}
	.boxFeedback .boxFeedbackInner .boxPesan .boxPesanText img {
		margin-top: 10px !important;
	    width: 25px;
    	height: auto;
    	float: right;
	}

	@media (min-width: 0px) and (max-width: 1300px) {
		section.spottab.artist_tab .boxFeedback .boxFeedbackInner .date {
			font-size: 14px !important;
		}
		section.spottab.artist_tab .boxFeedback .boxFeedbackInner .inline .point {
			font-size: 14px;
		}
		section.spottab.artist_tab .boxFeedback .boxFeedbackInner .inline .point img {
			margin-top: -5px !important;
		}
		section.spottab.artist_tab .boxFeedback .boxFeedbackInner .inline .point span {
			font-size: 12px;
		}
		section.spottab.artist_tab .boxFeedback .boxFeedbackInner .boxPesan .boxPesanIsi {
			width: 50% !important;
		}
		section.spottab.artist_tab .boxFeedback .boxFeedbackInner .boxPesan .boxPesanIsi .quality {
			height: 26px !important;
		}
		section.spottab.artist_tab .boxFeedback .boxFeedbackInner .boxPesan .boxPesanIsi .boxStarsQuality .quality {
			/*border: 1px solid;*/
			float: none;
			margin-right: 0px;
			margin-bottom: 0px;
		}
		section.spottab.artist_tab .boxFeedback .boxFeedbackInner .boxPesan .boxPesanIsi .boxStarsQuality .quality .label {
			font-size: 12px;
			width: 60px !important;
			margin-top: 0px;
			margin-right: 0px;
		}
		section.sale .boxContentSale .boxFeedback .boxFeedbackInner .boxPesan .boxPesanIsi .boxStarsQuality .quality .rating {
			background-size: 68.5px 13px !important;
			width: 68.5px;
			height: 13px;
		}
		section.sale .boxContentSale .boxFeedback .boxFeedbackInner .boxPesan .boxPesanText .name {
			font-size: 18px !important;
			text-align: right;
		}
	}
</style>
<div class="boxFeedback">
	<div class="boxFeedbackInner holdboxFeedbackInner">
		<div class="inline">
			<span class="point">
				<img src="{{$basesite}}assets/frontend/images/material/positive.png"> POSITIVE <span>(467)</span>
			</span>
			<span class="point">
				<img src="{{$basesite}}assets/frontend/images/material/neutral.png"> NEUTRAL <span>(20)</span>
			</span>
			<span class="point">
				<img src="{{$basesite}}assets/frontend/images/material/negative.png"> NEGATIVE <span>(5)</span>
			</span>
		</div>
	</div>
	<div class="boxFeedbackInner holdboxFeedbackInnerNext">
		<div class="boxPesan after_clear">
			<div class="boxPesanIsi">
				<div class="img">
					<img src="{{$basesite}}assets/frontend/images/content/feedback-1.png">
				</div>
				<div class="name">Hamsa Sleeve Bracelet</div>
				<div class="boxStarsQuality after_clear">
					<div class="quality after_clear">
						<div class="label">Quality</div>
						<div class="rating tiga"></div>
					</div>
					<div class="quality">
						<div class="label">Accuracy</div>
						<div class="rating lima"></div>
					</div>
					<div class="quality">
						<div class="label">Service</div>
						<div class="rating empat"></div>
					</div>
				</div>
			</div>
			<div class="boxPesanText">
				<div class="date">8 April 2016, 07:12 WIB</div>
				<div class="name">CINTA KHIEL</div>
				<img src="{{$basesite}}assets/frontend/images/material/positive.png">
			</div>
		</div>
	</div>
	<div class="boxFeedbackInner holdboxFeedbackInnerNext">
		<div class="boxPesan after_clear">
			<div class="boxPesanIsi">
				<div class="img">
					<img src="{{$basesite}}assets/frontend/images/content/feedback-2.png">
				</div>
				<div class="name">Hamsa Sleeve Bracelet</div>
				<div class="boxStarsQuality after_clear">
					<div class="quality after_clear">
						<div class="label">Quality</div>
						<div class="rating dua"></div>
					</div>
					<div class="quality after_clear">
						<div class="label">Accuracy</div>
						<div class="rating dua"></div>
					</div>
					<div class="quality after_clear">
						<div class="label">Service</div>
						<div class="rating tiga"></div>
					</div>
				</div>
			</div>
			<div class="boxPesanText">
				<div class="date">8 April 2016, 07:12 WIB</div>
				<div class="name">CINTA KHIEL</div>
				<img src="{{$basesite}}assets/frontend/images/material/negative.png">
			</div>
		</div>
	</div>
	<div class="boxFeedbackInner holdboxFeedbackInnerNext">
		<div class="boxPesan after_clear">
			<div class="boxPesanIsi">
				<div class="img">
					<img src="{{$basesite}}assets/frontend/images/content/feedback-3.png">
				</div>
				<div class="name">Hamsa Sleeve Bracelet</div>
				<div class="boxStarsQuality after_clear">
					<div class="quality after_clear">
						<div class="label">Quality</div>
						<div class="rating tiga"></div>
					</div>
					<div class="quality after_clear">
						<div class="label">Accuracy</div>
						<div class="rating tiga"></div>
					</div>
					<div class="quality after_clear">
						<div class="label">Service</div>
						<div class="rating tiga"></div>
					</div>
				</div>
			</div>
			<div class="boxPesanText">
				<div class="date">8 April 2016, 07:12 WIB</div>
				<div class="name">CINTA KHIEL</div>
				<img src="{{$basesite}}assets/frontend/images/material/neutral.png">
			</div>
		</div>
	</div>
	<div class="boxFeedbackInner holdboxFeedbackInnerNext">
		<div class="boxPesan after_clear">
			<div class="boxPesanIsi">
				<div class="img">
					<img src="{{$basesite}}assets/frontend/images/content/feedback-4.png">
				</div>
				<div class="name">Hamsa Sleeve Bracelet</div>
				<div class="boxStarsQuality after_clear">
					<div class="quality after_clear">
						<div class="label">Quality</div>
						<div class="rating empat"></div>
					</div>
					<div class="quality after_clear">
						<div class="label">Accuracy</div>
						<div class="rating tiga"></div>
					</div>
					<div class="quality after_clear">
						<div class="label">Service</div>
						<div class="rating lima"></div>
					</div>
				</div>
			</div>
			<div class="boxPesanText">
				<div class="date">8 April 2016, 07:12 WIB</div>
				<div class="name">CINTA KHIEL</div>
				<img src="{{$basesite}}assets/frontend/images/material/positive.png">
			</div>
		</div>
	</div>
</div>