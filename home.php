<?php 
    require_once("database.php");
    session_start();
    if ($_SESSION["loggedin"]){
        if ($_SESSION["user_role"] == "utilisateur"){
            header("Location: dashboard.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/home.css">
    <title>Home Page</title>
</head>
<body>
    <!-- header -->
    <header class="header">
        <div class="header-container">
            <a href="#" class="logo"><span>IT</span>Think</a>
            <nav>
                <a href="#">Freelancer</a>
                <a href="#">
                    <button class="out-btn">Log Out</button>
                </a>
            </nav>
        </div>
    </header>
    <!-- Page d'acceuil -->
    
</body>
</html>