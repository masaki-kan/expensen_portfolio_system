@extends('admin.app')

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">業務委託一覧</li>
			</ol>
		</div><!--/.row-->
				
		<div class="table-responsive" style="margin-top:10px;">
		<table class="table table-hover">
				<thead>
					<tr>
					<th>#</th>
							<th>会社名</th>
							<th>電話番号</th>
							<th>メールアドレス</th>
							<th>郵便番号</th>
              <th>住所</th>
							<th></th>
					</tr>
					</thead>
				<tbody>
        @foreach( $company as $key =>  $value)
        <tr>
          <td>{{ $key+1 }}</td>
          <td>{{ $value->name }}</td>
          <td><a href="tel:{{ $value->tel }}" onclick="return confirm('電話をおかけしますか？')">{{ $value->tel }}</a></td>
          <td><a href="tel:{{ $value->email }}" >{{ $value->email }}</a></td>
          <td>{{ $value->zip }}</td>
          <td>{{ $value->address }}</td>
					<td><a href="{{ route('company_detail',$value->id) }}"><button type="button" class="btn btn-info">詳細へ</button></a></td>
        </tr>
        @endforeach
				</tbody>
				</table>
		</div>

			<div class="col-sm-12">
				<p class="back-link">Expensen by <a href="">masaki</a></p>
			</div>
		</div><!--/.row-->
	</div>	<!--/.main-->
  @endsection
