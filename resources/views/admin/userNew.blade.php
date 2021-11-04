@extends('admin.app')

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">従業員登録</li>
        </ol>
    </div>
    <!--/.row-->

    <div class="">
        @if( session('massege') )
        <p class="text-center">{{ session('massege') }}</p>
        @endif
        <form action="{{ route('user_input') }}" method="POST" class="row">
            @csrf
            <div class="col-sm-8 col-sm-offset-2 mt-5" style="margin-top:40px;">
                <div class="form-group">
                    <label for="name"><span class="label label-danger">必須</span> お名前</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="例：ジャングル オーシャン" value="{{ old('name') }}">
                </div>
                @if( $errors->has('name') )
                <div class="form-group ">
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>
                @endif

                <div class="form-group">
                    <label for="email"><span class="label label-danger">必須</span> メールアドレス</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="例：raffaello@jungleocean.com" value="{{ old('email') }}">
                </div>
                @if( $errors->has('email') )
                <div class="form-group">
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>
                @endif

                <div class="form-group">
                    <label for="tel"><span class="label label-danger">必須</span> 電話番号</label>
                    <input type="tel" id="tel" name="tel" class="form-control" placeholder="例：080-1234-5678" value="{{ old('tel') }}">
                </div>
                @if( $errors->has('tel') )
                <div class="form-group">
                    <span class="text-danger">{{ $errors->first('tel') }}</span>
                </div>
                @endif

                <div class="form-group">
                    <label><span class="label label-danger">必須</span> 性別</label>
                    <div>
                        @foreach( $sex as $key => $value )
                        <label class="radio-inline">
                            <input type="radio" name="sex" value="{{$key}}" {{ old( 'sex' ) == $value ? 'checked' : "" }}>{{$value}}
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
                        @foreach( $service as $key => $value )
                        <label class="radio-inline">
                            <input type="radio" name="service" value="{{$key}}" {{ old( 'service' ) == $value  ? 'checked' : "" }}>{{$value}}
                        </label>
                        @endforeach
                    </div>
                </div>

                @if( $errors->has('service') )
                <div class="form-group">
                    <span class="text-danger">{{ $errors->first('service') }}</span>
                </div>
                @endif

                <div class="form-group" id="company_div" style="display: none;">
                    <label><span class="label label-danger">必須</span> 所属</label>
                    <div>
                        <select class="form-control company" name="company">
                            @foreach( $companies as $value )
                            <option value="{{$value->id}}">{{ $value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if( $errors->has('company') )
                <div class="form-group">
                    <span class="text-danger">{{ $errors->first('company') }}</span>
                </div>
                @endif

                <div class="form-group">
                    <label><span class="label label-danger">必須</span> 管理権限</label>
                    <div>
                        @foreach( $master as $key => $value )
                        <label class="radio-inline">
                            <input type="radio" name="master_flag" value="{{$key}}" {{ old( 'master_flag' ) == $value  ? 'checked' : "" }}>{{$value}}
                        </label>
                        @endforeach
                    </div>
                </div>

                @if( $errors->has('master_flag') )
                <div class="form-group">
                    <span class="text-danger">{{ $errors->first('master_flag') }}</span>
                </div>
                @endif

                <button type="submit" class="btn btn-primary">メール送信</button>
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
