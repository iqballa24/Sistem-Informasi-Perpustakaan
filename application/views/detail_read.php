<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">KODE PINJAM</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php foreach ($kode as $data) : ?>
                            <?= $data['kd_pinjam']; ?>
                        <?php endforeach ?>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-user fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header">
        <a href="<?php echo site_url('peminjaman/read') ?>"><i class="fas fa-arrow-left"></i>
            Back
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="myTable" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th> # </th>
                        <th> Judul </th>
                        <th> Gambar </th>
                        <th> Kategori </th>
                        <th> Penerbit </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($dt_peminjaman as $pinjam) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $pinjam['judul']; ?></td>
                            <td>
                                <?php if (!empty($pinjam['gambar'])) : ?>
                                    <img src="<?= base_url('upload_folder/' . $pinjam['gambar']); ?>" class="img-fluid" alt="ini gambar" style="height:70px;">
                                <?php endif; ?>
                            </td>
                            <td><?= $pinjam['kategori']; ?></td>
                            <td><?= $pinjam['penerbit']; ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>