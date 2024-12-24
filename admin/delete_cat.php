<?php 
    require("../config/database_config.php");
    session_start(); 
?>
<?php 
    if (isset($_GET['id'])){
        $id = $_GET['id'];
        try{
            $sql = $connect -> prepare ("SELECT * FROM categories WHERE categories.id_categorie = ?");
            $sql -> bind_param("d", $id);
            $sql -> execute();
            $resultat_sql = $sql -> get_result();
            $row_sql = $resultat_sql -> fetch_assoc();
            echo "<pre>";
            print_r($row_sql);
            echo "</pre>";
        }catch(mysqli_sql_exception $err){
            echo "Failed to find the cat ".$err->getMessage();
        }
    }

?>
<?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        try{
            $id = $_POST['id'];
            $new_cat_name = $_POST['nouveau_nom_categorie'];
            $delete_sql = $connect->prepare("DELETE FROM categories  WHERE categories.id_categorie = ?");
            $delete_sql -> bind_param("d",  $id);
            if ($delete_sql -> execute()){
                header("Location: admin_dashboard.php#settings");
            }
        }catch (mysqli_sql_exception $err){
            echo "Failed to create the cat". $err;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>delete  categorie</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
<body>
    <div id="container_cat" class="container absolute top-0 left-0 w-screen h-screen bg-black bg-opacity-50">
        <div  class="max-w-md mx-auto mt-8 p-6 bg-white rounded-lg shadow-md absolute top-0 left-[40%]">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Delete categorie</h2>
          
            <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" class="space-y-4">
                <div>
                    <label for="nom_categorie" class="block text-sm font-medium text-gray-700">nom de categorie: </label>
                    <input type="text" id="nom_categorie" value="<?=$row_sql['nom_categorie']?>" readonly name="nom_categorie" class="p-2 text-gray-500 mt-1 block w-full rounded-md border-gray-300 shadow focus:border-blue-500">
                </div>
                
                <input type="hidden" name="id" value="<?=$row_sql['id_categorie']?>">
                <button type="submit" class="inline-block bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none  focus:ring-blue-500">
                    Delete
                </button>
                <a id="close-add-cat-btn" href="admin_dashboard.php#settings" class="inline-block bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none  focus:ring-blue-500">
                    Home
            </a>
            </form>
        </div>
    </div>
   
</body>
</html>