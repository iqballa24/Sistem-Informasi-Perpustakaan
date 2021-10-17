<div class="card shadow mb-4">
    <div class="card-header">
        <h3><?= $judul ?></h3>
    </div>
    <div class="card-body">
        <label for="">Nama buku :</label>
        <input class="form-control" type="text" name="search_text" id="search_text" autofocus="" placeholder="Ketikan nama buku...">
        <br><br>
        <div id="result"></div>
    </div>
</div>

<script>
    fetchData();

    $('#search_text').keyup(function() {
        let search = $(this).val();
        let len_text = search.length;
        if (len_text > 0) {
            fetchData(search);
        } else {
            $("#result").html("");
        }
    });

    // Fetch data
    function fetchData(query) {
        $.ajax({
            url: "<?php echo base_url('index.php/Buku/fetchBook'); ?>",
            method: "POST",
            data: {
                query: query
            },
            success: function(data) {
                const obj = JSON.parse(data);

                if (obj.length == 0) {
                    $("#result").html(`<div class="alert alert-danger" role="alert">Data ${document.getElementById("search_text").value} tidak ditemukan</div>`);
                } else if (obj.empty) {
                    $("#result").html("");
                } else {
                    showBooks(obj);
                }
            }
        });
    }

    // Display result fetch
    function showBooks(data) {
        let bookHTML = '';
        let dataBook = '';
        let number = 1;

        data.forEach(book => {

            dataBook += `
                <tbody>
                        <tr>
                            <td>${number++}</td>
                            <td>${book.judul}</td>
                            <td>${book.gambar}</td>
                            <td>${book.penerbit}</td>
                            <td>${book.kategori}</td>
                            <td>${book.stok_buku}</td>
                            <td>${book.thn_terbit}</td>
                        </tr>
                </tbody>
            `;

            bookHTML = `
                <div class="table-responsive">
                    <table class="table table-striped" id="table" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th> # </th>
                                <th> Judul </th>
                                <th> Sampul </th>
                                <th> Penerbit </th>
                                <th> Kategori </th>
                                <th> Stok </th>
                                <th> Tahun terbit </th>
                            </tr>
                        </thead>
                        ${dataBook}
                    </table>
                </div>

            `;
        });
        document.getElementById("result").innerHTML = bookHTML;

        $('table').dataTable({
            searching: false,
        });

    }
</script>