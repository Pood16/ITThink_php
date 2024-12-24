<!-- connect database using PDO -->
<?php 
    // $hostname = "localhost";
    // $username = "root";
    // $password = "8951";
    // $database = "ITThink";
    
    // try{
    //     $connection = new PDO("mysql:host=$hostname;dbname=$database",$username,$password);
    //     $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // }catch(PDOException $e){
    //     echo "Failed to connect ". $e -> getMessage();
    // }
?>
<!-- connect to database using MySQLi object-oriented -->
<?php 

    $host_name = "localhost";
    $user_name = "root";
    $user_password = "8951";
    $data_base = "ITThink";
    try{
        $connect = new mysqli($host_name, $user_name, $user_password, $data_base);
        // echo "connected";
    }catch(mysqli_sql_exception $e){
        echo "connection failed " . $e -> getMessage();
    }
   

?>