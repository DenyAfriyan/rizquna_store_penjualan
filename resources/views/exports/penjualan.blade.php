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
        </tr>
        @endforeach
      @endif
    </tbody>
</table>
