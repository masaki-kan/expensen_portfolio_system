@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-5">
            <div class="login_select">
                <img class="login_title" src="{{ asset('/image/expensen_title.jpg')}}" style="  display: block;width:200px;
  margin: 0 auto;">

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group input-group-lg" style="margin-bottom: 10px;">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" placeholder="電子メールアドレス/E-mail Address" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group input-group-lg">

                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="パスワード/Password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- 
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> -->

                        <div class="form-group row mt-5">
                            <div class="login_button">
                                <input type="submit" class="login_top" style="text-align: center;" value="{{ __('Login') }}">
                            </div>

                            <!-- 
                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif -->
                        </div>
                </div>
                </form>
                <div style="text-align: center;">
                    <a href="{{route('passreset')}}">パスワードを忘れた場合</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
