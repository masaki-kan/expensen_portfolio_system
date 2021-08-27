<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
	<div class="profile-sidebar">
		<div class="profile-userpic">
			<!-- <img src="http://placehold.it/50/30a5ff/fff" class="img-responsive" alt=""> -->
			　@if( Auth::user()->image )
			<img src="{{ asset('storage/profile/'.Auth::user()->image) }}" class="img-responsive" alt="">
			@else
			<img src="{{ asset('image/noimage.png') }}" class="img-responsive" alt="">
			@endif
		</div>
		<div class="profile-usertitle">
			<div class="profile-usertitle-name">{{ Auth::user()->name}}</div>
			<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="divider"></div>
	<!-- <form role="search">
		<div class="form-group">
			<input type="text" class="form-control" placeholder="Search">
		</div>
	</form> -->
	<ul class="nav menu">
		<li><a href="{{ route('home') }}"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>
		<li class="parent "><a data-toggle="collapse" href="#sub-item-1">
				<em class="fa fa-navicon">&nbsp;</em> 経費 <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
			</a>
			<ul class="children collapse" id="sub-item-1">
				<li><a class="" href="{{ route('trans_new') }}">
						<span class="fa fa-arrow-right">&nbsp;</span> 登録
					</a></li>
				<li><a class="" href="{{ route('calendar') }}">
						<span class="fa fa-arrow-right">&nbsp;</span> カレンダー
					</a></li>
				<li><a class="" href="{{ route('pitapa.index') }}">
						<span class="fa fa-arrow-right">&nbsp;</span> PitapaCSVインポート
					</a></li>
				<!-- <li><a class="" href="#">
						<span class="fa fa-arrow-right">&nbsp;</span> その他CSVエクスポート
					</a></li> -->
			</ul>
		</li>
		<li>
			@if( Auth::user()->master_flag == 1 )
		<li class="parent "><a data-toggle="collapse" href="#sub-item-2">
				<em class="fa fa-navicon">&nbsp;</em> 設定 <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
			</a>
			<ul class="children collapse" id="sub-item-2">
				<li><a class="" href="{{ route('userlist') }}">
						<span class="fa fa-arrow-right">&nbsp;</span> 従業員一覧
					</a></li>
				<li><a class="" href="{{ route('usernew') }}">
						<span class="fa fa-arrow-right">&nbsp;</span> 従業員登録
					</a></li>
				<li><a class="" href="{{ route('companylist') }}">
						<span class="fa fa-arrow-right">&nbsp;</span> 委託会社一覧
					</a></li>
				<li><a class="" href="{{ route('company_new') }}">
						<span class="fa fa-arrow-right">&nbsp;</span> 委託会社登録
					</a></li>

			</ul>
		</li>
		@endif
		<li class="parent "><a data-toggle="collapse" href="#sub-item-3">
				<em class="fa fa-navicon">&nbsp;</em> マイページ <span data-toggle="collapse" href="#sub-item-3" class="icon pull-right"><em class="fa fa-plus"></em></span>
			</a>
			<ul class="children collapse" id="sub-item-3">
				<li><a class="" href="{{route('myprofile')}}">
						<span class="fa fa-arrow-right">&nbsp;</span> プロフィール
					</a></li>
				<li>
					<a href="{{ route('logout') }}" onclick="event.preventDefault();
				document.getElementById('logout-form').submit();">
						<em class="fa fa-power-off">&nbsp;</em> {{ __('Logout') }}</a>

					<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none" style="display: none;">
						<input type="hidden" name="email" value="{{ Auth::user()->email}}">
						<input type="hidden" name="id" value="{{ Auth::user()->id}}">
						@csrf
					</form>
				</li>

			</ul>

	</ul>
</div>
<!--/.sidebar-->
