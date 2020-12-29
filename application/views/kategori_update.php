<div class="col-sm-12">
    <div class="card shadow mb-4">
        <!-- btn back -->
        <div class="card-header">
            <a href="<?php echo site_url('kategori/read') ?>"><i class="fas fa-arrow-left"></i>
                Back</a>
        </div>
        <!-- btn back -->
        <div class="card-body">
            <form method="post" action="<?= site_url('kategori/update/' . $data_kategori_single['id_kategori']); ?>">
                <div class="form-group">
                    <label>Kategori</label>
                    <input type="kategori" class="form-control" name="kategori" value="<?= $data_kategori_single['kategori']; ?>">
                    <?= form_error('kategori', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div>
                    <div>&nbsp;</div>
                    <input class="btn btn-primary" type="submit" name="submit" value="Simpan">
                </div>
            </form>
        </div>
    </div>
</div>