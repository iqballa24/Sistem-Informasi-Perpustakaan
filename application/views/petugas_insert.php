<div class="col-sm-12">
    <div class="card shadow mb-4">
        <!-- btn back -->
        <div class="card-header">
            <a href="<?= site_url('petugas/read') ?>"><i class="fas fa-arrow-left"></i>
                Back</a>
        </div>
        <!-- btn back -->
        <div class="card-body">
            <form method="post" action="<?= site_url('petugas/insert/'); ?>">
                <div class="form-row">
                    <div class="form-group col-6">
                        <label>NIP</label>
                        <input type="text" class="form-control" name="nip" value="<?= set_value('nip'); ?>">
                        <?= form_error('nip', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group col-6">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" value="<?= set_value('nama'); ?>">
                        <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email" value="<?= set_value('email'); ?>">
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label>Level</label>
                    <select class="form-control" name="level" value ="<?= set_value('level')?>">
                        <option disabled selected>-- Select -- </option>
                        <option value="admin">admin</option>
                        <option value="petugas">petugas</option>
                    </select>
                    <?= form_error('level', '<small class="text-danger pl-3">', '</small>'); ?>
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