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
      <li class="active">交通費</li>
    </ol>
  </div>
  <!--/.row-->

  <div class="flex-center position-ref full-height">
    <div class="content">

      <div class="calender_flex">
        <p>
          <a href="/admin/trans/user_id={{$id}}&month={{ $prev }}"><i class="fas fa-caret-square-left"></i></a>
        </p>
        <p>
          <span class="month">{{ $month }}</span>
        </p>
        <p>
          <a href="/admin/trans/user_id={{$id}}&month={{ $next }}"><i class="fas fa-caret-square-right"></i></a>
        </p>
      </div>

    </div>
  </div>

  <div class="table-responsive" style="margin-top:10px;">
    <table class="table table-hover" id="table">
      <thead>
        <th></th>
        <th>日付</th>
        <th>沿線</th>
        <th>乗車</th>
        <th>降車</th>
        <th>金額</th>
        <th>タイプ</th>
        <th>備考</th>
      </thead>
      <tbody id="tablecontents">
        @foreach( $relationtrains as $ralation)
        <tr class="row1" data-id="{{ $ralation->id }}">
          <td><i class="fas fa-grip-horizontal" style="font-size: 15px;color: #666;"></i></td>
          <td>
            {{$ralation->date}}
          </td>
          <td>
            @foreach( $lines as $line)
            @if( $ralation->line == $line->id )
            {{$line->line}}
            @endif
            @endforeach
          </td>
          <td>
            {{$ralation->ride}}
          </td>
          <td>
            {{$ralation->getoff}}
          </td>
          <td>
            ￥{{$ralation->money}}
          </td>
          <td>
            {{ $type_array[$ralation->type] }}
          </td>
          <td>
            {{ $ralation->memo}}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>


  <div class="d-flex justify-content-end mt-4">
    <div class="mr-2">
      <form id='csvform' action="{{ route('admin.csvexp') }}" method="POST">
        @csrf
        @foreach( $relationtrains as $value )
        <input type="hidden" name="csvid[]" value="{{ $value->id }}">
        @endforeach
        <input type="hidden" name="user_id" value="{{$userdate->id}}">
        <input type="hidden" name="user_name" value="{{$userdate->name}}">
        <input type="hidden" name="ym" value="{{ $ym }}">
        <button type="submit" class="btn btn-success">csvダウンロード</button>
      </form>
    </div>
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
