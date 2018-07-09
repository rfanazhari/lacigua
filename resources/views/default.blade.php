<center class="padtop25">
	<span>Powered by <a href="{{$config['project']['site']}}" target='_BLANK' class='urllink black'>{{$config['project']['name']}}</a></span><br/><br/>
	<div class="headblockdefault">
	@foreach ($result['data'] as $key => $val)
	<a href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$val['permalink']}}" class="btn blockdefault bgdefblue" style="padding-top: 30px;">
		<span>
			<i class="fa {{$val['icon']}}" style="margin-bottom: 30px;"></i><br/>
			{{$val['name']}}
		</span>
	</a>
	@endforeach
	</div>
</center>

