<?php
require 'Connection.php';

if(isset($_POST['group_id'])){
    $id = $_POST['group_id'];
    
    header('Content-Type: application/json; charset=utf-8');
    $alternatif =  query("SELECT * FROM alternatif WHERE alternatif_group = '$id'");
    $pembagian = query("SELECT * FROM pembagian WHERE pembagian_alternative_group = '$id'");

    $alternatif = json_encode($alternatif);
    $pembagian = json_encode($pembagian);

    $result_detail = [
                        'alternatif' => $alternatif,
                        'pembagian' => $pembagian
                    ];
    
    print_r(json_encode($result_detail));
}