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
@if (isset($result['pagination']) && $result['pagination'] != '')
{!!$result['pagination']!!}
<div class='ptop10'></div>
@endif
@if (isset($result['data']) && $result['data'] != '')
<div id='table' class='table-scrollable'>
	<form id="defaultview" action="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}" method='post'>
		<table class="bordered">
			<thead>
				@if (isset($access) && (in_array('edit', $access) || in_array('copy', $access) || in_array('detail', $access)))<th class='width100c'>{{$inv->_trans('backend.defaultview.function')}}</th>@endif
				@foreach ($alias as $key => $val)
				@if (is_array($val) && $key != 'titlepage')
				@if (isset($val[1]) && $val[1] == true)
				<th style='@if (isset($val[2])){{$val[2]}}@endif'>
				@if (isset($getorder) && $getorder == $key)
				<a class='link' href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/
				@if (isset($getsort) && $getsort == 'asc')
				{{str_replace('order_'.$getorder, 'order_'.$key, str_replace('sort_asc', 'sort_desc', $result['parameter']))}}
				@else
				{{str_replace('order_'.$getorder, 'order_'.$key, str_replace('sort_desc', 'sort_asc', $result['parameter']))}}
				@endif/@if ($getpage != 1)page_{{$getpage}}@endif">
					{{$val[0]}}<div class='fright'><i class="fa @if ($getsort == 'asc') fa-sort-asc @else fa-sort-desc @endif"></i></div>
				</a>
				@else
				<a class='link' href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/{{str_replace('order_'.$getorder, 'order_'.$key, str_replace('sort_desc', 'sort_asc', $result['parameter']))}}/@if ($getpage != 1)page_{{$getpage}}@endif">
					{{$val[0]}}<div class='fright'><i class='fa fa-sort'></i></div>
				</a>
				@endif
				</th>
				@endif
				@endif
				@endforeach
				@if (isset($access) && in_array('delete', $access))
				<th class='width110c'>
					<div id="buttondel" class="btn-group" data-toggle="buttons">
						<label class="btn default" for="del">
							<input type="checkbox" class="toggle" name="del" id="del"> {{$inv->_trans('backend.defaultview.selectall')}}
						</label>
					</div>
				</th>
				@endif
			</thead>
			<tfoot>
				@php $count=0 @endphp
				@if (isset($access) && (in_array('edit', $access) || in_array('copy', $access) || in_array('detail', $access)))
					@php $count=1 @endphp
				@endif
				<th colspan='{{count(array_filter(array_column($alias,1))) - 1 + $count}}' class='pad10'>
					@if ((isset($getsearch) && $getsearch != '') || (isset($getsearchlast) && $getsearchlast != ''))
					<span class='black'>{{$inv->_trans('backend.defaultview.yoursearch')}} {{$alias[$getsearchby][0]}} : </span>
					<span class='red'>
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
					</span>
					<div style='float:right;'>
						{{$inv->_trans('backend.defaultview.pageofrecord', [
							'page' => $getpage,
							'pagetotal' => isset($result['pagetotal']) ? $result['pagetotal'] : '0',
							'recordtotal' => isset($result['total']) ? $result['total'] : '0',
						])}}
					</div>
					@else
					{{$inv->_trans('backend.defaultview.pageofrecord', [
						'page' => $getpage,
						'pagetotal' => isset($result['pagetotal']) ? $result['pagetotal'] : '0',
						'recordtotal' => isset($result['total']) ? $result['total'] : '0',
					])}}
					@endif
				</th>
				@if (isset($access) && in_array('delete', $access))
				<th class='width100c pad10'>
					<a id="alertcon" class="btn btn-sm default red-stripe" value="{{$inv->_trans('backend.defaultview.alertconval')}}" rel="{{$inv->_trans('backend.defaultview.alertconrel')}}" href="javascript:;" data="delete">
					{{$inv->_trans('backend.defaultview.buttondelete')}} <i class="fa fa-trash-o"></i>
					</a>
					<input id="delete" class="hide" name="delete" type="submit" />
				</th>
				@endif
			</tfoot>
			@php $i=0 @endphp
			@foreach ($result['data'] as $val)
			<tr @if ($i==0) @php $i=1 @endphp
				class="bottom"
			@else @php $i=0 @endphp
			@endif >
				@if (isset($access) && (count(array_diff(['copy','edit','detail'], $access)) < 3))
				<td class='width100c'>
					@if (in_array('edit', $access))
					<a href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/edit/id_
					@if (isset($inv->alias['idfunction']) && $inv->alias['idfunction'] != '')
					{{$val[$inv->alias['idfunction']]}}
					@else
					{{$val['permalink']}}
					@endif" class='buttonlink tooltips' data-original-title="{{$inv->_trans('backend.defaultview.tooltipsedit')}}"><i class="fa fa-edit"></i></a>
					@endif
					@if (in_array('copy', $access))
					<a href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/copy/id_
					@if (isset($inv->alias['idfunction']) && $inv->alias['idfunction'] != '')
					{{$val[$inv->alias['idfunction']]}}
					@else
					{{$val['permalink']}}
					@endif" class='buttonlink tooltips' data-original-title="{{$inv->_trans('backend.defaultview.tooltipscopy')}}"><i class="fa fa-copy"></i></a>
					@endif
					@if (in_array('detail', $access))
					<a href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/detail/id_
					@if (isset($inv->alias['idfunction']) && $inv->alias['idfunction'] != '')
					{{$val[$inv->alias['idfunction']]}}
					@else
					{{$val['permalink']}}
					@endif" class='buttonlink tooltips' data-original-title="{{$inv->_trans('backend.defaultview.tooltipsdetail')}}"><i class="fa fa-file-text-o"></i></a>
					@endif
				</td>
				@endif
				@foreach ($alias as $aliaskey => $aliasval)
				@if (is_array($aliasval) && $aliaskey != 'titlepage')
				@if (isset($aliasval[1]) && $aliasval[1] == true)
					@if (isset($aliasval[3]) && $aliasval[3] == 'image')
						@if ($val[$flip[$aliaskey]] != '')
						<td>
							<img src="{!!$val[$flip[$aliaskey]]!!}?{{uniqid()}}" />
						</td>
						@else
						<td><span class='red bold'>{{$inv->_trans('backend.defaultview.imagenotfound')}}</span></td>
						@endif
					@elseif (isset($aliasval[3]) && $aliasval[3] == 'file')
						@if ($val[$flip[$aliaskey]] != '')
						<td>
							<a id="file" class="btn btn-sm green" href="{!!$val[$flip[$aliaskey]]!!}" target="_blank">
							File <i class="fa fa-file-o"></i>
							</a>
						</td>
						@else
						<td><span class='red bold'>{{$inv->_trans('backend.defaultview.filenotfound')}}</span></td>
						@endif
					@else
						<td>{!!$val[$flip[$aliaskey]]!!}</td>
					@endif
				@endif
				@endif
				@endforeach
				@if (isset($access) && in_array('delete', $access))
				<td class='width100c'><input type="checkbox" class="hover checked" name="delete[]" value="@if (isset($inv->alias['idfunction']) && $inv->alias['idfunction'] != ''){{$val[$inv->alias['idfunction']]}}@else{{$val['permalink']}}@endif"></td>
				@endif
			</tr>
			@endforeach
		</table>
	</form>
</div>
@endif