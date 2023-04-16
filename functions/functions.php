<?php
require 'Connection.php';

if(isset($_GET['approve'])){
    global $conn;
    $data = json_decode(base64_decode($_GET['approve']));

    $update = mysqli_query($conn, 
        "UPDATE alternatif SET 
            alternatif_nilai_dosen = '".$data->nilaiDosen."', 
            alternatif_approve = '1'
            WHERE alternatif_id = '".$data->id."' AND alternatif_group = '".$data->group_id."'
        ");
    
    if($update){
        $getData = query("SELECT * FROM alternatif WHERE alternatif_group = '".$data->group_id."'");
        $n_Dsn = 0;
        $countApprove = 0;
    
        foreach($getData as $key=>$value){
            $n_Dsn += pow((float)$value['alternatif_nilai_dosen'], 2);

            if(isset($value['alternatif_approve'])){
                $countApprove++;
            }
        }

        $n_Dsn = round(sqrt($n_Dsn), 6);

        if($countApprove == count($getData)){
            $queryPembagian = "UPDATE pembagian SET 
                pembagian_nilai_dosen = '".$n_Dsn."',
                dosen_approve = '1'
                WHERE pembagian_alternative_group = '".$data->group_id."'
            ";
        }else{
            $queryPembagian = "UPDATE pembagian SET 
                pembagian_nilai_dosen = '".$n_Dsn."'
                WHERE pembagian_alternative_group = '".$data->group_id."'
            ";
        }

        $updatePembagian = mysqli_query($conn,$queryPembagian);

        print_r(true);
        exit;
    }else{
        print_r(false);
        exit;
    }

}
else if(isset($_POST['approveAll'])){
    $data = getPayload(json_decode(base64_decode($_POST['approveAll'])));

    foreach(explode(',',$data['id_dosen']) as $key=>$value){
        $update = mysqli_query($conn, 
            "UPDATE alternatif SET 
                alternatif_nilai_dosen = '".$data['nilai-dosen-'.$value]."', 
                alternatif_approve = '1'
                WHERE alternatif_id = '".$value."' AND alternatif_group = '".$data['group_id']."'
            ");
    }
    if($update){
        $getData = query("SELECT * FROM alternatif WHERE alternatif_group = '".$data['group_id']."'");
        $n_Dsn = 0;
        $countApprove = 0;
    
        foreach($getData as $key=>$value){
            $n_Dsn += pow((float)$value['alternatif_nilai_dosen'], 2);

            if(isset($value['alternatif_approve'])){
                $countApprove++;
            }
        }

        $n_Dsn = round(sqrt($n_Dsn), 6);

        if($countApprove == count($getData)){
            $queryPembagian = "UPDATE pembagian SET 
                pembagian_nilai_dosen = '".$n_Dsn."',
                dosen_approve = '1'
                WHERE pembagian_alternative_group = '".$data['group_id']."'
            ";
        }else{
            $queryPembagian = "UPDATE pembagian SET 
                pembagian_nilai_dosen = '".$n_Dsn."'
                WHERE pembagian_alternative_group = '".$data['group_id']."'
            ";
        }

        $updatePembagian = mysqli_query($conn,$queryPembagian);

        print_r(true);
        exit;
    }else{
        print_r(false);
        exit;
    }
}