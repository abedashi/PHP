<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" rel="stylesheet">
    <link href="CSS/profile.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="image/NBA_35964.ico">
    <title>Profile</title>
</head>
<body>
<?php
        include "project.php";
        session_start();
        include "session.php";
        if (!$_SESSION["id"]){
          header("Location:login.php");
        }

        $nameDone = $stateDone = $fileDone = $fileback = "";
        $nameErr = $stateErr = $fileErr ="";
        $nameTxt = $stateTxt = "";
        $nameProfile = $stateProfile = "";
        $valid = 0;
        $error = false;


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $target_dir = "image/";
            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            if (empty($_POST["name-profile"])) {
                $error = true;
                $nameErr = "background-color: #FFEEEE; !important;";
            } else {
                $nameProfile = test_input($_POST["name-profile"]);
                $nameDone = "background-color: white; !important;";
                $nameTxt = $nameProfile;
                $valid++;
            }

            if (empty($_POST["state-profile"])) {
                $error = true;
                $stateErr = "background-color: #FFEEEE; !important;";
            } else {
                $stateProfile = test_input($_POST["state-profile"]);
                $stateDone = "background-color: white; !important;";
                $stateTxt = $stateProfile;
                $valid++;
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                $error = true;
                $fileback = "background-color: #FFEEEE; !important;";
                $fileErr = "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["file"]["size"] > 500000) {
                $error = true;
                $fileErr = "Sorry, your file is too large.";
                $uploadOk = 0;
                $fileback = "background-color: #FFEEEE; !important;";
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                $error = true;
                $fileErr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $fileback = "background-color: #FFEEEE; !important;";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $error = true;
                $fileErr = "Sorry, your file was not uploaded.";
                $fileback = "background-color: #FFEEEE; !important;";

            // if everything is ok, try to upload file
            } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $valid++;
                $filedone = "background-color: #FFF; !important;";
                $fileErr = htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
            } else {
                $error = true;
                $fileErr = "Sorry, there was an error uploading your file.";
                $fileback = "background-color: #FFEEEE; !important;";
            }
            }
        }

        if ($valid == 3 && $uploadOk == 1) {
            $Query = "UPDATE users SET name='$nameProfile', state='$stateProfile', image='$target_file' WHERE id='$user_id'";
            if (mysqli_query($conn, $Query)) {
                echo "<script>alert('Profile successfully changed!')</script>";
              } else {
                die("Error updating record: " . mysqli_error($conn));
              }
        }

        $query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
        $row = mysqli_fetch_array($query);
        if (is_array($row)) {
            $name = $row["name"];
            $username = $row["username"];
            $state = $row["state"];
            $image = $row["image"];
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

    ?>
    <main>
        <div class="left">
            <a href="<?php echo $image;?>" target="blank">
                <img src="<?php echo $image;?>" width="100px" height="100px">
            </a>
            <span><strong><?php echo $name; ?></strong></span>
            <span><?php echo $username; ?></span>
            <span style="color: gray;"><?php echo $state; ?></span>
            <span style="margin-top: 35px;"> <?php echo $fileErr ?> </span>
        </div>
        <div class="right">
            <div class="top">
                <a href="home.php">
                    <ion-icon name="arrow-back-outline"></ion-icon>Back to home
                </a>
                <p>Edit Profile</p>
            </div>
            <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <div class="form">
                    <div class="mb-3">
                        <input type="text" autocomplete="off" name="name-profile" value="<?php echo $nameTxt; ?>" style="<?php echo ($error ? $nameErr : $nameDone); ?>" class="form-control" placeholder="Name">
                        </div>
                    <div class="mb-3">
                        <input type="text" autocomplete="off" name="state-profile" value="<?php echo $stateTxt; ?>" style="<?php echo ($error ? $stateErr : $stateDone); ?>" placeholder="State" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">file input</label>
                        <input class="form-control" type="file" name="file" id="formFile" style="<?php echo ($error ? $fileback : $fileDone) ?>"/>
                    </div>
                    <button type="submit" name="save" class="btn btn-primary">Save Profile</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>