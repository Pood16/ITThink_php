<?php 
    require_once("database.php");
    session_start();
    if (!isset($_SESSION["user_name"]) || !isset($_SESSION["user_email"]) || !isset($_SESSION["user_role"])) {
        header("Location: login.php");
        exit();
    }
    $current_user = [
        "name" => $_SESSION["user_name"],
        "email" => $_SESSION["user_email"],
        "role" => $_SESSION["user_role"]
    ];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITThink dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <div class="flex">
        <aside class="w-64 h-screen bg-gray-800 fixed">
            <div class="flex items-center justify-center h-16 bg-gray-900">
                <h2 class="text-white text-xl font-semibold">ITThink</h2>
            </div>
            <nav class="mt-6">
                <div id="sidebar-menu" class="px-4">
                    <!-- role -->
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="ml-64 w-full">
            <!-- Top Navigation -->
            <header class="bg-white shadow h-16 flex items-center justify-between px-6">
                <div class="flex items-center">
                    <span id="user-name" class="text-gray-800 font-medium"></span>
                </div>
                <div class="flex items-center">
                    <span id="user-role" class="mr-4 text-gray-600"></span>
                    <a href="login.php">
                        <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                            Logout
                        </button>
                    </a>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="p-6">
                <div id="dashboard-content" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                     <!-- role -->
                </div>
            </main>
        </div>
    </div>

    <script>
        const currentUser = {
            name: "<?php echo htmlspecialchars($current_user["name"]); ?>",
            role: "<?php echo htmlspecialchars($current_user["role"]); ?>"
        };
   

        
        const menuItems = {
            admin: [
             
                { title: 'User Management', icon: '👥' },
               
            ],
            utilisateur: [
                { title: 'Dashboard', icon: '📊' },
                { title: 'Projects', icon: '💼' }
               
            ],
            freelancer: [
                { title: 'Dashboard', icon: '📊' },
                
            ]
        };

        // Dashboard content
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
        const dashboardContent = {
            admin: [
                { title: 'Total Users', value: '<?php echo mysqli_num_rows($users_result)?>', color: 'bg-blue-500' },
                { title: 'Projects', value: '<?php echo mysqli_num_rows($projects_result)?>', color: 'bg-green-500' },
                { title: 'Freelances', value: '<?php echo mysqli_num_rows($freelances_result)?>', color: 'bg-yellow-500' },
                { title: 'Offres', value: '<?php echo mysqli_num_rows($offres_result)?>', color: 'bg-purple-500' }
            ],
            utilisateur: [
                // { title: 'My Tasks', value: '5', color: 'bg-blue-500' },
                // { title: 'Completed', value: '12', color: 'bg-green-500' },
                // { title: 'Messages', value: '3', color: 'bg-yellow-500' }
            ],
            freelancer: [
                // { title: 'Active Projects', value: '3', color: 'bg-blue-500' },
                // { title: 'Hours This Month', value: '45', color: 'bg-green-500' },
                // { title: 'Earnings', value: '$1,200', color: 'bg-purple-500' }
            ]
        };

        // Load dashboard 
        function loadDashboard(role) {
            
            document.getElementById('user-name').textContent = `Welcome, ${currentUser.name}`;

            // sidebar menu
            const sidebarMenu = document.getElementById('sidebar-menu');
            sidebarMenu.innerHTML = menuItems[role].map(item => `
                <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-md mb-2">
                    <span class="mr-3">${item.icon}</span>
                    ${item.title}
                </a>
            `).join('');

            // dashboard content
            const dashboardContainer = document.getElementById('dashboard-content');
            dashboardContainer.innerHTML = dashboardContent[role].map(item => `
                <div class="p-6 rounded-lg shadow-md ${item.color} text-white">
                    <h3 class="text-lg font-semibold mb-2">${item.title}</h3>
                    <p class="text-3xl font-bold">${item.value}</p>
                </div>
            `).join('');
        }

       

        
        function logout() {
            
            window.location.href = 'login.html';
        }

       
        loadDashboard(currentUser.role);
    </script>
</body>
</html>
