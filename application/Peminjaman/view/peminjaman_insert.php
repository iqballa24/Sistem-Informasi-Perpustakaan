<!--Alert -->
<?php if ($this->session->tempdata('message') == TRUE) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <p><?= $this->session->tempdata('message'); ?>
    </div>
<?php endif; ?>

<!-- tanggal hari ini + 14-->
<?php $tanggal = date('Y-m-d', strtotime("+14 day", strtotime(date('Y-m-d')))); ?>

<!-- Form Tambah data peminjaman -->
<div class="form-row">
    <div class="form-group col-md-6 col-sm-12">
        <div class="card shadow mb-4">
            <!-- btn back -->
            <div class="card-header">
                <a href="<?= site_url('peminjaman/read') ?>"><i class="fas fa-arrow-left"></i>
                    Back</a>
            </div>
            <!-- btn back -->
            <div class="card-body">
                <form method="post" action="<?php echo site_url('peminjaman/insert/'); ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>KODE PINJAM</label>
                        <input type="text" class="form-control" name="kd_pinjam" value="<?= set_value('kd_pinjam'); ?>">
                        <?= form_error('kd_pinjam', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label>Nama Anggota</label>
                        <select name="nama" class="form-control" value="<?= set_value('nama'); ?>">
                            <option name="" selected disabled>-- Pilih --</option>
                            <?php foreach ($data_anggota as $anggota) : ?>
                                <option value="<?php echo $anggota['id_anggota']; ?>"><?php echo $anggota['nim']; ?> - <?php echo $anggota['nama']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Pinjam</label>
                        <input type="date" class="form-control" name="tgl_pinjam" value="<?= date("Y-m-d"); ?>" readonly="readonly">
                        <?= form_error('tgl_pinjam', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label>Batas Pinjam</label>
                        <input type="date" class="form-control" name="bts_pinjam" value="<?= $tanggal ?>" readonly="readonly">
                        <?= form_error('tgl_pinjam', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div>
                        <p>&nbsp;</p>
                        <input class="btn btn-success" type="submit" name="submit" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Form Tambah Buku Yang di pinjam -->
    <div class="form-group col-md-6 col-sm-12">
        <div class="card shadow mb-4">
            <div class="card-header">
                <label>Form Buku yang ingin di Pinjam</label>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo site_url('detail/insert/'); ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>KODE PINJAM</label>
                        <select name="dt_pinjam" class="form-control">
                            <option name="" selected disabled>-- Pilih --</option>
                            <?php foreach ($status_pinjam as $data) : ?>
                                <option value="<?= $data['kd_pinjam']; ?>"><?= $data['kd_pinjam']; ?> - <?= $data['nama']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('dt_pinjam', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label>Buku (stok)</label>
                        <select multiple name="buku" class="form-control">
                            <option name="" selected disabled>-- Pilih --</option>
                            <?php foreach ($data_buku as $data) : ?>
                                <option value="<?php echo $data['id_buku']; ?>"><?= $data['judul']; ?> (<?= $data['stok_buku']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('buku', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div>
                        <p>&nbsp;</p>
                        <input class="btn btn-success" type="submit" name="submit" value="Simpan">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Table Detail Peminjaman -->
<div class="card shadow mb-4">
    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-primary">3 Data Buku yang baru di pinjam</h6>
    </a>
    <div class="collapse show" id="collapseCardExample">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="myDetail" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Kode Peminjaman </th>
                            <th> Buku </th>
                            <th> Sisa Stok </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($dt_peminjaman as $data) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $data['kd_pinjam']; ?></td>
                                <td><?= $data['judul']; ?></td>
                                <td><?= $data['stok_buku']; ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Datatables -->
<script>
    $(document).ready(function() {
        $('#myDetail').DataTable({
            "pageLength": 3,
            "lengthChange": false,
        });
    });
</script>