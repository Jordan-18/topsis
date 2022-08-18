<?php 
session_start();
// jika page khusus untuk yang sudah login 
// optional
if (!isset($_SESSION["login"])){
    header("Location:login");
    exit;
}