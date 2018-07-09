@foreach ($parents['values'] as $key => $val)
<option value='{{$val["permalink"]}}-{{$val["idMMenu"]}}' @if ($val["permalink"] == $headmenu) selected @endif >{!!$parents['tab']!!}{!!$parents['prefix']!!} {{$val['name']}}</option>
@if (isset($val[$val['permalink']]) && is_array($val[$val['permalink']]))
@include('errornie.module.modulenewmenulist', ['parents' => [
												'values' => $val[$val['permalink']],
												'prefix' => '-',
												'tab' => $parents['tab'] . "&nbsp;&nbsp;&nbsp;"
											]])
@endif
@endforeach