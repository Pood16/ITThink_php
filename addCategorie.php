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
            <h2 class="text-2xl font-bold mb-6 text-gray-800">nouveau categorie</h2>
            <?php 
                if ($_SERVER["REQUEST_METHOD"] == "POST"){
                    $categorie = trim($_POST["nom_categorie"]);
                    $warnings = [];
                    if (empty($categorie)){
                        $warnings[] = "Entrer le nom du categorie";
                    }
                    if(empty($warnings)){
                        $sql = $connect -> prepare("INSERT INTO categories (nom_categorie) VALUES (?)");
                        $sql -> bind_param("s", $categorie);
                        $sql -> execute();
                    }else{
                        foreach($warnings as $warning){?>
                            <div class="text-red-400"><?= $warning?></div>
                        <?php }
                    }
                }
            ?>
            <form action="admin.php" method="POST" class="space-y-4">
                <div>
                    <label for="nom_categorie" class="block text-sm font-medium text-gray-700">nom de categorie: </label>
                    <input type="text" id="nom_categorie" name="nom_categorie" class="mt-1 block w-full rounded-md border-gray-300 shadow focus:border-blue-500">
                </div>
        
                <button type="submit" class="inline-block bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none  focus:ring-blue-500">
                    Ajouter
                </button>
                <button id="close-add-cat-btn" type="button" class="inline-block bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none  focus:ring-blue-500">
                    Cancel
                </button>
            </form>
        </div>
    </div>
    <script>
        

            // // close cat modal
            // document.getElementById("close-add-cat-btn").addEventListener("click", function(){
            //     document.getElementById("container_cat").classList.add("hidden");
            // })
    </script>
</body>
</html>