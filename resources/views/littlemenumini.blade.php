@foreach ($parents as $items)
	<li @if (isset($classname[1]) && $items['permalink'] == $classname[1]) class="active" @endif >
		<a href="@if (isset($items[$items['permalink']]) && is_array($items[$items['permalink']])) javascript:; @else {{$basesite}}{{$config['backend']['aliaspage']}}{{$classname[0]}}/{{$items['permalink']}} @endif">
			<i class="fa @if (isset($items['icon']) && $items['icon']) {{$items['icon']}} @else @if (isset($items[$items['permalink']]) && is_array($items[$items['permalink']])) fa-th-list @else fa-star @endif @endif "></i>
			<span class="title">{{$items['name']}}</span>
			@if (isset($items[$items['permalink']]) && is_array($items[$items['permalink']]))
			<span class="arrow @if (isset($classname[1]) && $items['permalink'] == $classname[1]) open @endif"></span>
			@endif
		</a>
		@if (isset($items[$items['permalink']]) && is_array($items[$items['permalink']]))
		<ul class="sub-menu">
			@include('littlemenu', ['parents' => [
				'values' => $items[$items['permalink']],
				'prefix' => '&nbsp;'
			]])
		</ul>
		@endif
	</li>
@endforeach