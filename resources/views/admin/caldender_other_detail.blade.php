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
      <form accept="{{ route('applicant') }}" method="POST" id="other_detail_list">
        @csrf
        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
        <div class="app_form">
          <div class="">
            <input id="checkAll" type="checkbox" value="">全てチェック
          </div>
          <div class="">
            <button type="button" class="btn btn-success mb-2" id="ok_app">申請</button>

          </div>
        </div>
        <table class="calender_detail_table calender_detail_other_table">
          <tr>
            <thead>
              <th></th>
              <th>使用日</th>
              <th>項目</th>
              <th>金額</th>
              <th>添付ファイル</th>
              <th>使用理由</th>
              <th></th>
            </thead>
          </tr>
          @foreach( $trains_array as $train )
          <tr>
            <td>
              <input type="checkbox" name="applicant[]" value="{{ $train->id }}" @if( $train->status == 2 || $train->status == 1 || $train->status == 3 )
              disabled
              @endif>
            </td>
            <td data-label="使用日">{{ $train->date }}</td>
            <td data-label="項目">
              @foreach( $subjects as $sub)
              @if( $sub->id == $train->subject)
              {{ $sub->subject }}
              @endif
              @endforeach
            </td>
            <td data-label="金額">
              ￥{{ $train->money }}
            </td>
            <td data-label="添付ファイル">
              @if( $train->image )
              <!-- Button trigger modal -->
              <button type="button" data-bs-toggle="modal" data-bs-target="#imageModal_{{$train->id }}">添付確認</button>
              <!-- <img type="button" src="{{ asset('storage/other/'.$train->image) }}" width="100%" height="100%" data-bs-toggle="modal" data-bs-target="#imageModal_{{$train->id }}"> -->
              <!-- Modal -->
              <div class="modal fade" id="imageModal_{{$train->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-body">
                      <img src="{{ asset('storage/other/'.$train->image) }}" width="100%" height="100%">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    </div>
                  </div>
                </div>
              </div>
              @else
              <!-- <img src="{{ asset('/image/noimage.png') }}" width="100%" height="100%"> -->
              NoImage
              @endif
            </td>
            <td data-label="使用理由">{{$train->reason }}</td>
            <td data-label="">
              @if( $train->status == 0 )
              <span class="delete_button"><a href="{{ route('caldender_delete',$train->id)}}" onclick="return confirm('削除してもよろしいですか？')">削除</a></span>
              @elseif($train->status == 1)
              申請済
              @elseif($train->status == 2)
              承認済
              @elseif($train->status == 3)
              却下
              @endif
            </td>
          </tr>
          @endforeach
        </table>
      </form>
      <div>
        {{$trains_array->links('vendor/pagination/bootstrap-4')}}
      </div>
    </div>

  </div>
  <div class=" col-sm-12">
    <p class="back-link">Expensen by <a href="">masaki</a></p>
  </div>
</div>

@endsection
