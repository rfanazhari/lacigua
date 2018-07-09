<script type="text/javascript">
	function SendEmail(obj) {
		$.ajax({
			url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
			type		: 'POST',
			data		: {'ajaxpost':"sendemail",'value':obj},
			success		: function(data) {
				var data = JSON.parse(data);
        		if(data['response'] == 'AddUser') {
        			bootbox.alert('Please add Seller Admin before send email');
        		} else if(data['response'] == 'NeedPassword') {
        			bootbox.dialog({
				        title: "Please insert Password Seller Admin !!",
				        message: '<div class="row">' +
									'<div class="col-md-12">' +
										'<label class="control-label input-sm marlm10">User Name : <b>' + data['username'] + '</b></label>' + 
										'<input id="Password" type="text" class="form-control input-sm" />' +
									'</div>' +
								'</div>',
						buttons: {
							cancel: {
							    label: 'Cancel',
							    className: 'btn btn-default'
							},
							success: {
								label: "Send",
								className: "btn btn-primary",
								callback: function(result) {
							        if (result) {
							        	$.ajax({
											url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
											type		: 'POST',
											data		: {'ajaxpost':"sendemail",'value':obj,'Password':$('#Password').val()},
											success		: function(data) {
												var data = JSON.parse(data);
												if(data['response'] == 'OK') {
													bootbox.alert('Send Email Success !');
												} else {
													bootbox.alert('Invalid Password !');
												}
											}
										});
							        }
							    }
							}
						}
				    }).on('shown.bs.modal', function (e) {
					    $('#Password').focus();
					});
        		} else {
        			bootbox.alert('Error contact admin.');
        		}
			}
		});
	}
</script>