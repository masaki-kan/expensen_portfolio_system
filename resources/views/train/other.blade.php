@extends('admin.app')

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
			<li class="active">その他経費登録</li>
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
			<form class="row" enctype="multipart/form-data" id="other_form" action="{{ route('other_input') }}" method="POST">
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

				<div class="form-group">
					<label for=""><span class="label label-danger">必須</span> 項目</label>
					<select name="subject" id="" class="form-control">
						<option value="">選択してください。</option>
						@foreach( $subject_array as $sub)
						<option value="{{ $sub->id }}" {{ old('subject') == $sub->id ? 'selected' : ""}}>{{$sub->subject}}
						</option>
						@endforeach
					</select>
				</div>

				@if( $errors->has('subject'))
				<div class="form-group ">
					<span class="text-danger ">{{ $errors->first('subject') }}</span>
				</div>
				@endif

				<div class="form-group">
					<label><span class="label label-danger">必須</span> 金額</label>
					<input type="text" name="money" class="form-control" value="{{ old('money') }}" placeholder="">
					</select>
				</div>

				@if( $errors->has('money'))
				<div class="form-group ">
					<span class="text-danger ">{{ $errors->first('money') }}</span>
				</div>
				@endif

				<div class="form-group">
					<label><span class="label label-danger">必須</span> 使用理由</label>
					<input type="text" name="reason" class="form-control" value="{{ old('reason') }}" placeholder="">
					</select>
				</div>

				@if( $errors->has('reason'))
				<div class="form-group ">
					<span class="text-danger ">{{ $errors->first('reason') }}</span>
				</div>
				@endif

				<div class="form-group">
					<label><span class="label label-danger">必須</span>ファイル添付</label>
					<input type="file" id="image" name="image" class="form-control" value="{{ old('image') }}">
					<img src="{{ asset('image/noimage.png') }}" id="preview" class="preview_sample">
				</div>
				@if( $errors->has('image') )
				<div class="form-group">
					<span class="text-danger">{{ $errors->first('image') }}</span>
				</div>
				@endif

				<button type="submit" class="btn btn-primary" id="">登録</button>
		</div>
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
@endsection
