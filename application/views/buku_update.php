<div class="col-sm-12">
    <div class="card shadow mb-4">
        <!-- card header -->
        <div class="card-header">
            <a href="<?php echo site_url('buku/read') ?>"><i class="fas fa-arrow-left"></i>
                Back</a>
        </div>
        <!-- card body -->
        <div class="card-body">
            <!-- form -->
            <form method="post" action="<?php echo site_url('buku/update_submit/' . $data_buku_single['id_buku']); ?>" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>ISBN</label>
                        <input type="text" class="form-control" name="isbn" value="<?= $data_buku_single['ISBN']; ?>" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Nama buku</label>
                        <input type="text" class="form-control" name="nama" value="<?= $data_buku_single['judul']; ?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Kategori</label>
                        <select name="id_kategori" class="form-control" value="<?= set_value('id_kategori'); ?>" required>
                            <?php foreach ($data_kategori as $kategori) : ?>
                                <?php if ($kategori['id_kategori'] == $data_buku_single['id_kategori']) : ?>
                                    <option value="<?= $kategori['id_kategori']; ?>" selected><?= $kategori['kategori']; ?></option>
                                <?php else : ?>
                                    <option value="<?= $kategori['id_kategori']; ?>"><?= $kategori['kategori']; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Penerbit</label>
                        <select name="id_penerbit" class="form-control" value="<?= set_value('id_penerbit'); ?>" required>
                            <?php foreach ($data_penerbit as $penerbit) : ?>
                                <?php if ($penerbit['id_penerbit'] == $data_buku_single['id_penerbit']) : ?>
                                    <option value="<?= $penerbit['id_penerbit']; ?>" selected><?= $penerbit['penerbit']; ?></option>
                                <?php else : ?>
                                    <option value="<?= $penerbit['id_penerbit']; ?>"><?= $penerbit['penerbit']; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Tahun terbit</label>
                        <input type="text" class="form-control" name="thnTerbit" value="<?= $data_buku_single['thn_terbit']; ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Stok</label>
                        <input type="text" class="form-control" name="stok" value="<?= $data_buku_single['stok_buku']; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Rating</label>
                    <select name="rate" class="form-control" value="">
                        <option value="<?= $data_buku_single['rating']; ?>" selected><?= $data_buku_single['rating']; ?></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <label>Gambar</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="userfile" value="<?= base_url('upload_folder/' . $data_buku_single['gambar']) ?>">
                    <label class="custom-file-label">Choose Image...</label>
                    <!--response setelah upload-->
                    <?php if (!empty($response)) : ?>
                        <small class=" text-danger pl-3">
                            <?php echo $response; ?>
                        </small>
                    <?php endif; ?>
                </div>
                <div>
                    <p>&nbsp;</p>
                    <br>
                    <button class="btn btn-primary" type="submit" name="submit" value="Simpan">Simpan</button>
                </div>
            </form>
            <!-- form -->
        </div>
        <!-- card body -->
    </div>
</div>