<?php 
    require_once("database.php");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Login.css">
    <title>Login Page</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Login</header>
            <!-- php -->
            <?php 
                if ($_SERVER["REQUEST_METHOD"] == "POST"){
                    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                    $password = $_POST["password"];
                    $warnings = [];
                    // ncheckiw email format
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $warnings[] = "Wrong email format";
                    }
                    // password 
                    if (empty($password) || strlen($password) < 6) {
                        $warnings[] = "Password length should be at least 6 characters";
                    }
                    // jib data
                    if (empty($warnings)){
                       $sql = $connect -> prepare("SELECT * FROM utilisateurs WHERE email = ?");
                       $sql -> bind_param("s", $email);
                       $sql -> execute();
                       $query_result = $sql -> get_result();
                       $user = $query_result -> fetch_assoc();
                       if($user && password_verify($password, $user["mot_de_passe"])){
                            $_SESSION["user_name"] = $user["nom_utilisateur"];
                            $_SESSION["user_role"] = $user["user_role"];
                            $_SESSION["user_email"] = $user["email"];
                            $_SESSION["loggedin"] = true;
                            header("Location: admin.php");
                            exit;
                       }
                       else{
                         $warnings[] = "Invalid email or password";
                       }
                    }
                    else{
                        foreach ($warnings as $error) {
                            echo "<div class='message'><p>$error</p></div>";
                        }
                    }
                    
                }
            ?>
            <!-- php -->
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Email</label>
                    <input type="text" name="email" id="user_email" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="user_password" required>
                </div>
                <div class="field sub-btn">
                    <input type="submit" value="Login" name="submit" class="btn">
                </div>
                <div class="links">
                    <p>Dont have an account? <a href="register.php">  Register Now</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>