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
                <form enctype="multipart/form-data" class="myprof_form">
                    @if( $users->image == null )
                    <div class="pro_image">
                        <img src="{{asset('image/noimage.png')}}" id="preview" class="preview_sample">
                        <div id="camera_li">
                            <label for="image" class="camera_li_label"><i class="fas fa-camera"></i></label>
                        </div>
                    </div>
                    @else
                    <div class="pro_image">
                        <img src="{{ asset('storage/profile/'.$users->image) }}" id="preview" class="preview_sample">
                        <div id="camera_li">
                            <label for="image" class="camera_li_label"><i class="fas fa-camera"></i></label>
                        </div>
                    </div>
                    @endif
                    <input type="file" name="image" id="image" accept="image/*,.pdf,.jpg,.png" style="display: none;">
                    <!-- <button type="submit" style="display: block; margin: 0 auto 10px;">変更</button> -->
                </form>
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
