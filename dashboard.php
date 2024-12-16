<?php
    include("database.php");
?>
<?php 
    try {
        // Select all tables
        $users_sql = "SELECT * FROM utilisateurs";
        $users_result = mysqli_query($connect, $users_sql);
    
        $projects_sql = "SELECT * FROM projects";
        $projects_result = mysqli_query($connect, $projects_sql);
    
        $freelances_sql = "SELECT * FROM freelances";
        $freelances_result = mysqli_query($connect, $freelances_sql);
    
        $offres_sql = "SELECT * FROM offres";
        $offres_result = mysqli_query($connect, $offres_sql);
    }catch(mysqli_sql_exception){
        echo " Failed to load data";
    }

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Dashboard</title>
</head>
<body>
    <!-- Home page -->
    <section class="home_page">
       <div class="users data_info">
            <span><?php echo mysqli_num_rows($users_result)?></span>
            <p>utilisateurs</p>
        </div>
       <div class="projects data_info">
            <span><?php echo mysqli_num_rows($projects_result)?></span>
            <p>Projets</p>
       </div>
       <div class="freelances data_info">
            <span><?php echo mysqli_num_rows($freelances_result)?></span>
            <p>Freelances</p>
       </div>
       <div class="offres data_info">
            <span><?php echo mysqli_num_rows($offres_result)?></span>
            <p>Offres</p>
       </div> 
    </section>
</body>
</html>
