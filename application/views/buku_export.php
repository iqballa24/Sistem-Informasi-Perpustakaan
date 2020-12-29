<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=export_data_buku.xls");
?>


<table border="1">
    <thead>
        <tr>
            <th colspan="6">DATA KESELURUAH BUKU PERPUSTAKAAN SIP UMB</th>
        </tr>
        <tr>
            <th>ID Buku</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Penerbit</th>
            <th>Stok buku</th>
            <th>Gambar</th>
        </tr>
    </thead>
    <tbody>
        <!--looping data peminjaman-->
        <?php foreach ($data_buku as $data) : ?>

            <!--cetak data per baris-->
            <tr>
                <td><?= $data['id_buku']; ?></td>
                <td><?= $data['judul']; ?></td>
                <td><?= $data['kategori']; ?></td>
                <td><?= $data['penerbit']; ?></td>
                <td><?= $data['stok_buku']; ?></td>
                <td><?= $data['gambar']; ?></td>
            </tr>
        <?php endforeach ?>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <th>PETUGAS : <?= $data_petugas; ?></th>
        </tr>
    </tbody>
</table>