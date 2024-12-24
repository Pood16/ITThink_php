<?php 
    require("../config/database_config.php");
    session_start();
?>
<?php
    // $user_email = $user_password = "";
    $user_email_error = $user_password_error = $user_not_found_error = $none_error =  "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // email
        if (empty($_POST['email'])){
            $user_email_error = "Attention: Email est obligatoire";
        }else{
            if (!filter_var(check_input($_POST['email']), FILTER_VALIDATE_EMAIL)){
                $user_email_error = "Format d'email n'est pas valide";
            }else{
                $user_email = check_input($_POST['email']);
            }
        }
        // password
        if (empty($_POST['password'])){
            $user_password_error = "Attention: Password est Obligatoires";
        }else{
            if (strlen($_POST['password']) < 4){
                $user_password_error = "Attention: mot de passe doit contient aumoins 4 carecteres";  
            } else{
                $user_password = $_POST['password'];
            }
        }
       
        // Find the user from database
        $sql = $connect -> prepare("SELECT * FROM utilisateurs WHERE utilisateurs.email = ?");
        $sql -> bind_param("s", $user_email);
        $sql -> execute();
        $resultat = $sql -> get_result();
        if ($resultat -> num_rows == 1){
            $user = $resultat -> fetch_assoc();
            // print_r($user);
            if (isset($user) && password_verify($user_password, $user['mot_de_passe'])){
                switch($user['user_role']){
                    case "admin":
                        $_SESSION['user_name'] = "admin";
                        $_SESSION['user_email'] = $user_email;
                        $_SESSION['user_role'] = "admin";
                        $_SESSION['log_in'] = true;
                        header('Location: ../admin/admin_dashboard.php');
                        break;
                    case "utilisateur":
                        $_SESSION['user_name'] = $user['nom_utilisateur'];
                        $_SESSION['user_email'] = $user['email'];
                        $_SESSION['user_role'] = $user['user_role'];
                        $_SESSION['log_in'] = true;
                        header("Location: ../user/user_dashboard.php");
                        break;
                    case "freelancer":
                        $_SESSION['user_name'] = $user['nom_utilisateur'];
                        $_SESSION['user_email'] = $user['email'];
                        $_SESSION['user_role'] = $user['user_role'];
                        $_SESSION['id_utilisateur'] = $user['id_utilisateur'];
                        $_SESSION['log_in'] = true;
                        echo "<pre>";
                        print_r($user);
                        echo "</pre>";
                        header("Location: ../freelancer/freelancer_dashboard.php");
                        break;
                    default:
                        header("Location: ../authentication/login.php");
                        break;
                }
            }else{
                $none_error = "Email ou password n'est pas correcte";
            }
        }else{
            $user_not_found_error = "cette utilisateur n'existe pas";
        }
    }
    function check_input($input){
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Login.css">
    <title>Login Page</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Login</header>
            <span style="color: rgba(255, 0, 0, 0.5)"><?=$user_not_found_error?></span>
            <span style="color: rgba(255, 0, 0, 0.5)"><?=$none_error?></span>

            <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                <div class="field input">
                    <label for="username">Email</label>
                    <input type="text" name="email" id="user_email">
                    <span style="color: rgba(255, 0, 0, 0.5)"><?=$user_email_error?></span>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="user_password">
                    <span style="color: rgba(255, 0, 0, 0.5)"><?=$user_password_error?></span>
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