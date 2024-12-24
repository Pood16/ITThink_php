<?php require("../config/database_config.php") ?>
<?php 
    if (isset($_GET['id'])){
        $message = "";
        $target_user = $_GET['id'];
        // echo "$target_user";
        $sql = $connect -> prepare ("SELECT * FROM utilisateurs WHERE id_utilisateur = ?");
        $sql -> bind_param("d", $target_user);
        $sql -> execute();
        $result = $sql -> get_result();
        $row = $result -> fetch_assoc();
        // echo $row['nom_utilisateur'];
        // echo "<pre>";
        // print_r($row);
        // echo "</pre>";
    }
?>
<?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $target_id = $_POST['hidden_id'];
        $sql = $connect -> prepare("DELETE FROM utilisateurs WHERE id_utilisateur = ?");
        $sql -> bind_param("d", $target_id);
        if($sql -> execute()){
            $message = "utilisateurs est bien supprimer";
            header("Location: admin_dashboard.php#users");    
        }else $message = "Failed to supprimer l'utilisateur";
        

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Login.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>edit user role Page</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Changer Le role D'un utilisateur</header>
            <span class="text-red-500"><?=$message?></span>
            <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                <div class="field input">
                    <label for="username">nom d'utilisateur</label>
                    <input type="text" name="username" value="<?=$row['nom_utilisateur']?>" id="user_name" class="text-gray-600" readonly>
                </div>
                <div class="field input">
                    <label for="user_email">Email</label>
                    <input type="text" name="email" id="user_email" value="<?=$row['email']?>" class="text-gray-600" readonly> 
                </div>
                <div class="field input">
                    <label for="user_role">role actuelle</label>
                    <input type="text" name="old_role" id="user_role" value="<?=$row['user_role']?>" class="text-gray-600" readonly>
                </div>
                <input type="hidden" name="hidden_id" value="<?=$row['id_utilisateur']?>">
                <div class="field sub-btn">
                    <input type="submit" value="supprimer utilisateur" name="submit" class="btn">
                </div>
                <div class="links">
                <a href="admin_dashboard.php">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</body>
</html>



