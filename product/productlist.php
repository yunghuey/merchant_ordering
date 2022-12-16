<?php 
    /*
        purpose: frontend to display the product list and button to delete product
    */
    session_start();
    require_once "../database/connect_db.php";
    require_once "./update_product.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product List</title>
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
    <link rel="stylesheet" href="../staff/leftmenu.css">
    <link rel="stylesheet" href="../staff/template_style.css">

  </head>
  <body>
    <!-- navigation -->
    <?php include("../staff/leftmenu.php"); ?>

    <?php if(isset($_SESSION['product'])) :?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-left: 100px; width: 500px; ">
      <?php
        echo $_SESSION['product']."<br>";
        unset($_SESSION['product']);
      ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="content">
        <header><h2>view all product</h2></header>
        <section class="container-fluid">
            <table class="table table-hover" id="table-list" style="width:100%">
                <thead>
                    <th>No.</th>
                    <th style="display:none;">Id</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Detail</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </thead>
                <?php  
                    unset($rssp);
                    $ssp = "SELECT productID, productName, productCurrentQty FROM product";
                    if($rssp = mysqli_query($conn,$ssp)):
                        $count =1;
                        while($row = mysqli_fetch_assoc($rssp)):
                ?>
                <tr> 
                    <td><?php echo $count++; ?></td>
                    <td style="display:none;"><?php echo $row['productID']; ?></td>
                    <td><?php echo $row['productName']; ?></td>
                    <td><?php echo $row['productCurrentQty']; ?></td>
                    <td><a href="./productdetails.php?id=<?php echo $row['productID'] ?>" class="btn btn-outline-dark"><i class="far fa-eye"></i></a></td>
                    <td><a href="./editproduct.php?id=<?php echo $row['productID'] ?>" class="btn btn-outline-dark"><i class="fas fa-edit"></i></a></td>
                    <td><a class="btn btn-outline-dark deletebtn" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fas fa-trash-alt"></i></a></td>
                </tr>
                    <?php endwhile;?>
                <?php endif;?>
            </table>
        </section>
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
                        <button type="submit" class="btn btn-primary" name="deleteproduct">Yes</button>
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
            var productname = currentRow.find("td:eq(2)").text();
            var productid = currentRow.find("td:eq(1)").text();
            var str = "Are you sure to delete "+productname+" ?";
            $("#delete-modal-body").html(str);
            console.log(productid);
            $('#delete_id').val(productid);
        });
        $("#table-list").DataTable();
    });
</script>