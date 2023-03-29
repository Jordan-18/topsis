<?php
require '../Connection.php';

$response = [];

if(isset($_GET['index'])){
    $response = query("SELECT * FROM ms_alternatif");
}
else if(isset($_GET['show'])){
    $id = $_GET['show'];
    $response = query("SELECT * FROM ms_alternatif WHERE ms_alternatif_id = '$id'");
}
else if(isset($_POST['create'])){
    $uuid = generate_uuid();
    $data = getPayload(json_decode(base64_decode($_POST['create'])));
    $name = $data["alternatif_name"];

    $create = mysqli_query($conn, "INSERT INTO ms_alternatif VALUES('$uuid','$name')");
    
    $response = $create;
}
else if(isset($_POST['update'])){
    $data = getPayload(json_decode(base64_decode($_POST['update'])));
    $id = $data["alternatif_id"];
    $name = $data["alternatif_name"];

    $update = mysqli_query($conn, 
        "UPDATE ms_alternatif 
            SET ms_alternatif_name = '$name' 
            WHERE ms_alternatif_id = '$id'");
    
    $response = $update;
}
else if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    $update = mysqli_query($conn, 
        "DELETE FROM ms_alternatif WHERE ms_alternatif_id = '$id'");
}

die(json_encode($response));