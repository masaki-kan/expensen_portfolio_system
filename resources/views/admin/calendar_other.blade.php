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
      <li class="active">カレンダー（その他経費）</li>
    </ol>
  </div>
  <!--/.row-->
  <div class="flex-center position-ref full-height">
    <div class="content">

      <div class="calender_flex">
        <p>
          <a href="?ym={{ $prev }}"><i class="fas fa-caret-square-left"></i></a>
        </p>
        <p>
          <span class="month">{{ $month }}</span>
        </p>
        <p>
          <a href="?ym={{ $next }}"><i class="fas fa-caret-square-right"></i></a>
        </p>
      </div>

      <div class="select_expensen">
        <ul>
          <li class="transe_btn" id="train_li"><a href="{{ route('calendar')}} ">交通費</a></li>
          <li class="expensen_btn" id="other_li"><a href="{{ route('calendar_other')}} ">その他</a></li>
        </ul>
      </div>

      <table class="table table-bordered">
        <tr>
          <th>日</th>
          <th>月</th>
          <th>火</th>
          <th>水</th>
          <th>木</th>
          <th>金</th>
          <th>土</th>
        </tr>
        @foreach ($weeks as $week)
        {!! $week !!}
        @endforeach
      </table>

    </div>
  </div>
  <div class="col-sm-12">
    <p class="back-link">Expensen by <a href="">masaki</a></p>
  </div>
</div>

@endsection
