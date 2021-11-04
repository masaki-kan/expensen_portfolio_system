@extends('admin.app')

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
			<li class="active">ダッシュボード</li>
		</ol>
	</div>
	<!--/.row-->
	<div class="sum_replace">
		<p class="top_p">{{$ym}}月</p>
		<form id="sum_change_form">
			<input type="hidden" name="user_id" value="{{Auth::user()->id}}">
			<select name="change_y" id="change_y">
				@foreach( $ys as $y)
				<option value="{{$y}}" {{ $explode_y == $y ? 'selected' : "" }}>{{$y}}年</option>
				@endforeach
			</select>
			<select name="change_m" id="change_m">
				@foreach( $ms as $key => $m)
				<option value="{{$key}}" {{ $explode_m == $m ? 'selected' : "" }}>{{$m}}月</option>
				@endforeach
			</select>
			<button type="button" class="btn " id="change_ym">表示</button>
		</form>
		<div class="pc">
			<div class="top_flex">
				<div class="top_flex_l">
					<span>交通費</span>
					<span>
						￥{{$relations_money}}
					</span>
				</div>
				<div class=" top_flex_c">
					<span>車両費</span>
					<span>
						￥{{$trains2_money}}
					</span>
				</div>
				<div class=" top_flex_l">
					<span>交際費</span>
					<span>
						￥{{$trains3_money}}
					</span>
				</div>
			</div>
		</div>

		<div class="pc">
			<div class="top_flex">
				<div class="top_flex_l">
					<span>会議費
					</span>
					<span>
						￥{{$trains4_money}}
					</span>
				</div>
				<div class=" top_flex_c">
					<span>通信費
					</span>
					<span>
						￥{{$trains5_money}}
					</span>
				</div>
				<div class=" top_flex_r">
					<span>その他
					</span>
					<span>
						￥{{$trains6_money}}
					</span>
				</div>
			</div>
		</div>

		<div class="sp">
			<div class="top_flex">
				<div class=" top_flex_l">
					<span>交通費</span>
					<span>
						￥{{$relations_money}}
					</span>
				</div>
				<div class="top_flex_r">
					<span>車両費</span>
					<span>
						￥{{$trains2_money}}
					</span>
				</div>
			</div>
		</div>

		<div class="sp">
			<div class="top_flex">
				<div class=" top_flex_l">
					<span>交際費</span>
					<span>
						￥{{$trains3_money}}
					</span>
				</div>
				<div class="top_flex_r">
					<span>会議費</span>
					<span>
						￥{{$trains4_money}}
					</span>
				</div>
			</div>
		</div>


		<div class="sp">
			<div class="top_flex">
				<div class="top_flex_l">
					<span>通信費
					</span>
					<span>
						￥{{$trains5_money}}
					</span>
				</div>
				<div class=" top_flex_r">
					<span>その他
					</span>
					<span>
						￥{{$trains6_money}}
					</span>
				</div>
			</div>
		</div>

		<div class="top_flex_center">
			<div class="top_flex_c">
				<span>経費合計</span>
				<span>
					￥{{$trains_money}}
				</span>
			</div>
		</div>
	</div>

	<p class="top_p">経費</p>

	<div class="top_flex_2">
		<div class="col-md-6 user_expense">
			<a href="{{ route('trans_new') }}">
				<span>
					<i class="fas fa-train"></i>
					登録
				</span>
			</a>
		</div>
		<div class="col-md-6 user_expense">
			<a href="{{ route('calendar') }}">
				<span>
					<i class="far fa-calendar-alt"></i>
					カレンダー
				</span>
			</a>
		</div>
		<div class="col-md-6 user_expense">
			<a href="{{ route('pitapa.index') }}">
				<span>
					<i class="fas fa-file-upload"></i>
					csvインポート
				</span>
			</a>
		</div>
	</div>

	@if( Auth::user()->master_flag == 1 )
	<p class="top_p">ユーザー一覧</p>

	<div class="pc">
		<form action="{{ route('user_search') }}" method="GET">
			<div class="user_search_box">
				<div class="user_search_name">
					<label>社員名</label>
					<input type="text" name="user_name" id="user_name" value="" onkeyup="errorCheck()">
					<i class="fas fa-times" id="search_crear"></i>
				</div>
				<div class="user_search_service">
					<label>雇用形態</label>
					<select name="user_service">
						@foreach( $service as $key => $ser)
						<option value="{{$key}}">{{$ser}}</option>
						@endforeach
					</select>
				</div>
				<button type="submit" class="">検索</button>
			</div>
		</form>
	</div>
	<div class="sp">
		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#searchModal">
			検索
		</button>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">検索</h5>

				</div>
				<div class="modal-body">
					<form action="{{ route('user_search') }}" method="GET">
						@csrf
						<div class="user_search_box">
							<div class="user_search_name">
								<label>社員名</label>
								<input type="text" name="user_name">
								<i class="fas fa-times"></i>
							</div>
							<div class="user_search_service">
								<label>雇用形態</label>
								<select name="user_service">
									<option value="">選択してください。</option>
									@foreach( $service as $key => $ser)
									<option value="{{$key}}">{{$ser}}</option>
									@endforeach
								</select>
							</div>
							<button type="submit" class="btn btn-info" style="margin-top:10px;">検索</button>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>

	<div class="table-responsive" style="margin-top:10px;">
		<table class="table table-hover">
			<thead>
				<tr>
					<th></th>
					<th></th>
					<th>社員名</th>
					<th>電話番号</th>
					<th>メールアドレス</th>
					<th>所属</th>
					<th>雇用形態</th>
					<th>性別</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach( $users as $key => $user )
				<tr>
					<td>
						<div class="profile-userpic">
							<a href="{{ route('admin.userprofile',$user->id) }}">
								@if( $user->image )
								<img src="{{ asset('storage/profile/'.$user->image) }}" class="" alt="" style="margin:0px;">
								@else
								<img src="{{ asset('image/noimage.png') }}" class="" alt="" style="margin:0px;">
								@endif
							</a>
						</div>
					</td>
					<td>
						@if( $user->login == 1 )
						<span class="indicator label-success"></span>
						@elseif( $user->login == 0 )
						<span class="indicator label-danger"></span>
						@endif
					</td>
					<td>{{ $user->name }}</td>
					<td><a href="tel:{{ $user->tel }}" nclick="return confirm('電話をおかけしますか？')">{{ $user->tel }}</a></td>
					<td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
					<td>
						@if($user->company != 0)
						@foreach( $company as $value )
						@if($value->id == $user->company )
						{{$value->name}}
						@endif
						@endforeach
						@else
						自社
						@endif

					</td>
					<td>{{ $service[$user->service] }}</td>
					<td>{{ $sex[$user->sex] }}</td>
					<td><a href="/admin/trans/user_id={{$user->id}}&month={{$ym}}"><button type="button" class="btn btn-info">交通費</button></a></td>
					<td><a href="/admin/other/user_id={{$user->id}}&month={{$ym}}"><button type="button" class="btn btn-info">経費</button></a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	{{ $users->links('vendor/pagination/bootstrap-4') }}
	@endif



	<div class="col-sm-12" style="margin-top: 40px;">
		<p class="back-link">Expensen by <a href="">masaki</a></p>
	</div>
</div>
<!--/.row-->
</div>
<!--/.main-->
<script>
	/*****検索フォームのクリアボタン */

	const search_crear_button = document.getElementById('search_crear');
	search_crear_button.style.display = 'none';

	function errorCheck() {
		if (user_name.value.length > 1) {
			search_crear_button.style.display = "inline-block";
		} else {
			search_crear_button.style.display = 'none';
		}
	}
	let user_name = document.getElementById('user_name');
	search_crear_button.addEventListener('click', function() {
		let user_name = document.getElementById('user_name');
		user_name.value = '';
	})
</script>
@endsection
