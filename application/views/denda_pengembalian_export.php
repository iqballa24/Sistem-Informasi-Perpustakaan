<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=export_data_peminjaman.xls");
?>


<table border="1">
    <thead>
        <tr>
            <th colspan="6">DATA PENGEMBALIAN ANGGOTA PERPUSTAKAAN SIP UMB</th>
        </tr>
        <tr>
            <th>KODE PINJAM</th>
            <th>NIM</th>
            <th>NAMA</th>
            <th>Tanggal Pinjam</th>
            <th>Batas Pinjam</th>
            <th>Tanggal Kembali</th>
        </tr>
    </thead>
    <tbody>
        <!--looping data peminjaman-->
        <?php foreach ($data_pengembalian as $data) : ?>
            <!--cetak data per baris-->
            <tr>
                <td><?= $data['kd_pinjam']; ?></td>
                <td><?= $data['nim']; ?></td>
                <td><?= $data['nama']; ?></td>
                <td><?= $data['tgl_pinjam']; ?></td>
                <td><?= $data['bts_pinjam']; ?></td>
                <td><?= $data['tgl_kembali']; ?></td>
            </tr>
        <?php endforeach ?>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <th colspan="5">DAFTAR DENDA</th>
        </tr>
        <tr>
            <th>No</th>
            <th>Jenis Denda</th>
            <th>Biaya Denda</th>
            <th>Jumlah (buku/hari)</th>
            <th>Jumlah Denda</th>
        </tr>
        <?php $i = 1;
        foreach ($data_denda as $data) : ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $data['jenis_denda']; ?></td>
                <td><?= 'Rp.' . number_format($data['biaya']) ?></td>
                <td><?= $data['Jumlah']; ?></td>
                <td><?= 'Rp.' . number_format($data['total_denda']) ?></td>
            </tr>
        <?php endforeach ?>
        <tr>
            <th colspan="4">TOTAL DENDA YANG HARUS DI BAYAR :</th>
            <td colspan="1">
                <?php foreach ($jumlah as $data) : ?>
                    <?= 'Rp.' . number_format($data['total_denda']) ?>
                <?php endforeach ?>
            </td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <th colspan="6">PETUGAS : <?= $data_petugas; ?></th>
        </tr>
    </tbody>
</table>