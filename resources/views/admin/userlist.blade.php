@extends('admin.app')

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
			<li class="active">ユーザ一覧</li>
		</ol>
	</div>
	<!--/.row-->

	<div class="table-responsive" style="margin-top:10px;">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>社員名</th>
					<th>電話番号</th>
					<th>メールアドレス</th>
					　<th>雇用形態</th>
					<th>性別</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach( $users as $key => $user )
				<tr>

					<td>{{ $key +1 }}</td>
					<td>{{ $user->name }}</td>
					<td><a href="tel:{{ $user->tel }}" nclick="return confirm('電話をおかけしますか？')">{{ $user->tel }}</a></td>
					<td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
					<td>{{ $service[$user->service] }}</td>
					<td>{{ $sex[$user->sex] }}</td>
					<td><a href="{{ route('userdetail',$user->id) }}"><button type="button" class="btn btn-info">詳細へ</button></a></td>

				</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	{{ $users->links() }}

	<div class="col-sm-12">
		<p class="back-link">Expensen by <a href="">masaki</a></p>
	</div>
</div>
<!--/.row-->
</div>
<!--/.main-->
@endsection
