@extends('admin.app')

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">{{ $users->name }}</li>
        </ol>
    </div>
    <!--/.row-->

    <div class="">
        @if( session('message') )
        <p class="text-center">{{ session('message') }}</p>
        @endif
        <form action="{{ route('usercreate') }}" method="POST" class="row">
            @csrf
            <input type="hidden" name="id" value="{{ $users->id }}">
            <div class="col-sm-8 col-sm-offset-2 mt-5" style="margin-top:40px;">
                <div class="form-group">
                    <label for="name"><span class="label label-danger">必須</span> お名前</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $users->name }}">
                </div>
                @if( $errors->has('name') )
                <div class="form-group ">
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>
                @endif

                <div class="form-group">
                    <label for="email"><span class="label label-danger">必須</span> メールアドレス</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="例：raffaello@jungleocean.com" value="{{ $users->email }}">
                </div>
                @if( $errors->has('email') )
                <div class="form-group">
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>
                @endif

                <div class="form-group">
                    <label for="tel"><span class="label label-danger">必須</span> 電話番号</label>
                    <input type="tel" id="tel" name="tel" class="form-control" placeholder="例：080-1234-5678" value="{{ $users->tel }}">
                </div>
                @if( $errors->has('tel') )
                <div class="form-group">
                    <span class="text-danger">{{ $errors->first('tel') }}</span>
                </div>
                @endif

                <div class="form-group">
                    <label><span class="label label-danger">必須</span> 性別</label>
                    <div>
                        @foreach( $sex as $value )
                        <label class="radio-inline">
                            <input type="radio" name="sex" value="{{$value}}" {{ $users->sex == $value ? 'checked' : "" }}>{{$value}}
                        </label>
                        @endforeach
                    </div>
                </div>

                @if( $errors->has('sex') )
                <div class="form-group">
                    <span class="text-danger">{{ $errors->first('sex') }}</span>
                </div>
                @endif

                <div class="form-group">
                    <label><span class="label label-danger">必須</span> 就業形態</label>
                    <div>
                        @foreach( $service as $value )
                        <label class="radio-inline">
                            <input type="radio" name="service" value="{{$value}}" {{ $users->service  == $value  ? 'checked' : "" }}>{{$value}}
                        </label>
                        @endforeach
                    </div>
                </div>

                @if( $errors->has('service') )
                <div class="form-group">
                    <span class="text-danger">{{ $errors->first('service') }}</span>
                </div>
                @endif

                <button type="submit" class="btn btn-primary">修正する</button>
            </div>
        </form>
    </div>

    <div class="col-sm-12">
        <p class="back-link">Expensen by <a href="">masaki</a></p>
    </div>
</div>
<!--/.row-->
</div>
<!--/.main-->
@endsection
