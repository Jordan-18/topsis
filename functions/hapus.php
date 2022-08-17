<?php
session_start();
if (!isset($_SESSION["login"])){
    header("Location:login.php");
    exit;
}
require 'Connection.php';

function hapus_group($id){
    global $conn;

    mysqli_query($conn,"DELETE FROM alternatif WHERE alternatif_group ='$id'");
    mysqli_query($conn,"DELETE FROM pembagian WHERE pembagian_alternative_group	 = '$id'");
    return mysqli_affected_rows($conn);
}

$id_group = $_GET['id_group'];

if(hapus_group($id_group)){
    $_SESSION['alert'] = "Data Berhasil DiHapus";
    header("Location:../hasil");
}else{
    $_SESSION['alert'] = "Data Gagal DiHapus";
    header("Location:../hasil");
}