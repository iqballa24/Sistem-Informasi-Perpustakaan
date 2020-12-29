<!--Alert -->
<?php if ($this->session->tempdata('message') == TRUE) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <p><?php echo $this->session->tempdata('message'); ?>
    </div>
<?php endif; ?>

<!-- Body Content -->
<div class="card shadow mb-4">
    <div class="card-header">
        <a href="<?php echo site_url('peminjaman/insert') ?>"><i class="fas fa-plus"></i>
            Add New</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="table" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th> # </th>
                        <th> Kode Pinjam </th>
                        <th> Nama </th>
                        <th> Tanggal Pinjam </th>
                        <th> Batas Pinjam </th>
                        <th> Jumlah Buku </th>
                        <th> Status </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Content table -->
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <a href="<?= site_url('peminjaman/export/'); ?>">
            <i class="fas fa-file-excel"></i> Laporan Peminjaman
        </a>
    </div>
</div>
<!-- End Body Content -->

<script type="text/javascript">
    var table;
    jQuery(document).ready(function() {
        table = $('#table').DataTable({

            "responsive": true,
            "processing": true,
            "language": {
                "processing": '<i class="fas fa-circle-notch fa-spin fa-1x fa-fw"></i><span>Loading...</span> '
            },
            "serverSide": true,
            "lengthChange": false,
            "pageLength": 5,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('peminjaman/datatables') ?>",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }, ],
        });

        $('#table tbody').on('click', '.hapus', () => {
            if (!confirm("Are you sure ?")) {
                return false;
            }
        });
    });
</script>