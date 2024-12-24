<?php 
    require("../config/database_config.php");
    session_start();
    
?>
<?php 
    if (isset($_GET['id'])){
        $project_id = $_GET['id'];
        $select_sql = $connect -> prepare("SELECT projects.*, utilisateurs.* FROM projects JOIN utilisateurs ON projects.id_utilisateur = utilisateurs.id_utilisateur WHERE id_project = ?");
        $select_sql -> bind_param("d", $project_id);
        $select_sql -> execute();
        $resultat = $select_sql -> get_result();
        $row_project = $resultat -> fetch_assoc();
        echo "<pre>";
        print_r($row_project);
        echo "</pre>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Login.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>edit project status Page</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Changer Statu d'un Projet</header>
            <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                <div class="field input">
                    <label for="project_title">Titre de projet</label>
                    <input type="text" name="project_title" id="project_title" value="<?=$row_project['titre_projet']?>" class="text-gray-500" readonly>
                    
                </div>
                <div class="field input">
                    <label for="project_owner">nom d'utilisateur</label>
                    <input type="text" name="project_owner" value="<?=$row_project['nom_utilisateur']?>" class="text-gray-500" readonly>
                    
                </div>
                <div class="field input">
                    <label for="project_description">Description du Projet</label>
                    <textarea class="w-full h-40 p-3 border border-gray-300 focus:outline-none rounded-lg shadow-sm  resize-none text-gray-500" readonly><?=$row_project['description_projet']?></textarea>
                </div>
                <div class="field input">
                    <label for="date_creation">date de creation</label>
                    <input type="text" name="create_date" id="date_creation" value="<?=$row_project['date_creation']?>" class="text-gray-500" readonly>
                </div>
                <div class="field input">
                    <label for="project_statu">Statut de projet</label>
                    <select name="project_status" class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg">
                        <option value="Encours">Encours</option>
                        <option value="Done">Done</option>
                        <option value="Canceled">Canceled</option>
                    </select>
                </div>
                <input type="hidden" name="id" value="<?=$row_project['id_project']?>">
                <div class="field sub-btn">
                    <input type="submit"  value="Submit changes" name="submit" class="btn">
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $project_id = $_POST['id'];
        // echo $project_id;
        $selected_sat = $_POST['project_status'];
        try{
           $update_sql = $connect -> prepare("UPDATE projects SET projects.projet_status = ? WHERE projects.id_project = ?");
           $update_sql -> bind_param("sd", $selected_sat, $project_id); 
           if($update_sql -> execute()){
                header("Location: admin_dashboard.php#projects");
                // echo $selected_sat;
                // echo $project_id;
           }
        }catch (mysqli_sql_exception $err){
            echo "Failed to update the project status" .$err -> getMessage();
        }
    }

?>



