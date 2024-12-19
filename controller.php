<?php
    require("database.php");
?>
<!-- edit project status -->
<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $new_status = mysqli_real_escape_string($connect, $_POST['project_status']);
        $id = mysqli_real_escape_string($connect, $_POST['id']);
        $sql = "UPDATE projects SET projet_status = '{$_POST['project_status']}' WHERE id_project = $id";
        if(mysqli_query($connect, $sql)){
            header("Location: admin.php");
        }else{
            echo "bad things happned";
            die("something went bad");
        }
    }
                
?>