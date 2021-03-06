<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-Library - <?= $judul; ?></title>

    <!-- css yang digunakan theme -->
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet">

    <!-- js for this page -->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url('assets/vendor/datatables/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/sweetalert/sweetalert2.all.min.js'); ?>"></script>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- load sidebar -->
        <?php $this->load->view('theme/sidebar');; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- load header -->
                <?php $this->load->view('theme/header');; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Alert -->
                    <div class="flash-data" data-tempdata="<?= $this->session->tempdata('message') ?>"></div>
                    <div class="flash-data-info" data-tempdata="<?= $this->session->tempdata('info') ?>"></div>
                    <div class="flash-data-error" data-tempdata="<?= $this->session->tempdata('error') ?>"></div>

                    <!-- load halaman sesuai controller yang dipilih dari sidebar -->
                    <?php $this->load->view($theme_page);; ?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- load footer -->
            <?php $this->load->view('theme/footer');; ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Js yang digunakan pada theme -->
    <script src="<?= base_url('assets/js/sb-admin-2.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/index.js'); ?>"></script>

</body>

</html>