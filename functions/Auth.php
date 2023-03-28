<?php
require 'Connection.php';

function Register($data){
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $email = strtolower(stripslashes($data["email"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 =mysqli_real_escape_string($conn, $data["password2"]);
    
    $result=mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' AND email = '$email'");

    if(mysqli_fetch_assoc($result)){
        $_SESSION['danger'] = "Username Has Used";
        return false;
    }

    if($password !== $password2){
        $_SESSION['danger'] = "Password Does Not Match";
        return false;
    }

    $passwordhash = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO users VALUES('','$username','$email','$passwordhash','Mahasiswa')");
    return mysqli_affected_rows($conn);
}