<div style='clear:both;'></div>
@foreach ($parents['values'] as $key => $val)
	@if ($val['menu'] != 2)
	<label for='{{$val["permalink"]}}-{{$val["idMMenu"]}}' class='fleft pleft15 hover bold input-sm'>
		<input type='checkbox' class='hover' name='optmenu[]' value='{{$val["idMMenu"]}}' id='{{$val["permalink"]}}-{{$val["idMMenu"]}}' 
		@if (isset($parents['optmenu']) && $parents['optmenu']) @foreach ($parents['optmenu'] as $optmenuval)
			@if ($optmenuval == $val["idMMenu"]) checked @endif 
		@endforeach @endif />{{$val['name']}}
	</label>
	@else
	<span class='fleft pleft20 bold input-sm'>
		{{$val["name"]}}
	</span>
	@if (isset($parents['values'][$key][$parents['values'][$key]['permalink']]) && is_array($parents['values'][$key][$parents['values'][$key]['permalink']]))
		@include('dashboard.userteam.usergroupnewmenu2', ['parents' => [
			'values' => $parents['values'][$key][$parents['values'][$key]['permalink']],
			'optmenu' => $optmenu,
		]])
	@endif
	@endif
	<div style='clear:both;'></div>
@endforeach