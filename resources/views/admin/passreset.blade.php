@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-sm-5">
      <div class="login_select">
        <img class="login_title" src="{{ asset('/image/expensen_title.jpg')}}" style="display: block;width: 200px;margin: 0 auto;">

        <div class="card-body">
          @if( session('massege'))
          <p style="text-align: center;">{{ session('massege') }}</p>
          @endif
          <form method="POST" action="{{ route('reset') }}">
            @csrf
            <div class="input-group input-group-lg" style="margin-bottom: 10px;">
              <p style="text-align: center;">登録したアドレスを入力してください。<br>パスワード再設定案内メールが届きます。</p>
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="off" placeholder="電子メールアドレス/E-mail Address" autofocus>

              @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <div class="form-group row mt-5">
              <div class="login_button">
                <input type="submit" class="login_top" style="text-align: center;" value="{{ __('送信') }}">
              </div>
            </div>
        </div>
        </form>
        <div style="text-align: center;">
          <a href="{{ route('login')}}">戻る</a>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection
