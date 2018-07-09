<div style='clear:both;'></div>
@foreach ($parents['values'] as $key => $val)
	@if ($val['menu'] != 2)
	<span class='bold'>
		{{$val['name']}}
	</span>
	<div style='clear:both;'></div>
	@if (count($val['access']))
	@foreach ($val['access'] as $obj)
	<label for='{{$val["permalink"]}}-{{$val["idMMenu"]}}-{{$obj}}' class='fleft pleft15 hover input-sm @if (in_array($obj, ['popup','ajaxpost'])) hide @endif'>
		<input type='checkbox' class='hover' name='optmenu[{{$val["permalink"]}}-{{$val["idMMenu"]}}][]' value='{{$obj}}' id='{{$val["permalink"]}}-{{$val["idMMenu"]}}-{{$obj}}'
		@if (in_array($obj, ['popup','ajaxpost'])) checked 
		@else
		@if (isset($optmenu[$val["permalink"].'-'.$val["idMMenu"]]))
			@foreach ($optmenu[$val["permalink"].'-'.$val["idMMenu"]] as $optmenuval)
				@if ($optmenuval == $obj) checked @endif 
			@endforeach
		@elseif ($optmenu == 'all') checked @endif
		@endif /> {{$obj == 'index' ? 'view' : $obj}}
	</label>
	@endforeach
	@else
	<label class='fleft pleft15 red input-sm'>
		Function is not found !
	</label>
	@endif
	@else
	@if (isset($parents['values'][$key][$parents['values'][$key]['permalink']]) && is_array($parents['values'][$key][$parents['values'][$key]['permalink']]))
		@include('dashboard.userteam.listmenu2', ['parents' => [
			'values' => $parents['values'][$key][$parents['values'][$key]['permalink']],
			'optmenu' => $optmenu,
		]])
	@endif
	@endif
	<div style='clear:both;'></div>
@endforeach