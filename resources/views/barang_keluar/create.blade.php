@extends('layouts.app')
@section('content')
<div class="row" style="min-height: 75vh">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0">
                <h6 class="fw-bold text-dark">Add {{ $title }}</h6>
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
                <form action="{{ route('barang-keluar.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="barang_id" class="form-label">Jenis Barang</label>
                        <select class="form-select" aria-label="Default select example" name="barang_id">
                            <option selected disabled>Pilih Barang</option>
                            @foreach ($barang as $key=> $val)
                                <option value="{{ $val->id }}">{{ $val->nama_barang.' - (RP '.number_format($val->harga_satuan,2,',','.').')'}}</option>
                            @endforeach
                          </select>
                    </div>
                    <div class="mb-3">
                        <label for="qty" class="form-label">Qty</label>
                        <input type="number" class="form-control" id="qty" name="qty" placeholder="Contoh : 10">
                    </div>
                    <div class="mb-3">
                        <label for="harga_satuan" class="form-label">Harga Jual Satuan</label>
                        <input type="number" class="form-control" id="harga_satuan" name="harga_satuan" >
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
