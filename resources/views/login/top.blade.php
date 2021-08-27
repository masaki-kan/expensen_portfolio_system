@extends('login.app')
@section('content')
<div class="container">
        @if( session('massege') )
        <p class="text-center">{{ session('massege') }}</p>
        @endif
				@if( session('sucssesmassege') )
        <p class="text-center">{{ session('sucssesmassege') }}</p>
				<div class="text-center">
				<button class="btn btn-primary"><a href="/login">ログイン</a></button>
				</div>
				
        @endif
        <form action="{{ route('passset') }}" method="POST" class="row">
            @csrf
						<input type="hidden" name="id" value="{{ $user->id }}">
            <div class="col-sm-8 col-sm-offset-2 mt-5" style="margin-top:40px;">
								<div class="form-group">
									<label for="email"><span class="label label-danger">必須</span> メールアドレス</label>
									<input type="email" id="email" name="email" class="form-control" placeholder="例：raffaello@jungleocean.com" >
                </div>
                @if( $errors->has('email') )
                <div class="form-group">
                <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>
                @endif

                <div class="form-group">
                    <label for="password_first"><span class="label label-danger">必須</span>初期パスワード</label>
                     <input type="password" id="password_first" name="password_first" class="form-control">
                </div>
                @if( $errors->has('password_first') )
                <div class="form-group ">
                <span class="text-danger">{{ $errors->first('password_first') }}</span>
                </div>
                @endif
                <div class="form-group">
                    <label for="password"><span class="label label-danger">必須</span> 新しいパスワード</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>
                @if( $errors->has('password') )
                <div class="form-group">
                <span class="text-danger">{{ $errors->first('password') }}</span>
                </div>
                @endif
								<div class="form-group">
                    <label for="password_config"><span class="label label-danger">必須</span> 確認用パスワード</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                </div>
                @if( $errors->has('password_confirmed') )
                <div class="form-group">
                <span class="text-danger">{{ $errors->first('password_confirmed') }}</span>
                </div>
                @endif
                <button type="submit" class="btn btn-primary">登録する</button>
            </div>
        </form>
    </div>
@endsection
