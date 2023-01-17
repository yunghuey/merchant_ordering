<?php 
    /*
        purpose: frontend php page to display staff list and show the four buttons: view details, edit, archive, delete
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
    <title>Staff List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  
    <!-- font awesome v5 -->
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
    
    <!-- Import jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity= "sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <!-- for Datatable -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
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

    <?php if(isset($_SESSION['message'])) :?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-left: 100px; width: 500px; ">
      <?php
        echo $_SESSION['message']."<br>";
        unset($_SESSION['message']);
      ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="content">
        <header><h2>view all staff</h2></header>
        <section class="container-fluid">
            <table class="table table-hover" id="table-list" style="width:100%" summary="">
                <thead>
                    <th>No.</th>
                    <th style="display:none;">Id</th>
                    <th>Username</th>
                    <th>Detail</th>
                    <th>Edit</th>
                    <th>Archive</th>
                    <th>Delete</th>
                </thead>
                <script>
                    console.log(<?= json_encode($_SESSION['username']); ?>);
                </script>
                <?php  
                    unset($rsss);
                    $sss = "SELECT username, id FROM staff WHERE archive = 0";
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
                    <td><a href="./staffdetails.php?id=<?php echo $row['id'] ?>" class="btn btn-outline-dark"><i class="far fa-eye"></i></a></td>
                    <td><a href="./editstaff.php?id=<?php echo $row['id'] ?>" class="btn btn-outline-dark"><i class="fas fa-edit"></i></a></td>
                    <td><a class="btn btn-outline-dark archivebtn" data-bs-toggle="modal" data-bs-target="#archiveModal"><i class="far fa-file-archive"></i></a></td>
                    <td><a class="btn btn-outline-dark deletebtn" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fas fa-trash-alt"></i></a></td>
                </tr>
                    <?php endwhile;?>
                <?php endif;?>
            </table>
        </section>
    </div>
    <!-- Archive Modal -->
    <div class="modal fade" id="archiveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Archive User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="archive-modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="" method="post">
                        <input type="hidden" name="archive_id" id="archive_id">
                        <button type="submit" class="btn btn-primary" name="archivestaff">Yes, archive</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete user</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="delete-modal-body">
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <form action="" method="post">
                        <input type="hidden" name="delete_id" id="delete_id">
                        <button type="submit" class="btn btn-primary" name="deletestaff">Yes</button>
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
        $("#table-list").on('click','.deletebtn', function(){
            var currentRow = $(this).closest("tr");
            var username = currentRow.find("td:eq(2)").text();
            var id = currentRow.find("td:eq(1)").text();
            var str = "Are you sure to delete "+username+" ?";
            $("#delete-modal-body").html(str);
            console.log("Username is "+ username);
            $('#delete_id').val(id);
        });

        $("#table-list").on('click','.archivebtn', function(){
            var currentRow = $(this).closest("tr");
            var username = currentRow.find("td:eq(2)").text();
            var str = "Are you sure to archive "+username+" ?";
            $("#archive-modal-body").html(str);
            $('#archive_id').val(username);
        });
        $("#table-list").DataTable({
        });
    });
</script>