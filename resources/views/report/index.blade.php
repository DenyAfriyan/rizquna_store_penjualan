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
              <button onclick="exportsReportPerItem()" class="btn btn-dark float-end ms-3"><i class="fas fa-file-excel"></i>&nbsp; Export Per Item</button>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="" class="mt-5">Filter</label>
              <div id="reportrange-tanggalmasuk" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down"></i>
              </div>
            </div>
            <div class="col-md-4">
              <label for="" class="mt-5">
                Per Item
              </label>
              <select name="filter-item" id="filter-item" class="form-control">
                  <option value="" selected>
                    All
                  </option>
                  @foreach ($jenis_limbah_id as $key => $val)
                  <option value="{{ $val }}">
                    {{ $key }}
                  </option>
                  @endforeach
              </select>
            </div>
            {{-- <div class="col-md-6">
              <label for="" class="mt-5">Tanggal Keluar Limbah</label>
              <div id="reportrange-tanggalkeluar" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down"></i>
              </div>
            </div> --}}
          </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          @if(session()->has('message'))
              <div class="alert alert-success">
                  {{ session()->get('message') }}
              </div>
          @endif
          <div class="table-responsive p-4">
            <table id="DataGrid1" class="table table-striped table-bordered table-hover" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Limbah B3 Masuk</th>
                        <th>Tanggal Masuk Limbah B3</th>
                        <th>Sumber Limbah B3</th>
                        <th>Jumlah Limbah Masuk</th>
                        <th>Maksimal Penyimpanan s/d</th>
                        <th>Tanggal Keluar Limbah B3</th>
                        <th>Jumlah Limbah B3 Keluar</th>
                        <th>Tujuan Penyerahan</th>
                        <th>Bukti Nomer Dokumen</th>
                        <th>Sisa Limbah B3 yang ada di TPS</th>
                    </tr>
                </thead>
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
    var table;
    var start_date_limbah_masuk;
    var end_date_limbah_masuk;
    var start_date_limbah_keluar;
    var end_date_limbah_keluar;
    $(function(){
      var start_limbah_masuk = moment().subtract(29, 'days');
      var end_limbah_masuk = moment();
      var start_limbah_keluar = moment().subtract(29, 'days');
      var end_limbah_keluar = moment();
      start_date_limbah_masuk = start_limbah_masuk.format('YYYY-MM-DD')
      end_date_limbah_masuk = end_limbah_masuk.format('YYYY-MM-DD')
      start_date_limbah_keluar = start_limbah_keluar.format('YYYY-MM-DD')
      end_date_limbah_keluar = end_limbah_keluar.format('YYYY-MM-DD')

      function cb_limbah_masuk(start_limbah_masuk, end_limbah_masuk) {
          start_date_limbah_masuk = start_limbah_masuk.format('YYYY-MM-DD')
          end_date_limbah_masuk = end_limbah_masuk.format('YYYY-MM-DD')
          
          $('#reportrange-tanggalmasuk span').html(start_limbah_masuk.format('D MMMM YYYY') + ' - ' + end_limbah_masuk.format('D MMMM YYYY'));
      }
      function cb_limbah_keluar(start_limbah_keluar, end_limbah_keluar) {
          start_date_limbah_keluar = start_limbah_keluar.format('YYYY-MM-DD')
          end_date_limbah_keluar = end_limbah_keluar.format('YYYY-MM-DD')
          
          $('#reportrange-tanggalkeluar span').html(start_limbah_keluar.format('D MMMM YYYY') + ' - ' + end_limbah_keluar.format('D MMMM YYYY'));
      }
      $('#reportrange-tanggalmasuk').on('apply.daterangepicker', function (ev, picker) {
          table.ajax.url("{{url('report-datatable')}}?start_date_limbah_masuk="
         +start_date_limbah_masuk+"&end_date_limbah_masuk="+end_date_limbah_masuk+"&start_date_limbah_keluar="
         +start_date_limbah_keluar+"&end_date_limbah_keluar="+end_date_limbah_keluar);
          table.ajax.reload(null, false); 
      });
      $('#reportrange-tanggalkeluar').on('apply.daterangepicker', function (ev, picker) {
          table.ajax.url("{{url('report-datatable')}}?start_date_limbah_masuk="
         +start_date_limbah_masuk+"&end_date_limbah_masuk="+end_date_limbah_masuk+"&start_date_limbah_keluar="
         +start_date_limbah_keluar+"&end_date_limbah_keluar="+end_date_limbah_keluar);
          table.ajax.reload(null, false); 
      });

      $('#reportrange-tanggalmasuk').daterangepicker({
          startDate: start_limbah_masuk,
          endDate: end_limbah_masuk,
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Q1': [moment().quarter(1).startOf('quarter'), moment().quarter(1).endOf('quarter')],
            'Q2': [moment().quarter(2).startOf('quarter'), moment().quarter(2).endOf('quarter')],
            'Q3': [moment().quarter(3).startOf('quarter'), moment().quarter(3).endOf('quarter')],
            'Q4': [moment().quarter(4).startOf('quarter'), moment().quarter(4).endOf('quarter')],
            'This Year': [moment().startOf('year'), moment().endOf('year')],
          }
        }, cb_limbah_masuk);

      $('#reportrange-tanggalkeluar').daterangepicker({
          startDate: start_limbah_keluar,
          endDate: end_limbah_keluar,
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Q1': [moment().quarter(1).startOf('quarter'), moment().quarter(1).endOf('quarter')],
            'Q2': [moment().quarter(2).startOf('quarter'), moment().quarter(2).endOf('quarter')],
            'Q3': [moment().quarter(3).startOf('quarter'), moment().quarter(3).endOf('quarter')],
            'Q4': [moment().quarter(4).startOf('quarter'), moment().quarter(4).endOf('quarter')],
            'This Year': [moment().startOf('year'), moment().endOf('year')],
          }
        }, cb_limbah_keluar);

        cb_limbah_keluar(start_limbah_keluar, end_limbah_keluar);
        cb_limbah_masuk(start_limbah_masuk, end_limbah_masuk);
        
        table = $('#DataGrid1').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{url('report-datatable')}}?start_date_limbah_masuk="
         +start_date_limbah_masuk+"&end_date_limbah_masuk="+end_date_limbah_masuk+"&start_date_limbah_keluar="
         +start_date_limbah_keluar+"&end_date_limbah_keluar="+end_date_limbah_keluar,
         columns: [
                {
                    data: "sisa_id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    width : "35px"
                },
                { data: "jenis_limbah_name"},
                { data: "tanggal_masuk"},
                { data: "jumlah_limbah_masuk"},
                { data: "sumber_limbah_name"},
                { data: "maksimal_penyimpanan"},
                { data: "tanggal_keluar"},
                { data: "jumlah_limbah_keluar"},  
                { data: "vendors_name"},
                { data: "bukti_nomor_dokumen"},
                { data: "sisa_akhir"},
         ],
         language: {
                'paginate': {
                'previous': '<i class="fa fa-toggle-left"></i>',
                'next': '<i class="fa fa-toggle-right"></i>'
                }
            }
      });
      $('#filter-item').select2({
        theme: "classic"
    });
    })
    function exportsReport(){
        window.location.href = "{{url('report/export')}}/"+start_date_limbah_masuk+"/"+end_date_limbah_masuk+"/"
         +start_date_limbah_keluar+"/"+end_date_limbah_keluar;
	  }
    function exportsReportPerItem(){
        if ($('#filter-item').val() != ''){
          window.location.href = "{{url('report/export')}}/"+start_date_limbah_masuk+"/"+end_date_limbah_masuk+"/"
         +start_date_limbah_keluar+"/"+end_date_limbah_keluar+"/"+$('#filter-item').val();
        }else{
          alert("Harap Pilih jenis limbah terlebih dahulu");
        }
        
	  }
</script>
@endsection