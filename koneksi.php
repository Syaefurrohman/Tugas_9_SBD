<?php
$koneksi = mysqli_connect("localhost", "root", "", "saefulrohman");

if (mysqli_connect_errno()){
    echo "Gagal menghubungkan ke MYSQL:". mysqli_connect_error();
    
}