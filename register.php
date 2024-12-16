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
            <header>Creer un compte</header>
            <!-- php -->
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $username = trim($_POST["username"]);
                    $email = trim($_POST["email"]);
                    $password = $_POST["password"];

                    $warnings = [];

                    // Validation des inputs
                    if (empty($username) || empty($email) || empty($password)) {
                        $warnings[] = "All fields are required.";
                    }
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $warnings[] = "Invalid email format.";
                    }
                    if (strlen($password) < 6) {
                        $warnings[] = "Password must be at least 6 characters.";
                    }

                    // Check if a user exist
                    if (empty($warnings)) {
                        $sql = $connect->prepare("SELECT email FROM utilisateurs WHERE email = ?");
                        $sql->bind_param("s", $email);
                        $sql->execute();
                        $sql->store_result();

                        if ($sql->num_rows > 0) {
                            $warnings[] = "Email already in use.";
                        }
                        $sql->close();
                    }

                    // register user
                    if (empty($warnings)) {
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $sql = $connect->prepare("INSERT INTO utilisateurs(user_role, nom_utilisateur, mot_de_passe, email) VALUES (?, ?, ?, ?)");
                        $userRole = 'utilisateur';
                        $sql->bind_param("ssss", $userRole, $username, $hashedPassword, $email);

                        if ($sql->execute()) {
                            $_SESSION["user_name"] = $username;
                            $_SESSION["user_role"] = $userRole;
                            $_SESSION["user_email"] = $email;
                            $_SESSION["loggedin"] = true;
                            header("Location: home.php");
                            exit;
                        } else {
                            $warnings[] = "Failed to register. Please try again.";
                        }
                        $sql->close();
                    }

                    // Display warnings
                    if (!empty($warnings)) {
                        foreach ($warnings as $error) {
                            echo "<div class='message'><p>$error</p></div>";
                        }
                    }
                }
            ?>

            <!-- php -->
            <form action="" method="post">
                <div class="field input">
                    <label for="username">username</label>
                    <input type="text" name="username" id="user_name">
                </div>
                <div class="field input">
                    <label for="username">Email</label>
                    <input type="email" name="email" id="user_email">
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="user_password">
                </div>
                <div class="field sub-btn">
                    <input type="submit" value="Register" name="submit" class="btn">
                </div>
                <div class="links">
                    <p>Already have an account? <a href="login.php">Login Now</a></p>
                </div>

            </form>
        </div>
    </div>
</body>
</html>



