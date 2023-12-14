@extends('layouts.app')
@section('content')
<div class="row" style="min-height: 75vh">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0">
                <h6 class="fw-bold text-dark">Form {{ $title }}</h6>
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
                <form action="{{ route('penerimaan.store') }}" method="POST">
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
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="jumlah_limbah_masuk">
                                    Jumlah Limbah Masuk
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="jumlah_limbah_masuk" name="jumlah_limbah_masuk" placeholder="Contoh : 10">
                                    <span class="input-group-text d-none"></span>
                                    <span class="input-group-text bg-dark text-white">Kg</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="tanggal_masuk">Tanggal Limbah Masuk:</label>
                                <input type="datetime-local" class="form-control" id="tanggal_masuk" name="tanggal_masuk">
                            </div>
                            <div class="col-lg-6">
                                <label for="maksimal_penyimpanan">Tanggal Maksimal Penyimpanan:</label>
                                <input type="datetime-local" class="form-control" id="maksimal_penyimpanan" name="maksimal_penyimpanan">
                            </div>
                        </div>
                        
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