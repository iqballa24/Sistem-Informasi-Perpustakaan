<div class="form-group col-md-12">
    <div class="card shadow mb-4">
        <!-- btn back -->
        <div class="card-header">
            <a href="<?php echo site_url('peminjaman/read/'); ?>"><i class="fas fa-arrow-left"></i>
                Back</a>
        </div>
        <!-- btn back -->
        <div class="card-body">
            <!-- Form -->
            <form method="post" action="<?php echo site_url('peminjaman/update_submit/' . $data_peminjaman_single['kd_pinjam']); ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Nama Anggota</label>
                    <select name="nama" class="form-control" required>
                        <option name="" selected disabled>-- Pilih --</option>
                        <?php foreach ($data_anggota as $anggota) : ?>
                            <?php if ($anggota['id_anggota'] == $data_peminjaman_single['id_anggota']) : ?>
                                <option value="<?php echo $anggota['id_anggota']; ?>" selected><?php echo $anggota['nama']; ?></option>
                            <?php else : ?>
                                <option value="<?php echo $anggota['id_anggota']; ?>"><?php echo $anggota['nama']; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tanggal Pinjam</label>
                    <input type="date" class="form-control" name="tgl_pinjam" value="<?php echo $data_peminjaman_single['tgl_pinjam']; ?>" required>
                </div>
                <div class=" form-group">
                    <label>Batas Pinjam</label>
                    <input type="date" class="form-control" name="bts_pinjam" value="<?php echo $data_peminjaman_single['bts_pinjam']; ?>" required>
                </div>
                <div>
                    <p>&nbsp;</p>
                    <input class="btn btn-success" type="submit" name="submit" value="Simpan">
                </div>
            </form>
            <!-- Form -->
        </div>
    </div>
</div>