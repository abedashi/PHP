<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="icon" type="image/x-icon" href="image/NBA_35964.ico">
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" rel="stylesheet">
    <link href="CSS/register.css" rel="stylesheet">
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

        include "project.php";

        $nameErr = $usernameSignUpErr = $passwordSignUpErr = $termErr = "";
        $nameText = $usernameText = $passwordText = "";
        $name = $usernameSignUp = $passwordSignUp = "";
        $nameBackground = $namebackgroundDone = "";
        $usernameback = $usernamebackDone = "";
        $passwordback = $passwordbackDone = "";
        $usernameTaken = $rows = "";
        $error = false;
        $valid = 0;

    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["name-sign-up"])) {
                $error = true;
                $nameErr = "Name can't be blank";
                $nameBackground = "background-color: #FFEEEE; !important";
            } else {
                $name = test_input($_POST["name-sign-up"]);
                $nameBackgroundDone = "background-color: #f2f2f2ed; !important";
                $nameText = $name;
                $valid++;
            }

            if (empty($_POST["username-sign-up"])) {
                $error = true;
                $usernameSignUpErr = "Username can't be blank";
                $usernameback = "background-color: #FFEEEE; !important";
            } else {
                $usernameSignUp = test_input($_POST["username-sign-up"]);
                $sql_u = "SELECT * FROM users WHERE username='$usernameSignUp'";
                $row = mysqli_query($conn, $sql_u);
                if (mysqli_num_rows($row) > 0) {
                    $error = true;
                    $usernameback = "background-color: #FFEEEE; !important";
                    $usernameSignUpErr = "Username already taken";
                } else {
                    $usernamebackDone = "background-color: #f2f2f2ed; !important";
                    $usernameText = $usernameSignUp;
                    $valid++;
                }
            }

            if (empty($_POST["password-sign-up"])) {
                $error = true;
                $passwordSignUpErr = "Password can't be blank";
                $passwordback = "background-color: #FFEEEE; !imprtant";
            } else {
                $passwordSignUp = test_input($_POST["password-sign-up"]);
                // $password = password_hash($passwordSignUp, PASSWORD_BCRYPT);
                if (strlen($passwordSignUp) < 7) {
                    $error = true;
                    $passwordSignUpErr = "Password must be at least 8 characters.";
                    $passwordback = "background-color: #FFEEEE; !important";
                } else {
                    $passwordbackDone = "background-color: #f2f2f2ed; !important";
                    $passwordText = $passwordSignUp;
                    $valid++;
                }
            }

            if (!isset($_POST["terms"])) {
                $termErr = "You must agree to the Terms of Service";
            } else {
                $valid++;
            }
        }
        if ($valid == 4) {
            $query = "INSERT INTO users (name, username, password) VALUES ('$name', '$usernameSignUp', '$passwordSignUp')";
            mysqli_query($conn, $query) or die(mysqli_error($conn));

            header("Location:login.php");
        }
        
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    
    ?>

    
    <div class="form">

        <div class="shiii">
            <p>Already a member? <a href="login.php">Sign in</a></p>
        </div>


        <div class="container">

            <h2 id="signin-signup-title">Sign Up</h2>
            
            <div class="button-2">
                <button class="btn btn-primary" id="btn-sign-in" type="submit" style="width: 190px; border: none; border-radius: 5px; padding: 7px;"><strong>
                    <ion-icon name="logo-google">
                </strong></button>
                <button class="btn btn-primary" id="btn-create-account" type="submit" style="width: 190px; border: none; border-radius: 5px; padding: 7px;"><strong>
                    </ion-icon><ion-icon name="logo-apple"></ion-icon>
                </strong></button>
            </div>
            <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
            <br>
            <hr>
            <!-- <br> -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="div-sign-up">
                    <div class="two">
                        <div class="name">
                            <h6><strong>Name</strong></h6>
                            <div class="mb-3">
                                <input autocomplete="off" class="form-control mx w-auto" id="name" value="<?php echo $nameText ?>" name="name-sign-up" type="text" size="15" style="<?php echo ($error ? $nameBackground : $nameBackgroundDone); ?>">
                            </div>
                            <span class="error"><?php echo $nameErr;?></span>
                        </div>
                        <div class="user">
                            <h6><strong>Username</strong></h6>
                            <div class="mb-3">
                            <input autocomplete="off" class="form-control mx w-auto" id="username" value="<?php echo $usernameText ?>" name="username-sign-up" type="text" size="15" style="<?php echo ($error ? $usernameback : $usernamebackDone); ?>">
                            </div>
                            <span class="error"><?php echo $usernameSignUpErr;?></span>
                        </div>
                    </div>
                    <h6><strong>Password</strong></h6>
                    <div class="mb-3">
                        <input autocomplete="off" class="form-control mx w" id="password" value="<?php echo $passwordText ?>" name="password-sign-up" placeholder="6+ Characters" type="password" style="<?php echo ($error ? $passwordback : $passwordbackDone); ?>">
                    </div>
                    <span class="error"><?php echo $passwordSignUpErr;?></span>
                    <br>
                    <input name="terms" type="checkbox"> <span class="span">Creating an account means you’re okay with our Terms of Service, Privacy Policy, and our default Notification Settings.</span>
                    <br>
                    <span class="error"><?php echo $termErr;?></span>
                    <br>
                    <br>
                    <button class="btn btn-primary" name="btn-sign-up" type="submit" style="width: 190px; border: none; border-radius: 5px; padding: 7px; background-color: #FB5561;"><strong>Create Account</strong></button>
                    <br>
                    <br>
                </div>
            </form>
            
            <p class="copyright-responsive">&#169; Abed Al Salam Ashi</p>
        </div>
    </div>

</body>
</html>