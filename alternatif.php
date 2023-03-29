<?php include('functions/isLogin.php');?>
<?php 
include("functions/Alternatif.php");
$username = $_SESSION["username"];

$alternatif = query(
    "SELECT 
    alternatif.alternatif_mahasiswa, 
    alternatif.alternatif_dosen, 
    alternatif.created_at, 
    alternatif.alternatif_dosen,pembagian.pembagian_nilai_dosen,
    pembagian.pembagian_nilai_mahasiswa, 
    pembagian.pembagian_nilai_matkul,
    alternatif.alternatif_group
    FROM alternatif 
    LEFT JOIN pembagian 
    ON 
    alternatif.alternatif_group = pembagian.pembagian_alternative_group
    WHERE alternatif.alternatif_mahasiswa = '$username'
    GROUP BY alternatif.alternatif_group");

$user_data = query("SELECT * FROM users WHERE username = '$username'");
$dosen = query("SELECT * FROM dosen");
$bobot = query("SELECT * FROM bobot");
$alternatif_json = json_encode($alternatif);

if(isset($_POST["simpan"])){
    if(createAlternatif($_POST) > 0){
        header('Location: alternatif');
        exit;
    }
}
?>

<script>document.title = "Alternatif";</script>
<?php include('views/frontend/frontend_upper.php')?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Alternatif</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Alternatif</li>
        </ol>
        <div class="row">
            <?php if(isset($_SESSION['alert'])) : 
                $message = $_SESSION['alert']; 
                unset($_SESSION['alert']); 
            ?>
                <div class='p-3 mb-2 bg-success text-white' id='message'><?= $message ?></div>
            <?php endif; ?>
            <div class="col-md-12">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="data-tab" data-bs-toggle="tab" data-bs-target="#data" type="button" role="tab" aria-controls="data" aria-selected="true">Data</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="create-tab" data-bs-toggle="tab" data-bs-target="#create" type="button" role="tab" aria-controls="create" aria-selected="false">Create New</button>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="data" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card mb-4 mt-3">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                    Alternatif Table
                            </div>
                            <div class="card-body">
                                <table id="table_alternatif"></table>
                            </div>
                        </div>     
                    </div>

                    <div class="tab-pane fade" id="create" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <i class="fa-solid fa-circle-plus"></i>
                                            Create New Data Alternatif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                            <div class="mt-3">
                                <div class="col-sm-10">
                                    <button type="button" class="btn btn-primary form-control" id="count_alternatif" onclick="addAlternatif()">
                                        <i class="fa-solid fa-plus"></i> Tambah
                                    </button>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card-body">

                        <form action="" method="POST">
                            <div class="row">
                                <div id="alternatif_num"></div>
                                
                                <div class="col-md-3" id="row_name"></div>
                                <div class="col-md-2" id="row_matkul"></div>
                                <div class="col-md-1" id="row_nilai_dosen"></div>
                                <div class="col-md-1" id="row_nilai_mahasiswa"></div>
                                <div class="col-md-1" id="row_nilai_matkul"></div>
                                <div class="col-md-1" id="row_delete"></div>

                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="mahasiswa" class="form-label sm">Bobot <br>Dosen</label>
                                                <select class="form-select" aria-label="Default select example" name="b_dsn" required>
                                                    <option value="" selected>-- Bobot </option>
                                                    <?php foreach($bobot as $data) :?>
                                                        <option value="<?= $data['bobot']?>"><?= $data['kepentingan']?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="mahasiswa" class="form-label sm">Bobot <br>Mahasiswa</label>
                                                <select class="form-select" aria-label="Default select example" name="b_mhs" required>
                                                    <option value="" selected>-- Bobot </option>
                                                    <?php foreach($bobot as $data) :?>
                                                        <option value="<?= $data['bobot']?>"><?= $data['kepentingan']?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="mahasiswa" class="form-label sm">Bobot <br>Mata Kuliah</label>
                                                <select class="form-select" aria-label="Default select example" name="b_mt" required>
                                                    <option value="" selected>-- Bobot </option>
                                                    <?php foreach($bobot as $data) :?>
                                                        <option value="<?= $data['bobot']?>"><?= $data['kepentingan']?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="dosen" class="form-label">Dosen Name</label>
                                        <select class="form-select" id="dosen" name="dosen" aria-label="Default select example" required>
                                            <option value="" selected>---Pilih---</option>
                                            <?php foreach($dosen as $data) :?>
                                                <option value="<?= $data['dosen_name']?>"><?= $data['dosen_name']?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="mahasiswa" class="form-label">Mahasiswa</label>
                                        <input type="text" class="form-control" id="mahasiswa" placeholder="Name Mahasiswa" value="<?= $user_data[0]["username"] ?>" name="mahasiswa" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <input type="hidden" id="numberofalternatif" name="numberofalternatif">
                                        <button class="btn btn-primary form-control" type="submit" name="simpan">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        </div>
                    </div>

                </div>
                
            </div>
        </div>
    </div>
</main>

<!-- Display Data -->
<script>
    var alternatif_num = 0;
    var selectAlternatif = null;
    var selectMatakuliah = null;
    $(document).ready( function (){
        var data = <?= $alternatif_json; ?>;
        $('#table_alternatif').DataTable({
            processing: true,
            data : data,
            fnRowCallback: function(row,data,index,rowIndex){
                $('td:eq(3)',row).html(new Date(data.created_at).toDateString())
                // $('td:eq(7)',row).html(``)
            },
            columns: [
                    {data: '', name: '', width:'5%', title: "#"},
                    {data: 'alternatif_mahasiswa', name: 'alternatif_mahasiswa', title: "Mahasiswa"},
                    {data: 'alternatif_dosen', name: 'alternatif_dosen', title: "Dosen"},
                    {data: 'created_at', name: 'created_at', title: "Dibuat"},
                    {data: 'pembagian_nilai_dosen', name: 'pembagian_nilai_dosen', title: "Nilai Dosen"},
                    {data: 'pembagian_nilai_mahasiswa', name: 'pembagian_nilai_mahasiswa', title: "Nilai Mahasiswa"},
                    {data: 'pembagian_nilai_matkul', name: 'pembagian_nilai_matkul', title: "Nilai Matkul"},
                ],
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            }]
        })
    })

    $.ajax({
        url: "functions/master/alternatif.php?index",
        success:function(response){
            var data = JSON.parse(response)

            selectAlternatif = data
        }
    })

    $.ajax({
        url: "functions/master/mata_kuliah.php?index",
        success:function(response){
            var data = JSON.parse(response)

            selectMatakuliah = data
        }
    })

    addAlternatif = () => {
        alternatif_num++
        const i = alternatif_num

        $('#alternatif_num').append(`
            <input type="hidden" id="alternatif_num${i}" name="alternatif_num[]" value="${i}">
        `)

        $('#row_name').append(`
            <div class="input_name mb-3">
                <label for="alternatif1" class="form-label">Name Alternatif</label>
                <select class="form-control" id="name_alternatif${i}" name="name_alternatif${i}" required>
                    <option value="" disabled selected>-- Pilih --</option>
                <select>
            </div>
        `)

        $.each(selectAlternatif, (key, value) =>{
            $(`#name_alternatif${i}`).append(`
                <option value="${value.ms_alternatif_name}">${value.ms_alternatif_name}</option>
            `)
        })

        $('#row_matkul').append(`
                <div class="input_matkul mb-3">
                    <label for="alternatif" class="form-label">Mata Kuliah</label>
                    <select class="form-control" id="matkul_alternatif${i}" name="matkul_alternatif${i}" required>
                        <option value="" disabled selected>-- Pilih --</option>
                    <select>
                </div>
        `)

        $.each(selectMatakuliah, (key, value) =>{
            $(`#matkul_alternatif${i}`).append(`
                <option value="${value.mata_kuliah_name}">${value.mata_kuliah_name}</option>
            `)
        })

        $('#row_nilai_dosen').append(`
                <div class="input_nilai mb-3">
                    <label for="alternatif" class="form-label">Dosen</label>
                    <input type="number" class="form-control" id="nilai_dosen_alternatif${i}" name="nilai_dosen_alternatif${i}" placeholder="Nilai" readonly>
                </div>
        `)
        $('#row_nilai_mahasiswa').append(`
                <div class="input_nilai mb-3">
                    <label for="alternatif" class="form-label">Mahasiswa</label>
                    <input type="number" class="form-control" id="nilai_mahasiswa_alternatif${i}" name="nilai_mahasiswa_alternatif${i}" placeholder="Nilai" min="0" max="5" required>
                </div>
        `)
        $('#row_nilai_matkul').append(`
                <div class="input_nilai mb-3">
                    <label for="alternatif" class="form-label">Mata Kuliah</label>
                    <input type="number" class="form-control" id="nilai_matkul_alternatif${i}" name="nilai_matkul_alternatif${i}" placeholder="Nilai" min="0" max="5" required>
                </div>
        `)

        $('#row_delete').append(`
                <div class="input_name mb-3">
                    <label for="alternatif1" class="form-label" style="color:white;">Name</label>
                    <input type="button" class="btn btn-danger form-control" id="button_delete${i}" data-id="${i}" onclick="onHapus(this)" value="Hapus">
                </div>
        `)

        $('#numberofalternatif').val(i);
    }

    onHapus = (el) => {
        var id = $(el).data('id');

        $('#alternatif_num'+id).remove()
        $('#name_alternatif'+id).parent().remove()
        $('#matkul_alternatif'+id).parent().remove()
        $('#nilai_dosen_alternatif'+id).parent().remove()
        $('#nilai_mahasiswa_alternatif'+id).parent().remove()
        $('#nilai_matkul_alternatif'+id).parent().remove()
        $('#button_delete'+id).parent().remove()

        alternatif_num--
    }
</script>
<script>
    setTimeout(() => {
        $('#message').slideUp('fast');
    }, 1500);
</script>
<?php include('views/frontend/frontend_lower.php')?>