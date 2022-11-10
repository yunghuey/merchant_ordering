<?php include './database/connect_db.php' ?>
<!doctype html>
<html lang="en">
<head>
  <!-- required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- bootstrap css -->
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

  <style>
    body{
      background-color: #EDF5E1;
    }
  </style>
</head>
<body>
  <div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-12 col-sm-8 col-md-6 m-auto">
          <div class="card border-0 shadow">
            <div class="text-center card-header">
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
              </svg>
              <h2>Login</h2>
            </div>
            <div class="card-body">
              <form action="staff/index.php" method="post">                    
                <input type="text" class="form-control my-3 py-2" placeholder="Username" name="username" id="" required>                 
                <input type="password" class="form-control my-3 py-2" placeholder="Password" name="password" id="" required>
                <button name="login" value="login" class="btn btn-primary" type="submit">Login</button>
                  <a href="#" class="nav-link">Forgot password?</a>
              </form>
            </div>
          </div>
        </div>
    </div>
  </div>
   
    
  <!-- bootstrap bundle with popper-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

  </body>
</html>

<!-- example of taking data from database SHOW  -->
<?php    
/*
  $sql = "SELECT * FROM customer WHERE customerID = 1";
  $result = mysqli_query($conn,$sql);
  if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result))
    {
      echo $row["email"];
    }
} 
*/                     
?>