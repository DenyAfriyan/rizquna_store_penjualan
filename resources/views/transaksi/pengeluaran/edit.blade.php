@extends('layouts.app')
@section('content')
<div class="row" style="min-height: 75vh">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0">
                <h6 class="fw-bold text-dark">Edit {{ $title }}</h6>
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
                <form action="{{ route('pengeluaran.update' , ['pengeluaran' => $pengeluaran->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="bukti_nomor_dokumen">
                            Bukti Nomor Dokumen
                        </label>
                        <input type="text" class="form-control" name="bukti_nomor_dokumen" id="bukti_nomor_dokumen" value="{{ $pengeluaran->bukti_nomor_dokumen }}">
                    </div>
                    <div class="mb-3">
                        <label for="jenis_limbah_id">
                            Jenis Limbah
                        </label>
                        <select class="select2 form-control" name="jenis_limbah_id" id="jenis_limbah_id">
                            {{-- @foreach ($jenis_limbah as $key => $val) --}}
                                <option value="{{ $pengeluaran->jenis_limbah_id }}" >{{ $pengeluaran->jenis_limbah->name }}</option>
                            {{-- @endforeach --}}
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="vendor_id">
                            Vendor
                        </label>
                        <select class="select2 form-control" name="vendor_id" id="vendor_id" >
                            @foreach ($vendor as $key => $val)
                                <option value="{{ $val }}" {{ $val == $pengeluaran->vendor_id ? 'selected' : '' }}>{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="jumlah_limbah_keluar">
                                    Jumlah Limbah Keluar
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="jumlah_limbah_keluar" name="jumlah_limbah_keluar" value="{{ $pengeluaran->jumlah_limbah_keluar }}">
                                    <span class="input-group-text d-none"></span>
                                    <span class="input-group-text bg-dark text-white">Kg</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="tanggal_keluar">Tanggal Limbah Keluar:</label>
                                <input type="datetime-local" class="form-control" id="tanggal_keluar" name="tanggal_keluar" value="{{ $pengeluaran->tanggal_keluar }}">
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
        theme: "classic",
    });
    $('#vendor_id').select2({
        theme: "classic"
    });
}); 
</script>
@endsection