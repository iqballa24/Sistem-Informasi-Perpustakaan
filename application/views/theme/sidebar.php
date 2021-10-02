<ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#sidebar">
        <div class="sidebar-brand-icon">
            <i class="fas fa-book"></i>
        </div>
        <div class="sidebar-brand-text mx-3">E-Library</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - page Dashboard -->
    <?php $i = $this->uri->segment(1) ?>
    <li class="nav-item <?php if ($i == 'dashboard') {
                            echo "active";
                        } ?>">
        <a class="nav-link" href="<?php echo site_url('dashboard/read'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    <!-- Nav Item - page Anggota -->
    <?php $i = $this->uri->segment(1) ?>
    <li class="nav-item <?php if ($i == 'anggota') {
                            echo "active";
                        } ?>">
        <a class="nav-link" href="<?php echo site_url('anggota/read'); ?>">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Anggota</span>
        </a>
    </li>

    <!-- Nav Item - Page Rak buku -->
    <?php $i = $this->uri->segment(1) ?>
    <li class="nav-item <?php if ($i == 'rak') {
                            echo "active";
                        } ?>">
        <a class="nav-link" href="<?php echo site_url('rak/read'); ?>">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Rak Buku</span>
        </a>
    </li>

    <!-- Nav Item - page Buku -->
    <li class="nav-item <?php if ($i == 'buku' || $i == 'penerbit' || $i == 'kategori') {
                            echo 'active';
                        } ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#bookPages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-book"></i>
            <span>Data Buku</span>
        </a>
        <div id="bookPages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Tambah Data:</h6>
                <a class="collapse-item" href="<?php echo site_url('penerbit/read'); ?>">Penerbit</a>
                <a class="collapse-item" href="<?php echo site_url('kategori/read'); ?>">Kategori</a>
                <a class="collapse-item" href="<?php echo site_url('buku/read'); ?>">Buku</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - page Peminjaman -->
    <?php $i = $this->uri->segment(1) ?>
    <li class="nav-item <?php if ($i == 'peminjaman' || $i == 'pengembalian') {
                            echo "active";
                        } ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#transaksiPages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-database"></i>
            <span>Transaksi</span>
        </a>
        <div id="transaksiPages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Tambah Data:</h6>
                <a class="collapse-item" href="<?php echo site_url('peminjaman/read'); ?>">Peminjaman</a>
                <a class="collapse-item" href="<?php echo site_url('pengembalian/read'); ?>">Pengembalian</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - page Denda -->
    <?php $i = $this->uri->segment(1) ?>
    <li class="nav-item <?php if ($i == 'jenis_denda') {
                            echo "active";
                        } ?>">
        <a class="nav-link" href="<?php echo site_url('jenis_denda/read'); ?>">
            <i class="fas fa-fw fa-money-bill-wave"></i>
            <span>Data Denda</span>
        </a>
    </li>

    <!-- Nav Item - page Denda -->
    <?php $i = $this->uri->segment(1) ?>
    <li class="nav-item <?php if ($i == 'tester') {
                            echo "active";
                        } ?>">
        <a class="nav-link" href="<?php echo site_url('tester'); ?>">
            <i class="fas fa-fw fa-money-bill-wave"></i>
            <span>Tester</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Page laporan -->
    <?php $i = $this->uri->segment(1) ?>
    <li class="nav-item <?php if ($i == 'rak_buku') {
                            echo "active";
                        } ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#laporanPages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-file"></i>
            <span>Laporan</span>
        </a>
        <div id="laporanPages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Unduh laporan</h6>
                <a class="collapse-item" href="<?= site_url('peminjaman/export/'); ?>">Peminjaman</a>
                <a class="collapse-item" href="<?=site_url('pengembalian/export'); ?>">Pengembalian</a>
                <a class="collapse-item" href="<?php echo site_url('anggota/export'); ?>">Anggota</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Page setting -->
    <?php $i = $this->uri->segment(1) ?>
    <li class="nav-item <?php if ($i == 'petugas') {
                            echo "active";
                        } ?>"">
        <a class=" nav-link" href="<?php echo site_url('petugas/read'); ?>">
        <i class="fas fa-fw fa-user"></i>
        <span>User management</span>
        </a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>