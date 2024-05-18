@extends('layouts.app')
@section('content')
<div class="row" style="min-height: 75vh">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
            <div class="row justify-content-between">
                <div class="col-6">
                  <h6 class="fw-bold text-dark">{{ $title }} Table</h6>
                </div>
                <div class="col-6">
                  <button onclick="exportsReport()" class="btn btn-dark float-end ms-3"><i class="fas fa-file-excel"></i>&nbsp; Export</button>
                </div>
              </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          @if(session()->has('message'))
              <div class="alert alert-success">
                  {{ session()->get('message') }}
              </div>
          @endif
          <div class="table-responsive p-4">
            <table id="barang-table" class="table table-striped table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jenis Barang</th>
                        <th>Deskripsi Barang</th>
                        <th>Merek</th>
                        <th>Ukuran</th>
                        <th>Harga Satuan</th>
                        <th>Stok</th>
                        <th>Barang Keluar</th>
                        <th>Margin</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @if (count($barang) > 0)
                    @foreach ($barang as $key => $row)
                    <?php
                        $totalKeluar = $barangKeluar->firstWhere('barang_id', $row->id)->total_keluar ?? 0;
                        $totalMargin = $barangKeluar->firstWhere('barang_id', $row->id)->total_margin ?? 0;
                    ?>
                    <tr>
                      <td class="align-middle text-center" style="width: 10%">
                        <span class="text-dark">{{ $key + 1 }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ $row->nama_barang }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ $row->jenis_barang }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ $row->deskripsi_barang }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ $row->merek }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ $row->ukuran }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ $row->harga_satuan }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ $row->stok }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ $totalKeluar }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ $totalMargin }}</span>
                      </td>
                      <td class="align-middle" style="width: 20%">
                        <a href="{{ route('barang.edit', ['barang' => $row->id]) }}" class="btn btn-info m-0">
                          <i class="fa fa-pen"></i>
                        </a>
                        <form action="{{ route('barang.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin?');" style="display: inline-block;">
                          <input type="hidden" name="_method" value="DELETE">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          {{-- <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></span></button> --}}
                          <button type="submit" class="btn btn-danger m-0">
                            <i class="fa fa-trash"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                    @endforeach
                  @endif
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('custom_script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function(){
        $('#barang-table').dataTable({
            language: {
                'paginate': {
                'previous': '<i class="fa fa-toggle-left"></i>',
                'next': '<i class="fa fa-toggle-right"></i>'
                }
            },


        });
    })
    function exportsReport(){
        window.location.href = "{{url('/report-penjualan')}}";
	  }
</script>
@endsection
