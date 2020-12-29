<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=export_data_anggota.xls");
?>


<table border="1">
    <thead>
        <tr>
            <th colspan="5">DATA KESELURUAH ANGGOTA PERPUSTAKAAN SIP UMB</th>
        </tr>
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Program Studi</th>
            <th>Email</th>
            <th>Password</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data_anggota as $data) : ?>

            <!--cetak data per baris-->
            <tr>
                <td><?= $data['nim']; ?></td>
                <td><?= $data['nama']; ?></td>
                <td><?= $data['prodi']; ?></td>
                <td><?= $data['email']; ?></td>
                <td><?= $data['password']; ?></td>
            </tr>
        <?php endforeach ?>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <th colspan="5">PETUGAS : <?= $data_petugas; ?></th>
        </tr>
    </tbody>
</table>