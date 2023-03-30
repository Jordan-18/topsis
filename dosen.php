<?php include('functions/isLogin.php');?>
<?php 
include("functions/Alternatif.php");
$username = $_SESSION["username"];

$dosenName = explode(" ", $username);

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
    WHERE alternatif.alternatif_dosen LIKE '%$dosenName[0]%'
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
        <h1 class="mt-4">Dosen</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dosen</li>
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
                    <li class="nav-item" role="presentation" style="display: none;">
                        <button class="nav-link" id="create-tab" data-bs-toggle="tab" data-bs-target="#create" type="button" role="tab" aria-controls="create" aria-selected="false">Create New</button>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="data" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card mb-4 mt-3">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                    Dosen Table
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
                                <input type="number" class="form-control" id="count_alternatif" onchange="addAlternatif()" placeholder='press ⬆ to Add Row'>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card-body">

                        <form action="" method="POST">
                            <div class="row">

                                <div class="col-md-4" id="row_name"></div>
                                <div class="col-md-2" id="row_matkul"></div>
                                <div class="col-md-1" id="row_nilai_dosen"></div>
                                <div class="col-md-1" id="row_nilai_mahasiswa"></div>
                                <div class="col-md-1" id="row_nilai_matkul"></div>

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

<!-- Modal -->
<div class="modal fade" id="dosenEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Approve Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <table id="alternatifDosen" class="table table-bordered">
          </table>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<!-- Display Data -->
<script>
    $(document).ready( function (){
        var data = <?= $alternatif_json; ?>;
        $('#table_alternatif').DataTable({
            processing: true,
            data : data,
            fnRowCallback: function(row,data,index,rowIndex){
                $('td:eq(3)',row).html(new Date(data.created_at).toDateString())
                $('td:eq(7)',row).html(`
                    <button class="btn btn-warning" name="edit" value="${data.alternatif_group}" data-group_id="${data.alternatif_group}" onclick="onEdit(this);"><i class="fa-solid fa-pen"></i></button>
                `)
            },
            columns: [
                    {data: '', name: '', width:'5%', title: "#"},
                    {data: 'alternatif_mahasiswa', name: 'alternatif_mahasiswa', title: "Mahasiswa"},
                    {data: 'alternatif_dosen', name: 'alternatif_dosen', title: "Dosen"},
                    {data: 'created_at', name: 'created_at', title: "Dibuat"},
                    {data: 'pembagian_nilai_dosen', name: 'pembagian_nilai_dosen', title: "N.Dosen"},
                    {data: 'pembagian_nilai_mahasiswa', name: 'pembagian_nilai_mahasiswa', title: "N.Mahasiswa"},
                    {data: 'pembagian_nilai_matkul', name: 'pembagian_nilai_matkul', title: "N.Matkul"},
                    {name: 'action', title: "Action"},
                    // {data: 'alternatif_group', name: 'alternatif_group', title: "Action"},
                ],
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            }]
        })
    })

    addAlternatif = () => {
        const row_al = $('#count_alternatif').val();
        $('.input_name').remove()
        $('.input_matkul').remove()
        $('.input_nilai').remove()
        for(var i=0; i < row_al; i++){
            $('#row_name').append(`
                    <div class="input_name mb-3">
                        <label for="alternatif1" class="form-label">Name Alternatif ${i+1}</label>
                        <input type="text" class="form-control" id="name_alternatif${i+1}" name="name_alternatif${i+1}" placeholder="Name Alternatif ${i+1}" required>
                    </div>
            `)
            $('#row_matkul').append(`
                    <div class="input_matkul mb-3">
                        <label for="alternatif" class="form-label">Mata Kuliah ${i+1}</label>
                        <input type="text" class="form-control" id="matkul_alternatif${i+1}" name="matkul_alternatif${i+1}" placeholder="Mata Kuliah ${i+1}" required>
                    </div>
            `)
            $('#row_nilai_dosen').append(`
                    <div class="input_nilai mb-3">
                        <label for="alternatif" class="form-label">Dsn${i+1}</label>
                        <input type="number" class="form-control" id="nilai_dosen_alternatif${i+1}" name="nilai_dosen_alternatif${i+1}" placeholder="Nilai ${i+1}" readonly>
                    </div>
            `)
            $('#row_nilai_mahasiswa').append(`
                    <div class="input_nilai mb-3">
                        <label for="alternatif" class="form-label">Mhs${i+1}</label>
                        <input type="number" class="form-control" id="nilai_mahasiswa_alternatif${i+1}" name="nilai_mahasiswa_alternatif${i+1}" placeholder="Nilai ${i+1}" required>
                    </div>
            `)
            $('#row_nilai_matkul').append(`
                    <div class="input_nilai mb-3">
                        <label for="alternatif" class="form-label">MT${i+1}</label>
                        <input type="number" class="form-control" id="nilai_matkul_alternatif${i+1}" name="nilai_matkul_alternatif${i+1}" placeholder="Nilai ${i+1}" required>
                    </div>
            `)
        }

        $('#numberofalternatif').val(i);
    }

    onEdit = (el) => {
        $('#dosenEdit').modal('show');
        const id = $(el).data('group_id');
        
        $.ajax({
            url: "functions/Detail.php",
            type:"POST",
            data: "group_id=" + id,
            success:function(response){
                var hasil_alternatif = JSON.parse(response.alternatif)
                var hasil_pembagian = JSON.parse(response.pembagian)
                $('#alternatifDosen').DataTable({
                    processing: true,
                    data : hasil_alternatif,
                    fnRowCallback: function(row,data,index,rowIndex){
                        if(data.alternatif_approve == 1){
                            $('td:eq(5)',row).html(`
                                <span class="badge rounded-pill bg-primary">Approved</span>
                            `)
                        }

                        if(data.alternatif_approve == null || data.alternatif_approve == 0){
                            $('td:eq(5)',row).html(`
                                <button class="btn btn-success" name="approve" data-group_id="${data.alternatif_group}" data-id="${data.alternatif_id}" onclick="onApprove(this);"><i class="fa-solid fa-circle-check"></i> Approve</button>
                            `)
                            $('td:eq(2)',row).html(`
                                <input type="number" class="form-control" placeholder="Nilai Dosen" min="0" max="5" name="nilai-dosen-${data.alternatif_id}" id="nilai-dosen-${data.alternatif_id}" autocomplete="off">
                            `)
                        }
                    },
                    columns: [
                        {data: '#', name: '#', title: "#"},
                        {data: 'alternatif_name', name: 'alternatif_name', title: "Alternatif"},
                        {data: 'alternatif_nilai_dosen', name: 'alternatif_nilai_dosen', title: "Dosen"},
                        {data: 'alternatif_nilai_mahasiswa', name: 'alternatif_nilai_mahasiswa', title: "Mahasiswa"},
                        {data: 'alternatif_nilai_matkul', name: 'alternatif_nilai_matkul', title: "Mata Kuliah"},
                        {name: 'action', title: "Action"},
                    ],
                    columnDefs: [{
                        "defaultContent": "-",
                        "targets": "_all"
                    }]
                })

                $('#alternatifDosen').css('width','')

                $('#alternatifDosen').DataTable().destroy();
                
            }
        })
    }

    onApprove = (el) => {
        var data = $(el).data();
        let nilaiDosen = $('#nilai-dosen-'+data.id).val();

        if(nilaiDosen == ""){
            return alert(' Nilai Dosen Belum ter isi');
        }else{
            if(confirm('Apakah Anda yakin menyetujui nilai ini ?')){
                data = {
                    ...data,
                    nilaiDosen
                }
        
                let record = btoa(JSON.stringify(data))
                $.ajax({
                    url: 'functions/functions.php?approve='+record,
                    success:function(response){
                        if(response == 1){
                            alert('Succesfully');
                            onEdit('<button class="btn btn-warning" name="edit" data-group_id="'+data.group_id+'" onclick="onEdit(this);"><i class="fa-solid fa-pen"></i></button>')
    
                        }else{
                            alert('Failed to Update');
                        }
                    }
                })
            }else{
                return alert('Data Gagal Di input');
            }
        }
    }

    onEditDetail = (el) => {
        const id = $(el).data();
        let nilaiDosen = $('#nilai-dosen-'+data.id);
    }

    $('#dosenEdit').on('hidden.bs.modal', function () {
        location.reload();
    });
</script>
<script>
    setTimeout(() => {
        $('#message').slideUp('fast');
    }, 1500);
</script>
<?php include('views/frontend/frontend_lower.php')?>