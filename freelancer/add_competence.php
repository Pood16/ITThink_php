<?php 
    // session_start();
    require("../config/database_config.php");
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $competence = $_POST['competence'];
        $id = $_POST['hidden_id'];
        // echo $id;
        try{
            $sql = $connect -> prepare("UPDATE freelances SET freelances.competenceS = ? WHERE freelances.id_utilisateur = ?");
            $sql -> bind_param("sd", $competence, $id);
            if ($sql->execute()){
                header("Location: freelancer_dashboard.php#overview");
            }
        }catch(mysqli_sql_exception $err){
            echo "Failed to update competence ".$err->getMessage();
        }
    }
?>
<?PHP 
    $current_id = $_SESSION['id_utilisateur'];
    $sql = $connect -> prepare("SELECT freelances.*, utilisateurs.*  FROM freelances JOIN utilisateurs  ON freelances.id_utilisateur = utilisateurs.id_utilisateur WHERE freelances.id_utilisateur = ?");
    $sql -> bind_param("d", $current_id);
    $sql -> execute();
    $result = $sql -> get_result();
    $row = $result -> fetch_assoc();
    // echo "<pre>";
    //  print_r($row);
    // echo "</pre>";
    // echo "<br>";
                        
?>
<div class="container" style = "min-height:unset">
    <div class="box form-box">
        <header>Ajouter des Competances</header>
        <form action="add_competence.php" method="post">
            <div class="field input">
                <label for="username">username</label>
                <input type="text" name="username" id="user_name" value="<?=$row['nom_utilisateur']?>" class="text-gray-500" readonly>
            </div>
            <div class="field input">
                <label for="username">Email</label>
                <input type="text" name="email" id="user_email" value="<?=$row['email']?>"  class="text-gray-500" readonly> 
            </div>
            <div class="field input">
                <label for="competance">Competances</label>
                <input type="text" name="competence" id="user_competance">
            </div>
            <input type="hidden" name="hidden_id" value="<?=$_SESSION['id_utilisateur']?>">
            <div class="field sub-btn">
                <input type="submit" value="add" name="submit" class="btn">
            </div>
            <div class="links">
            </div>
        </form>
    </div>
</div>