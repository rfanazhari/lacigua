				</div>
			</div>
		</div>
		@if ($header['menus'] == true)
		<div class="page-footer">
			<div class="page-footer-inner">
				{!!$inv->_trans('backend.footer.pagerender', [
					'second' => $benchmark['controllerloadtime'],
					'memory' => $inv->_converttobytesize(memory_get_usage(true)),
				])!!}
			</div>
			<div class="scroll-to-top">
				<i class="icon-arrow-up"></i>
			</div>
		</div>
		@endif
		@if (isset($config['backend']['autolock']) && $config['backend']['autolock'] != false)
		<input type="text" class="hide" name="basesite" value="{{$basesite}}">
		<input type="text" class="hide" name="adminpage" value="{{$config['backend']['aliaspage']}}">
		<input type="text" class="hide" name="extlink" value="{{$extlink}}">
		<input type="text" class="hide" name="autolock" value="{{$config['backend']['autolock']}}">
		@endif
		<!--[if lt IE 9]>
		<script src="{{$basesite}}assets/backend/global/plugins/respond.min.js"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/excanvas.min.js"></script> 
		<![endif]-->
		<script src="{{$basesite}}assets/backend/global/plugins/jquery.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
		<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
		<script src="{{$basesite}}assets/backend/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/admin/pages/scripts/components-pickers.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript" ></script>
		<script src="{{$basesite}}assets/backend/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/scripts/metronic.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/admin/layout/scripts/layout.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/admin/layout/scripts/demo.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/admin/layout/scripts/custom.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/select2/select2.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/admin/pages/scripts/components-dropdowns.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/fuelux/js/spinner.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/bootstrap-pwstrength/pwstrength-bootstrap.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/admin/pages/scripts/components-form-tools.js"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/jquery-idle-timeout/jquery.idletimeout.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/global/plugins/jquery-idle-timeout/jquery.idletimer.js" type="text/javascript"></script>
		<script src="{{$basesite}}assets/backend/admin/pages/scripts/ui-idletimeout.js"></script>
		<script src="{{$basesite}}assets/backend/admin/pages/scripts/jquery.mCustomScrollbar.concat.min.js"></script>
	</body>
</html>