@extends('layouts.app')
@section('content')
<div class="row" style="min-height: 75vh">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <a href="{{ route('pengeluaran.create') }}" class="btn btn-sm btn-dark float-end m-0"><i class="fas fa-plus"></i> <span>Add {{ $title }}</span></a>
          <h6 class="fw-bold text-dark">{{ $title }} Table</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          @if(session()->has('message'))
              <div class="alert alert-success">
                  {{ session()->get('message') }}
              </div>
          @endif
          <div class="table-responsive p-4">
            <table id="pengeluaran-table" class="table table-striped table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Bukti No Dokumen</th>
                        <th>Jenis Limbah</th>
                        <th>Vendor</th>
                        <th>Jumlah Limbah Keluar</th>
                        <th>Tanggal Keluar</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @if (count($pengeluaran) > 0) 
                    @foreach ($pengeluaran as $key => $row)
                    <tr>
                      <td class="align-middle text-center" style="width: 10%">
                        <span class="text-dark">{{ $key + 1 }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ $row->bukti_nomor_dokumen }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ $row->jenis_limbah->name }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ $row->vendor->name }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ $row->jumlah_limbah_keluar }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ date("d-m-Y",strtotime($row->tanggal_keluar)) }}</span>
                      </td>
                      <td class="align-middle" style="width: 20%">
                        <a href="{{ route('pengeluaran.edit', ['pengeluaran' => $row->id]) }}" class="btn btn-info m-0">
                          <i class="fa fa-pen"></i>
                        </a>
                        <form action="{{ route('pengeluaran.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin?');" style="display: inline-block;">
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
        $('#pengeluaran-table').dataTable({
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