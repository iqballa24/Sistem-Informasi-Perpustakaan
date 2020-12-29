<div class="row">
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
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">TOTAL DENDA</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php foreach ($jumlah as $data) : ?>
                                <?= 'Rp.'.number_format($data['total_denda']) ?>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header">
        <a href="<?php echo site_url('pengembalian/read') ?>"><i class="fas fa-arrow-left"></i>
            Back
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="myTable" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th> # </th>
                        <th> Jenis Denda </th>
                        <th> Biaya Denda </th>
                        <th> Jumlah (Buku/Hari) </th>
                        <th> Jumlah Denda </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($data_denda as $data) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $data['jenis_denda']; ?></td>
                            <td><?= 'Rp.'.number_format($data['biaya']) ?></td>
                            <td><?= $data['Jumlah']; ?></td>
                            <td><?= 'Rp.'.number_format($data['total_denda']) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="text-right">
            <a href="<?php echo site_url('pengembalian/insert') ?>"><i class="fas fa-arrow-right"></i>
                Add
            </a>
        </div>
    </div>
</div>