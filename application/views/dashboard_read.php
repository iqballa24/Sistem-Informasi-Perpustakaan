<div class="alert alert-info" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="alert-heading">Selamat datang
        <strong class="green"><?= $data_petugas; ?></strong>,
    </h4>
    <hr>
    <p>Tetap santuy dan semangat !!!</p>
</div>

<!-- Content -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Anggota</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php foreach ($data_anggota as $anggota) : ?>
                                <?= $anggota['total']; ?>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total koleksi Buku</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php foreach ($data_koleksi as $data) : ?>
                                <?= $data['total']; ?>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Stok Buku</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php foreach ($data_buku as $data) : ?>
                                <?= $data['total']; ?>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total transaksi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php foreach ($data_transaksi as $data) : ?>
                                <?= $data['total']; ?>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xl-7 col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Jumlah Buku Berdasarkan Kategori</h6>
            </div>
            <div class="card-body">
                <div id="container"></div>
            </div>
        </div>
    </div>

    <!-- Grafik Presentase Penerbit Buku -->
    <div class="col-xl-5 col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Persentase Penerbit Buku Berdasarkan Jumlah Buku</h6>
            </div>
            <div class="card-body">
                <div id="pie"></div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"></h6>
    </div>
    <div class="card-body">
        <div id="chart"></div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript">
    // Build the chart
    Highcharts.chart('chart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Perbandingan total buku yang dipinjam'
        },
        xAxis: {
            categories: [
                'Buku'
            ],
            /*categories: [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ],*/
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Judul (Stok)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.f} Buku</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },

        series: [
            <?php foreach ($data_peminjaman as $data) : ?> {
                    name: '<?php echo $data['judul']; ?>',
                    data: [<?php echo $data['total']; ?>]
                },
            <?php endforeach ?>
        ]

    });
    $(documnet).ready(_ => {
        
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

<script type="text/javascript">
    Highcharts.chart('pie', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{

            //format data buku
            data: [
                <?php foreach ($data_buku_grafik as $buku) : ?> {
                        name: '<?php echo $buku['penerbit']; ?>',
                        y: <?php echo $buku['total_penerbit']; ?>
                    },
                <?php endforeach ?>
            ]

        }]
    });
</script>
<script type="text/javascript">
    // Build the chart
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: [
                'Kategori'
            ],
            /*categories: [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ],*/
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Buku'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.f} Buku</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },

        //format data penduduk kota
        series: [
            <?php foreach ($data_jumlah_buku as $data_buku2) : ?> {
                    name: '<?php echo $data_buku2['kategori']; ?>',
                    data: [<?php echo $data_buku2['total']; ?>]
                },
            <?php endforeach ?>
        ]

        //format data original

        /*series: [{
            name: 'Tokyo',
            data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

        }, {
            name: 'New York',
            data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

        }, {
            name: 'London',
            data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

        }, {
            name: 'Berlin',
            data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]

        }]*/
    });
</script>