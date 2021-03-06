<!-- Body Content -->
<div class="card shadow mb-4">
    <div class="card-header">
        <a href="<?php echo site_url('rak/insert') ?>"><i class="fas fa-plus"></i>
            Add New</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="table" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th> # </th>
                        <th> Rak </th>
                        <th> Kategori </th>
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
                "url": "<?php echo site_url('rak/datatables') ?>",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [0, 3],
                "orderable": false,
            }],
        });        
    });
</script>