<?php 

$conn = mysqli_connect("localhost", "root", "", "fin_track", "3306");

if($conn == false){
    echo "Connection Failed";
} 