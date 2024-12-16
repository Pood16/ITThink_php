<!-- connect database -->
<?php 
    include("database.php");
    session_start();
?>
<!-- html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form action="sign.php" method="post">
        <label for="username">Username:</label><br>
        <input type="text" name="username" id="user_name"><br>
        <label for="email">Email:</label><br>
        <input type="email" name="email" id="user_email"><br>
        <label for="password">Password:</label><br>
        <input type="password" name="password" id="user_password"><br>
        <label for="confirm_password">Confirm Password:</label><br>
        <input type="password" name="confirm_password" id="confirm_password"><br>
        <input type="submit" value="Register" name="submit">
    </form>
</body>
</html>
<?php 
    // submit the form
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $userName = $_POST["username"];
        $userEmail = $_POST["email"];
        $password = $_POST["password"];
        $confirmedPassword = $_POST["confirm_password"];

        function validPass($pass, $confirmPass){
            if ($pass == $confirmPass){
                return password_hash($pass, PASSWORD_DEFAULT);
            }else{
                echo "the password does not match";
                return null;
            }
        }
        $userPassword = validPass($password, $confirmedPassword);
        
        // validation
        if (empty($userName)){
            echo "The username can not be empty!";
        }
        if (empty($userEmail)){
            echo "The Email can not be empty!";
        }
        if (empty($password)){
            echo "The password can not be empty!";
        }
        if (empty($confirmedPassword)){
            echo "This filled can not be empty!";
        } 
        // check if the user is already existe
        $check_user_sql = "SELECT * FROM utilisateurs WHERE nom_utilisateur = '$userName'";
        $check_result = mysqli_query($connect, $check_user_sql);
        if (($check_result &&  $userPassword !== null)|| $userName == "admin"){
            $num_records = mysqli_num_rows($check_result);
            if ($num_records > 0){
                echo "this user name is taken, Please try another one!";
            } else {
                try{
                    $insert_sql = "INSERT INTO utilisateurs(user_role, nom_utilisateur, mot_de_passe, email) VALUES ('utilisateur','$userName','$userPassword', '$userEmail')";
                    $insert_result = mysqli_query($connect, $insert_sql);
                    echo "<li>user created avec success</li>";
                    header("Location: dashboard.php");
                }catch(mysqli_sql_exception){
                    echo "Failed to add user!";
                }
            }
        }
    }
?>