<!-- Form -->
<div class="col-sm-12">
    <div class="card shadow mb-4">

        <!-- btn back -->
        <div class="card-header">
            <a href="<?php echo site_url('jenis_denda/read'); ?>"> <i class="fas fa-arrow-left"></i> Back </a>
        </div>

        <div class="card-body">
            <!-- Form -->
            <form method="post" action="<?= site_url('jenis_denda/update/' . $data_jenis_denda_single['id_jenis_denda']); ?>">
                <div class="form-group">
                    <label>Jenis Denda</label>
                    <input class="form-control" type="text" name="jenis_denda" value="<?= $data_jenis_denda_single['jenis_denda'] ?>">
                </div>
                <div class="form-group">
                    <label>Biaya Denda</label>
                    <input class="form-control" type="text" name="biaya" value="<?= $data_jenis_denda_single['biaya'] ?>">
                </div>
                <div>
                    <br>
                    <input class="btn btn-primary" type="submit" name="submit" value="Simpan">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- sideBar Toggle-->
<script src="<?= base_url('assets/js/sb-admin-2.min.js'); ?>"></script>