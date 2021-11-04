@extends('admin.app')

@section('style')
@endsection

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="#">
          <em class="fa fa-home"></em>
        </a></li>
      <li class="active">Pitapaインポート</li>
    </ol>
  </div>

  <div class="col-sm-8 col-sm-offset-2 mt-5" style="margin-top:40px;">
    <!-- form start -->
    <form id='csvform' action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
      <input type="hidden" name="user_name" value="{{ Auth::user()->name }}">
      <!-- /.card-body -->
      <div class="card-body">
        <div class="form-group">
          <div class=" col-form-label">
            <p>交通費データとpitapacsvを突合します。</p>
            <p class="text-danger error-text">
              @if( $errors->has('pitapacsv') )
              {{ $errors->first('pitapacsv') }}
              @endif
              @if( session('pitapamessase') )
              {{ session('pitapamessase') }}
              @endif
            </p>
          </div>
          <div class="input-css" id="input_plural">
            <input name="pitapacsv" type="file" class="pitapacsv">
          </div>
        </div>
      </div>
      <div class="card-footer text-center">
        <button type='submit' class="btn btn-success">アップロード</button>
      </div>
    </form>

  </div>

</div>

@if( session('errmessage') )
<script>
  $(window).on('load', function() {
    $('#myModal').modal('show');
  });
</script>

<!-- モーダルウィンドウの中身 -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        {{ session('errmessage') }}
      </div>
      <div class="modal-footer text-center">
      </div>
    </div>
  </div>
</div>
@endif

@endsection
