@if ((isset($getsearch) && $getsearch != '') || (isset($getsearchlast) && $getsearchlast != ''))
	<span class='black bold'>{{$inv->_trans('backend.defaultview.yoursearch')}} {{$alias[$getsearchby][0]}} : </span>
	<span class='red bold'>
	@if (isset($getsearchby) && strpos($getsearchby, "date") !== false)
		@if ((isset($getsearch) && $getsearch != '') && (isset($getsearchlast) && $getsearchlast != ''))
			{{$getsearch}} to {{$getsearchlast}}
		@elseif (isset($getsearch) && $getsearch != '')
			> {{$getsearch}}
		@elseif (isset($getsearchlast) && $getsearchlast != '')
			< {{$getsearchlast}}
		@endif
	@elseif(isset($getsearch))
		{{$getsearch}}
	@endif
	</span><br/><br/>
@endif
@if (isset($messageerror) && $messageerror != '')
<span class='red bold'>{!!$messageerror!!}</span><br/><br/>
@endif
@if (isset($messagesuccess) && $messagesuccess != '')
<span class='green bold'>{!!$messagesuccess!!}</span><br/><br/>
@endif
@if (isset($result['data']) && $result['data'] != '')
<div id='table' class='table-scrollable'>
	<form id="defaultview" action="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}" method='post'>
		<table class="bordered">
			<thead>
				<th class='pad10' style="width: 70px;text-align: center;">
					Edit
				</th>
				<th class='pad10' style="width: 100px;text-align: center;">
					{{ $alias['ModelType'][0] }}
				</th>
				<th class='pad10' style="width: 200px;">
					{{ $alias['NameCategory'][0] }}
				</th>
				<th class='pad10'>
					{{ $alias['Name'][0] }}
				</th>
				<th class='pad10' style='width:130px;'>
					{{ $alias['ShowOnHeader'][0] }}
				</th>
				<th class='pad10' style='width:150px;'>
					{{ $alias['Priority'][0] }}
				</th>
				<th class='pad10' style='width:150px;'>
					{{ $alias['IsActive'][0] }}
				</th>
				@if (isset($access) && in_array('delete', $access))<th class='width100c'>Delete</th>@endif
			</thead>
			<tfoot>
				<th colspan='8' class='pad10'>&nbsp;</th>
			</tfoot>
				@php $i=0 @endphp
				@php reset($result['data']); $arrayfirst = key($result['data']); @endphp
				@php end($result['data']); $arrayend = key($result['data']); @endphp

				@foreach ($result['data'] as $key => $val)
				<tr @if ($i==0) @php $i=1 @endphp
				class="bottom"
				@else @php $i=0 @endphp
				@endif >
				
				<td style="text-align: center;">
					<a href="productsubcategory/edit/id_{{$val['permalink']}}" class="buttonlink tooltips" data-original-title="Edit">
						<i class="fa fa-edit text-center"></i>
					</a>
				</td>
				<td>
					{{$val['ModelType']}}
				</td>
				<td>
					{{$val['NameCategory']}}
				</td>
				<td>
					{{$val['Name']}}
				</td>
					<td>
					<input type="checkbox" class="make-switch SetOnHeader {{ $val['ID'] }}" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" @if ($val['ShowOnHeader']) checked @endif rel="{{ $inv->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $alias['ShowOnHeader'][0]]) }}">
				</td>
				<td>
					<center>
						@if ($arrayfirst == $key)
						@if (count($result['data']) == 1)
						@else
						<a href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/priority/set_down.{{$val['ID']}}" class='pad5 buttonlink'>Down</a>
						@endif
						@elseif ($arrayend == $key)
						<a href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/priority/set_up.{{$val['ID']}}" class='pad5 buttonlink'>Up</a>
						@else
						<a href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/priority/set_down.{{$val['ID']}}" class='pad5 buttonlink'>Down</a>
						<a href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/priority/set_up.{{$val['ID']}}" class='pad5 buttonlink'>Up</a>
						@endif
					</center>
				</td>
				<td>
					<input type="checkbox" class="make-switch IsActive {{ $val['ID'] }}" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" @if ($val['IsActive']) checked @endif rel="{{ $inv->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $alias['IsActive'][0]]) }}">
				</td>

				@if (isset($access) && in_array('delete', $access))
				<td class='width100c'><a onCLick="return deleteData('{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/delete/id_{{$val['permalink']}}', '{{$val['Name']}}');" href='javascript:;' class='pad5 buttonlink'>Delete</a></td>
				@endif
			</tr>
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
@endif