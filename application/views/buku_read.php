<!-- Body Content -->
<div class="card shadow mb-4">
    <div class="card-header">
        <a href="<?php echo site_url('buku/insert') ?>"><i class="fas fa-plus"></i>
            Add New</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped " id="table" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th> # </th>
                        <th style="width: 360px;"> Judul </th>
                        <th> Gambar </th>
                        <th> Kategori </th>
                        <th> Penerbit </th>
                        <th> Stok </th>
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

<!-- Modal -->
<div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body table-responsive">
                <div class="row">
                    <div class="col-lg-4">
                        <ul class="list-group">
                            <li class="list-group-item border-0"><span id="gambar"></span></li>
                        </ul>
                    </div>
                    <div class="col-lg-8">
                        <ul class="list-group">
                            <li class="list-group-item"><strong>ISBN</strong> : <span id="isbn"></span></li>
                            <li class="list-group-item"><strong>Title</strong> : <span id="judul"></span></li>
                            <li class="list-group-item"><strong>Publisher</strong> : <span id="penerbit"></span></li>
                            <li class="list-group-item"><strong>Category</strong> : <span id="kategori"></span></li>
                            <li class="list-group-item"><strong>Year</strong> : <span id="thnTerbit"></span></li>
                            <li class="list-group-item"><strong>Rate</strong> : <span id="rate"></span></li>
                            <li class="list-group-item"><strong>Location</strong> : <span id="rak"></span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Js -->
<script type="text/javascript">
    // Datatables server side
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
                "url": "<?php echo site_url('buku/datatables') ?>",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [0, 6],
                "orderable": false,
            }, ],
        });

        // Set image
        const images = document.querySelector('#gambar');
        const setImage = new Image(200, 250);

        // Event click btn detail modal box
        $('#table tbody').on('click', '.detail', function(e) {

            e.preventDefault();
            const kategori = $(this).data('kategori');
            const penerbit = $(this).data('penerbit');
            const thnTerbit = $(this).data('terbit');
            const gambar = $(this).data('gambar');
            const judul = $(this).data('judul');
            const isbn = $(this).data('isbn');
            const rate = $(this).data('rate');
            const rak = $(this).data('rak');

            // Load content
            $('#thnTerbit').text(thnTerbit);
            $('#penerbit').text(penerbit);
            $('#kategori').text(kategori);
            $('#judul').text(judul);
            $('#isbn').text(isbn);
            $('#rak').text(rak);

            console.log(rak);

            // load image
            setImage.src = `http://localhost/tb2/upload_folder/${gambar}`;
            setImage.classList.add("img-fluid", "image");
            images.appendChild(setImage);

            // Loop rate book star
            let text = '';
            for (i = 1; i <= rate; i++) {
                // rate.appendChild(addSpan)[i];
                text += `<span class="fas fa-star" style="color: orange;"></span>`;
            }
            document.querySelector("#rate").innerHTML = text;
        });

    });
</script>