<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="image/NBA_35964.ico">
    <link href="CSS/games.css" rel="stylesheet">
    <title>Games</title>
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
              <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
              News
            </a>
          </li>
          <li class="nav-item">
            <a href="games.php" class="nav-link active" style="background-color: #FB5561;" aria-current="page">
              <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
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
          <li>
            <a href="comment.php" class="nav-link link-dark">
              <svg class="bi me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
              Comment
            </a>
          </li>
        </ul>
        <hr>
        <div class="dropdown">
          <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?php echo $image;?>" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong> <?php echo $name; ?> </strong>
          </a>
          <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
            <li><a class="dropdown-item" href="#">New project...</a></li>
            <li><a class="dropdown-item" href="#">Change Password</a></li>
            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
          </ul>
        </div>
      </div>

     

      <main>
          
        <header>
            <h4>Today's Game</h4>
        </header>

        <?php
          include "APIGAMES.php";
            echo '
            <div class="game">
              <div class="time">
              <p>NBA - '.$response[0]["startTime"].'</p>
              </div>

              <div class="teams">
                  <div>
                      <h4><p>'.$response[0]["homeTeam"].' - '.strtoupper($response[0]["homeTeamScore"]).'</p></h4>
                  </div>
                  <div>
                      VS
                  </div>
                  <div>
                      <h4><p>'.$response[0]["awayTeam"].' - '.strtoupper($response[0]["awayTeamScore"]).'</p></h4>
                  </div>
              </div>

              <div class="playoffs">
                  <p>NBA Playoffs<br></p>
              </div>

              <div class="final">
                  <p>Lineup Starters:</p>
                  <p>'.$response[0]["homeTeam"].' : '.$response[0]["homeStarters"][0].' - '.$response[0]["homeStarters"][1].' - '.$response[0]["homeStarters"][2].' - '.$response[0]["homeStarters"][3].' - '.$response[0]["homeStarters"][4].'</p>
                  <p>'.$response[0]["awayTeam"].' : '.$response[0]["awayStarters"][0].' - '.$response[0]["awayStarters"][1].' - '.$response[0]["awayStarters"][2].' - '.$response[0]["awayStarters"][3].' - '.$response[0]["awayStarters"][4].'</p>
              </div>
            </div>
            ';
          ?>
        
      </main>

</body>
</html>