@foreach ($parents['values'] as $items)
	<li @if (isset($classname[2]) && $items['permalink'] == $classname[2]) class="active" @endif >
		<a href="{{$basesite}}{{$config['backend']['aliaspage']}}@if ($items['parentName'] != 'errornie'){{$classname[0]}}/@endif{{$items['parentName']}}/{{$items['permalink']}}">
		{{$parents['prefix']}}{{$items['name']}}
		</a>
	</li>
@endforeach