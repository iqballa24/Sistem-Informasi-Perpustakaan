<div class="col-sm-12">
    <div class="card shadow mb-4">
        <!-- btn back -->
        <div class="card-header">
            <a href="<?php echo site_url('petugas/read') ?>"><i class="fas fa-arrow-left"></i>
                Back</a>
        </div>
        <!-- btn back -->
        <div class="card-body">
            <form method="post" action="<?php echo site_url('petugas/update/' . $data_petugas_single['NIP']); ?>">
                <div class="form-row">
                    <div class="form-group col-6">
                        <label>NIP</label>
                        <input type="text" class="form-control" name="nip" value="<?php echo $data_petugas_single['NIP']; ?>" readonly>
                        <?= form_error('nip', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group col-6">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" value="<?php echo $data_petugas_single['nama']; ?>">
                        <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $data_petugas_single['email']; ?>">
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label>Level</label>
                    <select name="level" class="form-control" value="<?= set_value('level'); ?>" required>
                        <option value="<?= $data_petugas_single['level']; ?>" selected><?= $data_petugas_single['level']; ?></option>
                        <option value="admin">admin</option>
                        <option value="petugas">petugas</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="text" class="form-control" name="password" value="<?php echo $data_petugas_single['NIP']; ?>">
                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div>
                    <p>&nbsp;</p>
                    <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>