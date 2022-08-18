<?php include('functions/isLogin.php');?>
<?php 
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
  <div class="modal-dialog modal-xl">
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

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#tab_5" type="button" role="tab" aria-controls="data" aria-selected="true">Tab 5/No.6</button>
                        </li>
                        
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#tab_6" type="button" role="tab" aria-controls="data" aria-selected="true">Tab 6/No.7</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#tab_7" type="button" role="tab" aria-controls="data" aria-selected="true">Hasil Akhir</button>
                        </li>

                    </ul>

                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active" id="tab_1" role="tabpanel" aria-labelledby="home-tab">
                            <div class="card mb-4 mt-3">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                        Data Asli Dari Alternatif
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
                                        Data Setelah Dibagi Dengan Pembagi
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
                                        Data Hasil Pembagi di Kali Dengan Bobot Utama
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
                                        Data Max dan Min
                                </div>
                                <div class="card-body">
                                    <table id="table_tab_4"></table>
                                </div>
                            </div>     
                        </div>

                        <div class="tab-pane fade show" id="tab_5" role="tabpanel" aria-labelledby="home-tab">
                            <div class="card mb-4 mt-3">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                        Data D+ & D-
                                </div>
                                <div class="card-body">
                                    <table id="table_tab_5"></table>
                                </div>
                            </div>     
                        </div>
                        
                        <div class="tab-pane fade show" id="tab_6" role="tabpanel" aria-labelledby="home-tab">
                            <div class="card mb-4 mt-3">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                        Data Alternatif Preferensi
                                </div>
                                <div class="card-body">
                                    <table id="table_tab_6"></table>
                                </div>
                            </div>     
                        </div>

                        <div class="tab-pane fade show" id="tab_7" role="tabpanel" aria-labelledby="home-tab">
                            <div class="card mb-4 mt-3">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                        Hasil Topsis
                                </div>
                                <div class="card-body">
                                    <table id="table_tab_7"></table>
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
                        <div id="table_pembagi"></div>
                        <tbody id="body_tab_2"></tbody>
                    </table>
                `)

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

                $('#table_tab_4').replaceWith(`
                    <table class="table table-bordered" id="table_tab_4">
                        <thead>
                            <tr class="bg-warning text-white">
                                <th>Value</th>
                                <th>Keputusan Dosen</th>
                                <th>Keinginan Mahasiswa</th>
                                <th>Nilai MataKuliah</th>
                            </tr>
                        </thead>
                        <tbody id="body_tab_4"></tbody>
                    </table>
                `)

                $('#table_tab_5').replaceWith(`
                    <table class="table table-bordered" id="table_tab_5">
                        <thead>
                            <tr class="bg-secondary text-white">
                                <th>Alternatif</th>
                                <td>D+</td>
                                <td>D-</td>
                            </tr>
                        </thead>
                        <tbody id="body_tab_5"></tbody>
                    </table>
                `)

                $('#table_tab_6').replaceWith(`
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-secondary text-white">
                                <th>Alternatif</th>
                                <td>Preferensi(V)</td>
                            </tr>
                        </thead>
                        <tbody id="body_tab_6"></tbody>
                    </table>
                `)

                $('#table_tab_7').replaceWith(`
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-secondary text-white">
                                <th>Alternatif</th>
                                <td>Preferensi(V)</td>
                                <td>Ranking</td>
                            </tr>
                        </thead>
                        <tbody id="body_tab_7"></tbody>
                    </table>
                `)

                // npb --> nilai pembagi bobot
                var npb_dsn = [];
                var npb_mhs = [];
                var npb_mt = [];
                $.each(hasil_alternatif, (i,v) =>{

                    $('#body_tab_1').append(`
                        <tr>
                            <td>${i+1}</td>
                            <td>${(v.alternatif_name).toUpperCase()}</td>
                            <td>${v.alternatif_nilai_dosen}</td>
                            <td>${v.alternatif_nilai_mahasiswa}</td>
                            <td>${v.alternatif_nilai_matkul}</td>
                        </tr>
                    `)

                    $('#body_tab_2').append(`
                        <tr>
                            <td>${i+1}</td>
                            <td>${(v.alternatif_name).toUpperCase()}</td>
                            <td>${(v.alternatif_nilai_dosen / hasil_pembagian[0].pembagian_nilai_dosen).toFixed(5)}</td>
                            <td>${(v.alternatif_nilai_mahasiswa / hasil_pembagian[0].pembagian_nilai_mahasiswa).toFixed(5)}</td>
                            <td>${(v.alternatif_nilai_matkul / hasil_pembagian[0].pembagian_nilai_matkul).toFixed(5)}</td>
                        </tr>
                    `)

                    $('#body_tab_3').append(`
                        <tr>
                            <td>${i+1}</td>
                            <td>${(v.alternatif_name).toUpperCase()}</td>
                            <td>${(((v.alternatif_nilai_dosen / hasil_pembagian[0].pembagian_nilai_dosen).toFixed(5)) * hasil_pembagian[0].b_dsn).toFixed(5)}</td>
                            <td>${(((v.alternatif_nilai_mahasiswa / hasil_pembagian[0].pembagian_nilai_mahasiswa).toFixed(5)) * hasil_pembagian[0].b_mhs).toFixed(5)}</td>
                            <td>${(((v.alternatif_nilai_matkul / hasil_pembagian[0].pembagian_nilai_matkul).toFixed(5)) * hasil_pembagian[0].b_mt).toFixed(5)}</td>
                        </tr>
                    `)

                    npb_dsn.push((((v.alternatif_nilai_dosen / hasil_pembagian[0].pembagian_nilai_dosen).toFixed(5)) * hasil_pembagian[0].b_dsn).toFixed(5))
                    npb_mhs.push((((v.alternatif_nilai_mahasiswa / hasil_pembagian[0].pembagian_nilai_mahasiswa).toFixed(5)) * hasil_pembagian[0].b_mhs).toFixed(5))
                    npb_mt.push((((v.alternatif_nilai_matkul / hasil_pembagian[0].pembagian_nilai_matkul).toFixed(5)) * hasil_pembagian[0].b_mt).toFixed(5))

                })

                // nilai terbesar
                max_dsn = Math.max(...npb_dsn);
                max_mhs = Math.max(...npb_mhs);
                max_mt = Math.max(...npb_mt);

                // nilai terkecil
                min_dsn = Math.min(...npb_dsn);
                min_mhs = Math.min(...npb_mhs);
                min_mt = Math.min(...npb_mt);

                $('#body_tab_4').append(`
                    <tr>
                        <td class="bg-danger text-white">MAX</td>
                        <td>${max_dsn}</td>
                        <td>${max_mhs}</td>
                        <td>${max_mt}</td>
                    </tr>
                    <tr>
                        <td colspan="4" height="50px"></td>
                    </tr>
                    <tr>
                        <td class="bg-success text-white">MIN</td>
                        <td>${min_dsn}</td>
                        <td>${min_mhs}</td>
                        <td>${min_mt}</td>
                    </tr>
                `)

                // menyimpan data dari D+ & D-
                var hasil_d_plus = []
                var hasil_d_min = []
                $.each(hasil_alternatif, (i,v) => {

                    $('#body_tab_5').append(`
                        <tr>
                            <td width="20%">${(v.alternatif_name).toUpperCase()}</td>
                            <td>${Math.sqrt((Math.pow((max_dsn-((((v.alternatif_nilai_dosen / hasil_pembagian[0].pembagian_nilai_dosen).toFixed(5)) * hasil_pembagian[0].b_dsn).toFixed(5))), 2))+(Math.pow((max_mhs-((((v.alternatif_nilai_mahasiswa / hasil_pembagian[0].pembagian_nilai_mahasiswa).toFixed(5)) * hasil_pembagian[0].b_mhs).toFixed(5))),2))+(Math.pow((max_mt-((((v.alternatif_nilai_matkul / hasil_pembagian[0].pembagian_nilai_matkul).toFixed(5)) * hasil_pembagian[0].b_mt).toFixed(5))),2)))}</td>
                            <td>${Math.sqrt((Math.pow((min_dsn-((((v.alternatif_nilai_dosen / hasil_pembagian[0].pembagian_nilai_dosen).toFixed(5)) * hasil_pembagian[0].b_dsn).toFixed(5))), 2))+(Math.pow((min_mhs-((((v.alternatif_nilai_mahasiswa / hasil_pembagian[0].pembagian_nilai_mahasiswa).toFixed(5)) * hasil_pembagian[0].b_mhs).toFixed(5))),2))+(Math.pow((min_mt-((((v.alternatif_nilai_matkul / hasil_pembagian[0].pembagian_nilai_matkul).toFixed(5)) * hasil_pembagian[0].b_mt).toFixed(5))),2)))}</td>
                        </tr>
                    `)

                    hasil_d_plus.push(Math.sqrt((Math.pow((max_dsn-((((v.alternatif_nilai_dosen / hasil_pembagian[0].pembagian_nilai_dosen).toFixed(5)) * hasil_pembagian[0].b_dsn).toFixed(5))), 2))+(Math.pow((max_mhs-((((v.alternatif_nilai_mahasiswa / hasil_pembagian[0].pembagian_nilai_mahasiswa).toFixed(5)) * hasil_pembagian[0].b_mhs).toFixed(5))),2))+(Math.pow((max_mt-((((v.alternatif_nilai_matkul / hasil_pembagian[0].pembagian_nilai_matkul).toFixed(5)) * hasil_pembagian[0].b_mt).toFixed(5))),2))))
                    hasil_d_min.push(Math.sqrt((Math.pow((min_dsn-((((v.alternatif_nilai_dosen / hasil_pembagian[0].pembagian_nilai_dosen).toFixed(5)) * hasil_pembagian[0].b_dsn).toFixed(5))), 2))+(Math.pow((min_mhs-((((v.alternatif_nilai_mahasiswa / hasil_pembagian[0].pembagian_nilai_mahasiswa).toFixed(5)) * hasil_pembagian[0].b_mhs).toFixed(5))),2))+(Math.pow((min_mt-((((v.alternatif_nilai_matkul / hasil_pembagian[0].pembagian_nilai_matkul).toFixed(5)) * hasil_pembagian[0].b_mt).toFixed(5))),2))))
                })


                var hasil_akhir = {}
                var urutan_hasil = []
                $.each(hasil_alternatif, (i,v) => {
                    $('#body_tab_6').append(`
                        <tr>
                            <td width="50%">${(v.alternatif_name).toUpperCase()}</td>
                            <td width="50%">${hasil_d_min[i]/(hasil_d_min[i]+hasil_d_plus[i])}</td>
                        </tr>
                    `)
                    // hasil_akhir = [v.alternatif_name , hasil_d_min[i]/(hasil_d_min[i]+hasil_d_plus[i])]
                    hasil_akhir = { 
                                    "alternatif" : v.alternatif_name,
                                    "poin" : (hasil_d_min[i]/(hasil_d_min[i]+hasil_d_plus[i]))
                                }
                    urutan_hasil.push(hasil_akhir)
                })

                urutan_hasil.sort((a,b) => b.poin - a.poin)
                
                $.each(urutan_hasil, (i,v) => {
                    $('#body_tab_7').append(`
                        <tr>
                            <td>${v.alternatif}</td>
                            <td>${v.poin}</td>
                            <td>${i+1}</td>
                        </tr>
                    `)
                })

                $('#table_pembagi').replaceWith(`
                    <table class="table table-bordered" style="font-size:12px;">
                        <tr>
                            <th>Nilai Pembagi Dosen</th>
                            <th>Nilai Pembagi Mahasiswa</th>
                            <th>Nilai Pembagi Mata Kuliah</th>
                        </tr>
                        <tr>
                            <td>${hasil_pembagian[0].pembagian_nilai_dosen}</td>
                            <td>${hasil_pembagian[0].pembagian_nilai_mahasiswa}</td>
                            <td>${hasil_pembagian[0].pembagian_nilai_matkul}</td>
                        </tr>
                    </table>
                `)


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