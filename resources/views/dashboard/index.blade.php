@extends('layouts.app')
@section('content')
<div class="row" style="min-height: 75vh">
  <div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <a href="{{ route('permintaan-pengambilan.index') }}">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-9">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize  font-weight-bold">Request Limbah Baru</p>
                <h5 class="font-weight-bolder mb-0 " >
                  {{ $permintaan_pengambilan_baru }}
                </h5>
              </div>
            </div>
            <div class="col-3">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="fas fa-inbox "></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </a>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Stok Limbah Di TPS</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $total_sisa->sisa_akhir ?? 0 }} Kg
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="fas fa-warehouse"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Limbah Masuk</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $limbah_masuk ?? 0 }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="fas fa-arrow-down"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Limbah Keluar</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $limbah_keluar ?? 0 }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="fas fa-arrow-up"></i >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row justify-content-center pt-4">
    <div class="col-md-12">
      <div class="card text-center">
        <div class="card-header pb-0">
            <h6 class="text-start">Stock Limbah di TPS Perjenis Limbah</h6>
        </div>
        <div class="card-body px-0 pb-2 m-2">
          <div class="table-responsive">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <td class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 text-start">Jenis Limbah</td>
                  <td class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 text-start">Stock</td>
                </tr>
              </thead>
              <tbody>
                @if (count($sisa) > 0)
                  @foreach ($sisa as $row)
                  <tr>
                    <td class="align-middle text-start text-sm">
                      <span class="text-xs font-weight-bold text-dark"> {{ $row->jenis_limbah->name }} </span>
                    </td>
                    <td class="align-middle text-start text-sm">
                      <span class="text-xs font-weight-bold text-danger"> {{ $row->sisa_akhir }} </span>
                    </td>
                  </tr>                  
                  @endforeach
                @else
                  <tr>
                    <td colspan="2" class="text-center">
                      Limbah di TPS Kosong
                    </td>
                  </tr>
                @endif
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="chart">
        <canvas id="jenis-limbah-chart" width="600" height="400"></canvas>
      </div>
    </div>
  </div>
</div>
@endsection
@section('custom_script')
<script>

</script>
@endsection