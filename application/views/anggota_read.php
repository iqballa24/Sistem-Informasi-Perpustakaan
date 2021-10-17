<!-- Body Content -->
<div class="card shadow mb-4">
	<div class="card-header">
		<a href="#" data-toggle="modal" data-target="#Modal_Add"><i class="fas fa-plus"></i>
			Add New</a>
		<a href="<?php echo site_url('anggota/import') ?>"><i class="fas fa-plus"></i>
			Import</a>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-striped" id="table" width="100%" cellspacing="0">
				<thead class="thead-dark">
					<tr>
						<th> # </th>
						<th> NIM </th>
						<th> Nama </th>
						<th> Program Studi </th>
						<th> Email </th>
						<th> Password </th>
						<th> Action </th>
					</tr>
				</thead>
				<tbody>
					<!-- content table -->
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- End Body Content -->

<!-- Modal Add -->
<form>
	<div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-md-2 col-form-label">NIM</label>
						<div class="col-md-10">
							<input type="text" name="nim" id="nim" class="form-control" placeholder="NIM">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label">Nama</label>
						<div class="col-md-10">
							<input type="text" name="nama" id="nama" class="form-control" placeholder="Nama">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label">Program Studi</label>
						<div class="col-md-10">
							<input type="text" name="program_studi" id="program_studi" class="form-control" placeholder="Program Studi">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label">Email</label>
						<div class="col-md-10">
							<input type="text" name="email" id="email" class="form-control" placeholder="Email">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" type="submit" id="btn_save" class="btn btn-primary">Save</button>
				</div>
			</div>
		</div>
	</div>
</form>
<!--END MODAL ADD-->

<!-- MODAL UPDATE -->
<div class="modal fade" id="Modal_Update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Update Data</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group row">
						<label class="col-md-2 col-form-label">NIM</label>
						<div class="col-md-10">
							<input type="text" name="nim_u" id="nim_u" class="form-control" placeholder="NIM">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label">Nama</label>
						<div class="col-md-10">
							<input type="text" name="nama_u" id="nama_u" class="form-control" placeholder="Nama">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label">Program Studi</label>
						<div class="col-md-10">
							<input type="text" name="program_studi_u" id="program_studi_u" class="form-control" placeholder="Program Studi">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label">Email</label>
						<div class="col-md-10">
							<input type="text" name="email_u" id="email_u" class="form-control" placeholder="Email">
						</div>
						<input type="hidden" id="id_anggota" name="id_anggota">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" type="submit" id="btn_update" class="btn btn-primary">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- END MODAL UPDATE -->

<!-- Js -->
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() {
		var table = $('#table').DataTable({
			"responsive": true,
			"processing": true,
			"language": {
				"processing": '<i class="fas fa-circle-notch fa-spin fa-1x fa-fw"></i><span>Loading...</span> '
			},
			"serverSide": true,
			"order": [],
			"ajax": {
				"url": "<?php echo site_url('anggota/datatables') ?>",
				"type": "POST"
			},
			"columnDefs": [{
				"targets": [0, 6],
				"className": 'dt-center',
				"orderable": false,
			}],
		});

		//Save anggota
		$('#btn_save').on('click', function() {
			let nim = $('#nim').val();
			let nama = $('#nama').val();
			let program_studi = $('#program_studi').val();
			let email = $('#email').val();

			$.ajax({
				type: "POST",
				url: "<?php echo site_url('anggota/save') ?>",
				dataType: "JSON",
				data: {
					nim: nim,
					nama: nama,
					program_studi: program_studi,
					email: email
				},
				success: function(data) {
					if (data.error) {
						console.log(data.error)
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: data.error,
						})
					}

					if (data.success) {
						$('[name="nim"]').val("");
						$('[name="nama"]').val("");
						$('[name="program_studi"]').val("");
						$('[name="email"]').val("");
						$('#Modal_Add').modal('hide');
						Swal.fire({
							title: 'Success',
							text: data.success,
							icon: 'success'
						});
						table.ajax.reload();
					}
				},
				error: function(request, status, error) {
					alert(error);
				}
			});
			// table.ajax.reload();
			// return false;
		});

		//GET data update anggota
		$('#table tbody').on('click', '.item_update', function(e) {
			e.preventDefault();

			const id_anggota = $(this).attr('data');

			$.ajax({
				type: "GET",
				url: `<?php echo base_url() ?>index.php/anggota/get_update/${id_anggota}`,
				dataType: "JSON",
				data: {
					id_anggota: id_anggota
				},
				success: function(data) {
					$('#Modal_Update').modal('show');
					$.each(data, function() {
						$('[name="nim_u"]').val(data.nim);
						$('[name="nama_u"]').val(data.nama);
						$('[name="program_studi_u"]').val(data.prodi);
						$('[name="email_u"]').val(data.email);
						$('#id_anggota').val(data.id_anggota);
					});
				},
				error: function(request, status, error) {
					alert(request.responseText);
				}
			});
		});

		// SIMPAN ANGGOTA
		$('#btn_update').on('click', function() {
			let nim = $('[name="nim_u"]').val();
			let nama = $('[name="nama_u"]').val();
			let program_studi = $('[name="program_studi_u"]').val();
			let email = $('[name="email_u"]').val();
			let id_anggota = $('#id_anggota').val();

			$.ajax({
				type: "POST",
				url: "<?php echo site_url('anggota/Simpan') ?>",
				dataType: "JSON",
				data: {
					nim_u: nim,
					nama_u: nama,
					program_studi_u: program_studi,
					email_u: email,
					id_anggota: id_anggota
				},
				success: function(data) {
					if (data.error) {
						console.log(data.error)
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: data.error,
						})
					}

					if (data.success) {
						$('#Modal_Update').modal('hide');
						Swal.fire({
							title: 'Success',
							text: data.success,
							icon: 'success'
						});
						table.ajax.reload();
					}
				},
				error: function(request, status, error) {
					alert(error);
				}
			});
		});


	});
</script>