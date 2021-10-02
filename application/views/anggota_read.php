<!-- Body Content -->
<div class="card shadow mb-4">
	<div class="card-header">
		<a href="<?php echo site_url('anggota/insert') ?>"><i class="fas fa-plus"></i>
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

<!-- Js -->
<script type="text/javascript">
	$(document).ready(() => {
		$('#table').DataTable({
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

	});
</script>