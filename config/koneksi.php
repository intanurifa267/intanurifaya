<?php
    $koneksi = mysqli_connect("localhost", "root", "", "inventaris");

    if(mysqli_connect_error()){
        echo "koneksi error :" . mysqli_connect_error();
    }
    
?>