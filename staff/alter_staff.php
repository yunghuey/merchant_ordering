<?php 
    /*
        purpose: backend php for stafflist.php and archivelist.php
    */
    if ($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['deletestaff'])){
            $id = $_POST['delete_id'];
            $delete_sql = "DELETE FROM staff WHERE username = '".$id."'"; 
            echo "<script> console.log('".$delete_sql."')</script>"; 
            if (mysqli_query($conn,$delete_sql)){
                $_SESSION['message'] = $id." is deleted";
                header("location:stafflist.php");
            } else{
                echo "<script> alert('Error occur'); </script>";
            }
        }

        if(isset($_POST['archivestaff'])){
            $id = $_POST['archive_id'];
            $archive_sql = "UPDATE staff SET archive = 1 WHERE username = '".$id."'"; 
            echo "<script> console.log('".$archive_sql."')</script>"; 
            if (mysqli_query($conn,$archive_sql)){
                header("location:archivelist.php");
            } else{
                echo "<script> alert('Error occur'); </script>";
            }
        }

        if(isset($_POST['unarchivestaff'])){
            $id = $_POST['unarchive_id'];
            $archive_sql = "UPDATE staff SET archive = 0 WHERE username = '".$id."'"; 
            echo "<script> console.log('".$archive_sql."')</script>"; 
            if (mysqli_query($conn,$archive_sql)){
                header("location:./archivelist.php");
            } else{
                echo "<script> alert('Error occur'); </script>";
            }
        }
    }  
?>