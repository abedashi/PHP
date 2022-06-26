<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="image/NBA_35964.ico">
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" rel="stylesheet">
    <link href="CSS/layout.css" rel="stylesheet">
    <style>
        .error {
            color: red;
            font-size: small;
        }
    </style>
</head>
<body>
    <div class="aside">
        <div class="h">
            <h2>Sport</h2>
        </div>
        <div class="copyright">
            &#169; Abed Al Salam Ashi
        </div>
    </div>

    <?php

        session_start();
        include "project.php";

        $usernameSignInErr = $passwordSignInErr = "";
        $usernameback = $usernamebackDone = "";
        $passwordback = $passwordbackDone = "";
        $usernameText = $passwordText = "";
        $passwordSignIn = "";
        $error = false;
        $nb = 0;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty($_POST["username-sign-in"])) {
                $error = true;
                $usernameSignInErr = "Name can't be blank";
                $usernameback = "background-color: #FFEEEE; !important";
            } else {
                $username = test_input($_POST["username-sign-in"]);
                $sql_u = mysqli_query($conn, "SELECT username FROM users WHERE username='$username'") or die(mysqli_error($conn));
                if (mysqli_num_rows($sql_u) === 0) {
                    $error = true;
                    $usernameSignInErr = "Username not exist";
                    $usernameback = "background-color: #FFEEEE; !important";
                } else {
                    $usernamebackDone = "background-color: #f2f2f2ed; !important";
                    $usernameText = $username;
                    $nb++;
                }
            }

            if (empty($_POST["password-sign-in"])) {
                $error = true;
                $passwordSignInErr = "Password can't be blank";
                $passwordback = "background-color: #FFEEEE; !important";
            } else {
                $passwordSignIn = test_input($_POST["password-sign-in"]);
                if (strlen($passwordSignIn) < 7) {
                    $error = true;
                    $passwordSignInErr = "Password must be at least 8 characters.";
                    $passwordback = "background-color: #FFEEEE; !important";
                } else {
                    $passwordbackDone = "background-color: #f2f2f2ed; !important";
                    $passwordText = $passwordSignIn;
                    $nb++;
                }
            }
        }

        if ($nb ==  2) {
            $query = "SELECT * FROM users WHERE username='$username' AND password='$passwordSignIn'";
            $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
            $row = mysqli_fetch_array($result);
            if (is_array($row)) {
                $_SESSION["id"] = $row["id"];
                $_SESSION["name"] = $row["name"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["image"] = $row["image"];
                $_SESSION["state"] = $row["state"];
            } else {
                $error = true;
                echo "<script>alert('username or password incorrect!')</script>";
                $usernameback = "background-color: #FFEEEE; !important";
                $passwordback = "background-color: #FFEEEE; !important";
                $passwordSignInErr = "Invalid Username or Password.";
            }
        }
        if (isset($_SESSION["id"])) {
            header("Location:home.php");
        }


        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>


    <div class="form">

        <div class="member">
            <p>Not a member? <a href="register.php">Sign up now</a></p>
        </div>

        <div class="container">

            <h2 id="signin-signup-title">Sign In</h2>
            
            <div class="button-2">
                <button class="btn btn-primary" id="btn-sign-in" type="submit" style="width: 190px; border: none; border-radius: 5px; padding: 7px;"><strong>
                    <ion-icon name="logo-google"></ion-icon>
                </strong></button>
                <button class="btn btn-primary" id="btn-create-account" type="submit" style="width: 190px; border: none; border-radius: 5px; padding: 7px;"><strong>
                    <ion-icon name="logo-apple"></ion-icon>
                </strong></button>
            </div>
            <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
            <br>
            <hr>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="div-sign-in">
                    <div class="shi">
                        <h6><strong>Username</strong></h6>
                        <a href="#">Forgot password?</a>
                    </div>
                    <div class="mb-3">
                        <input autocomplete="off" class="form-control mx w" id="username" name="username-sign-in" type="text" size="55" value="<?php echo $usernameText ?>" style="<?php echo ($error ? $usernameback : $usernamebackDone); ?>">
                    </div>
                    <span class="error"><?php echo $usernameSignInErr;?></span>
                    <h6><strong>Password</strong></h6>
                    <div class="mb-3">
                        <input autocomplete="off" class="form-control mx w" id="password" name="password-sign-in" type="password" size="55" value="<?php echo $passwordText ?>" style="<?php echo ($error ? $passwordback : $passwordbackDone); ?>">
                    </div>
                    <span class="error"><?php echo $passwordSignInErr;?></span>
                    <br>
                    <!-- FFADCE -->
                    <button class="btn btn-primary" name="btn-sign-in" type="submit" style="width: 190px; border: none; border-radius: 5px; padding: 7px; background-color: #FB5561;"><strong>Sign In</strong></button>
                    <br>
                    <br>
                </div>
            </form>
            <p class="copyright-responsive">&#169; Abed Al Salam Ashi</p>
        </div>
    </div>
</body>
</html>