<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="CSS/comment.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="image/NBA_35964.ico">
    <title>Comment</title>
</head>
<body>
      <?php
        include "project.php";
        session_start();
        include "session.php";
        if (!$_SESSION["id"]) {
          header("Location:login.php");
        }
        $query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'") or die(mysqli_error($conn));
        $row = mysqli_fetch_array($query);

        if (is_array($row)) {
            $name = $row["name"];
            $image = $row["image"];
        }
      ?>


    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" id="sidebar" style="width: 200px; height: 100vh; position: fixed;">
        <a class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
          <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
          <span class="fs-4">NBA Live</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
        <li>
            <a href="home.php" class="nav-link link-dark">
              <svg class="bi me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
              News
            </a>
          </li>
          <li>
            <a href="games.php" class="nav-link link-dark">
              <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
              Today Game's
            </a>
          </li>
          <li>
            <a href="standings.php" class="nav-link link-dark">
              <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
              Teams
            </a>
          </li>
          <li>
            <a href="players.php" class="nav-link link-dark">
              <svg class="bi me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
              Players
            </a>
          </li>
          <li class="nav-item">
            <a href="Comment.php" class="nav-link active" style="background-color: #FB5561;" aria-current="page">
              <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
              Comment
            </a>
          </li>
        </ul>
        <hr>
        <div class="dropdown">
          <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?php echo $image; ?>" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong> <?php echo $name; ?> </strong>
          </a>
          <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
            <!-- <li><a class="dropdown-item" href="#">New project...</a></li> -->
            <li><a class="dropdown-item" href="#">Change Password</a></li>
            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
          </ul>
        </div>
      </div>

      <?php

        $backgroud = $backgrouddone = "";
        $valid = 0;
        $error = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          if (empty($_POST["text"])){
            $error = true;
            $backgroud = "background-color: #FFEEEE; !important";
          } else {
            $textarea = test_input($_POST["text"]);
            $backgrouddone = "background-color: #FFF; !important";
            $valid++;
          }
        }
        
        if ($valid == 1) {
          $commentQuery = mysqli_query($conn, "INSERT INTO comment (user_id, post) VALUES ('$user_id', '$textarea')") or die(mysqli_erorr($conn));
        }

        function test_input($data) {
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
          return $data;
        }
      ?>

      <main>
          <header>
            NBA Live Comments
          </header>
            
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
            <div class="form">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1"><strong>Post an Comment</strong></label>
                    <textarea class="form-control" name="text" placeholder="Comment" id="exampleFormControlTextarea1" rows="3" style="<?php echo ($error ? $backgroud : $backgrouddone) ?>"></textarea>
                </div>
                <button class="btn btn-primary" name="btn-sign-in" type="submit" style="width: 190px; margin-top: 10px; border: none; border-radius: 5px; padding: 7px;"><strong>Comment</strong></button>
                <hr>
            </div>
        </form> 
        <?php
        $post = mysqli_query($conn, "SELECT users.username, comment.time, comment.post FROM users JOIN comment ON users.id=comment.user_id ORDER BY comment.id DESC") or die(mysqli_error($conn));
        while ($shi = mysqli_fetch_array($post)) {
          ?>
    
          <div class="form-comments">
            <div class="comment">
                <div class="user-time">
                  <h5><?php echo $shi['username'] ?></h5>
                  <span><?php echo $shi['time'] ?> </span>
              </div>
              <p><?php echo $shi['post'] ?> </p>
            </div>
          </div>

            <?php } ?>
      </main>
</body>
</html>