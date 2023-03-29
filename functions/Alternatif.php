<?php
require 'Connection.php';

function createAlternatif($data)
{
    global $conn;
    $number_of_alternatif = (int)$data['numberofalternatif'];
    $dosen = $data['dosen'];
    $mahasiswa = $data['mahasiswa'];
    $b_dsn = $data['b_dsn'];
    $b_mhs = $data['b_mhs'];
    $b_mt = $data['b_mt'];
    $gen_group_id = generate_uuid();
    $insert_at = date('Y-m-d H:i:s');
    $n_Dsn = 0;
    $n_Mhs = 0;
    $n_MT = 0;

    foreach($data['alternatif_num'] as $key=>$value){
        $name_alternatif = strtolower(stripslashes($data['name_alternatif'.($value)]));
        // $matkul_alternatif = strtolower(stripslashes($data['matkul_alternatif'.($value)]));
        $nilai_dosen_alternatif = $data['nilai_dosen_alternatif'.($value)];
        $nilai_mahasiswa_alternatif = $data['nilai_mahasiswa_alternatif'.($value)];
        $nilai_matkul_alternatif = $data['nilai_matkul_alternatif'.($value)];

        mysqli_query($conn, "INSERT INTO alternatif VALUES('','$gen_group_id','$name_alternatif','$dosen','$mahasiswa','$nilai_dosen_alternatif','$nilai_mahasiswa_alternatif','$nilai_matkul_alternatif','','$insert_at')");
        
        
        $n_Dsn += pow((float)$data['nilai_dosen_alternatif'.($value)], 2);
        $n_Mhs += pow((float)$data['nilai_mahasiswa_alternatif'.($value)],2 );
        $n_MT += pow((float)$data['nilai_matkul_alternatif'.($value)],2 );
    }

    $n_Dsn = round(sqrt($n_Dsn), 6);
    $n_Mhs = round(sqrt($n_Mhs), 6);
    $n_MT = round(sqrt($n_MT), 6);

    mysqli_query($conn, "INSERT INTO pembagian VALUES('','$gen_group_id','$n_Dsn','$n_Mhs','$n_MT','$b_dsn','$b_mhs','$b_mt', '')");
 

    $_SESSION['alert'] = "Data Berhasil Diinputkan";
    return mysqli_affected_rows($conn);
}