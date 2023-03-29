<?php
$conn = mysqli_connect("45.90.230.191","u1584221_jordan","Surabaya2000","u1584221_yusuf");
// $conn = mysqli_connect("localhost","root","","topsis");

function query($query){
    global $conn;
    $result = mysqli_query($conn,$query);
    $rows =[];
    while ( $row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

function generate_uuid() {
	return sprintf( '%04x%04x%04x-%04x-%04x-%04x%04x%04x',
		mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
		mt_rand( 0, 0xffff ),
		mt_rand( 0, 0x0fff ) | 0x4000,
		mt_rand( 0, 0x3fff ) | 0x8000,
		mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
	);
}

function getPayload($form)
{
    $result = [];
    foreach($form as $key=>$value){
        $result[$value->name] = $value->value;
    }

    return $result;
}