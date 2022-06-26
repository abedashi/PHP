<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="CSS/players.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="image/NBA_35964.ico">
    <title>Players</title>
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
              <svg class="bi me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
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
          <li class="nav-item">
            <a href="players.php" class="nav-link active" style="background-color: #FB5561;" aria-current="page">
              <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
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
            <img src="<?php echo $image; ?>" alt="" width="32" height="32" class="rounded-circle me-2">
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
        <div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
                <div class="input-search">
                    <input class="input" autocomplete="off" autofocus placeholder="Search NBA Player Name" name="search" type="text" size="68">
                    <button type="submit" class="button-search">
                        <ion-icon name="search-outline"></ion-icon>
                    </button>
                </div>
            </form>
            <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        </div>

        <?php

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
       
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
          $playerName = test_input($_GET["search"]);

          $curl = curl_init();
          $playerName = str_replace(" ", "+", $playerName);//or %20
          curl_setopt_array($curl, [
            CURLOPT_URL => "https://free-nba.p.rapidapi.com/players?page=0&per_page=1&search=$playerName",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
              "X-RapidAPI-Host: free-nba.p.rapidapi.com",
              "X-RapidAPI-Key: e103566983mshc38d5759511e755p19cbe7jsn25aa72f7ea8e"
            ],
          ]);

          $response = curl_exec($curl);
          $err = curl_error($curl);

          curl_close($curl);
          
          //
          $curll = curl_init();

          curl_setopt_array($curll, [
            CURLOPT_URL => "https://google-image-search1.p.rapidapi.com/?keyword=$playerName&max=30",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
              "X-RapidAPI-Host: google-image-search1.p.rapidapi.com",
		          "X-RapidAPI-Key: e103566983mshc38d5759511e755p19cbe7jsn25aa72f7ea8e"
            ],
          ]);

          $responsee = curl_exec($curll);
          $errr = curl_error($curll);

          curl_close($curll);

          if ($errr) {
            echo "cURL Error #:" . $errr;
          }
              $responsee = json_decode($responsee, true);
              
          //

    
          if ($err) {
            echo "cURL Error #:" . $err;
          } else {
            $response = json_decode($response, true);
            // try {
              if (empty($playerName)){
            echo '
                <div class="box">
                  <div class="head">
                      <h2>Player Name</h2>
                  </div>
      
                  <div class="card">
                      <img src="image/unknown.webp" alt="Avatar" style="width:100%; height: 350px;">
                      <div class="container">
                          <h4><b>Position</b></h4> 
                          <p>Team</p> 
                          <p>Conference</p>
                      </div>
                  </div>
              </div>
              ';
              // }
            } else {
              echo '
                <div class="box">
                  <div class="head">
                      <h2>'.$response["data"][0]["first_name"].' '.$response["data"][0]["last_name"].'</h2>
                  </div>
      
                  <div class="card">
                      <img src="'.$responsee[0]["image"]["url"].'" alt="player image" style="width:100%; height: 350px;">
                      <div class="container">
                          <h4><b>'.$response["data"][0]["position"].'</b></h4> 
                          <p>'.$response["data"][0]["team"]["full_name"].'</p> 
                          <p>'.$response["data"][0]["team"]["conference"].' Conference</p>
                      </div>
                  </div>
              </div>
              ';
            }
          }
        }
        ?>
    </main>
</body>
</html>