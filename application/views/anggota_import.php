<div class="col-sm-12">
	<div class="card shadow mb-4">
		<!-- btn back -->
		<div class="card-header">
			<a href="<?= site_url('anggota/read') ?>"><i class="fas fa-arrow-left"></i>
				Back</a>
		</div>
		<!-- btn back -->
		<div class="card-body">
			<form method="post" action="<?= site_url('anggota/upload/'); ?>" enctype="multipart/form-data">
				<div class="form-group">
					<label>UNGGAH FILE EXCEL</label>
					<input type="file" class="form-control" name="userfile" value="<?= set_value('userfile'); ?>">
					<?= form_error('userfile', '<small class="text-danger pl-3">', '</small>'); ?>
				</div>
				<div>
					<p>&nbsp;</p>
					<input type="submit" name="submit" value="Simpan" class="btn btn-primary">
				</div>
			</form>
		</div>
	</div>
</div>