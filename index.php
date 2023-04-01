<?php include('functions/isLogin.php');?>
<?php 
include("functions/connection.php");
?>
<script>document.title = "Dashboard";</script>
<?php include('views/frontend/frontend_upper.php')?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fa-solid fa-chalkboard-user"></i>
                        Dosen
                    </div>
                    <div class="card-body">
                        <span>
                            Hak dan Kuasa yang dapat dilakukan oleh <strong>Dosen</strong> dalam Aplikasi
                        </span>

                        <ol class="mt-3">
                            <li>Dosen mampu memantau permintaan Mahasiswa dalam pengajuan bidang minat untuk mengajukan Skripsi</li>
                            <li>Dosen mampu memberikan nilai atas permintaan tema bidang minat skripsi mahasiswa, guna menjadi gambaran besar tema dan judul skripsi yang akan di ajukan</li>
                            <li>Dosen mampu tidak menyetujui akan suatu bidang minat yang diajukan mahasiswa dengan memberikan nilai <strong>0</strong> pada form persetujuan dosen pada aplikasi</li>
                            <li>Dosen mampu melihat hasil dan nilai akhir yang di tentukan dalam aplikasi guna mengetahui bidang yang sesuai dengan minat mahasiswa sesuai keputusan Metode Topsis pada Aplikasi</li>
                            <li>Dosen mampu menghapus data mahasiswa yang telah disetujui sehingga mahasiswa dapat mengisi kembali form pengajuan untuk mendapatkan hasil yang diinginkan bersama</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fa-solid fa-graduation-cap"></i>
                        Mahasiswa
                    </div>
                    <div class="card-body">
                        <span>
                        Hak dan Kuasa yang dapat dilakukan oleh <strong>Mahasiswa</strong> dalam Aplikasi
                        </span>

                        <ol class="mt-3">
                            <li>
                                Masiswa mampu mengisi form Alternatif untuk memilih bidang minat yang akan diinginkan dalam pengajuan skripsi
                                <ul>
                                    <li>Form Pengajuan bidang minat tidak memiliki batasan, namun harap kebijakan dalam memilih bidang minat yang akan diajukan guna mempermudah, mahasiswa dan dosen dalam menentukan nilai yang terbaik</li>
                                    <li>Form Mata kuliah ditunjukkan sebagai parameter awal dan tidak disimpan dalam program sehingga diharapkan untuk para mahasiswa memahami dan mengingat Mata kuliah yang dipilih</li>
                                    <li>Form yang telah diisi tidak akan langsung muncul pada menu <strong>Hasil</strong>, hingga dosen menyetujui akan pengajuan bidang minat yang diajukan</li>
                                </ul>
                            </li>
                            <li>Mahasiswa mampu menghapus data yang telah disetujui sehingga mahasiswa dapat mengisi kembali form pengajuan untuk mendapatkan hasil yang diinginkan bersama</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<?php include('views/frontend/frontend_lower.php')?>