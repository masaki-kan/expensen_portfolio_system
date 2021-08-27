@extends('admin.app')

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="#">
          <em class="fa fa-home"></em>
        </a></li>
      <li class="active">{{$ymd1}}~{{$ymd2}}csv都合結果</li>
    </ol>
  </div>
  <div class="d-flex justify-content-center">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-info sm-button mt-40" data-bs-toggle="modal" data-bs-target="#csvModal">
      {{$ymd1}}~{{$ymd2}}のcsvデータを表示
    </button>
  </div>
  <!-- Modal -->
  <div class="csvModal">
    <div class="modal  fade" id="csvModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$ymd1}}~{{$ymd2}}のcsvデータ</h5>
          </div>
          <div class="modal-body">
            <table class="table table-head-fixed text-nowrap">
              <tr>
                <th class=" text-start">使用日</th>
                <th class=" text-start">乗車</th>
                <th class=" text-start">降車</th>
                <th class=" text-start">金額</th>
              </tr>
              @foreach( $icdatas as $ic )
              <tr>
                <td class=" text-start">{{ $ic->date }}</td>
                <td class=" text-start">{{ $ic->ride }}</td>
                <td class=" text-start">{{ $ic->getoff }}</td>
                <td class=" text-start">￥{{ $ic->money }}</td>
              </tr>
              @endforeach
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Main content -->
  　<p class="text-danger error-text">＊判定✖️は修正が必要な項目です。
    <br>赤文字は修正箇所です。クリックすると入力することができます。
    <br>csvデータを見て修正してください。
  </p>


  @if( session('message') )
  <p id="left-to-message" class="fadein-after">
    状態：{{ session('message') }}
  </p>
  @else
  <p id="left-to-message" class="fadein-before">
    状態：未申請
  </p>
  @endif

  <div class="card-body table-responsive">
    <table class="table table-head-fixed csv_comp_table">
      <thead>
        <tr>
          <th class=" text-start">使用日</th>
          <th class=" text-start">沿線</th>
          <th class=" text-start">乗車</th>
          <th class=" text-start">降車</th>
          <th class=" text-start">金額</th>
          <th class=" text-start">タイプ</th>
          <th class=" text-start" style="width: 20px!important;">判定</th>
          <th class=" text-start">備考</th>
          <th class=" text-start"></th>
        </tr>
      </thead>
      @foreach( $transfers as $key => $result )
      @if ($result === end($transfers))
      <tr class="last">
        @else
      <tr>
        @endif
        <form action="{{ route('create') }}" method="post" class="">
          @csrf
          <input type="hidden" name="id" value="{{ $comp[$result->id]['id'] }}">
          <td class=" text-start table_td_first" data-label="使用日">{{ $comp[$result->id]['date'] }}</td>
          <td class=" text-start" data-label="沿線">
            @if( $comp[$result->id]['err'] == false )

            @if( $comp[$result->id]['statuscount'] == 1)

            @foreach( $line_array as $line)
            @if( $line->id == $comp[$result->id]['line'] )
            {{$line->line}}
            @endif
            @endforeach

            @else
            <select name="line" class="">
              @foreach( $line_array as $line)
              <option value="{{$line->id}}" {{ old('line', $comp[$result->id]['line'] ) == $line->id ? 'selected' : "" }}>{{$line->line}}</option>
              @endforeach
            </select>
            @endif

            @elseif( $comp[$result->id]['err'] == true )
            @foreach( $line_array as $line)
            @if( $line->id == $comp[$result->id]['line'] )
            {{$line->line}}
            @endif
            @endforeach
            @endif

          </td>
          <td class=" text-start" data-label="乗車">
            @if( $comp[$result->id]['err'] == false )

            @if( $comp[$result->id]['statuscount'] == 1)
            {{ $comp[$result->id]['ride'] }}
            @else
            @if( $comp[$result->id]['errride'] == false )
            <div class="">
              <input type="text" name="ride" class="text-danger error-text" value="{{$comp[$result->id]['ride']}}">
            </div>
            @else
            {{ $comp[$result->id]['ride'] }}
            @endif
            @endif

            @elseif( $comp[$result->id]['err'] == true )
            {{ $comp[$result->id]['ride'] }}
            @endif
          </td>
          <td class=" text-start" data-label="降車">
            @if( $comp[$result->id]['err'] == false )

            @if( $comp[$result->id]['statuscount'] == 1)
            {{ $comp[$result->id]['getoff'] }}
            @else

            @if( $comp[$result->id]['errgetoff'] == false )
            <div class="">
              <input type="text" name="getoff" class="text-danger error-text" value="{{$comp[$result->id]['getoff']}}">
            </div>
            @else
            {{ $comp[$result->id]['getoff'] }}
            @endif

            @endif

            @elseif( $comp[$result->id]['err'] == true )
            {{ $comp[$result->id]['getoff'] }}
            @endif
          </td>

          <td class=" text-start" data-label="金額">
            @if( $comp[$result->id]['err'] == false )

            @if( $comp[$result->id]['statuscount'] == 1)
            ￥{{ $comp[$result->id]['money'] }}
            @else
            @if( $comp[$result->id]['errmoney'] == false )
            <div class="">
              ￥<input type="text" name="money" class="text-danger error-text" value="{{$comp[$result->id]['money']}}">
            </div>
            @else
            ￥{{ $comp[$result->id]['money'] }}
            @endif
            @endif

            @elseif( $comp[$result->id]['err'] == true )
            ￥{{ $comp[$result->id]['money'] }}
            @endif
          </td>
          <td class=" text-start" data-label="タイプ">
            @if( $comp[$result->id]['err'] == false )
            @if( $comp[$result->id]['statuscount'] == 1)
            @foreach( $type_array as $key => $val)
            @if( $comp[$result->id]['type'] == $key )
            {{$val}}
            @endif
            @endforeach
            @else
            <select name="type" id="input_plural" class="">
              @foreach($type_array as $key => $type)
              <option value="{{$key}}" {{ old('type' , $comp[$result->id]['type']) == $type ? 'selected' : ''}}>{{$type}}</option>
              @endforeach
            </select>
            @endif

            @elseif( $comp[$result->id]['err'] == true )
            @foreach( $type_array as $key => $val)
            @if( $comp[$result->id]['type'] == $key )
            {{$val}}
            @endif
            @endforeach
            @endif
          </td>
          <td class=" text-start" data-label="判定">
            @if( $comp[$result->id]['err'] == true )
            <i class="far fa-circle"></i>
            @elseif( $comp[$result->id]['err'] == false )
            <i class="fas fa-times"></i>
            @endif
          </td>
          <td class=" text-start" data-label="備考">
            @if( $comp[$result->id]['err'] == false )
            @if( $comp[$result->id]['statuscount'] == 1)

            {{ $comp[$result->id]['memo'] }}
            @else
            <div class="row">
              <div class="col-12">
                <input type="text" name="memo" class="form-control" value="{{ $comp[$result->id]['memo'] }}">
              </div>
              @if( $errors->has('memo') )
              <div class="text-danger error-text col-12">{{ $errors->first('memo') }}</div>
              @endif
            </div>
            @endif
            @else
            {{ $comp[$result->id]['memo'] }}
            @endif
          </td>
          <td class="text-center" data-label="" style="display: block">
            @if( $comp[$result->id]['err'] == false )
            @if( $comp[$result->id]['statuscount'] == 0)
            <button type="submit" class="btn btn-success sm-button" onclick="return confirm( '修正しますか？' )">修正</button>
            @endif
            @else
            完了
            @endif
          </td>
        </form>
      </tr>
      @endforeach
    </table>
    <form action="{{ route('csv_appli') }}" method="post">
      @csrf
      @foreach( $transfers as $result )
      <input type="hidden" name="id[{{$result->id}}][]" value="{{$result->id}}">
      @if( $comp[$result->id]['err'] == false )
      <input type="hidden" name="memo[{{$result->id}}][0][]" value="{{ $comp[$result->id]['memo'] }}">
      <input type="hidden" name="err[{{$result->id}}][]" value="0">
      @elseif( $comp[$result->id]['err'] == true )
      <input type="hidden" name="memo[{{$result->id}}][1][]" value="{{ $comp[$result->id]['memo'] }}">
      <input type="hidden" name="err[{{$result->id}}][]" value="1">
      @endif
      @endforeach
      <button type="submit" class="btn btn-success app_button" onclick="return confirm( '上記の内容で申請しますか？' )">
        申請
      </button>
    </form>
  </div>

</div>
@endsection
