
$(document).ready(function () {

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    } //Headersを書き忘れるとエラーになる
  })


  /*****申請ボタン */
  $('#ok_app').on('click', function () {
    var formData = new FormData($('#other_detail_list').get(0))
    $.ajax({
      type: 'POST',//リクエストタイプ
      url: '/applicant',
      cache: false, // キャッシュを無効化
      async: true,
      processData: false, // Ajaxがdataを整形しない指定（画像を送信する際は必須）
      contentType: false, // content-typeヘッダの値（画像を送信する際は必須）
      dataType: 'json',
      data: formData,//Laravelに渡すデータ
      success: function (data) {
        if (data.format == '成功') {
          alert('チェック項目を承認しました。')
          location.reload()
        } else if (data.format == '失敗') {
          alert('チェックがありません。もしくは処理に失敗しました。')
        }
      },
      error: function () {
        alert('チェックがありません。もしくは処理に失敗しました。')
      }
    });
  });

  /*****承認ボタン */
  $('#comp_app').on('click', function () {
    var formData = new FormData($('#admin_other_list').get(0))
    $.ajax({
      type: 'POST',//リクエストタイプ
      url: '/admin_app_ok',
      cache: false, // キャッシュを無効化
      async: true,
      processData: false, // Ajaxがdataを整形しない指定（画像を送信する際は必須）
      contentType: false, // content-typeヘッダの値（画像を送信する際は必須）
      dataType: 'json',
      data: formData,//Laravelに渡すデータ
      success: function (data) {
        if (data.format == '成功') {
          alert('チェック項目を承認しました。')
          location.reload()
        } else if (data.format == '失敗') {
          alert('チェックがありません。もしくは処理に失敗しました。')
        }
      },
      error: function () {
        alert('チェックがありません。もしくは処理に失敗しました。')
      }
    });
  });

  /*****却下ボタン */
  $('#no_app').on('click', function () {
    var formData = new FormData($('#admin_other_list').get(0))
    $.ajax({
      type: 'POST',//リクエストタイプ
      url: '/admin_app_no',
      cache: false, // キャッシュを無効化
      async: true,
      processData: false, // Ajaxがdataを整形しない指定（画像を送信する際は必須）
      contentType: false, // content-typeヘッダの値（画像を送信する際は必須）
      dataType: 'json',
      data: formData,//Laravelに渡すデータ
      success: function (data) {
        if (data.format == '成功') {
          alert('チェック項目を却下しました。')
          location.reload()
        } else if (data.format == '失敗') {
          alert('チェックがありません。もしくは処理に失敗しました。')
        }
      },
      error: function () {
        alert('チェックがありません。もしくは処理に失敗しました。')
      }
    });
  });

  /*****チェックボックス　全選択 */
  var checkAll = '#checkAll'; //「すべて」のチェックボックスのidを指定
  var removeAll = '#removeAll';
  var checkBox = 'input[name="applicant[]"]'; //チェックボックスのnameを指定

  $(checkAll).on('click', function () {
    $(checkBox).prop('checked', $(this).is(':checked'));
  });

  $(removeAll).on('click', function () {
    $(checkBox).removeAttr('checked', $(this).is(':checked'));
  });

  $(checkBox).on('click', function () {
    var boxCount = $(checkBox).length; //全チェックボックスの数を取得
    var checked = $(checkBox + ':checked').length; //チェックされているチェックボックスの数を取得
    if (checked === boxCount) {
      $(checkAll).prop('checked', true);
    } else {
      $(checkAll).prop('checked', false);
    }
  });

  //管理その他経費選択
  $('.other_select_op').on('change', function () {
    const formData = new FormData($('#admin_other_list').get(0))
    $.ajax({
      type: 'POST',//リクエストタイプ
      url: '/admin/other_change',
      cache: false, // キャッシュを無効化
      async: true,
      processData: false, // Ajaxがdataを整形しない指定（画像を送信する際は必須）
      contentType: false, // content-typeヘッダの値（画像を送信する際は必須）
      dataType: 'json',
      data: formData,//Laravelに渡すデータ
      success: function (data) {
        if (data.val == 0) {
          $('.replace').html(data.formdata);
          $('.other_select_op').val(data.val).prop('selected', true);
        } else {
          $('.replace').html(data.formdata);
          $('.other_select_op').val(data.val).prop('selected', true);
        }
      },
      error: function () {
        alert('データ取得に失敗しました。')
      }
    });
  })


  //過去履歴変更
  $('#change_ym').on('click', function () {
    const formData = new FormData($('#sum_change_form').get(0))
    // var formData = new FormData($(this).parent('form').get(0))
    $.ajax({
      type: 'POST',//リクエストタイプ
      url: '/sum_change',
      cache: false, // キャッシュを無効化
      async: true,
      processData: false, // Ajaxがdataを整形しない指定（画像を送信する際は必須）
      contentType: false, // content-typeヘッダの値（画像を送信する際は必須）
      dataType: 'json',
      data: formData,//Laravelに渡すデータ
      success: function (data) {
        $('.sum_replace').html(data.formdata);
        $('#change_y').val(data.explode_y).prop('selected', true);
        $('#change_m').val(data.explode_m).prop('selected', true);
      },
      error: function () {
        alert('データ取得に失敗しました。')
      }
    });
  })

  //過去履歴変更
  $('#image').change(function () {
    const formData = new FormData($('.myprof_form').get(0))
    // var formData = new FormData($(this).parent('form').get(0))
    $.ajax({
      type: 'POST',//リクエストタイプ
      url: '/profimage',
      cache: false, // キャッシュを無効化
      async: true,
      processData: false, // Ajaxがdataを整形しない指定（画像を送信する際は必須）
      contentType: false, // content-typeヘッダの値（画像を送信する際は必須）
      dataType: 'json',
      data: formData,//Laravelに渡すデータ
      success: function (data) {

      },
      error: function () {
        alert('データ取得に失敗しました。')
      }
    });
  })


  var val = $('input[name="service"]:checked').val();
  // console.log(val);
  if (val == 2 || val == 3) {
    $('#company_div').show();
    $('.company_detail').attr('disabled', false);
  }
  if (val == 0 || val == 1) {
    $('#company_div').hide();
    $('.company_detail').attr('disabled', true);
  }

  $('.company').attr('disabled', true);
  $('input[name="service"]:radio').change(function () {
    let a2 = $(this).val();
    if (a2 == 2 || a2 == 3) {
      $('#company_div').show();
      $('.company').attr('disabled', false);
      $('.company_detail').attr('disabled', false);
    } else {
      $('#company_div').hide();
      $('.company').attr('disabled', true);
      $('.company_detail').attr('disabled', true);
    }
  })


  // 	$('#submit').on('click', function() {
  // 		var formData = new FormData($('#trans_form').get(0))
  // 		$.ajax({
  // 			type: 'POST', //リクエストタイプ
  // 			url: '/trans_input',
  // 			cache: false, // キャッシュを無効化
  // 			async: true,
  // 			processData: false, // Ajaxがdataを整形しない指定（画像を送信する際は必須）
  // 			contentType: false, // content-typeヘッダの値（画像を送信する際は必須）
  // 			dataType: 'json',
  // 			data: formData, //Laravelに渡すデータ
  // 			success: function(data) {
  // 				// console.log(data.formdata)
  // 				if ($.isEmptyObject(data.error)) {
  // 					if (data.method == "success") {
  // 						$.each(data.formdata.input_item, function(index, value) { //入力内容を分解
  // 							if (value != "") { // 確認画面に入力項目を表示
  // 								// $('.' + index + '_view').text(value);
  // 								$('.' + index + '_view').html($('<dummy>').text(value).html().replace(/\r?\n/g, '<br>'));
  // 							}
  // 						})
  // 					}
  // 				} else {
  // 					$.each(data.error, function(key, value) {
  // 						// console.log(key);
  // 						$('.' + key + '_err').text(value);
  // 					});
  // 				}
  // 			},
  // 			error: function() {
  // 				alert('データ取得に失敗しました。')
  // 			}
  // 		});
  // 	});
  // 
});
