<?php require("database.php")?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="modal z-50 w-screen h-screen bg-red-100 absolute top-0 left-0">
            <div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-6">Modifier Categorie</h2>
                <?php 
                    if (isset($_GET['id'])){
                        $id = $_GET['id'];
                        $sql = $connect -> prepare("SELECT nom_categorie FROM categories WHERE id_categorie = ?");
                        $sql -> bind_param("i", $id);
                        $sql -> execute();
                        $result = $sql -> get_result();
                        if($result -> num_rows > 0){
                            $row = $result -> fetch_assoc();?>
                            
                <form class="space-y-4" method="post" action="update_cat.php">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="categorie_nom">
                            nom categorie
                        </label>
                        <input type="text" name="nom_categorie" id="nom_categorie"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                            value="<?=$row['nom_categorie']?>">
                    </div>
                    <input type="hidden" name="id" value='<?=$row['id_categorie']?>'>
    
                    <div class="flex justify-end space-x-4">
                        <a href="admin.php" class="cancel-btn px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Annuler</a>
                        <input type="submit" value="Enregistrer" 
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 cursor-pointer">
                    </div>
                    <?php }else echo "no data";
        }?>
                </form>
                
            </div>
    </div>
    <!-- submit l form -->
    <?php 
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $id_cat = $_POST['id'];
            $up_sql = $connect -> prepare("UPDATE nom_categorie FROM categories WHERE id_categorie = ?");
            $up_sql -> bind_param("i", $id_cat);
            $up_sql -> execute();
        }
    ?>
</body>
</html>