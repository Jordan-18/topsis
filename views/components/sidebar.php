<?php
    $role = $_SESSION["role"];

    $menuHideforMahasiswa = ($role == 'Mahasiswa' ? 'style="display:none;"' : '');
    $menuHideforDosen = ($role == 'Dosen' ? 'style="display:none;"' : '');
?>
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                
                <div class="sb-sidenav-menu-heading">Admin</div>

                <a class="nav-link <?php if(basename($_SERVER['REDIRECT_URL']) == 'index' || basename($_SERVER['REDIRECT_URL']) == '') echo 'active' ?>" href="index">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                </a>

                <div id="menuAdmin" style="display: none;">
                    <div class="sb-sidenav-menu-heading" >Master Data</div>
                    <a class="nav-link <?php if(basename($_SERVER['REDIRECT_URL']) == 'ms.alternatif') echo 'active'  ?>" href="ms.alternatif">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-recycle"></i></div>
                            Alternatif
                    </a>
                    <a class="nav-link <?php if(basename($_SERVER['REDIRECT_URL']) == 'ms.matkul') echo 'active'  ?>" href="ms.matkul">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                            Mata Kuliah
                    </a>
                </div>

                <div class="sb-sidenav-menu-heading">Bidang Minat</div>
                <a class="nav-link <?php if(basename($_SERVER['REDIRECT_URL']) == 'alternatif') echo 'active'  ?>" href="alternatif" <?= $menuHideforDosen ?>>
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-recycle"></i></div>
                        Alternatif
                </a>
                <a class="nav-link <?php if(basename($_SERVER['REDIRECT_URL']) == 'dosen') echo 'active'  ?>" href="dosen" <?= $menuHideforMahasiswa ?>>
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                        Dosen
                </a>
                <a class="nav-link <?php if(basename($_SERVER['REDIRECT_URL']) == 'hasil') echo 'active' ?>" href="hasil">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-subscript"></i></div>
                        Hasil
                </a>
            </div>
        </div>

        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
                <?php echo strtoupper($_SESSION["username"]); ?>
        </div>
    </nav>
</div>

<script>
    let path = window.location.pathname;
    path = path.replace('/projek/topsis_yusuf/','')

    $('a[href="' + path + '"]').addClass('active');

    if('<?= $_SESSION["username"] ?>' == 'admin'){
        $('#menuAdmin').css('display','')
    }
</script> 