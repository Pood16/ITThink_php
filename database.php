

<!-- connect to database -->
<?php 
    $host_name = "localhost";
    $user_name = "root";
    $password = "8951";
    $data_base = "ITThink";

    $connect = "";
    try{
        $connect = mysqli_connect($host_name, $user_name, $password, $data_base);
    }catch(mysqli_sql_exception){
        echo "Failed to connect";
    }
    if ($connect){
        // echo "connected!";
    }
?>