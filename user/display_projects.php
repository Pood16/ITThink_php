
<?php 
    require("../config/database_config.php");
    // session_start();
    // echo "<pre>";
    // print_r($_SESSION);
    // echo "</pre>";
?>
<!-- start -->
<?php 
    if ($_SESSION['user_email']){
        $user_email = $_SESSION['user_email'];
        try{
            $sql = $connect -> prepare("SELECT utilisateurs.id_utilisateur, utilisateurs.nom_utilisateur FROM utilisateurs WHERE utilisateurs.email = ?");
            $sql -> bind_param("s", $user_email);
            if ($sql -> execute()){
                $resultat = $sql -> get_result();
                $row = $resultat -> fetch_assoc();
                $id_utilisateur = $row['id_utilisateur'];
                // echo $id_utilisateur;
                // echo "<pre>";
                // print_r($row);
                // echo "</pre>";
                $sql_projects = $connect -> prepare("SELECT projects.*, sousCategories.*, categories.* FROM projects JOIN sousCategories ON projects.id_sous_categorie = sousCategories.id_sous_categorie JOIN categories ON projects.id_categorie = categories.id_categorie WHERE projects.id_utilisateur = ? ");
                $sql_projects -> bind_param("d", $id_utilisateur);
                if ($sql_projects -> execute()){
                    $res = $sql_projects -> get_result();
                    
                    // while($rows = $res -> fetch_assoc()){
                    //     echo "<pre>";
                    //     print_r($rows);
                    //     echo "</pre>";
                    // }
                }
            }
          

            
        }catch(mysqli_sql_exception $err){
            echo "The user not found ".$err -> getMessage();
        }
    }

?>

<!-- End -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>display projects</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="p-4">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="text-left p-4">Project title</th>
                    <th class="text-left p-4">categorie</th>
                    <th class="text-left p-4">sous categorie</th>
                    <th class="text-left p-4">Project owner</th>
                    <th class="text-left p-4">Project status</th>
                    <th class="text-left p-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($rows = $res -> fetch_assoc()){?>
                <tr class="border-b">
                    <td class="p-4"><?=$rows['titre_projet']?></td>
                    <td class="p-4"><?=$rows['nom_categorie']?></td>
                    <td class="p-4"><?=$rows['nom_sous_categorie']?></td>
                    <td class="p-4"><?=$row['nom_utilisateur']?></td>
                    <td class="p-4"><span class="px-2 py-1 bg-green-100 text-green-800 rounded"><?=$rows['projet_status']?></span></td>
                    <td class="p-4">
                        <button class="text-blue-500 hover:text-blue-700 mr-2">Edit</button>
                        <button class="text-red-500 hover:text-red-700">Delete</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>