<div class="col-sm-12">
	<div class="card shadow mb-4">
		<!-- btn back -->
		<div class="card-header">
			<a href="<?= site_url('anggota/read') ?>"><i class="fas fa-arrow-left"></i>
				Back</a>
		</div>
		<!-- btn back -->
		<div class="card-body">
			<form method="post" action="<?= site_url('anggota/insert/'); ?>">
				<div class="form-row">
					<div class="form-group col-6">
						<label>NIM</label>
						<input type="text" class="form-control" name="nim" value="<?= set_value('nim'); ?>">
						<?= form_error('nim', '<small class="text-danger pl-3">', '</small>'); ?>
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
					<label>Program studi</label>
					<input type="text" class="form-control" name="prodi" value="<?= set_value('prodi'); ?>">
					<?= form_error('prodi', '<small class="text-danger pl-3">', '</small>'); ?>
				</div>
				<div>
					<p>&nbsp;</p>
					<input type="submit" name="submit" value="Simpan" class="btn btn-primary">
				</div>
			</form>
		</div>
	</div>
</div>