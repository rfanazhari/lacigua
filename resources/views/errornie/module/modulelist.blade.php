@if (isset($messageerror) && $messageerror != '')
<span class='red bold'>{!!$messageerror!!}</span><br/><br/>
@endif
@if (isset($messagesuccess) && $messagesuccess != '')
<span class='green bold'>{!!$messagesuccess!!}</span><br/><br/>
@endif
<div id='table' class='table-scrollable'>
	<form action="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}" method='post'>
		<table class="bordered">
			<thead>
				<th class='pad10'>
					Module Name
				</th>
				<th class='pad10' style='width:150px;'>
					Description
				</th>
				<th class='pad10' style='width:150px;'>
					Priority
				</th>
				@if (isset($access) && in_array('delete', $access))<th class='width100c'>Delete</th>@endif
			</thead>
			<tfoot>
				<th colspan='4' class='pad10'>&nbsp;</th>
			</tfoot>
			@php $i=0 @endphp
			@php reset($result['data']); $arrayfirst = key($result['data']); @endphp
			@php end($result['data']); $arrayend = key($result['data']); @endphp

			@foreach ($result['data'] as $key => $val)
			<tr @if ($i==0) @php $i=1 @endphp
				class="bottom"
			@else @php $i=0 @endphp
			@endif >
				<td><i class="fa @if ($val['icon']) {{$val['icon']}} @endif"></i> {{$val['name']}}</td>
				<td>
					@if ($val['menu'] == 1) Root Menu
					@elseif ($val['menu'] == 2) Menu
					@else Sub Menu
					@endif
				</td>
				<td>
					<center>
						@if ($arrayfirst == $key)
							@if (count($result['data']) == 1)
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
															'prefix' => 'fa-th-list',
															'tab' => 15
														]])
			@endif
			@endforeach
		</table>
	</form>
</div>
<script>
function deleteData (obj, name) {
	bootbox.confirm('Are you sure to remove ' + name + ' ?', function(result) {
		if(result) {
			window.location.replace(obj);
		}
	});
}
</script>