<div style='clear:both;'></div>
@foreach ($parents['values'] as $key => $val)
	<div class='fleft pleft' style='width:200px;'>
		<label for='{{$val["permalink"]}}-{{$val["idMMenu"]}}' class='hover input-sm'>
			<input type='checkbox' class='hover' name='optmenu[]' value='{{$val["idMMenu"]}}' id='{{$val["permalink"]}}-{{$val["idMMenu"]}}'
			@if (isset($parents['optmenu']) && $parents['optmenu']) @foreach ($parents['optmenu'] as $optmenuval)
				@if ($optmenuval == $val["idMMenu"]) checked @endif 
			@endforeach @endif />{{$val['name']}}
		</label>
	</div>
@endforeach
<div style='clear:both;'></div>