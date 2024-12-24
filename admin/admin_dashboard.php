<?php
    session_start();
    require('../config/database_config.php');
    if (isset($_SESSION['log_in']) && $_SESSION['user_role'] == 'admin'){
        // echo "<pre>";
        // print_r($_SESSION);
        // echo "</pre>";
    }else{
        header('Location: ../authentication/login.php');
        exit();
    }
?>
<!-- stats from database : page d'acceuil -->
<?php 
    try{
        $total_users = $connect->query("SELECT * FROM utilisateurs WHERE id_utilisateur != 1");
        
        $total_projects = $connect->query("SELECT * FROM projects");
        $total_freelances = $connect->query("SELECT * FROM freelances");
        $total_offers = $connect->query("SELECT * FROM offres");
    }catch(mysqli_sql_exception $err){
        echo "Fialed to load stats" . $err -> getMessage();
    }
?>
<!-- projects -->
<?php 
    $select_sql = $connect->prepare("SELECT projects.*, utilisateurs.* FROM projects JOIN utilisateurs WHERE projects.id_utilisateur = utilisateurs.id_utilisateur");
    $select_sql -> execute();
    $resultat = $select_sql -> get_result();
?>
<!-- cats and sub cats -->
<?php 
    try{
        $select_cats_sql = $connect -> prepare ("SELECT * FROM categories");
        $select_cats_sql -> execute();
        $res = $select_cats_sql -> get_result();
        // while($row_cats = $res->fetch_assoc()){
        //     echo "<pre>";
        //     print_r($row_cats);
        //     echo "</pre>";
        // }
    }catch(mysqli_sql_exception $err){
        echo "Failed ".$err -> getMessage();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Hide sections by default */
        .dashboard-section {
            display: none;
        }
        /* Show active section */
        .dashboard-section.active {
            display: block;
        }
        /* Active navigation state */
        .nav-link.active {
            background-color: #4B5563;
        }
    </style>
</head>
<body>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800">
            <div class="p-4 border-b border-gray-700">
                <h2 class="text-xl font-bold text-white"><?=$_SESSION['user_role']?> Dashboard</h2>
            </div>
            
            <nav class="p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="#overview" onclick="showSection('overview')" class="nav-link block text-white hover:bg-gray-700 rounded p-2">
                            Statistiques Generales
                        </a>
                    </li>
                    <li>
                        <a href="#users" onclick="showSection('users')" class="nav-link block text-white hover:bg-gray-700 rounded p-2">
                            Users Management
                        </a>
                    </li>
                    <li>
                        <a href="#projects" onclick="showSection('projects')" class="nav-link block text-white hover:bg-gray-700 rounded p-2">
                            Projects
                        </a>
                    </li>
                    <li>
                        <a href="#settings" onclick="showSection('settings')" class="nav-link block text-white hover:bg-gray-700 rounded p-2">
                        Gestion des categories
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-lg">
                <div class="p-2 flex justify-end items-center">
                    
                    <div class="flex items-center space-x-4">
                        <a href="../authentication/logout.php">
                            <button  class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Logout</button>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <!-- stats Section -->
                <section id="overview" class="dashboard-section active">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-gray-700 text-lg font-semibold mb-2 text-center">Utilisateurs</h3>
                            <p class="text-3xl font-bold text-rose-900 text-center"><?=$total_users->num_rows?></p>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-gray-700 text-lg font-semibold mb-2 text-center">Projects</h3>
                            <p class="text-3xl font-bold text-rose-900 text-center"><?=$total_projects->num_rows?></p>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-gray-700 text-lg font-semibold mb-2 text-center">Active Freelances</h3>
                            <p class="text-3xl font-bold text-rose-900 text-center"><?=$total_freelances->num_rows?></p>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-gray-700 text-lg font-semibold mb-2 text-center">Active Offers</h3>
                            <p class="text-3xl font-bold text-rose-900 text-center"><?=$total_offers->num_rows?></p>
                        </div>
                    </div>
                </section>

                <!-- Users Management Section -->
                <section id="users" class="dashboard-section">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                            <h2 class="text-xl font-semibold text-gray-900">Users Management</h2>
                            <!-- <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add New User</button> -->
                        </div>
                        <div class="p-4">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="text-left p-4">User</th>
                                        <th class="text-left p-4">Role</th>
                                        
                                        <th class="text-left p-4">Actions</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php while($row = $total_users -> fetch_assoc()){ ?>
                                        <tr class="border-b">
                                            <td class="p-4"><?=$row['nom_utilisateur']?></td>
                                            <td class="p-4"><?=$row['user_role']?></td>
                                            
                                            <td class="p-4">
                                                <a href="edit_role.php?id=<?=$row['id_utilisateur']?>" class="cursor-pointer text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                                                <a href="delete_user.php?id=<?=$row['id_utilisateur']?>" class="cursor-pointer text-red-500 hover:text-red-700">Delete</a>
                                            </td>
                                        </tr>
                                            <?php   } ?>
                                        </tbody>
                                    </table>
                        </div>
                    </div>
                </section>

                <!-- Projects Section -->
                <section id="projects" class="dashboard-section">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                            <h2 class="text-xl font-semibold text-gray-900">Projects</h2>
                        </div>
                        <div class="p-4">
                        
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="text-left p-4">#</th>
                                        <th class="text-left p-4">titre Projet</th>
                                        <th class="text-left p-4">projet utilisateur</th>
                                        <th class="text-left p-4">Status du Projet</th>
                                        <th class="text-left p-4">date de creation</th>
                                        <th class="text-left p-4 text-blue-900">Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php while($row_projects = $resultat -> fetch_assoc()){;?>
                                        <tr class="border-b">
                                            <td class="p-4"><?=$row_projects['id_project']?></td>
                                            <td class="p-4"><?=$row_projects['titre_projet']?></td>
                                            <td class="p-4"><?=$row_projects['nom_utilisateur']?></td>
                                            <td class="p-4 text-red-500"><?=$row_projects['projet_status']?></td>
                                            <td class="p-4"><?=$row_projects['date_creation']?></td>
                                            <td class="p-4">
                                                <a href="edit_project_statu.php?id=<?=$row_projects['id_project']?>" class="cursor-pointer text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- Categories Section -->
                <section id="settings" class="dashboard-section">
                    <div class="bg-white rounded-lg shadow p-3 flex justify-between">
                        <a href="add_cat.php" class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">nouveau categorie</a>
                        <a href="add_sub_cat.php" class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">nouveau sous categorie</a>
                    </div>
                    <div class="p-4 grid gap-5 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                            <?php while($row_cats = $res->fetch_assoc()){
                                    // $sub_query = "SELECT * FROM sub_categories WHERE categorie_id = ".$row_cats['id_categorie'];
                                    // $res_sub = $db->query($sub_query); 
                                ?>

                                <table class="min-w-full ">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th class=" p-4"><?=$row_cats['nom_categorie']?></th>
                                            <th class="p-4 text-right">
                                                <a href="edit_cat.php?id=<?=$row_cats['id_categorie']?>" class="cursor-pointer text-blue-500 hover:text-blue-700 inline-block mr-3">Edit</a>
                                                <a href="delete_cat.php?id=<?=$row_cats['id_categorie']?>" class="cursor-pointer text-red-500 hover:text-red-700 inline-block">Delete</a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <tr class="border-b">
                                            <!-- <td class="p-4"></td> -->
                                            <!-- <td class="p-4"></td> -->
                                            <!-- <td class="p-4">
                                                <a href="edit_role.php?id=" class="cursor-pointer text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                                                <a href="delete_user.php?id=" class="cursor-pointer text-red-500 hover:text-red-700">Delete</a>
                                            </td> -->
                                        </tr>  
                                        
                                    </tbody>
                                </table>
                            <?php } ?>      
                    </div>
                </section>
            </main>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            // Hide all sections
            document.querySelectorAll('.dashboard-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Show selected section
            document.getElementById(sectionId).classList.add('active');
            
            // Update active navigation state
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });
            document.querySelector(`a[href="#${sectionId}"]`).classList.add('active');
        }

        // Check URL hash on page load
        window.addEventListener('load', () => {
            const hash = window.location.hash.slice(1) || 'overview';
            showSection(hash);
        });
        
    </script>
</body>
</html>



