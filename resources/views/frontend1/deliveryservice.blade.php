<section class="tarif">
	<div class="wrapper">
		<h1>TARIF PENGIRIMAN</h1>
		<p>Untuk memudahkan Anda memprediksi tarif pengiriman ke alamat yang Anda tuju <br/>silahkan cek tarif disini</p>

		<div class="boxFormInline">
			<h3>DOMESTIK</h3>
			<form id="Form" class="form-horizontal" action="{{$basesite}}delivery-service-result" method="post">
				{{csrf_field()}}
				<div class="after_clear">
					<div class="form-group">
						<label class="control-label" for="From">ASAL</label>
						<div class="control-input">
							<input type="text" class="form-control" id="From" name="From">
							<input type="text" style="display: none;" name="TmpFrom">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="To">TUJUAN</label>
						<div class="control-input">
							<input type="text" class="form-control" id="To" name="To">
							<input type="text" style="display: none;" name="TmpTo">
						</div>
					</div>
					<div class="form-group" style="width: 60px;">
						<label class="control-label " for="Weight">&nbsp;</label>
						<div class="control-input">
							<input type="text" class="form-control numberonly" id="Weight" name="Weight">
							<span class="note">Berat (Kg)</span>
						</div>
					</div>
				</div>
				<div class="form-button">
					<div class="boxButton cek_tarif">
						<button type="submit" name="submit" class="btn grey">CEK TARIF</button>
					</div>
				</div>
			</form>
			<p class="info">
				* Perlu diketahui tidak semua kota tujuan ada dalam jangkauan pengiriman
			</p>
		</div>
		<div class="boxPengiriman" style="display: none;">
			<h3>Internasional</h3>
			<p>Silahkan pilih salah satu partner jasa pengiriman internasional kami</p>
			<div class="boxkirim after_clear">
				<div>
					<a href="javascript:;">
						<img src="{{$basesite}}assets/frontend/images/content/dhl.png">
					</a>
				</div>
				<div>
					<a href="javascript:;">
						<img src="{{$basesite}}assets/frontend/images/content/fedex.png">
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$(function() {
		$('#Form').submit(function( event ) {
        	$('[name="From"]').attr('style', 'border: 1px solid black');
        	$('[name="To"]').attr('style', 'border: 1px solid black');
        	$('[name="Weight"]').attr('style', 'border: 1px solid black');

			var TmpFrom = $('[name="TmpFrom"]').val();
			var TmpTo = $('[name="TmpTo"]').val();
			var Weight = $('[name="Weight"]').val();

			if(!TmpFrom) $('[name="From"]').attr('style', 'border: 1px solid red');
			if(!TmpTo) $('[name="To"]').attr('style', 'border: 1px solid red');
			if(!Weight) $('[name="Weight"]').attr('style', 'border: 1px solid red');

			if(TmpFrom && TmpTo && Weight) {
			} else event.preventDefault();
		});
		$('[name="From"]').bind("keydown", function( event ) {
			$('[name="From"]').attr('style', 'border: 1px solid black');
			$('[name="TmpFrom"]').val("");
				
        	if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
  				event.preventDefault();
			}
		}).autocomplete({
			html: true,
			minLength: 3,
			source: function( request, response ) {
				var search = $('[name="From"]').val();
				if(search.indexOf(', ') != -1) search = search.split(', ')[1];

                $.ajax({
	                url         : '{{$basesite}}api/checking',
	                type        : 'POST',
	                data        : {'ajaxpost':"SearchLocationFrom", 'search':search},
	                success     : function(data) {
	                	var data = JSON.parse(data);

	                	if(data['response'] != 'error') {
	                		response($.map(data['response'], function (item) {
	                            var AC = new Object();

	                            AC.label = item.LabelName;
	                            AC.value = item.DistrictName + ", " + item.VillageName;

	                            AC.ProvinceName = item.ProvinceName;
	                            AC.CityName = item.CityName;
	                            AC.DistrictName = item.DistrictName;
	                            AC.VillageName = item.VillageName;
	                            AC.ID = item.ID;

	                            return AC;
	                        }));
	                	} else {
	                		$("ul#ui-id-1").hide();
	                		$('[name="From"]').attr('style', 'border: 1px solid red');
	                	}
	                }
	            });
			},
			create: function () {
				$(this).data('ui-autocomplete')._renderItem = function (ul, item) {
					var t = String(item.label).replace( new RegExp(this.term, "gi"), "<strong>$&</strong>");
				    return $("<li></li>").data("item.autocomplete", item).append("<div>" + t + "</div>").appendTo(ul);
            	};
			},
			search: function(e,ui){
				$(this).data("ui-autocomplete").menu.bindings = $();
			},
			open: function() {
		        $("ul.ui-menu").width( $(this).innerWidth() );
		    },
			select: function (event, ui) {                    
                $('[name="From"]').val(ui.item.label);
                $('[name="TmpFrom"]').val(ui.item.ID);
			}
		}).focus(function () {
	        $(this).autocomplete("search");
	        $('[name="From"]').autocomplete({
	            autoFocus: true
	        })
	    });
		$('[name="To"]').bind("keydown", function( event ) {
			$('[name="To"]').attr('style', 'border: 1px solid black');
			$('[name="TmpTo"]').val("");

        	if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
  				event.preventDefault();
			}
		}).autocomplete({
			html: true,
			minLength: 3,
			source: function( request, response ) {
				var search = $('[name="To"]').val();
				if(search.indexOf(', ') != -1) search = search.split(', ')[1];
				
                $.ajax({
	                url         : '{{$basesite}}api/checking',
	                type        : 'POST',
	                data        : {'ajaxpost':"SearchLocationTo", 'search':search, 'notsearch':$('[name="TmpFrom"]').val()},
	                success     : function(data) {
	                	var data = JSON.parse(data);

	                	if(data['response'] != 'error' && data['response'] != 'errornot') {
	                		$('[name="From"]').attr('style', 'border: 1px solid black');

	                		response($.map(data['response'], function (item) {
	                            var AC = new Object();

	                            AC.label = item.LabelName;
	                            AC.value = item.DistrictName + ", " + item.VillageName;

	                            AC.ProvinceName = item.ProvinceName;
	                            AC.CityName = item.CityName;
	                            AC.DistrictName = item.DistrictName;
	                            AC.VillageName = item.VillageName;
	                            AC.ID = item.ID;

	                            return AC
	                        }));
	                	} else {
	                		$("ul#ui-id-2").hide();
	                		if(data['response'] == 'error')
								$('[name="From"]').attr('style', 'border: 1px solid red');
							else
								$('[name="To"]').attr('style', 'border: 1px solid red');
	                	}
	                }
	            });
			},
			create: function () {
				$(this).data('ui-autocomplete')._renderItem = function (ul, item) {
					var t = String(item.label).replace( new RegExp(this.term, "gi"), "<strong>$&</strong>");
				    return $("<li></li>").data("item.autocomplete", item).append("<div>" + t + "</div>").appendTo(ul);
            	};
			},
			search: function(e,ui){
				$(this).data("ui-autocomplete").menu.bindings = $();
			},
			open: function() {
		        $("ul.ui-menu").width( $(this).innerWidth() );
		    },
			select: function (event, ui) {
                $('[name="To"]').val(ui.item.label);
                $('[name="TmpTo"]').val(ui.item.ID);
			}
		}).focus(function () {
	        $(this).autocomplete("search");
	        $('[name="To"]').autocomplete({
	            autoFocus: true
	        })
	    });
	});
</script>