@extends('admin.app')

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">経費登録</li>
			</ol>
		</div><!--/.row-->

      <div class="container">
        <form action="{{ route('expensen_input') }}" method="get" class="row">
            @csrf
            <div class="col-sm-8 col-sm-offset-2 mt-5" style="margin-top:40px;">
                <div class="form-group">
                    <label for="name"><span class="label label-danger">必須</span> お名前</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="例：ジャングル オーシャン" autofocus required>
                </div>
                <div class="form-group">
                    <label for="email"><span class="label label-danger">必須</span> メールアドレス</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="例：raffaello@jungleocean.com" required>
                </div>
                <div class="form-group">
                    <label for="tel"><span class="label label-danger">必須</span> 電話番号</label>
                    <input type="tel" id="tel" name="tel" class="form-control" placeholder="例：080-1234-5678" required>
                </div>
                <div class="form-group">
                    <label><span class="label label-danger">必須</span> 性別</label>
                    <div>
                        <label class="radio-inline">
                            <input type="radio" name="male" value="1" required>男性
                        </label>
                    
                        <label class="radio-inline">
                            <input type="radio" name="female" value="2" required>女性
                        </label>
                    
                        <label class="radio-inline">
                            <input type="radio" name="not applicable" value="9" required>その他
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">送信する</button>
            </div>
        </form>
    </div>
    
			<div class="col-sm-12">
				<p class="back-link">Expensen by <a href="">masaki</a></p>
			</div>
		</div><!--/.row-->
	</div>	<!--/.main-->
  @endsection
