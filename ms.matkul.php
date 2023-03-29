<?php 
    include('functions/isLogin.php');
    $username = $_SESSION["username"];
?>

<script>document.title = "Mata Kuliah";</script>
<?php include('views/frontend/frontend_upper.php')?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Mata Kuliah</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Mata Kuliah</li>
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
                                    Mata Kuliah Table
                            </div>
                            <div class="card-body">
                                <table id="table_ms-mata_kuliah"></table>
                            </div>
                        </div>     
                    </div>

                </div>
                
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="ModalMataKuliah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Mata Kuliah Modal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="formMataKuliah" onsubmit="onCreate()" method="POST">
            <input type="hidden" name="mata_kuliah_id" id="mata_kuliah_id">
            <div class="mb-3">
                <label for="MataKuliah-name" class="form-label">Mata Kuliah Name</label>
                <input type="text" class="form-control" name="mata_kuliah_name" id="mata_kuliah_name" placeholder="Nama Mata Kuliah">
            </div>
        </form>
      </div>

      <div class="modal-footer" id="modalmatakuliah-footer"></div>
    </div>
  </div>
</div>

<!-- Display Data -->
<script>
    $(document).ready( function (){
        $.ajax({
            url: "functions/master/mata_kuliah.php?index",
            success:function(response){
                var data = JSON.parse(response)

                $('#table_ms-mata_kuliah').DataTable({
                    data : data,
                    fnRowCallback: function(row,data,index,rowIndex){
                        $('td:eq(2)',row).html(`
                            <button class="btn btn-warning" name="detail" data-id="${data.mata_kuliah_id}" onclick="onEdit(this);"><i class="fa-solid fa-pen"></i></button>
                            <button class="btn btn-danger" name="detail" data-id="${data.mata_kuliah_id}" onclick="onDelete(this);"><i class="fa-solid fa-trash"></i></button>
                        `)
                    },
                    columns: [
                            {data: '', name: '', width:'5%', title: "#"},
                            {data: 'mata_kuliah_name', name: 'mata_kuliah_name', title: "Mata Kuliah"},
                            {title: "Action"},
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
        $('#ModalMataKuliah').modal('show')
        $('#formMataKuliah').trigger("reset");
        $('#formMataKuliah').attr("onsubmit","onCreate()");
        $('#modalmatakuliah-footer').empty()
        $('#modalmatakuliah-footer').append(`<button class="btn btn-primary" onclick="onCreate()">Submit</button>`)
    }

    onCreate = () => {
        let form = $('#formMataKuliah').serializeArray()
        form = btoa(JSON.stringify(form))
        $.ajax({
            url:"functions/master/mata_kuliah.php",
            type: "POST",
            data: 'create='+form,
            success:function(response){
                if(response){
                    alert('Successfully')
                    $('#ModalMataKuliah').modal('hide')
                }else{
                    alert('Falied')
                }
            }
        })
    }

    onEdit = (el) => {
        var data = $(el).data()
        $('#ModalMataKuliah').modal('show')
        $('#formMataKuliah').trigger("reset");
        $('#formMataKuliah').attr("onsubmit","onUpdate()");
        $.ajax({
            url: "functions/master/mata_kuliah.php?show="+data.id,
            success:function(response){
                var data = JSON.parse(response)[0]

                $('#mata_kuliah_id').val(data['mata_kuliah_id']);
                $('#mata_kuliah_name').val(data['mata_kuliah_name']);
            }
        })
        $('#modalmatakuliah-footer').empty()
        $('#modalmatakuliah-footer').append(`<button class="btn btn-success" onclick="onUpdate();">Update</button>`)
    }

    onUpdate = () => {
        let form = $('#formMataKuliah').serializeArray()
        form = btoa(JSON.stringify(form))
        $.ajax({
            url:"functions/master/mata_kuliah.php",
            type: "POST",
            data: 'update='+form,
            success:function(response){
                console.log(response);
                if(response){
                    alert('Successfully')
                    $('#ModalMataKuliah').modal('hide')
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
            url: "functions/master/mata_kuliah.php?delete="+data.id,
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

    $('#ModalMataKuliah').on('hidden.bs.modal', function () {
        location.reload();
    });

</script>
<script>
    setTimeout(() => {
        $('#message').slideUp('fast');
    }, 1500);
</script>
<?php include('views/frontend/frontend_lower.php')?>