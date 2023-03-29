<?php 
    include('functions/isLogin.php');
    $username = $_SESSION["username"];
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
                </ul>

                <div class="tab-content" id="myTabContent">
                    

                    <div class="tab-pane fade show active" id="data" role="tabpanel" aria-labelledby="home-tab">
                        <button class="btn btn-success mt-3" onclick="onTambah();"><i class="fa-solid fa-plus"></i> Tambah</button>

                        <div class="card mb-4 mt-3">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                    Alternatif Table
                            </div>
                            <div class="card-body">
                                <table id="table_ms-alternatif"></table>
                            </div>
                        </div>     
                    </div>

                </div>
                
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="ModalAlternatif" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Alternatif Modal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="formAlternatif" onsubmit="onCreate()" method="POST">
            <input type="hidden" name="alternatif_id" id="alternatif_id">
            <div class="mb-3">
                <label for="alternatif-name" class="form-label">Alternatif Name</label>
                <input type="text" class="form-control" name="alternatif_name" id="alternatif_name" placeholder="Alternatif Name">
            </div>
        </form>
      </div>

      <div class="modal-footer" id="modalAlternatid-footer"></div>
    </div>
  </div>
</div>

<!-- Display Data -->
<script>
    $(document).ready( function (){
        $.ajax({
            url: "functions/master/alternatif.php?index",
            success:function(response){
                var data = JSON.parse(response)

                $('#table_ms-alternatif').DataTable({
                    data : data,
                    fnRowCallback: function(row,data,index,rowIndex){
                        $('td:eq(2)',row).html(`
                            <button class="btn btn-warning" name="detail" data-id="${data.ms_alternatif_id}" onclick="onEdit(this);"><i class="fa-solid fa-pen"></i></button>
                            <button class="btn btn-danger" name="detail" data-id="${data.ms_alternatif_id}" onclick="onDelete(this);"><i class="fa-solid fa-trash"></i></button>
                        `)
                    },
                    columns: [
                            {data: '', name: '', width:'5%', title: "#"},
                            {data: 'ms_alternatif_name', name: 'ms_alternatif_name', title: "Alternatif"},
                            {data: 'alternatif_group', name: 'alternatif_group', title: "Action"},
                        ],
                    columnDefs: [{
                        "defaultContent": "-",
                        "targets": "_all"
                    }]
                })

            }
        })
    })

    onTambah = () => {
        $('#ModalAlternatif').modal('show')
        $('#formAlternatif').trigger("reset");
        $('#formAlternatif').attr("onsubmit","onCreate()");
        $('#modalAlternatid-footer').empty()
        $('#modalAlternatid-footer').append(`<button class="btn btn-primary" onclick="onCreate()">Submit</button>`)
    }

    onCreate = () => {
        let form = $('#formAlternatif').serializeArray()
        form = btoa(JSON.stringify(form))
        $.ajax({
            url:"functions/master/alternatif.php",
            type: "POST",
            data: 'create='+form,
            success:function(response){
                if(response){
                    alert('Successfully')
                    $('#ModalAlternatif').modal('hide')
                }else{
                    alert('Falied')
                }
            }
        })
    }

    onEdit = (el) => {
        var data = $(el).data()
        $('#ModalAlternatif').modal('show')
        $('#formAlternatif').trigger("reset");
        $('#formAlternatif').attr("onsubmit","onUpdate()");
        $.ajax({
            url: "functions/master/alternatif.php?show="+data.id,
            success:function(response){
                var data = JSON.parse(response)[0]

                $('#alternatif_id').val(data['ms_alternatif_id']);
                $('#alternatif_name').val(data['ms_alternatif_name']);
            }
        })
        $('#modalAlternatid-footer').empty()
        $('#modalAlternatid-footer').append(`<button class="btn btn-success" onclick="onUpdate();">Update</button>`)
    }

    onUpdate = () => {
        let form = $('#formAlternatif').serializeArray()
        form = btoa(JSON.stringify(form))
        $.ajax({
            url:"functions/master/alternatif.php",
            type: "POST",
            data: 'update='+form,
            success:function(response){
                console.log(response);
                if(response){
                    alert('Successfully')
                    $('#ModalAlternatif').modal('hide')
                }else{
                    alert('Falied')
                }
            }
        })
        

    }

    onDelete = (el) => {
        if(confirm('Apakah anda yakin menghapus data ini ?')){
            var data = $(el).data()
            $.ajax({
            url: "functions/master/alternatif.php?delete="+data.id,
            success:function(response){
                if(response){
                    alert('Successfully')
                    location.reload();
                }else{
                    alert('Falied')
                }
            }
        })
        }
        else{

        }
    }

    $('#ModalAlternatif').on('hidden.bs.modal', function () {
        location.reload();
    });

</script>
<script>
    setTimeout(() => {
        $('#message').slideUp('fast');
    }, 1500);
</script>
<?php include('views/frontend/frontend_lower.php')?>