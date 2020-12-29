<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=export_data_pengembalian.xls");
?>


<table border="1">
    <thead>
        <tr>
            <th colspan="8">DATA KESELURUAH PENGEMBALIAN PERPUSTAKAAN SIP UMB</th>
        </tr>
        <tr>
            <th> kode peminjaman </th>
            <th> NIM </th>
            <th> Nama </th>
            <th> Tanggal Pinjam </th>
            <th> Batas Pinjam </th>
            <th> Tanggal Kembali </th>
            <th> Jumlah Buku Pinjam </th>
            <th> Jumlah Buku Kembali </th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($data_pengembalian as $data) : ?>

            <!--cetak data per baris-->
            <tr>
                <td><?= $data['kd_pinjam']; ?></td>
                <td><?= $data['nim']; ?></td>
                <td><?= $data['nama']; ?></td>
                <td><?= $data['tgl_pinjam']; ?></td>
                <td><?= $data['bts_pinjam']; ?></td>
                <td><?= $data['tgl_kembali']; ?></td>
                <td><?= $data['Jumlah']; ?></td>
                <td><?= $data['jumlah']; ?></td>
            </tr>
        <?php endforeach ?>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <th colspan="8">PETUGAS : <?= $data_petugas; ?></th>
        </tr>
    </tbody>
</table>