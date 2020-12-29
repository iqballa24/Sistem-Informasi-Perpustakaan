<div class="col-sm-12">
    <div class="card shadow mb-4">

        <!-- btn back -->
        <div class="card-header">
            <a href="<?php echo site_url('jenis_denda/read'); ?>"> <i class="fas fa-arrow-left"></i> Back </a>
        </div>

        <!-- btn back -->
        <div class="card-body">
            <!-- Form -->
            <form method="post" action="<?= site_url('jenis_denda/insert/'); ?>">
                <div class="form-group">
                    <label>Jensi Denda</label>
                    <input class="form-control" type="text" name="jenis_denda" value="<?= set_value('jenis_denda'); ?>"></>
                    <?= form_error('jenis_denda', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label>Biaya</label>
                    <td><input class="form-control" type="text" name="biaya" value="<?= set_value('biaya'); ?>"></td>
                    <?= form_error('biaya', '<small class="text-danger pl-3">', '</small>'); ?>
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