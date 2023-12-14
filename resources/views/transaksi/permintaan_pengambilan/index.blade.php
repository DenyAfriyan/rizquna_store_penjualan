@extends('layouts.app')
@section('content')
<div class="row" style="min-height: 75vh">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          @can('permintaan pengambilan')
          <a href="{{ route('permintaan-pengambilan.create') }}" class="btn btn-sm btn-dark float-end m-0"><i class="fas fa-plus"></i> <span>Add {{ $title }}</span></a> 
          @endcan
          <h6 class="fw-bold text-dark">{{ $title }} Table</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          @if(session()->has('message'))
              <div class="alert alert-success">
                  {{ session()->get('message') }}
              </div>
          @endif
          <div class="table-responsive p-4">
            <table id="permintaan-pengambilan-table" class="table table-striped table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Limbah</th>
                        <th>Sumber Limbah</th>
                        <th>Notes</th>
                        <th>Tanggal Dibuat</th>
                        <th>Status</th>
                        @can('setujui pengambilan')
                        <th>Action</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                  @if (count($permintaan_pengambilan) > 0) 
                    @foreach ($permintaan_pengambilan as $key => $row)
                    <tr>
                      <td class="align-middle text-center" style="width: 10%">
                        <span class="text-dark">{{ $key + 1 }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ $row->jenis_limbah->name }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ $row->sumber_limbah->name }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ $row->notes }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="text-dark">{{ date("d-m-Y",strtotime($row->created_at)) }}</span>
                      </td>
                      <td class="align-middle">
                        <span class="badge bg-{{ $row->is_approved == 1 ? "success" : "warning text-dark"  }}">{{ $row->is_approved == 1 ? "Disetujui" : "Menunggu Persetujuan"  }}</span>
                      </td>
                      @can('setujui pengambilan')
                      <td class="align-middle" style="width: 20%">
                        @if ($row->is_approved != 1)
                        <form action="{{ route('permintaan-pengambilan.update', $row->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin setujui permintaan?');" style="display: inline-block;">
                          <input type="hidden" name="_method" value="PUT">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          {{-- <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></span></button> --}}
                          <button type="submit" class="btn btn-info m-0">
                            <i class="fa fa-user-check"></i>
                          </button>
                        </form>
                        @endif
                        <form action="{{ route('permintaan-pengambilan.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin?');" style="display: inline-block;">
                          <input type="hidden" name="_method" value="DELETE">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          {{-- <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></span></button> --}}
                          <button type="submit" class="btn btn-danger m-0">
                            <i class="fa fa-trash"></i>
                          </button>
                        </form>
                      </td>   
                      @endcan 
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
        $('#permintaan-pengambilan-table').dataTable({
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