<?php 
session_start();
// jika page khusus untuk yang sudah login 
// optional
if (!isset($_SESSION["login"])){
    header("Location:login.php");
    exit;
}
?>
<!-- Judul -->
<script>document.title = "Hello World";</script>

<!-- tampilan bagian Atas -->
<?php include('views/frontend/frontend_upper.php')?>

<!-- code here -->

<!-- tampilan bagian bawah -->
<?php include('views/frontend/frontend_lower.php')?>