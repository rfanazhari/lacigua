@php $i=0 @endphp
@php reset($parents['values']); $arrayfirst = key($parents['values']); @endphp
@php end($parents['values']); $arrayend = key($parents['values']); @endphp

@foreach ($parents['values'] as $key => $val)
<tr @if ($i==0) @php $i=1 @endphp
	class="bottom"
@else @php $i=0 @endphp
@endif >
		<td><i class="fa @if ($val['icon']) {{$val['icon']}} @else {{$parents['prefix']}} @endif" style='padding-left:{{$parents['tab']}}px;'></i> {{$val['name']}}</td>
		
		<td>
			@if ($val['menu'] == 1) Root Menu
			@elseif ($val['menu'] == 2) Menu
			@else Sub Menu
			@endif
		</td>
		
		<td>
			<center>
				@if ($arrayfirst == $key)
					@if (count($parents['values']) == 1)
					---
					@else
					<a href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/priority/set_down.{{$val['idMMenu']}}" class='pad5 buttonlink'>Down</a>
					@endif
				@elseif ($arrayend == $key)
				<a href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/priority/set_up.{{$val['idMMenu']}}" class='pad5 buttonlink'>Up</a>
				@else
				<a href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/priority/set_down.{{$val['idMMenu']}}" class='pad5 buttonlink'>Down</a>
				<a href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/priority/set_up.{{$val['idMMenu']}}" class='pad5 buttonlink'>Up</a>
				@endif
			</center>
		</td>
		
		@if (isset($access) && in_array('delete', $access))
		<td class='width100c'><a onCLick="return deleteData('{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/delete/id_{{$val['idMMenu']}}', '{{$val['name']}}');" href='javascript:;' class='pad5 buttonlink'>Delete</a></td>
		@endif
	</tr>
	@if (isset($val[$val['permalink']]) && is_array($val[$val['permalink']]))
	@include('errornie.module.modulemenulist', ['parents' => [
													'values' => $val[$val['permalink']],
													'prefix' => '',
													'tab' => $parents['tab'] + 15
												]])
	@endif
@endforeach