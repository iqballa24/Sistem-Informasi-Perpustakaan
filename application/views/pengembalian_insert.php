<!-- Form Tambah data pengembalian -->
<div class="form-row">
    <div class="form-group col-md-12 col-sm-12">
        <div class="card shadow mb-4 kembali">
            <!-- btn back -->
            <div class="card-header">
                <a href="<?= site_url('pengembalian/read') ?>"><i class="fas fa-arrow-left"></i>
                    Back</a>
            </div>
            <!-- btn back -->
            <div class="card-body">
                <form method="post" action="<?php echo site_url('pengembalian/insert_submit/'); ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>KODE PINJAM</label>
                        <select name="kd_pinjam" class="form-control" value="<?= set_value('kd_pinjam'); ?>" required>
                            <option name="" selected disabled>-- Pilih --</option>
                            <?php foreach ($status_pinjam as $data) : ?>
                                <option value="<?php echo $data['kd_pinjam']; ?>"><?php echo $data['kd_pinjam']; ?> - <?php echo $data['nama']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Kembali</label>
                        <input type="date" class="form-control" name="tgl_kembali" value="<?= date("Y-m-d"); ?>" readonly="readonly" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Buku Kembali</label>
                        <input type="text" class="form-control" name="jumlah" value="<?= set_value('jumlah'); ?>" required>
                    </div>
                    <div>
                        <p>&nbsp;</p>
                        <input class="btn btn-primary" type="submit" name="submit" value="Proses">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Form Denda -->
    <div class="form-group col-md-12 col-sm-12">
        <div class="card shadow mb-4 denda" style="display: none;">
            <div class="card-header">
                <?php foreach ($data_kembali as $data) : ?>
                    <h6 class="m-0 font-weight-bold text-primary">Form denda - <?= $data['kd_pinjam'] == null ? "-" : $data['kd_pinjam']; ?></h6>
                <?php endforeach; ?>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo site_url('denda/insert/'); ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <?php foreach ($data_kembali as $data) : ?>
                            <input type="text" class="form-control" name="kd_pinjam" value="
                            <?= $data['kd_kembali'] ?>
                        <?php endforeach; ?>" hidden>
                    </div>
                    <div class="form-group">
                        <label>Jenis Denda</label>
                        <select name="denda" class="form-control" value="<?= set_value('denda'); ?>" required>
                            <option name="" selected disabled>-- Pilih --</option>
                            <?php foreach ($data_denda as $data) : ?>
                                <option value=" <?= $data['id_jenis_denda']; ?>"><?= $data['jenis_denda']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Hari/Buku</label>
                        <input type="text" class="form-control" name="value" value="<?= set_value('value'); ?>" required>
                    </div>
                    <div>
                        <div>&nbsp;</div>
                        <input class="btn btn-primary" type="submit" name="submit" value="Tambah">
                        <a href="<?= site_url('pengembalian/read'); ?>" class="btn btn-secondary">Selesai</a>
                        <small class="text-secondary">* Klik selesai jika tidak memiliki denda</small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Table Detail pengembalian -->
<div class="card shadow mb-4 table" style="display: none;">
    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-primary">Informasi keterlambatan dan buku hilang</h6>
    </a>
    <div class="collapse show" id="collapseCardExample">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Kode Pinjam </th>
                            <th> Nama </th>
                            <th> Batas Pinjam </th>
                            <th> Tanggal Kembali </th>
                            <th> Telat </th>
                            <th> Hilang </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($data_pengembalian as $data) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $data['kd_pinjam']; ?></td>
                                <td><?= $data['nama']; ?></td>
                                <td><?php $tgl = date_create($data['bts_pinjam']);
                                    echo date_format($tgl, "D, d M Y"); ?></td>
                                <td><?php $tgl = date_create($data['tgl_kembali']);
                                    echo date_format($tgl, "D, d M Y"); ?></td>
                                <td><?= $data['telat'] <= 0 ? '-' :  $data['telat'] . ' hari' ?></td>
                                <td><?= $data['hilang'] <= 0 ? '-' : $data['hilang'] . 'buku' ?></td>
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

        const formDenda = document.querySelector('.denda');
        const table = document.querySelector('.table');
        const formKembali = document.querySelector('.kembali');
        const flashdata = $('.flash-data').data('tempdata');

        // Alert success
        if (flashdata) {
            Swal.fire({
                title: 'Success',
                text: flashdata,
                icon: 'success'
            });

            table.style.display = "block";
            formDenda.style.display = "block";
            formKembali.style.display = "none";
        }

        // Alert error
        const error = $('.flash-data-error').data('tempdata');

        if (error) {
            Swal.fire({
                title: 'Info',
                text: error,
                icon: 'info'
            });

            table.style.display = "block";
            formDenda.style.display = "block";
            formKembali.style.display = "none";
        }
    });
</script>