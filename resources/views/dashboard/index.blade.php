@extends('layouts.app')
@section('content')
<div class="row" style="min-height: 75vh">
  <div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-9">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize  font-weight-bold">Total Stock Barang</p>
                <h5 class="font-weight-bolder mb-0 " >
                    {{ $total_stock_barang ?? 0 }}
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
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Jumlah Barang Masuk</p>
                <h5 class="font-weight-bolder mb-0">
                    {{ $total_barang_masuk ?? 0 }}
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
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Jumlah Barang Keluar</p>
                <h5 class="font-weight-bolder mb-0">
                    {{ $total_barang_keluar ?? 0 }}
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
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Jumlah Karyawan</p>
                <h5 class="font-weight-bolder mb-0">
                    {{ $total_users_karyawan ?? 0 }}
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
  </div>
</div>
@endsection
@section('custom_script')
<script>

</script>
@endsection
