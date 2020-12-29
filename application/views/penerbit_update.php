<div class="col-sm-12">
    <div class="card shadow mb-4">
        <!-- btn back -->
        <div class="card-header">
            <a href="<?php echo site_url('penerbit/read') ?>"><i class="fas fa-arrow-left"></i>
                Back</a>
        </div>
        <!-- btn back -->
        <div class="card-body">
            <!-- Form -->
            <form method="post" action="<?= site_url('penerbit/update/' . $data_penerbit_single['id_penerbit']); ?>">
                <div class="form-group">
                    <label>Penerbit</label>
                    <input type="text" class="form-control" name="penerbit" value="<?= $data_penerbit_single['penerbit']; ?>">
                    <?= form_error('penerbit', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div>
                    <div>&nbsp;</div>
                    <input class="btn btn-primary" type="submit" name="submit" value="Simpan">
                </div>
            </form>
        </div>
    </div>
</div>