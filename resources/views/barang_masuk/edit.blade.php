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
                <form action="{{ route('barang.update' , ['barang' => $barang->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" value="{{ $barang->nama_barang ?? '' }}" name="nama_barang" autofocus>
                      </div>
                      <div class="mb-3">
                          <label for="merek" class="form-label">Merek</label>
                          <input type="text" class="form-control" id="merek" name="merek" value="{{ $barang->merek ?? '' }}">
                        </div>
                      <div class="mb-3">
                          <label for="jenis_barang" class="form-label">Jenis Barang</label>
                          <select class="form-select" aria-label="Default select example" name="jenis_barang">
                              <option value="Sepatu" {{ $barang->jenis_barang == 'Sepatu' ? 'selected' : '' }}>Sepatu</option>
                              <option value="Sendal" {{ $barang->jenis_barang == 'Sendal' ? 'selected' : '' }}>Sendal</option>
                            </select>
                      </div>
                      <div class="mb-3">
                          <label for="deskripsi_barang" class="form-label">Deskripsi Barang</label>
                          <textarea class="form-control" id="deskripsi_barang" rows="3" name="deskripsi_barang">{{ $barang->deskripsi_barang ?? '' }}</textarea>
                      </div>
                      <div class="mb-3">
                          <label for="ukuran" class="form-label">Ukuran</label>
                          <select class="form-select" aria-label="Default select example" name="ukuran">
                              @php
                                  for($i = 35; $i <= 45 ; $i++){
                                      if ($barang->ukuran == $i){
                                        echo '<option value="'.$i.'" selected>'.$i.'</option>';
                                      }else{
                                        echo '<option value="'.$i.'" >'.$i.'</option>';
                                      }
                                  }
                              @endphp
                            </select>
                      </div>
                      <div class="mb-3">
                          <label for="harga_satuan" class="form-label">Harga Satuan</label>
                          <input type="text" class="form-control" id="harga_satuan" name="harga_satuan" placeholder="Contoh : 100000" value="{{ $barang->harga_satuan ?? '' }}" >
                      </div>
                      <div class="mb-3">
                          <label for="gambar_barang" class="form-label">Gambar Barang</label>
                          <input class="form-control" type="file" id="gambar_barang" name="gambar_barang">
                      </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
