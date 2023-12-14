
<style>
    #tes{
        border: 1px solid black
    }
</style>
    <table style="border: 1ch black; width: 100%; table-layout: fixed;">
        <tr></tr>
        <tr>
            <td></td>
            <td style="font-weight:bold;text-align: center;">             PT SURYARAYA RUBBERINDO INDUSTRI</td>
            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            <th style="border: 1px solid black; font-weight:600; text-align: center;">
                No. Dokumen
            </th>
            <th colspan="2" style="border: 1px solid black; font-weight:600; text-align: center;">
                
            </th>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            <th style="border: 1px solid black; font-weight:600; text-align: center;">
                Revisi
            </th>
            <th colspan="2" style="border: 1px solid black; font-weight:600; text-align: center;">
                
            </th>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            <th style="border: 1px solid black; font-weight:600; text-align: center;">
                Tanggal Berlaku
            </th>
            <th colspan="2" style="border: 1px solid black; font-weight:600; text-align: center;">
                
            </th>
        </tr>
        <tr>
            <td></td>
            <th colspan="11" style="font-weight:bold; text-align: center;">
                LEMBAR KEGIATAN LIMBAH BAHAN BERBAHAYA DAN BERACUN (B3)
            </th>
        </tr>
        <tr>
            <td></td>
            <th colspan="11" style="font-weight:bold; text-align: center;">
                PT. SURYARAYA RUBBERINDO INDUSTRIES
            </th>
            <th></th><th></th><th></th><th></th><th></th>
        </tr>
        <tr></tr>
        <tr>
            <td></td>
            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            <th></th><th></th><th></th><th></th><th></th>
        </tr>
        <tr>
            <th colspan="7" style="border: 1px solid black; font-weight:bold; text-align: center;">
                MASUKNYA LIMBAH B3 KE TPS
            </th>
            <td></td>
            <th colspan="5" style="border: 1px solid black; font-weight:bold; text-align: center;">
                KELUARNYA LIMBAH B3 DARI TPS
            </th>
            <th colspan="2" style="border: 1px solid black; font-weight:bold; text-align: center;">
                SISA
            </th>
            <th></th><th></th>
        </tr>
        <thead style="border: 1px solid black">
            <tr style="border: 1px solid black">
                <th style="border: 1px solid black; color:black; font-weight:bold">
                    No
                </th>
                <th style="border: 1px solid black; color:black; font-weight:bold">
                    Jenis Limbah B3 Masuk
                </th>
                <th style="border: 1px solid black; color:black; font-weight:bold">
                    Tanggal Masuk Limbah B3
                </th>
                <th style="border: 1px solid black; color:black; font-weight:bold">
                    Sumber limbah B3
                </th>
                <th colspan="2" style="border: 1px solid black; color:black; font-weight:bold">
                    Jumlah Limbah B3 Masuk ( ton atau kg)
                </th>
                <th style="border: 1px solid black; color:black; font-weight:bold">
                    Maksimal penyimpanan s/d tanggal
                </th>
                <th></th>
                <th style="border: 1px solid black; color:black; font-weight:bold">
                    Tanggal Keluar Limbah B3
                </th>
                <th colspan="2" style="border: 1px solid black; color:black; font-weight:600">
                    Jumlah Limbah B3 ( ton atau kg)
                </th>
                <th style="border: 1px solid black; color:black; font-weight:600">
                    Tujuan Penyerahan
                </th>
                <th style="border: 1px solid black; color:black; font-weight:600">
                    Bukti Nomer Dokumen
                </th>
                <th colspan="2" style="border: 1px solid black; color:black; font-weight:600">
                    Sisa LB3 yang ada di TPS ( ton atau kg)
                </th>
                <th></th><th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($report_data as $key => $val)
                @php
                    $no = $key + 1;
                @endphp
                @if ($val->jenis_transaksi == 'Pengeluaran')
                <tr>
                    <td style="border: 1px solid black;font-weight:500">
                        {{ $no }} 
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                        {{ $val->jenis_limbah_name ?? ''}}
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                        {{ $val->tanggal_masuk != '' ? date("d-M-Y",strtotime($val->tanggal_masuk)) : '' }}
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                        {{ $val->sumber_limbah_name ?? ''}}
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                        {{ $val->jumlah_limbah_masuk ?? ''}}
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                        KG
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                        {{ $val->maksimal_penyimpanan != '' ? date("d-M-Y",strtotime($val->maksimal_penyimpanan)) : '' }}
                    </td>
                    <td></td>
                    <td style="border: 1px solid black;font-weight:500">
                        {{ $val->tanggal_keluar != '' ? date("d-M-Y",strtotime($val->tanggal_keluar)) : '' }}
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                        {{ $val->jumlah_limbah_keluar ?? ''}}
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                        KG
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                        {{ $val->vendors_name ?? ''}}
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                        {{ $val->bukti_nomor_dokumen ?? ''}}
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                        {{ $val->sisa_akhir ?? ''}}
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                        KG
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;font-weight:500">
                        {{ $no + 1}}
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                        SUB_TOTAL
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                        {{ $val->sisa_akhir ?? ''}}
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                        KG
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                    </td>
                    <td></td>
                    <td style="border: 1px solid black;font-weight:500">
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                        {{ $val->jumlah_limbah_keluar ?? ''}}
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                        
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                    </td>
                    <td style="border: 1px solid black;font-weight:500">
                        KG
                    </td>

                </tr>
                    
                @else
                    <tr>
                        <td style="border: 1px solid black;font-weight:500">
                            {{ $no}}
                        </td>
                        <td style="border: 1px solid black;font-weight:500">
                            {{ $val->jenis_limbah_name ?? ''}}
                        </td>
                        <td style="border: 1px solid black;font-weight:500">
                            {{ $val->tanggal_masuk != '' ? date("d-M-Y",strtotime($val->tanggal_masuk)) : '' }}
                        </td>
                        <td style="border: 1px solid black;font-weight:500">
                            {{ $val->sumber_limbah_name ?? ''}}
                        </td>
                        <td style="border: 1px solid black;font-weight:500">
                            {{ $val->jumlah_limbah_masuk ?? ''}}
                        </td>
                        <td style="border: 1px solid black;font-weight:500">
                            KG
                        </td>
                        <td style="border: 1px solid black;font-weight:500">
                            {{ $val->maksimal_penyimpanan != '' ? date("d-M-Y",strtotime($val->maksimal_penyimpanan)) : '' }}
                        </td>
                        <td></td>
                        <td style="border: 1px solid black;font-weight:500">
                            {{ $val->tanggal_keluar != '' ? date("d-M-Y",strtotime($val->tanggal_keluar)) : '' }}
                        </td>
                        <td style="border: 1px solid black;font-weight:500">
                            {{ $val->jumlah_limbah_keluar ?? ''}}
                        </td>
                        <td style="border: 1px solid black;font-weight:500">
                            KG
                        </td>
                        <td style="border: 1px solid black;font-weight:500">
                            {{ $val->vendors_name ?? ''}}
                        </td>
                        <td style="border: 1px solid black;font-weight:500">
                            {{ $val->bukti_nomor_dokumen ?? ''}}
                        </td>
                        <td style="border: 1px solid black;font-weight:500">
                            {{ $val->sisa_akhir ?? ''}}
                        </td>
                        <td style="border: 1px solid black;font-weight:500">
                            KG
                        </td>
                    </tr>
                @endif
                
            @endforeach
        </tbody>
        <tr>
            <td></td>
            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            <th style="font-weight:bold; text-align: center;">Cileungsi, 12 Desember 2023</th>
        </tr>
        <tr>
            <td></td>
            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            <th style="border: 1px solid black; font-weight:bold; text-align: center;">
                Dibuat
            </th>
            <th colspan="2" style="border: 1px solid black; font-weight:bold; text-align: center;">
                Diketahui
            </th>
        </tr>
        <tr>
            <td></td>
            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            <th rowspan="3" style="border: 1px solid black; font-weight:bold; text-align: center;">
                
            </th>
            <th colspan="2" rowspan="3" style="border: 1px solid black; font-weight:bold; text-align: center;">
                
            </th>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td></td>
            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            <th style="border: 1px solid black; font-weight:bold; text-align: center;">
                PIC Limbah
            </th>
            <th colspan="2" style="border: 1px solid black; font-weight:bold; text-align: center;">
                Ka.Sie.
            </th>
        </tr>
        
</table>