@extends('admin.app')

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">業務委託修正</li>
        </ol>
    </div>
    <!--/.row-->

    <div class="">
        @if( session('message') )
        <p class="text-center mt-4">{{ session('massege') }}</p>
        @endif
        <form action="{{ route('company_input') }}" method="POST" class="row">
            @csrf
            <div class="col-sm-8 col-sm-offset-2 mt-5" style="margin-top:40px;">
                <div class="form-group">
                    <label for="name"><span class="label label-danger">必須</span> 会社名</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $company->name }}">
                </div>
                @if( $errors->has('name') )
                <div class="form-group ">
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>
                @endif
                <div class="form-group">
                    <label for="email"><span class="label label-danger">必須</span> メールアドレス</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ $company->email }}">
                </div>
                @if( $errors->has('email') )
                <div class="form-group">
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>
                @endif
                <div class="form-group">
                    <label for="tel"><span class="label label-danger">必須</span> 電話番号</label>
                    <input type="tel" id="tel" name="tel" class="form-control" value="{{ $company->tel }}">
                </div>
                @if( $errors->has('tel') )
                <div class="form-group">
                    <span class="text-danger">{{ $errors->first('tel') }}</span>
                </div>
                @endif

                <div class="form-group">
                    <label><span class="label label-danger">必須</span> 郵便番号</label>
                    <input type="text" id="zip" name="zip" class="form-control" placeholder="例：111-0000" value="{{ $company->zip }}">
                </div>
                @if( $errors->has('zip') )
                <div class="form-group">
                    <span class="text-danger">{{ $errors->first('zip') }}</span>
                </div>
                @endif
                <div class="form-group">
                    <label><span class="label label-danger">必須</span> 住所</label>
                    <input type="text" id="zip" name="address" class="form-control" placeholder="例：東京都目黒区..1丁目1-1" value="{{ $company->address }}">
                </div>
                @if( $errors->has('adress') )
                <div class="form-group">
                    <span class="text-danger">{{ $errors->first('adress') }}</span>
                </div>
                @endif
                <button type="submit" class="btn btn-primary">登録する</button>
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
