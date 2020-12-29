<!-- Body Content -->
<div class="card shadow mb-4">
    <div class="card-header">
        <a href="<?php echo site_url('petugas/insert') ?>"><i class="fas fa-plus"></i>
            Add New</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="table" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th> # </th>
                        <th> NIP </th>
                        <th> Nama </th>
                        <th> Email </th>
                        <th> Level </th>
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
                "url": "<?php echo site_url('petugas/datatables') ?>",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }],
        });

        // action ketika menghapus data
        $('#table tbody').on('click', '.btnHapus', function(e) {
            e.preventDefault();
            const href = $(this).attr('href');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    document.location.href = href;
                }
            })
        });

        // alert success
        const flashdata = $('.flash-data').data('tempdata');
        // console.log(flashdata);
        if (flashdata) {
            Swal.fire({
                title: 'Success',
                text: flashdata,
                icon: 'success'
            })
        }

        // Alert error
        const error = $('.flash-data-error').data('tempdata');
        if (error) {
            Swal.fire({
                title: 'Oops...',
                text: 'ERROR : ' + error,
                icon: 'error'
            });
        }

    });
</script>