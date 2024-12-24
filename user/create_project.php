<?php 
    require("../config/database_config.php");
    session_start();
    // echo "<pre>";
    //         print_r($_SESSION);
    //         echo "</pre>";
?>
<!-- nom_utilisateur -->
<?php 
    $user_id = "";
    try{
        if(isset($_SESSION['user_email'])){
            $user_email = $_SESSION['user_email'];
            // echo $user_email;
            $sql = $connect -> prepare("SELECT * FROM utilisateurs WHERE utilisateurs.email = ?");
            $sql -> bind_param("s", $user_email);
            if ($sql -> execute()){
                $resultat = $sql -> get_result();
                $row = $resultat -> fetch_assoc();
                $user_id = $row['id_utilisateur'];
            }
            // echo $user_id;
            
            // echo "<pre>";
            // print_r($row);
            // echo "</pre>";
        }    
    }catch (mysqli_sql_exception $err){
        echo "Failed to update the project status" .$err -> getMessage();
    }
?>
<!-- categories -->
<?php 
    try{   
        $sql = $connect -> prepare("SELECT * FROM categories");
        $sql -> execute();
        $resultat_cat = $sql -> get_result();
        $row_cat = $resultat -> fetch_assoc();
        
        // echo "<pre>";
        // print_r($row_cat);
        // echo "</pre>";
         
    }catch (mysqli_sql_exception $err){
        echo "Failed " .$err -> getMessage();
    }
?>
<!-- sub cats -->
<?php 
    try{   
        $sql = $connect -> prepare("SELECT * FROM sousCategories");
        $sql -> execute();
        $resultat_subcat = $sql -> get_result();
        $row_sub_cat = $resultat -> fetch_assoc();
        // echo "<pre>";
        // print_r($row_sub_cat);
        // echo "</pre>";
         
    }catch (mysqli_sql_exception $err){
        echo "Failed " .$err -> getMessage();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Login.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Create Project</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Creer un Projet</header>
            <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                <div class="field input">
                    <label for="project_title">Titre de projet</label>
                    <input type="text" name="project_title" id="project_title" value="" class="text-gray-500">
                    
                </div>
                <div class="field input">
                    <label for="project_owner">nom d'utilisateur</label>
                    <input type="text" name="project_owner" value="<?=$row['nom_utilisateur']?>" class="text-gray-500" readonly>
                    
                </div>
                <div class="field input">
                    <label for="project_description">Description du Projet</label>
                    <textarea name="project_description" class="w-full h-30 p-3 border border-gray-300 focus:outline-none rounded-lg shadow-sm  resize-none text-gray-500"></textarea>
                </div>
                <div class="field input">
                    <label for="project_statu">Categorie</label>
                    <select name="categorie_name" class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg">
                        <?php while($row_cat = $resultat_cat -> fetch_assoc()){?>
                                <option value="<?=$row_cat['nom_categorie']?>"><?=$row_cat['nom_categorie']?></option>
                        <?php } ?>  
                    </select>
                </div>
                <div class="field input">
                    <label for="project_statu">sous Categorie</label>
                    <select name="sous_categorie_name" class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg">
                        <?php while($row_sub_cat = $resultat_subcat -> fetch_assoc()){?>
                                <option value="<?=$row_sub_cat['nom_sous_categorie']?>"><?=$row_sub_cat['nom_sous_categorie']?></option>
                        <?php } ?>   
                    </select>
                </div>
                <div class="field input">
                    <label for="date_creation">date de creation</label>
                    <input type="date" name="create_date" id="date_creation" value="<?=date('Y-m-d')?>" class="text-gray-500">
                </div>

                <input type="hidden" name="id_utilisateur" value="<?=$row['id_utilisateur']?>">
                <div class="field sub-btn">
                    <input type="submit"  value="Create" name="submit" class="btn">
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $user_id = $_POST['id_utilisateur'];
        $project_description = $_POST['project_description'];
        $project_title = $_POST['project_title'];
        $nom_categorie = $_POST['categorie_name'];
        $nom_sous_categorie = $_POST['sous_categorie_name'];
        $create_date = $_POST['create_date'];
        $id_cate = null;
        $id_sub_cate = null;
        try{
            // cat
            $sql_select_cat_id = $connect -> prepare("SELECT categories.id_categorie FROM categories WHERE categories.nom_categorie = ?");
            $sql_select_cat_id -> bind_param("s", $nom_categorie);
            // sub cat
            $sql_select_sub_cat_id = $connect -> prepare("SELECT sousCategories.id_sous_categorie FROM sousCategories WHERE sousCategories.nom_sous_categorie = ?");
            $sql_select_sub_cat_id -> bind_param("s", $nom_sous_categorie);
            if ($sql_select_cat_id->execute()){
                $res1 = $sql_select_cat_id -> get_result();
                $row1 = $res1 -> fetch_assoc();
                $id_cate = $row1['id_categorie'];
                // echo "<pre>";
                // print_r($row1);
                // echo "</pre>";
            }else{
                echo "bad";
            }
            if($sql_select_sub_cat_id->execute()){
                $res2 = $sql_select_sub_cat_id -> get_result();
                $row2 = $res2 -> fetch_assoc();
                $id_sub_cate = $row2['id_sous_categorie'];
                // echo "<pre>";
                // print_r($row2);
                // echo "</pre>";
            }else{
                echo "bad";
            }
            try{
                $sql = $connect -> prepare("INSERT INTO projects (titre_projet, description_projet, id_categorie, id_sous_categorie, id_utilisateur, date_creation) VALUES (?,?,?,?,?,?)");
                $sql -> bind_param("ssddds", $project_title, $project_description, $id_cate,  $id_sub_cate, $user_id, $create_date );
                if($sql -> execute()){
                    header("Location: user_dashboard.php#projects");
                }
               
            }catch (mysqli_sql_exception $err){
                echo "Failed to update the project status :" .$err -> getMessage();
            }
        }catch (mysqli_sql_exception $err){
            echo "Failed to update the project status :" .$err -> getMessage();
        }
        
    }

?>



