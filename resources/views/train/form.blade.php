@extends('admin.app')

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
			<li class="active">交通費登録</li>
		</ol>
	</div>
	<!--/.row-->

	<div class="">

		@if( session('massege') )
		<p class="text-center">{{ session('massege') }}</p>
		@endif

		<div class="col-sm-8 col-sm-offset-2 mt-5" style="margin-top:40px;margin-bottom:40px;">
			<div class="select_expensen">
				<!-- <form id="form_change">
					@csrf
					<select class="select" name="select">
						<option value="0">交通費</option>
						<option value="1">その他</option>
					</select>
				</form> -->
				<ul>
					<li class="transe_btn" id="train_li"><a href="{{ route('trans_new')}} ">交通費</a></li>
					<li class="expensen_btn" id="other_li"><a href="{{ route('other_new')}} ">その他</a></li>
				</ul>
			</div>


			@if( session('message'))
			<div class="modal" tabindex="-1">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Modal title</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<p>Modal body text goes here.</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary">Save changes</button>
						</div>
					</div>
				</div>
			</div>
			@endif
			<form class="row" enctype="multipart/form-data" id="trans_form" action="{{ route('trans_input') }}" method="POST">
				@csrf
				<div class="form-group">
					<label for=""><span class="label label-danger">必須</span> 使用日</label>
					<input type="date" id="" name="date" class="form-control" value="{{ old('date') }}" autocomplete="off">
				</div>

				@if( $errors->has('date'))
				<div class="form-group ">
					<span class="text-danger ">{{ $errors->first('date') }}</span>
				</div>
				@endif

				<div id="relation_train_box">
					<div class="train_add" id="train_add">

						<div class="form-group">
							<label for=""><span class="label label-danger">必須</span>沿線</label>
							<select name="line[]" class="form-control">
								<option value="">選択してください▼</option>
								@foreach( $line_array as $key => $line)
								<option value="{{$line->id}}" {{ old('line.*') == $line->id ? 'selected' : ""}}>{{$line->line}}</option>
								@endforeach
							</select>
						</div>

						@if( $errors->has('line.*') )
						<div class="form-group">
							<span class="text-danger">{{ $errors->first('line.*') }}</span>
						</div>
						@endif

						<div class="form-group">
							<label for=""><span class="label label-danger">必須</span> 駅名（乗車）</label>
							<input type="text" name="ride[]" class="form-control" value="{{ old('ride.*') }}">
						</div>

						@if( $errors->has('ride.*'))
						<div class="form-group ">
							<span class="text-danger ">{{ $errors->first('ride.*') }}</span>
						</div>
						@endif

						<div class="form-group">
							<label for=""><span class="label label-danger">必須</span> 駅名（降車）</label>
							<input type="text" name="getoff[]" class="form-control" value="{{ old('getoff.*') }}">
						</div>

						@if( $errors->has('getoff.*'))
						<div class="form-group ">
							<span class="text-danger ">{{ $errors->first('getoff.*') }}</span>
						</div>
						@endif

						<div class="form-group">
							<label><span class="label label-danger">必須</span> 金額</label>
							<input type="text" name="money[]" class="form-control" value="{{ old('money.*') }}">
						</div>

						@if( $errors->has('getoff.*'))
						<div class="form-group ">
							<span class="text-danger ">{{ $errors->first('getoff.*') }}</span>
						</div>
						@endif

						<div class="form-group">
							<label><span class="label label-danger">必須</span> 使用理由</label>
							<select name="type[]" class="form-control">
								<option value="">選択してください▼</option>
								@foreach( $type_array as $key => $type)
								<option value="{{$key}}" {{ old('type[]') == $key ? 'selected' : ""}}>{{$type}}</option>
								@endforeach
							</select>
						</div>

						@if( $errors->has('type.*'))
						<div class="form-group ">
							<span class="text-danger ">{{ $errors->first('type.*') }}</span>
						</div>
						@endif

					</div>

				</div>

				<div class="form-group">
					<input type="button" value="追加" class="btn btn-info" onclick="clickBtn3()" />
					<input type="button" value="削除" class="btn btn-info" onclick="clickBtn4()" id="delete_button" />
				</div>


				<div class="form-group">
					<label><span class="label label-danger">必須</span> 訪問先</label>
					<input type="text" name="visit" class="form-control" value="{{ old('visit') }}" placeholder="家,会社など">
					</select>
				</div>

				@if( $errors->has('visit'))
				<div class="form-group ">
					<span class="text-danger ">{{ $errors->first('visit') }}</span>
				</div>
				@endif

				<div class="form-group">
					<label>ファイル添付</label>
					<input type="file" id="image" name="image" class="form-control form_image" value="{{ old('image') }}">
					<img src="{{ asset('image/noimage.png') }}" id="preview" class="preview_sample">
				</div>

				@if( $errors->has('image') )
				<div class="form-group">
					<span class="text-danger">{{ $errors->first('image') }}</span>
				</div>
				@endif

				<button type="submit" class="btn btn-primary" id="">登録</button>

			</form>
		</div>
	</div>

	<div class="col-sm-12">
		<p class="back-link">Expensen by <a href="">masaki</a></p>
	</div>
</div>
<!--/.row-->
</div>
<!--/.main-->
<script type="text/javascript">
	let element = document.querySelector('#relation_train_box');

	let arg = element.getElementsByClassName('train_add').length;
	if (arg == 1) {
		document.querySelector('#delete_button').classList.add('blocknone')
	}

	function clickBtn4() {

		element = document.querySelector('#relation_train_box');
		if (element.hasChildNodes()) {
			element.removeChild(element.lastChild);
		}

		let arg = element.getElementsByClassName('train_add').length;
		if (arg == 1) {
			document.querySelector('#delete_button').classList.add('blocknone')
		}
	}

	function clickBtn3() {
		let arg = element.getElementsByClassName('train_add').length;
		if (arg >= 1) {
			document.querySelector('#delete_button').classList.remove('blocknone')
		}
		element = document.querySelector('#relation_train_box');
		if (element.hasChildNodes()) {
			element.insertAdjacentHTML('beforeend',

				'<div class="train_add" id="">' +
				'<div class="form-group"><label for=""><span class="label label-danger">必須</span>沿線</label><select name="line[]" class="form-control"><option value="">選択してください▼</option>@foreach( $line_array as $key => $line)<option value="{{$line->id}}">{{$line->line}}</option>@endforeach</select></div>' +
				'<div class="form-group"><label for=""><span class="label label-danger">必須</span> 駅名（乗車）</label><input type="text" name="ride[]" class="form-control" value="{{ old("ride.*")}}"></div>' +
				'<div class="form-group"><label for=""><span class="label label-danger">必須</span> 駅名（降車）</label><input type="text" name="getoff[]" class="form-control" value="{{ old("getoff.*")}}"></div>' +
				'<div class="form-group"><label><span class="label label-danger">必須</span> 金額</label><input type="text" name="money[]" class="form-control" value="{{ old("money.*")}}"></div>' +
				'<div class="form-group"><label><span class="label label-danger">必須</span> 使用理由</label><select name="type[]" class="form-control"><option value="">選択してください▼</option>@foreach( $type_array as $key => $type)<option value="{{$key}}">{{$type}}</option>@endforeach</select></div>' +
				'</div>');
		}
	}
</script>

@endsection
