<?php 
    require("../config/database_config.php");
    session_start(); 
?>
<!-- cat and sub cats -->
<?php 
    try{
        $sql = $connect -> prepare("SELECT categories.*, sousCategories.* FROM categories LEFT JOIN sousCategories ON categories.id_categorie = sousCategories.id_categorie");
        $sql -> execute();
        $resultat = $sql -> get_result();
        // $row_cat = $resultat->fetch_assoc();
        // echo "<pre>";
        // print_r($row_cat);
        // echo "</pre>";
    }catch(mysqli_sql_exception $err){
        $err -> getMessage();
    }

?>
<!-- end -->

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>add sous categorie</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
<body>
    <div id="container_cat" class="container absolute top-0 left-0 w-screen h-screen bg-black bg-opacity-50">
        <div  class="max-w-md mx-auto mt-8 p-6 bg-white rounded-lg shadow-md absolute top-0 left-[40%]">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">nouveau sous categorie</h2>
          
            <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" class="space-y-4">
                <div>
                    <label for="nom_categorie" class="block text-sm font-medium text-gray-700">nom de sous categorie: </label>
                    <input type="text" id="nom_categorie" name="nom_sous_categorie" class="mt-1 block w-full rounded-md border-gray-300 shadow focus:border-blue-500">
                </div>
                <div class="field input">
                    <label for="project_statu">Categorie</label>
                    <select name="categorie_name" class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg">
                        <?php while($row_cat = $resultat->fetch_assoc()){?>
                                <option value="<?=$row_cat['nom_categorie']?>"><?=$row_cat['nom_categorie']?></option>
                            <?php } ?>
                    </select>
                </div>
                <button type="submit" class="inline-block bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none  focus:ring-blue-500">
                    Ajouter
                </button>
                <a id="close-add-cat-btn" href="admin_dashboard.php#settings" class="inline-block bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none  focus:ring-blue-500">
                    Home
            </a>
            </form>
        </div>
    </div>
   
</body>
</html>
<?PHP 
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sou_cat = $_POST['nom_sous_categorie'];
        $cat_name = $_POST['categorie_name'];
        $cat_id_sql = $connect -> prepare("SELECT categories.id_categorie FROM categories WHERE categories.nom_categorie =  ?");
        $cat_id_sql -> bind_param("s", $cat_name);
        if($cat_id_sql -> execute()){
            $resultat_cat = $cat_id_sql -> get_result();
            $row_catt = $resultat_cat->fetch_assoc();
            $id_cat = $row_catt['id_categorie'];
            // echo "<pre>";
            // print_r($row_catt);
            // echo "</pre>";
            try{
                $insert_sql = $connect-> prepare("INSERT INTO sousCategories (sousCategories.id_categorie, sousCategories.nom_sous_categorie) VALUES (?,?)");
                $insert_sql -> bind_param("ds", $id_cat, $sou_cat);
                if ($insert_sql -> execute()){
                    header("Location: admin_dashboard.php#settings");
                }
            }catch(mysqli_sql_exception $err){
                $err -> getMessage();
            }
        }
        
        
        


    }

?>