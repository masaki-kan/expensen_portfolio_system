@extends('admin.app')

@section('style')
<style>
  .dataTables_length,
  .dataTables_filter,
  .dataTables_info,
  .dataTables_paginate {
    display: none;
  }
</style>
@endsection
@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="#">
          <em class="fa fa-home"></em>
        </a></li>
      <li class="active">その他
      </li>
    </ol>
  </div>
  <!--/.row-->

  <div class="flex-center position-ref full-height">
    <div class="content">

      <div class="calender_flex">
        <p>
          <a href="/admin/other/user_id={{$id}}&month={{ $prev }}"><i class="fas fa-caret-square-left"></i></a>
        </p>
        <p>
          <span class="month">{{ $month }}</span>
        </p>
        <p>
          <a href="/admin/other/user_id={{$id}}&month={{ $next }}"><i class="fas fa-caret-square-right"></i></a>
        </p>
      </div>

    </div>
  </div>

  <div class="" style="margin-top:10px;">
    <form id="admin_other_list">
      <input type="hidden" name="user_id" value="{{$id}}">
      <input type="hidden" name="ym" value="{{$ym}}">
      <div class="app_form">
        <div class="">
          <input id="checkAll" type="checkbox" value="">全てチェック
        </div>
        <div class="">
          <button type="button" class="btn btn-success mb-2" id="comp_app">承認</button>
          <button type="button" class="btn btn-success mb-2" id="no_app">却下</button>
        </div>
      </div>
      <div class="other_select">
        <select class="other_select_op" name="other_select_op">
          <option value="0">全て</option>
          @foreach( $subjects as $subject)
          <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
          @endforeach
        </select>
      </div>
      <div class="table-responsive" style="margin-top:10px;">
        <table class="table table-hover">
          <thead>
            <th></th>
            <th></th>
            <th>日付</th>
            <th>項目</th>
            <th>金額</th>
            <th>理由</th>
            <th>添付</th>
          </thead>
          <tbody id="tablecontents" class="replace">
            @foreach( $relationtrains as $ralation)
            <tr>
              <td>
                <input type="checkbox" name="applicant[]" value="{{ $ralation->id }}" @if( $ralation->status == 2 )
                disabled
                @endif>
              </td>
              <td>
                @if($ralation->status == 1 )
                申請済
                @elseif($ralation->status == 2)
                承認済
                @elseif($ralation->status == 3)
                却下済
                @endif
              </td>
              <td>
                {{$ralation->date}}
              </td>
              <td>
                @foreach( $subjects as $subject)
                @if( $ralation->subject == $subject->id )
                {{ $subject->subject }}
                @endif
                @endforeach
              </td>
              <td>
                ￥{{$ralation->money}}
              </td>
              <td>
                {{$ralation->reason}}
              </td>
              <td>
                @if( $ralation->image )
                <!-- Button trigger modal -->

                <button type="button" data-bs-toggle="modal" data-bs-target="#imageModal_{{$ralation->id }}">添付確認</button>

                <!-- Modal -->
                <div class="modal fade" id="imageModal_{{$ralation->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-body">
                        <img src="{{ asset('storage/other/'.$ralation->image) }}" width="auto" height="400px" style="margin: 0 auto;display: block;">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
                @else
                添付なし
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </form>
    {{ $relationtrains->links('vendor/pagination/bootstrap-4') }}
  </div>

  <div class="col-sm-12">
    <p class="back-link">Expensen by <a href="">masaki</a></p>
  </div>
</div>
<!--/.row-->
</div>
<!--/.main-->
<!-- jQuery UI -->
<script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- Datatables Js-->
<script type="text/javascript" src="//cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
<script>
  $(function() {
    $("#table").DataTable();

    $("#tablecontents").sortable({
      items: "tr",
      cursor: 'move',
      opacity: 1,
      update: function() {
        sendOrderToServer();
      }
    });

    function sendOrderToServer() {

      var order = [];
      $('tr.row1').each(function(index, element) {
        order.push({
          id: $(this).attr('data-id'),
          position: index + 1
        });
      });

      $.ajax({
        type: "POST",
        dataType: "json",
        url: "{{ route('admin.updateItems') }}",
        data: {
          order: order,
          _token: '{{csrf_token()}}',
        },
        success: function(response) {
          if (response.status == "success") {
            console.log(response);
          } else {
            console.log(response);
          }
        }
      });

    }
  });
</script>
@endsection
