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
