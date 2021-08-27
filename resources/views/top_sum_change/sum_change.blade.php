<p class="top_p">{{$ym}}月</p>
<form id="sum_change_form">
  <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
  <select name="change_y" id="change_y">
    @foreach( $ys as $y)
    <option value="{{$y}}" {{ $explode_y == $y ? 'selected' : "" }}>{{$y}}年</option>
    @endforeach
  </select>
  <select name="change_m" id="change_m">
    @foreach( $ms as $key => $m)
    <option value="{{$key}}" {{ $explode_m == $m ? 'selected' : "" }}>{{$m}}月</option>
    @endforeach
  </select>
  <button type="button" class="btn " id="change_ym">表示</button>
</form>
<div class="pc">
  <div class="top_flex">
    <div class="top_flex_l">
      <span>交通費</span>
      <span>
        ￥{{$relations_money}}
      </span>
    </div>
    <div class=" top_flex_c">
      <span>車両費</span>
      <span>
        ￥{{$trains2_money}}
      </span>
    </div>
    <div class=" top_flex_l">
      <span>交際費</span>
      <span>
        ￥{{$trains3_money}}
      </span>
    </div>
  </div>
</div>

<div class="pc">
  <div class="top_flex">
    <div class="top_flex_l">
      <span>会議費
      </span>
      <span>
        ￥{{$trains4_money}}
      </span>
    </div>
    <div class=" top_flex_c">
      <span>通信費
      </span>
      <span>
        ￥{{$trains5_money}}
      </span>
    </div>
    <div class=" top_flex_r">
      <span>その他
      </span>
      <span>
        ￥{{$trains6_money}}
      </span>
    </div>
  </div>
</div>

<div class="sp">
  <div class="top_flex">
    <div class=" top_flex_l">
      <span>交通費</span>
      <span>
        ￥{{$relations_money}}
      </span>
    </div>
    <div class="top_flex_r">
      <span>車両費</span>
      <span>
        ￥{{$trains2_money}}
      </span>
    </div>
  </div>
</div>

<div class="sp">
  <div class="top_flex">
    <div class=" top_flex_l">
      <span>交際費</span>
      <span>
        ￥{{$trains3_money}}
      </span>
    </div>
    <div class="top_flex_r">
      <span>会議費</span>
      <span>
        ￥{{$trains4_money}}
      </span>
    </div>
  </div>
</div>


<div class="sp">
  <div class="top_flex">
    <div class="top_flex_l">
      <span>通信費
      </span>
      <span>
        ￥{{$trains5_money}}
      </span>
    </div>
    <div class=" top_flex_r">
      <span>その他
      </span>
      <span>
        ￥{{$trains6_money}}
      </span>
    </div>
  </div>
</div>

<div class="top_flex_center">
  <div class="top_flex_c">
    <span>経費合計</span>
    <span>
      ￥{{$trains_money}}
    </span>
  </div>
</div>
<script>
  //過去履歴変更
  $('#change_ym').on('click', function() {
    console.log('ok')
    const formData = new FormData($('#sum_change_form').get(0))
    $.ajax({
      type: 'POST', //リクエストタイプ
      url: '/sum_change',
      cache: false, // キャッシュを無効化
      async: true,
      processData: false, // Ajaxがdataを整形しない指定（画像を送信する際は必須）
      contentType: false, // content-typeヘッダの値（画像を送信する際は必須）
      dataType: 'json',
      data: formData, //Laravelに渡すデータ
      success: function(data) {
        $('.sum_replace').html(data.formdata);
        $('#change_y').val(data.explode_y).prop('selected', true);
        $('#change_m').val(data.explode_m).prop('selected', true);
      },
      error: function() {
        alert('データ取得に失敗しました。')
      }
    });
  })
</script>
