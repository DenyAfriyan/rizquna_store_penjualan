@extends('layouts.app')
@section('content')
<div class="row" style="min-height: 75vh">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <a href="{{ route('barang-keluar.create') }}" class="btn btn-sm btn-dark float-end m-0"><i class="fas fa-plus"></i> <span>Add {{ $title }}</span></a>
          <h6 class="fw-bold text-dark">{{ $title }} Table</h6>
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
                        <th>QTY</th>
                        <th>Margin</th>
                        <th>Nama Karyawan</th>
                    </tr>
                </thead>
                <tbody>
                  @if (count($barang_keluar) > 0)
                    @foreach ($barang_keluar as $key => $row)
                    <tr>
                      <td class="align-middle text-center" style="width: 10%">
                        <span class="text-dark">{{ $key + 1 }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ $row->barang->nama_barang ?? '' }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ $row->qty }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ $row->margin }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ $row->nama_karyawan }}</span>
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
            }
        });
    })
</script>
@endsection
