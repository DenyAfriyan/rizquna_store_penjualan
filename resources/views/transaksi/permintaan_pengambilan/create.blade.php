@extends('layouts.app')
@section('content')
<div class="row" style="min-height: 75vh">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0">
                <h6 class="fw-bold text-dark">Form {{ $title }} Limbah</h6>
              </div>
            <div class="card-body">
                @if($errors->any())
                      <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li class="text-white">{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                  @endif
                <form action="{{ route('permintaan-pengambilan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="jenis_limbah_id">
                            Jenis Limbah
                        </label>
                        <select class="select2 form-control" name="jenis_limbah_id" id="jenis_limbah_id" >
                            @foreach ($jenis_limbah as $key => $val)
                                <option value="{{ $val }}">{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sumber_limbah_id">
                            Sumber Limbah
                        </label>
                        <select class="select2 form-control" name="sumber_limbah_id" id="sumber_limbah_id" >
                            @foreach ($sumber_limbah as $key => $val)
                                <option value="{{ $val }}">{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea name="notes" id="notes" class="form-control" rows="4"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
@section('custom_script')
<script>
$(document).ready(function() {
    $('#jenis_limbah_id').select2({
        theme: "classic"
    });
    $('#sumber_limbah_id').select2({
        theme: "classic"
    });
}); 
</script>
@endsection