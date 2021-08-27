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
	</div>
	<!--/.row-->

	<div class="container">

		<div class="col-sm-8 col-sm-offset-2 mt-5" style="margin-top:40px;">
			<div>
				<ul>
					<li class="btn btn-primary" id="train_li">交通費</li>
					<li class="btn btn-primary" id="other_li">その他</li>
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

		</div>

		<div class="col-sm-12">
			<p class="back-link">Expensen by <a href="">masaki</a></p>
		</div>
	</div>
	<!--/.row-->
</div>
<!--/.main-->

<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		} //Headersを書き忘れるとエラーになる
	})

	$('#submit').on('click', function() {
		var formData = new FormData($('#trans_form').get(0))
		$.ajax({
			type: 'POST', //リクエストタイプ
			url: '/trans_input',
			cache: false, // キャッシュを無効化
			async: true,
			processData: false, // Ajaxがdataを整形しない指定（画像を送信する際は必須）
			contentType: false, // content-typeヘッダの値（画像を送信する際は必須）
			dataType: 'json',
			data: formData, //Laravelに渡すデータ
			success: function(data) {
				console.log(data.formdata)
				if ($.isEmptyObject(data.error)) {
					if (data.method == "success") {
						$.each(data.formdata.input_item, function(index, value) { //入力内容を分解
							if (value != "") { // 確認画面に入力項目を表示
								// $('.' + index + '_view').text(value);
								$('.' + index + '_view').html($('<dummy>').text(value).html().replace(/\r?\n/g, '<br>'));
							}
						})
					}
				} else {
					$.each(data.error, function(key, value) {
						console.log(key);
						$('.' + key + '_err').text(value);
					});
				}
			},
			error: function() {
				alert('データ取得に失敗しました。')
			}
		});
	});
</script>

@endsection
