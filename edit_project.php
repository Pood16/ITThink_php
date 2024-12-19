<?php require("database.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php 
    
?>
<body>
    <div class="modal z-50 w-screen h-screen bg-red-100 absolute top-0 left-0">
        <div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-6">Modifier le projet</h2>
            <?php 
                if (isset($_GET["id"])){
                    $id = $_GET["id"];
                    // echo "id = $id";
                    $sql = "SELECT * FROM projects WHERE id_project = $id";
                    $result = mysqli_query($connect, $sql);
                    $row = mysqli_fetch_array($result);
                }
            ?>
            <form class="space-y-4" method="post" action="controller.php">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="project_title">
                        Titre du Projet
                    </label>
                    <input type="text" name="project_title" id="project_title"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        value="<?=$row['titre_projet']?>" readonly>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="project_status">
                        Status du Projet
                    </label>
                    <input type="text" name="project_status" id="project_status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        value="<?=$row['projet_status']?>">
                </div>
                <input type="hidden" name="id" value="<?=$row['id_project']?>">


                <!-- <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="project_categorie" 
                    value="" readonly>
                        Catégorie du Projet
                    </label>
                    <input type="text" name="project_categorie" id="project_categorie"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="project_sub_categorie" readonly>
                        Sous-catégorie du Projet
                    </label>
                    <input type="text" name="project_sub_categorie" id="project_sub_categorie"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div> -->

                <div class="flex justify-end space-x-4">
                    <a href="admin.php" class="cancel-btn px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Annuler</a>
                    <input type="submit" value="Enregistrer" 
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 cursor-pointer">
                </div>
            </form>
            
        </div>
    </div>
</body>
</html>