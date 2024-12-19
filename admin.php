<?php 
    session_start();
    require("database.php");
    // include("addCategorie.php");
    if (!isset($_SESSION["user_name"]) && !isset($_SESSION["user_email"]) && !isset($_SESSION["user_role"])) {
        if ($_SESSION["user_email"] != "admin@gmail.com" && $_SESSION["user_name"] != "admin"){
            header("Location: login.php");
            exit();
        }
    }
    $current_user = [
        "name" => "admin",
        "email" => "admin@gmail.com",
        "role" => "admin"
    ];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Login.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="bg-gray-800 text-white w-64 min-h-screen p-4">
            <div class="mb-8">
                <h1 class="text-2xl font-bold">ITThink: admin</h1>
            </div>
            
            <nav>
                <ul class="space-y-2">
                    <li>
                        <a href="#stats" class="flex items-center p-2 hover:bg-gray-700 rounded-lg">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Statistiques
                        </a>
                    </li>
                    <li>
                        <a href="#testimonials" class="flex items-center p-2 hover:bg-gray-700 rounded-lg">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                            Gestion Témoignages
                        </a>
                    </li>
                    <li>
                        <a href="#categories" class="flex items-center p-2 hover:bg-gray-700 rounded-lg">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Gestion Catégories
                        </a>
                    </li>
                    <li>
                        <a href="#projects" class="flex items-center p-2 hover:bg-gray-700 rounded-lg">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                            </svg>
                            Gestion Projets
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        <!-- <button class="bg-blue-500 absolute top-2 right-2 cursor-pointer hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"name="logout-btn">
            Button
        </button> -->
        <?php 
            // if (isset())
        ?>
        
        <!-- <a href="login.php" class="flex items-center justify-center absolute top-2 right-2 p-2 text-red-500 bold hover:bg-red-700 hover:text-white rounded-lg">
            Logout
        </a> -->
        

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <?php 
                try {
                    $users_result = mysqli_query($connect, "SELECT * FROM utilisateurs");
                    $projects_result = mysqli_query($connect, "SELECT * FROM projects");
                    $freelances_result = mysqli_query($connect, "SELECT * FROM freelances");
                    $offres_result = mysqli_query($connect, "SELECT * FROM offres");
                }catch(mysqli_sql_exception){
                    echo " Failed to load data";
                } 
            ?>
            <!-- Statistics Section -->
            <section id="stats" class="mb-8 hidden">
                <h2 class="text-2xl font-bold mb-4">Statistiques</h2>
                <div class="grid grid-cols-4 gap-4">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-gray-500 text-sm">Projets Totaux</h3>
                        <p class="text-3xl font-bold"><?php echo mysqli_num_rows($projects_result)?></p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-gray-500 text-sm">Freelancer</h3>
                        <p class="text-3xl font-bold"><?php echo mysqli_num_rows($freelances_result)?></p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-gray-500 text-sm">Utilisateurs</h3>
                        <p class="text-3xl font-bold"><?php echo mysqli_num_rows($users_result)?></p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-gray-500 text-sm">Témoignages</h3>
                        <p class="text-3xl font-bold"><?php echo mysqli_num_rows($offres_result)?></p>
                    </div>
                </div>
            </section>
            <!-- Projects Section -->
            <section id="projects" class="mb-8">
                <h2 class="text-2xl font-bold mb-4">Gestion des Projets</h2>
                <div class="bg-white rounded-lg shadow p-6">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php 
                                $sql = "SELECT * FROM projects";
                                $resultat = $connect->query($sql);
                                while ($row = mysqli_fetch_array($resultat)) {
                                    ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $row["id_project"]?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $row["titre_projet"]?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $row["projet_status"]?></td>
                                        <td class="px-6 py-4"><?php echo $row["description_projet"]?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="edit_project.php?id=<?=$row["id_project"]?>" class="edit-btn bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 cursor-pointer">Modifier</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Categories Section -->
            <section id="categories" class="mb-8 hidden">
                <h2 class="text-2xl font-bold mb-4">Gestion des Catégories</h2>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="mb-4 inline-block">
                        <a href="addCategorie.php" id="add_cat" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Nouvelle Catégorie</a>
                    </div>
                    <div class="mb-4 inline-block">
                        <a id="add_sub_cat" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Nouvelle Sous Catégorie</a>
                    </div>
                    <div class="grid grid-cols-4 gap-4">
                        <div class="border p-4 rounded-lg">
                            <h3 class="font-bold">Design UI/UX</h3>
                            <div class="mt-4 space-x-2">
                                <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Modifier</button>
                                <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Supprimer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Testimonials Section -->
            <section id="testimonials" class="mb-8 hidden">
                <h2 class="text-2xl font-bold mb-4">Gestion des Témoignages</h2>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="space-y-4">
                        <div class="border p-4 rounded-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold">John Doe</h3>
                                    <p class="text-gray-600">Excellent service, très professionnel...</p>
                                </div>
                                <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Supprimer</button>
                            </div>
                        </div>
                        <div class="border p-4 rounded-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold">Jane Smith</h3>
                                    <p class="text-gray-600">Très satisfaite du résultat final...</p>
                                </div>
                                <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Supprimer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
        </main>
    </div>

    <script>
        // Simple navigation logic
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('main section');
            const navLinks = document.querySelectorAll('aside a');

            function showSection(sectionId) {
                sections.forEach(section => {
                    section.classList.add('hidden');
                    if (section.id === sectionId) {
                        section.classList.remove('hidden');
                    }
                });
            }

            navLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const sectionId = link.getAttribute('href').substring(1);
                    showSection(sectionId);
                });
            });

            // Show projects
            showSection('categories');
            // edit project stats
            // document.querySelectorAll(".edit-btn").forEach(function(button){
            //         button.addEventListener("click", function(){
            //            document.querySelector(".modal").classList.remove("hidden");
                   
            //         })
            //     })
            //     document.querySelector(".cancel-btn").addEventListener("click", function(){
            //             document.querySelector(".modal").classList.add("hidden");
            //     })
                // add categorie
                // document.getElementById("add_cat").addEventListener("click", function(){
                //     console.log(document.getElementById("add_cat"));
                //     document.getElementById("container_cat").classList.remove("hidden");
                // })
        });
    </script>
</body>
</html>
