@extends('admin.app')

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">プロフィール</li>
        </ol>
    </div>
    <!--/.row-->
    <div class="">
        <div class="col-sm-8 col-sm-offset-2 mt-5" style="margin-top:40px;">
            <div style="display: block;">
                @if( $users->image == null )
                <div class="pro_image">
                    <img src="{{asset('image/noimage.png')}}" id="preview" class="preview_sample">
                </div>
                @else
                <div class="pro_image">
                    <img src="{{ asset('storage/profile/'.$users->image) }}" id="preview" class="preview_sample">
                </div>
                @endif
            </div>

            <div class="form-group">
                <div class="my_div">
                    <span>お名前</span>
                    <span>{{ $users->name }}</span>
                </div>
            </div>

            <div class="form-group">
                <div class="my_div">
                    <span>メールアドレス</span>
                    <span>{{ $users->email }}</span>
                </div>
            </div>

            <div class="form-group">
                <div class="my_div">
                    <span>電話番号</span>
                    <span>{{ $users->tel }}</span>
                </div>
            </div>

            <div class="form-group">
                <div class="my_div">
                    <span>性別</span>
                    <span>{{$sex[$users->sex]}}</span>
                </div>
            </div>
            <div class="form-group">
                <div class="my_div">
                    <span>就業形態</span>
                    <span>{{$service[$users->service]}}</span>
                </div>
            </div>
            <div class="form-group">
                <div class="my_div">
                    <span>所属</span>
                    <span>
                        @foreach( $company as $value )
                        @if( $users->company == 0 )
                        自社
                        @elseif($value->id == $users->company)
                        {{$value->name}}
                        @endif
                        @endforeach</span>
                </div>
            </div>
            <div class="form-group">
                <div class="my_div">
                    <span>権限</span>
                    <span>{{$masters[$users->master_flag]}}</span>
                </div>
            </div>
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
