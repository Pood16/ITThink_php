<?php
    session_start();
    if (isset($_SESSION['log_in']) && $_SESSION['user_role'] == 'utilisateur'){
            // echo "<pre>";
            // print_r($_SESSION);
            // echo "</pre>";
    }else{
        header('Location: ../authentication/login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user Dashboard</title>
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
                <h2 class="text-xl font-bold text-white text-center">Welcome <?=$_SESSION['user_name']?></h2>
            </div>
            
            <nav class="p-4">
                <ul class="space-y-2">
                    <!-- <li>
                        <a href="#overview" onclick="showSection('overview')" class="nav-link block text-white hover:bg-gray-700 rounded p-2">
                            Overview
                        </a>
                    </li> -->
                    <!-- <li>
                        <a href="#users" onclick="showSection('users')" class="nav-link block text-white hover:bg-gray-700 rounded p-2">
                            Users Management
                        </a>
                    </li> -->
                    <li>
                        <a href="#projects" onclick="showSection('projects')" class="nav-link block text-white hover:bg-gray-700 rounded p-2">
                            Projects
                        </a>
                    </li>
                    <!-- <li>
                        <a href="#settings" onclick="showSection('settings')" class="nav-link block text-white hover:bg-gray-700 rounded p-2">
                            Settings
                        </a>
                    </li> -->
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-lg">
                <div class="p-4 flex justify-end items-center">
                    <!-- <div>
                        <h1 class="text-2xl font-bold text-gray-900">Welcome back!</h1>
                        <p class="text-gray-600">Role: Admin</p>
                    </div> -->
                    <div class="flex items-center space-x-4">
                        <a href="../authentication/logout.php">
                            <button  class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Logout</button>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <!-- Overview Section -->
                <!-- <section id="overview" class="dashboard-section active">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-gray-700 text-lg font-semibold mb-2">Total Users</h3>
                            <p class="text-3xl font-bold text-gray-900">248</p>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-gray-700 text-lg font-semibold mb-2">Active Projects</h3>
                            <p class="text-3xl font-bold text-gray-900">12</p>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-gray-700 text-lg font-semibold mb-2">Total Revenue</h3>
                            <p class="text-3xl font-bold text-gray-900">$24,500</p>
                        </div>
                    </div>
                </section> -->

                <!-- Users Management Section -->
                <section id="users" class="dashboard-section">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                            <h2 class="text-xl font-semibold text-gray-900">Users Management</h2>
                            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add New User</button>
                        </div>
                        <div class="p-4">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="text-left p-4">User</th>
                                        <th class="text-left p-4">Role</th>
                                        <th class="text-left p-4">Status</th>
                                        <th class="text-left p-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b">
                                        <td class="p-4">John Doe</td>
                                        <td class="p-4">Admin</td>
                                        <td class="p-4"><span class="px-2 py-1 bg-green-100 text-green-800 rounded">Active</span></td>
                                        <td class="p-4">
                                            <button class="text-blue-500 hover:text-blue-700 mr-2">Edit</button>
                                            <button class="text-red-500 hover:text-red-700">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- Projects Section -->
                <section id="projects" class="dashboard-section">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                            <h2 class="text-xl font-semibold text-gray-900">Mes Projets</h2>
                            <a href="create_project.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ajouter Projet</a>
                        </div>
                        <?php include("display_projects.php")?>
                    </div>
                </section>

                <!-- Settings Section -->
                <section id="settings" class="dashboard-section">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Settings</h2>
                        <form>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Site Name</label>
                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Email Notifications</label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                                    <span class="ml-2 text-gray-700">Enable email notifications</span>
                                </label>
                            </div>
                            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save Settings</button>
                        </form>
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