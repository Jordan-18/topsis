<?php
require '../Connection.php';

$response = [];

if(isset($_GET['index'])){
    $response = query(
        "SELECT * 
        FROM mata_kuliah
        LEFT JOIN ms_alternatif
        ON  mata_kuliah.mata_kuliah_alternatif = ms_alternatif.ms_alternatif_id");
}
else if(isset($_GET['byAlternatif'])){
    $alternatif = $_GET['byAlternatif'];
    
    $response = query(
        "SELECT * 
        FROM mata_kuliah
        LEFT JOIN ms_alternatif
        ON  mata_kuliah.mata_kuliah_alternatif = ms_alternatif.ms_alternatif_id
        WHERE ms_alternatif.ms_alternatif_name LIKE '%$alternatif%'");
}
else if(isset($_GET['show'])){
    $id = $_GET['show'];
    $response = query("SELECT * FROM mata_kuliah WHERE mata_kuliah_id = '$id'");
}
else if(isset($_POST['create'])){
    $uuid = generate_uuid();
    $data = getPayload(json_decode(base64_decode($_POST['create'])));
    $name = $data["mata_kuliah_name"];
    $alternatif_id = $data["name_alternatif"];

    $create = mysqli_query($conn, "INSERT INTO mata_kuliah VALUES('$uuid','$name','$alternatif_id')");
    
    $response = $create;
}
else if(isset($_POST['update'])){
    $data = getPayload(json_decode(base64_decode($_POST['update'])));
    $id = $data["mata_kuliah_id"];
    $name = $data["mata_kuliah_name"];
    $alternatif_id = $data["name_alternatif"];

    $update = mysqli_query($conn, 
        "UPDATE mata_kuliah 
            SET 
            mata_kuliah_name = '$name',
            mata_kuliah_alternatif = '$alternatif_id'
            WHERE mata_kuliah_id = '$id'");
    
    $response = $update;
}
else if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    $update = mysqli_query($conn, 
        "DELETE FROM mata_kuliah WHERE mata_kuliah_id = '$id'");
}

die(json_encode($response));