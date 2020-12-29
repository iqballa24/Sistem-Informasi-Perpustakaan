<div class="col-sm-12">
    <div class="card shadow mb-4">
        <!-- btn back -->
        <div class="card-header">
            <a href="<?= site_url('buku/read') ?>"><i class="fas fa-arrow-left"></i>
                Back</a>
        </div>
        <!-- btn back -->

        <div class="card-body">
            <!-- Form -->
            <form method="post" action="<?= site_url('buku/insert/'); ?>" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>ISBN</label>
                        <input type="text" class="form-control" name="isbn" value="<?= set_value('isbn'); ?>">
                        <?= form_error('isbn', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Nama buku</label>
                        <input type="text" class="form-control" name="nama" value="<?= set_value('nama'); ?>">
                        <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Kategori</label>
                        <select name="id_kategori" class="form-control" value="<?= set_value('id_kategori'); ?>">
                            <option name="" selected disabled>-- Pilih --</option>
                            <?php foreach ($data_kategori as $kategori) : ?>
                                <option value="<?= $kategori['id_kategori']; ?>"><?= $kategori['kategori']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('id_kategori', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Penerbit</label>
                        <select name="id_penerbit" class="form-control" value="<?= set_value('id_penerbit'); ?>">
                            <option name="" selected disabled>-- Pilih --</option>
                            <?php foreach ($data_penerbit as $penerbit) : ?>
                                <option value="<?= $penerbit['id_penerbit']; ?>"><?= $penerbit['penerbit']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('id_penerbit', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Tahun terbit</label>
                        <input type="text" class="form-control" name="thnTerbit" value="<?= set_value('thnTerbit'); ?>">
                        <?= form_error('thnTerbit', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Stok</label>
                        <input type="text" class="form-control" name="stok" value="<?= set_value('stok'); ?>">
                        <?= form_error('stok', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label>Rating</label>
                    <select name="rate" class="form-control" value="<?= set_value('rate'); ?>">
                        <option disabled selected>-- Select --</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <?= form_error('rate', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <label>Gambar</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="userfile" id="validatedInputGroupCustomFile" required>
                    <label class="custom-file-label" for="validatedInputGroupCustomFile">Choose File...</label>
                    <!--response setelah upload-->
                    <?php if (!empty($response)) : ?>
                        <small class="text-danger pl-3">
                            <?= $response; ?>
                        </small>
                    <?php endif; ?>
                </div>
                <div>
                    <p>&nbsp;</p>
                    <input class="btn btn-primary" type="submit" name="submit" value="Simpan">
                </div>
            </form>
            <!-- Form -->
        </div>
    </div>
</div>