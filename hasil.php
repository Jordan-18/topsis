<?php 
session_start();
if (!isset($_SESSION["login"])){
    header("Location:login.php");
    exit;
}
include("functions/Connection.php");
$matrix = query(
    "SELECT *
    FROM alternatif 
    INNER JOIN pembagian 
    ON 
    alternatif.alternatif_group = pembagian.pembagian_alternative_group
    GROUP BY alternatif.alternatif_group");

$matrix_json = json_encode($matrix);

// $data_detail = [];
// if(isset($_POST['detail'])){
//     $data_detail = detail($_POST['detail']);
// }

?>
<script>document.title = "Nilai Matrix";</script>
<?php include('views/frontend/frontend_upper.php')?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Hasil</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Hasil Topsis</li>
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

                </ul>
                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="data" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card mb-4 mt-3">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                    Data Table
                            </div>
                            <div class="card-body">
                                <table id="table_matrix"></table>
                            </div>
                        </div>     
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="DetailHasil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data Detail</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="modal_data_detail"></div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready( function (){
        var data = <?= $matrix_json; ?>;
        $('#table_matrix').DataTable({
            processing: true,
            data : data,
            fnRowCallback: function(row,data,index,rowIndex){
                $('td:eq(3)',row).html(new Date(data.created_at).toDateString())
                $('td:eq(4)',row).html(`
                        <button class="btn btn-success" name="detail" value="${data.alternatif_group}" data-group_id="${data.alternatif_group}" onclick="onDetail(this);"><i class="fa-solid fa-circle-info"></i></button>
                        <a class="btn btn-danger" href="functions/hapus.php?id_group=${data.alternatif_group}" onclick="return confirm('Yakin ?');"><i class="fa-solid fa-trash"></i></a>
                `)
            },
            columns: [
                    {data: '', name: '', width:'5%', title: "#"},
                    {data: 'alternatif_mahasiswa', name: 'alternatif_mahasiswa', title: "Mahasiswa"},
                    {data: 'alternatif_dosen', name: 'alternatif_dosen', title: "Dosen"},
                    {data: 'created_at', name: 'created_at', title: "Dibuat"},
                    {data: 'alternatif_group', name: 'alternatif_group', title: "Action"},
                ],
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            }]
        })
    })

    onDetail = (el) => {
        $('#DetailHasil').modal('show');
        const id = $(el).data('group_id');
        $.ajax({
            url: "functions/Detail.php",
            type:"POST",
            data: "group_id=" + id,
            success:function(response){
                var hasil_alternatif = JSON.parse(response.alternatif)
                var hasil_pembagian = JSON.parse(response.pembagian)
                console.log(hasil_alternatif);
                console.log(hasil_pembagian);
                $('#modal_data_detail').empty();
                $('#modal_data_detail').append(`
                    <ul class="nav nav-tabs" id="myTab" role="tablist">

                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="data-tab" data-bs-toggle="tab" data-bs-target="#tab_1" type="button" role="tab" aria-controls="data" aria-selected="true">Tab 1/Data Asli</button>
                        </li>
                        
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#tab_2" type="button" role="tab" aria-controls="data" aria-selected="true">Tab 2/No.3</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#tab_3" type="button" role="tab" aria-controls="data" aria-selected="true">Tab 3/No.4</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#tab_4" type="button" role="tab" aria-controls="data" aria-selected="true">Tab 4/No.5</button>
                        </li>

                    </ul>

                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active" id="tab_1" role="tabpanel" aria-labelledby="home-tab">
                            <div class="card mb-4 mt-3">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                        Data Table
                                </div>
                                <div class="card-body">
                                    <table id="table_tab_1"></table>
                                </div>
                            </div>     
                        </div>

                        <div class="tab-pane fade show" id="tab_2" role="tabpanel" aria-labelledby="home-tab">
                            <div class="card mb-4 mt-3">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                        Data Table
                                </div>
                                <div class="card-body">
                                    <table id="table_tab_2"></table>
                                </div>
                            </div>     
                        </div>

                        <div class="tab-pane fade show" id="tab_3" role="tabpanel" aria-labelledby="home-tab">
                            <div class="card mb-4 mt-3">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                        Data Table
                                </div>
                                <div class="card-body">
                                    <table id="table_tab_3"></table>
                                </div>
                            </div>     
                        </div>

                        <div class="tab-pane fade show" id="tab_4" role="tabpanel" aria-labelledby="home-tab">
                            <div class="card mb-4 mt-3">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                        Data Table
                                </div>
                                <div class="card-body">
                                    <table id="table_tab_4"></table>
                                </div>
                            </div>     
                        </div>

                    </div>
                `)

                $('#table_tab_1').replaceWith(`
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-warning text-white">
                                <th>No</th>
                                <th>Alternatif</th>
                                <th>Keputusan Dosen</th>
                                <th>Keinginan Mahasiswa</th>
                                <th>Nilai MataKuliah</th>
                            </tr>
                        </thead>
                        <tbody id="body_tab_1"></tbody>
                    </table>
                `)
                $.each(hasil_alternatif, (i,v) =>{
                    $('#body_tab_1').append(`
                        <tr>
                            <td>${i+1}</td>
                            <td>${v.alternatif_name}</td>
                            <td>${v.alternatif_nilai_dosen}</td>
                            <td>${v.alternatif_nilai_mahasiswa}</td>
                            <td>${v.alternatif_nilai_matkul}</td>
                        </tr>
                    `)
                })

                $('#table_tab_2').replaceWith(`
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-warning text-white">
                                <th>No</th>
                                <th>Alternatif</th>
                                <th>Keputusan Dosen</th>
                                <th>Keinginan Mahasiswa</th>
                                <th>Nilai MataKuliah</th>
                            </tr>
                        </thead>
                        <tbody id="body_tab_2"></tbody>
                    </table>
                `)
                $.each(hasil_alternatif, (i,v) =>{
                    $('#body_tab_2').append(`
                        <tr>
                            <td>${i+1}</td>
                            <td>${v.alternatif_name}</td>
                            <td>${(v.alternatif_nilai_dosen / hasil_pembagian[0].pembagian_nilai_dosen).toFixed(5)}</td>
                            <td>${(v.alternatif_nilai_mahasiswa / hasil_pembagian[0].pembagian_nilai_mahasiswa).toFixed(5)}</td>
                            <td>${(v.alternatif_nilai_matkul / hasil_pembagian[0].pembagian_nilai_matkul).toFixed(5)}</td>
                        </tr>
                    `)
                })

                $('#table_tab_3').replaceWith(`
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-warning text-white">
                                <th>No</th>
                                <th>Alternatif</th>
                                <th>Keputusan Dosen</th>
                                <th>Keinginan Mahasiswa</th>
                                <th>Nilai MataKuliah</th>
                            </tr>
                        </thead>
                        <tbody id="body_tab_3"></tbody>
                    </table>
                `)
                $.each(hasil_alternatif, (i,v) =>{
                    $('#body_tab_3').append(`
                        <tr>
                            <td>${i+1}</td>
                            <td>${v.alternatif_name}</td>
                            <td>${(((v.alternatif_nilai_dosen / hasil_pembagian[0].pembagian_nilai_dosen).toFixed(5)) * hasil_pembagian[0].b_dsn).toFixed(5)}</td>
                            <td>${(((v.alternatif_nilai_mahasiswa / hasil_pembagian[0].pembagian_nilai_mahasiswa).toFixed(5)) * hasil_pembagian[0].b_mhs).toFixed(5)}</td>
                            <td>${(((v.alternatif_nilai_matkul / hasil_pembagian[0].pembagian_nilai_matkul).toFixed(5)) * hasil_pembagian[0].b_mt).toFixed(5)}</td>
                        </tr>
                    `)
                })


                $('#modal_data_detail').append(`
                    <table class="table table-bordered" style="font-size:12px;">
                        <tr>
                            <th>Bobot Dosen</th>
                            <th>Bobot Mahasiswa</th>
                            <th>Bobot Mata Kuliah</th>
                        </tr>
                        <tr>
                            <td>${hasil_pembagian[0].b_dsn}</td>
                            <td>${hasil_pembagian[0].b_mhs}</td>
                            <td>${hasil_pembagian[0].b_mt}</td>
                        </tr>
                    </table>
                
                `)
            }
            
        })
    }
</script>
<script>
    setTimeout(() => {
        $('#message').slideUp('fast');
    }, 1500);
</script>

<!-- tampilan bagian bawah -->
<?php include('views/frontend/frontend_lower.php')?>