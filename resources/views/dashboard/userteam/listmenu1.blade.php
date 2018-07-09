@if (isset($arrmenu))
<fieldset class='fieldset'><legend class='legend' rel="stylesheet">Function for this Group</legend>
	<div class="col-md-12">
		<div class="form-group">
			@foreach ($arrmenu as $key => $val)
			<div style='clear:both;'>
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
				@endif
				@if (isset($arrmenu[$key][$arrmenu[$key]['permalink']]) && is_array($arrmenu[$key][$arrmenu[$key]['permalink']]))
					@include('dashboard.userteam.listmenu2', ['parents' => [
						'values' => $arrmenu[$key][$arrmenu[$key]['permalink']],
						'optmenu' => $optmenu,
					]])
				@endif
				<br/>
			</div>
			@endforeach
			<span class="help-block"></span>
		</div>
	</div>
</fieldset>
@endif