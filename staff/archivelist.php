<?php
    /*
        purpose: frontend php to view the archive list 
        with function to unarchive it. 
    */
    session_start();
    if($_SESSION['role'] != "Management" && $_SESSION['role'] != "Admin"){
        header("location:index.php");
        exit;
    }
    require_once "../database/connect_db.php";
    require_once "./alter_staff.php";  
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Archive List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  
    <!-- font awesome v5 -->
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
    
    <!-- Import jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity= "sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <!-- for Datatable -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <!-- customize css -->
    <link rel="stylesheet" href="leftmenu.css">
    <link rel="stylesheet" href="template_style.css">  
  </head>
  <body>
        <!-- navigation -->
        <?php include_once("leftmenu.php"); ?>

        <div class="content">
        <header><h2>view archive staff</h2></header>
        <section class="container-fluid">
            <table class="table table-hover" id="table-list" style="width:100%" summary="">
                <thead>
                    <th>No.</th>
                    <th style="display:none;">Id</th>
                    <th>Username</th>
                    <th>Unarchive</th>
                </thead>
                <script>
                    console.log(<?= json_encode($_SESSION['username']); ?>);
                </script>
                <?php  
                    unset($rsss);
                    $sss = "SELECT username, id FROM staff WHERE username NOT IN ('".$_SESSION['username']."') AND archive = 1";
                    $rsss = mysqli_query($conn,$sss);
                    $rwss = mysqli_num_rows($rsss);
                    $count = 1;                 
                    if ($rwss > 0):
                        while($row = mysqli_fetch_assoc($rsss)):
                ?>
                <tr> 
                    <td><?php echo $count++; ?></td>
                    <td style="display:none;"><?php echo $row['id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><a class="btn btn-outline-dark unarchivebtn" data-bs-toggle="modal" data-bs-target="#unarchiveModal"><i class="fas fa-archive"></i></a></td>
                </tr>
                    <?php endwhile;?>
                <?php endif;?>
                
            </table>
        </section>
    </div>
     <!-- unarchive Modal -->
     <div class="modal fade" id="unarchiveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Unarchive staff</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="unarchive-modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="" method="post">
                        <input type="hidden" name="unarchive_id" id="unarchive_id">
                        <button type="submit" class="btn btn-primary" name="unarchivestaff">Yes, unarchive</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>

<script type="text/javascript">
    $(document).ready(function(){
        $("#table-list").DataTable();
        $("#table-list").on('click','.unarchivebtn', function(){
                    var currentRow = $(this).closest("tr");
                    var username = currentRow.find("td:eq(2)").text();
                    console.log("Username is "+ username);
                    var str = "Are you sure to unarchive "+username+" ?";
                    $("#unarchive-modal-body").html(str);
                    $('#unarchive_id').val(username);
                });
    });
</script>
