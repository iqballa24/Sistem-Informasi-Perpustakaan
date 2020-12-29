<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=export_data_peminjaman.xls");
?>


<table border="1">
    <thead>
        <tr>
            <th colspan="7">DATA PEMINJAMAN ANGGOTA PERPUSTAKAAN SIP UMB</th>
        </tr>
        <tr>
            <th>kode peminjaman</th>
            <th>NIM</th>
            <th>Nama Peminjam</th>
            <th>Tanggal Pinjam</th>
            <th>Batas Pinjam</th>
            <th>Jumlah</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <!--looping data peminjaman-->
        <?php foreach ($dt_peminjam as $data) : ?>
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
            <td colspan="7"></td>
        </tr>
        <tr>
            <th colspan="5">DAFTAR BUKU YANG DIPINJAM ANGGOTA</th>
        </tr>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Penerbit</th>
            <th>Gambar</th>
        </tr>
        <?php $i = 1;
        foreach ($dt_peminjaman as $data) : ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $data['judul']; ?></td>
                <td><?= $data['kategori']; ?></td>
                <td><?= $data['penerbit']; ?></td>
                <td><?= $data['gambar']; ?></td>
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