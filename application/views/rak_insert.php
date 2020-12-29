<div class="col-sm-12">
    <div class="card shadow mb-4">
        <!-- btn back -->
        <div class="card-header">
            <a href="<?= site_url('rak/read') ?>"><i class="fas fa-arrow-left"></i>
                Back</a>
        </div>
        <!-- btn back -->
        <div class="card-body">
            <form method="post" action="<?= site_url('rak/insert/'); ?>">
                <div class="form-group">
                    <label>Rak</label>
                    <input type="text" class="form-control" name="rak" value="<?= set_value('rak'); ?>">
                    <?= form_error('rak', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori" class="form-control" value="<?= set_value('kategori'); ?>">
                        <option name="" selected disabled>-- Pilih --</option>
                        <?php foreach ($data_kategori as $kategori) : ?>
                            <option value="<?= $kategori['id_kategori']; ?>"><?= $kategori['kategori']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('kategori', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div>
                    <p>&nbsp;</p>
                    <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        // Alert error
        const error = $('.flash-data-error').data('tempdata');

        if (error) {
            Swal.fire({
                title: 'Info',
                text: error,
                icon: 'info'
            });
        }

    });
</script>