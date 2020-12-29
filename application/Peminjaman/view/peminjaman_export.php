<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=export_data_peminjaman.xls");
?>


<table border="1">
    <thead>
        <tr>
            <th colspan="7">DATA KESELURUAH PEMINJAMAN PERPUSTAKAAN SIP UMB</th>
        </tr>
        <tr>
            <th>kode peminjaman</th>
            <th>NIM</th>
            <th>Nama Peminjam</th>
            <th>Tanggal Pinjam</th>
            <th>Batas Pinjam</th>
            <th>Jumlah Buku</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <!--looping data peminjaman-->
        <?php foreach ($data_peminjaman as $data) : ?>

            <!--cetak data per baris-->
            <tr>
                <td><?= $data['kd_pinjam']; ?></td>
                <td><?= $data['nim']; ?></td>
                <td><?= $data['nama']; ?></td>
                <td><?= $data['tgl_pinjam']; ?></td>
                <td><?= $data['bts_pinjam']; ?></td>
                <td><?= $data['Jumlah']; ?></td>
                <td><?= $data['status']; ?></td>
            </tr>
        <?php endforeach ?>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <th colspan="7">PETUGAS : <?= $data_petugas; ?></th>
        </tr>
    </tbody>
</table>