<div class="card shadow mb-4">

    <div class="card-header">
        <a href="<?php echo site_url('jenis_denda/insert') ?>"><i class="fas fa-plus"></i>
            Add New</a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="table" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th> Jenis Denda </th>
                        <th> Biaya Denda </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Content table -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Js -->
<script type="text/javascript">
    var table;
    $(document).ready(() => {

        table = $('#table').DataTable({

            "responsive": true,
            "processing": true,
            "language": {
                "processing": '<i class="fas fa-circle-notch fa-spin fa-1x fa-fw"></i><span>Loading...</span> '
            },
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('jenis_denda/datatables') ?>",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }, ],
        });

    });
</script>