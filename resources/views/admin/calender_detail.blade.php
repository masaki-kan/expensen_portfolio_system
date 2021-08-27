@extends('admin.app')

@section('style')
<link href="{{ asset('css/calendar.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="#">
          <em class="fa fa-home"></em>
        </a></li>
      <li class="active">{{$ymd}}</li>
    </ol>
  </div>
  <!--/.row-->
  <div class="flex_table">
    <div>
      <table class="calender_detail_table">
        <tr>
          <thead>
            <th>添付ファイル</th>
            <th>訪問先</th>
            <th>詳細</th>
            <th></th>
          </thead>
        </tr>
        @foreach( $trains_array as $train )
        <tr>
          <td data-label="添付ファイル">
            @if( $train->image )
            <!-- Button trigger modal -->
            <button type="button" data-bs-toggle="modal" data-bs-target="#imageModal_{{$train->id }}">添付確認</button>
            <!-- <img type="button" src="{{ asset('storage/trans/'.$train->image) }}" width="100%" height="100%" data-bs-toggle="modal" data-bs-target="#imageModal_{{$train->id }}"> -->
            <!-- Modal -->
            <div class="modal fade" id="imageModal_{{$train->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-body">
                    <img src="{{ asset('storage/trans/'.$train->image) }}" width="100%" height="100%">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                  </div>
                </div>
              </div>
            </div>
            @else
            <!-- <img src="{{ asset('/image/noimage.png') }}" width="100%" height="100%"> -->
            添付なし
            @endif
          </td>
          <td data-label="訪問先">{{$train->visit }}</td>
          <td data-label="詳細">
            <span type="button" class="confirm" data-bs-toggle="modal" data-bs-target="#relation_{{ $train->id }}">確認する</span>

            <!-- Modal -->
            <div class="modal fade" id="relation_{{ $train->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">内容</h5>
                  </div>
                  <div class="modal-body">
                    <table class="calender_relation_table table-responsive">
                      <tr>
                        <thead>
                          <th>沿線</th>
                          <th>乗車</th>
                          <th>降車</th>
                          <th>金額</th>
                          <th>タイプ</th>
                          <th></th>
                          <th></th>
                        </thead>
                      </tr>
                      @foreach( $relationtrains as $ralation)
                      @if( $ralation->train_id == $train->id )
                      <tr>
                        @if( $train->status == 0 )
                        <form action="{{ route('calendar_detail_create') }}" method="POST">
                          @csrf
                          <input type="hidden" name="id" value="{{$ralation->id}}">
                          @endif
                          <td data-label="沿線">
                            @if( $train->status == 0 )
                            <select name="line">
                              @foreach( $lines as $line)
                              <option value="{{$line->id}}" {{old('line',$ralation->line) == $line->id ? 'selected' : "" }}>{{$line->line}}</option>
                              @endforeach
                            </select>
                            @if( $errors->has('line') )
                            <span class="text-danger ">{{ $errors->first('line') }}</span>
                            @endif
                            @else
                            @foreach( $lines as $line)
                            @if( $ralation->line == $line->id )
                            {{$line->line}}
                            @endif
                            @endforeach
                            @endif
                          </td>
                          <td data-label="乗車">
                            @if( $train->status == 0 )
                            <input type="text" name="ride" value="{{$ralation->ride}}">
                            @if( $errors->has('ride') )
                            <span class="text-danger ">{{$errors->first('ride') }}</span>
                            @endif
                            @else
                            {{$ralation->ride}}
                            @endif
                          </td>
                          <td data-label="降車">
                            @if( $train->status == 0 )
                            <input type="text" name="getoff" value="{{$ralation->getoff}}">
                            @if( $errors->has('getoff') )
                            <span class="text-danger ">{{ $errors->first('getoff') }}</span>
                            @endif
                            @else
                            {{$ralation->getoff}}
                            @endif
                          </td>
                          <td data-label="金額">
                            @if( $train->status == 0 )
                            <input type="text" name="money" value="{{$ralation->money}}">
                            @if( $errors->has('money') )
                            <span class="text-danger ">{{ $errors->first('money') }}</span>
                            @endif
                            @else
                            ￥{{$ralation->money}}
                            @endif
                          </td>
                          <td data-label="タイプ">
                            @if( $train->status == 0 )
                            <select name="type">
                              @foreach( $type_array as $key => $val )
                              <option value="{{$key}}" {{old('type',$ralation->type) == $key ? 'selected' : "" }}>{{$val}}</option>
                              @endforeach
                            </select>
                            @if( $errors->has('type') )
                            <span class="text-danger ">{{ $errors->first('type') }}</span>
                            @endif

                            @else
                            {{ $type_array[$ralation->type] }}
                            @endif
                          </td>

                          <td>
                            @if( $train->status == 0 )
                            <input type="submit" value="修正">
                            @else
                            完了
                            @endif
                          </td>
                          @if( $train->status == 0 )
                        </form>
                        @endif
                        <td>
                          @if( $train->status == 0 )
                          <span class="delete_button"><a href="{{ route('caldender_relation_delete',$ralation->id)}}" onclick="return confirm('削除してもよろしいですか？')">削除</a></span>
                          @else
                          申請済
                          @endif
                        </td>
                      </tr>
                      @endif
                      @endforeach
                    </table>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                  </div>
                </div>
              </div>
            </div>
          </td>
          <td>
            @if( $ralation->status != 1 )
            <span class="delete_button"><a href="{{ route('caldender_delete',$train->id)}}" onclick="return confirm('削除してもよろしいですか？')">削除</a></span>
            @endif
          </td>
        </tr>
        @endforeach
      </table>
    </div>
    <div>

    </div>
  </div>
  <div class=" col-sm-12">
    <p class="back-link">Expensen by <a href="">masaki</a></p>
  </div>
</div>

@endsection
