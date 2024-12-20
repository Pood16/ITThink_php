<?php 
    require("database.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>add categorie</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
<body>
    <div id="container_cat" class="container absolute top-0 left-0 w-screen h-screen bg-black bg-opacity-50">
        <div  class="max-w-md mx-auto mt-8 p-6 bg-white rounded-lg shadow-md absolute top-0 left-[40%]">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">nouveau sous categorie</h2>
            <?php 
                if ($_SERVER["REQUEST_METHOD"] == "POST"){
                    $subcategorie = trim($_POST["nom_sub_categorie"]);
                    $categorie_id = $_POST["select-cat"];
                    
                
                    $warnings = [];
                    if (empty($subcategorie)){
                        $warnings[] = "Entrer le nom du categorie";
                    }
                    if(empty($warnings)){
                        $sql = $connect -> prepare("INSERT INTO sousCategories (nom_sous_categorie, id_categorie) VALUES (?, ?)");
                        $sql -> bind_param("si", $subcategorie, $categorie_id);
                        $sql -> execute();
                        header("Location: admin.php");
                    }else{
                        foreach($warnings as $warning){?>
                            <div class="text-red-400"><?= $warning?></div>
                        <?php }
                    }
                }
            ?>
            <form action="addSubCat.php" method="POST" class="space-y-4">
                
                <div>
                    <label for="nom_categorie" class="block text-sm font-medium text-gray-700">nom de sous categorie: </label>
                    <input type="text" id="nom_categorie" name="nom_sub_categorie" class="mt-1 block w-full rounded-md border-gray-300 shadow focus:border-blue-500">
                </div>
                <div>
                    <label for="nom_categorie" class="text-sm font-medium text-gray-700">categorie: </label>
                    <?php 
                        
                     
                    ?>
                    
                    <select name="select-cat" id="select-cat">
                    <?php
                        $category_sql = "SELECT * FROM categories";
                        $resultat = $connect->query($category_sql);
                        if ($resultat->num_rows > 0) {
                            $rows = $resultat->fetch_all(MYSQLI_ASSOC);
                            foreach($rows as $row){
                                echo "<option value='{$row['id_categorie']}'>" . $row['nom_categorie'] . "</option>";
                            }
                        }else echo "no data";
                        
                    ?>
                        
                    </select>
                </div>
        
                <button type="submit" class="inline-block bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none  focus:ring-blue-500">
                    Ajouter
                </button>
                <a id="close-add-cat-btn" href="admin.php" class="inline-block bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none  focus:ring-blue-500">
                    Home
            </a>
            </form>
        </div>
    </div>
</body>
</html>