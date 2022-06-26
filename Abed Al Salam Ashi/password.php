<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" rel="stylesheet">
    <link href="CSS/password.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="image/NBA_35964.ico">
    <title>Change Password</title>
</head>
<body>
        <?php
            include "project.php";
            session_start();
            include "session.php";

            if (!$_SESSION["id"]){
                header("Location:login.php");
            }

            $currErr = $currback = $currbackDone = $currText = $currChecked = "";
            $newChar = $newErr = $newbackdone = $newback = $newText = $newErrChecked = $newCharChecked = "";
            $confirmationErr = $confirmationback = $confirmationbackDone = $confirmationText = $confirmationChecked = "";
            $error = false;
            $errorMark = false;
            $errorMarkConf = false;
            $errorCurr = false;
            $valid = 0;

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST["current"])) {
                    $error = true;
                    $errorCurr = true;
                    $currErr = "close-outline";
                    $currback = "background-color: #FFEEEE; !important";
                } else {
                    $current = test_input($_POST["current"]);
                    $passQuery = mysqli_query($conn, "SELECT password FROM users WHERE id='$user_id'") or die(mysqli_error($conn));
                    $row = mysqli_fetch_array($passQuery);
                    if ($row["password"] != $current) {
                        $error = true;
                        $errorCurr = true;
                        $currErr = "close-outline";
                        $currback = "background-color: #FFEEEE; !important";
                    } else {
                        $currbackDone = "background-color: #f2f2f2ed; !important";
                        $currChecked = "checkmark-done-outline";
                        $currText = $current;
                        $valid++;
                    }
                }

                if (empty($_POST["new"])) {
                    $error = true;
                    $errorMark = true;
                    $newErr = "close-outline";
                    $newChar = "close-outline";
                    $newback = "background-color: #FFEEEE; !important";
                } else {
                    $newpassword = test_input($_POST["new"]);
                    if (strlen($newpassword) < 7) {
                        $error = true;
                        $errorMark = true;
                        $newErr = "close-outline";
                        $newChar = "close-outline";
                        $newback = "background-color: #FFEEEE; !important";
                    } else {
                        $newbackdone = "background-color: #f2f2f2ed; !important";
                        $newText = $newpassword;
                        $newCharChecked = "checkmark-done-outline";
                        $newErrChecked = "checkmark-done-outline";
                        $valid++;
                    }
                }

                if (empty($_POST["confirmation"])) {
                    $error = true;
                    $errorMarkConf = true;
                    $confirmationErr = "close-outline";
                    $confirmationback = "background-color: #FFEEEE; !important";
                } else {
                    $confirmation = test_input($_POST["confirmation"]);
                    if ($confirmation != $newpassword) {
                        $error = true;
                        $errorMarkConf = true;
                        $confirmationback = "background-color: #FFEEEE; !important";
                        $confirmationErr = "close-outline";
                    } else {
                        $confirmationbackDone = "background-color: #f2f2f2ed; !important";
                        $confirmationText = $confirmation;
                        $confirmationChecked = "checkmark-done-outline";
                        $valid++;
                    }
                }
            }

            if ($valid == 3) {
                $passUpdate = "UPDATE users SET password='$newpassword' WHERE id='$user_id'";
                if (mysqli_query($conn, $passUpdate)) {
                    echo "<script>alert('Password successfully changed!')</script>";
                } else {
                    die("Error updating record: " . mysqli_error($conn));
                }
            }

            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
        ?>
    <div class="main">
                <div class="correct">
                    <a href="home.php" style="margin-bottom: 50px; display: flex; align-items: center;"><ion-icon name="arrow-back-outline"></ion-icon>Back to home</a>
                    <div class="head">
                        <h3>Change Password</h3>
                    </div>
                    <div class="contain">
                        <span>Password must contain:</span>
                    </div>
                    <div class="validation">
                        <span class="span"><ion-icon style="<?php echo ($errorMark ? "color: red;" : "color: green;") ?>" name="<?php echo ($errorMark ? $newChar : $newCharChecked)?>"></ion-icon>At least 7 charachters</span>
                        <span class="span"><ion-icon style="<?php echo ($errorCurr ? "color: red;" : "color: green;") ?>" name="<?php echo ($errorCurr ? $currErr : $currChecked)?>"></ion-icon>Current password</span>
                        <span class="span"><ion-icon style="<?php echo ($errorMark ? "color: red;" : "color: green;") ?>" name="<?php echo ($errorMark ? $newErr : $newErrChecked)?>"></ion-icon>New password</span>
                        <span class="span"><ion-icon style="<?php echo ($errorMarkConf ? "color: red;" : "color: green;") ?>" name="<?php echo ($errorMarkConf ? $confirmationErr : $confirmationChecked)?>"></ion-icon>Confirmation equal to new password</span>
                    </div>
                </div>
                <div class="inputs">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="mb-3">
                        <input type="password" autocomplete="off" value="<?php echo $currText ?>" name="current" placeholder="Current Password" class="form-control" style="<?php echo ($error ? $currback : $currbackDone); ?>">
                    </div>
                    <div class="mb-3">
                        <input type="password" autocomplete="off" value="<?php echo $newText ?>" name="new" placeholder="New Password" class="form-control" style="<?php echo ($error ? $newback : $newbackdone); ?>">
                    </div>
                    <div class="mb-3">
                        <input type="password" autocomplete="off" value="<?php echo $confirmationText ?>" name="confirmation" placeholder="Comfirmation Password" class="form-control" style="<?php echo ($error ? $confirmationback : $confirmationbackDone); ?>">
                    </div>
                    <button type="submit" name="save" class="btn btn-primary">Change Password</button>
                    </form>
                </div>
        </div>
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>