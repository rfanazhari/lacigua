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
	<table class="bordered" style="overflow: hidden;">
		<thead>
			@if (isset($popuptype) && $popuptype == 'multiple')
			<th class='width100c'>
				<div id="buttonsel" class="btn-group" data-toggle="buttons">
					<label class="btn default" for="sel">
						<input type="checkbox" class="toggle" name="sel" id="sel"> {{$inv->_trans('backend.defaultview.selectall')}}
					</label>
				</div>
			</th>
			@endif
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
			@if(isset($classname[2]) && $classname[2] == 'cadre')
			<th>&nbsp;</th>
			@endif
		</thead>
		<tfoot>
			@if (isset($popuptype) && $popuptype == 'multiple')
			<th class='width100c pad10'>
				<a id="selectpopup" class="btn btn-sm default red-stripe" rel="Data has not been selected !" href="javascript:;" data="selectdata" style="border-left: 3px solid #6DCBDC;">
				Select <i class="fa fa-check-square-o"></i>
				</a>
				<button id="selectfinishpopup" class="hide"></button>
			</th>
			@endif
			@php $count=0 @endphp
			<th colspan='{{count(array_filter(array_column($alias,1))) + $count}}' class='pad10'>
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
		</tfoot>
		@php $i=0 @endphp
		@foreach ($result['data'] as $val)
		<tr @if ($i==0) @php $i=1 @endphp
			class="bottom"
		@else @php $i=0 @endphp
		@endif >
			@if (isset($popuptype) && $popuptype == 'multiple')
			<td class='width100c'><input type="checkbox" class="hover checked" name="selectdata[]" value="@if (isset($inv->alias['idfunction']) && $inv->alias['idfunction'] != ''){{$val[$inv->alias['idfunction']]}}@else{{$val['permalink']}}@endif"></td>
			@endif
			<td class='hide'>{!!$val[$flip[$getid]]!!}</td>
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
			@if(isset($classname[2]) && $classname[2] == 'cadre')
			<td><button id="cadreid" class="btn btn-sm green" value="{!!$val[$flip[$getid]]!!}">Pilih</button></td>
			@endif
		</tr>
		@endforeach
	</table>
</div>
@endif
<script type="text/javascript">
	function popupalert(msg) {
		bootbox.alert(msg);
	}
</script>