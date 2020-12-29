<!-- tanggal hari ini + 14-->
<?php $tanggal = date('Y-m-d', strtotime("+14 day", strtotime(date('Y-m-d')))); ?>

<!-- Form Tambah data peminjaman -->
<div class="form-row">
    <div class="form-group col-md-12 col-sm-12">
        <div class="card shadow mb-4 pinjam">
            <!-- btn back -->
            <div class="card-header">
                <a href="<?= site_url('peminjaman/read') ?>"><i class="fas fa-arrow-left"></i>
                    Back</a>
            </div>

            <div class="card-body">
                <form method="post" action="<?= site_url('peminjaman/insert/'); ?>" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>KODE PINJAM</label>
                            <input type="text" class="form-control" name="kd_pinjam" value="TR<?= sprintf("%05s", $kode_pinjam) ?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Nama Anggota</label>
                            <select name="nama" class="form-control" value="<?= set_value('nama'); ?>">
                                <option name="" selected disabled>-- Pilih --</option>
                                <?php foreach ($data_anggota as $anggota) : ?>
                                    <option value="<?= $anggota['id_anggota']; ?>"><?= $anggota['nim']; ?> - <?= $anggota['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Pinjam</label>
                        <input type="date" class="form-control" name="tgl_pinjam" value="<?= date("Y-m-d"); ?>" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label>Batas Pinjam</label>
                        <input type="date" class="form-control" name="bts_pinjam" value="<?= $tanggal ?>" readonly="readonly">
                    </div>
                    <div>
                        <p>&nbsp;</p>
                        <input class="btn btn-primary" type="submit" name="submit" value="Proses">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Form Buku Yang di pinjam -->
    <div class="form-group col-md-12 col-sm-12">
        <div class="card shadow mb-4 buku" style="display: none;">
            <div class="card-body">
                <form method="post" action="<?php echo site_url('detail/insert/'); ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>KODE PINJAM</label>
                        <?php foreach ($data_pinjam as $data) : ?>
                            <input type="text" class="form-control" name="dt_pinjam" value="<?= $data['kd_pinjam'] ?>" readonly>
                        <?php endforeach; ?>
                    </div>
                    <div class="form-group">
                        <label>Buku</label>
                        <select multiple name="buku" class="form-control" required>
                            <option name="" selected disabled>-- Pilih --</option>
                            <?php foreach ($data_buku as $data) : ?>
                                <option value="<?php echo $data['id_buku']; ?>"><?= $data['judul']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('buku', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div>
                        <p>&nbsp;</p>
                        <input class="btn btn-primary" type="submit" name="submit" value="Tambah">
                        <a href="<?= site_url('peminjaman/read') ?>" class="btn btn-secondary">Selesai</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Table data Detail Peminjaman -->
<div class="card shadow mb-4 table" style="display: none;">
    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-primary">3 Data Buku yang baru di pinjam</h6>
    </a>
    <div class="collapse show" id="collapseCardExample">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table" width="100%" cellspacing="0">
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
        $('#table').DataTable({
            "pageLength": 3,
            "lengthChange": false,
        });

        const formBuku = document.querySelector('.buku');
        const table = document.querySelector('.table');
        const formPinjam = document.querySelector('.pinjam');
        const flashdata = $('.flash-data').data('tempdata');
        // console.log(flashdata);

        if (flashdata) {
            Swal.fire({
                title: 'Success',
                text: flashdata,
                icon: 'success'
            });

            table.style.display = "block";
            formBuku.style.display = "block";
            formPinjam.style.display = "none";
        }
    });
</script>