<?php 
    /*
        purpose: backend php for stafflist.php and archivelist.php
        function: can delete, archive, and unarchive staff
    */
    if ($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['deletestaff'])){
            $id = $_POST['delete_id'];
            if ($id != $_SESSION['id']){
                $replace_sql = "UPDATE `order` o INNER JOIN `staff` s ON s.id=o.preparedByStaff "
                              ."SET o.preparedByStaff=".$_SESSION['id']
                              ." WHERE o.preparedByStaff=".$id;
                mysqli_query($conn,$replace_sql);
                $delete_sql = "DELETE FROM staff WHERE id = '".$id."'"; 
                if (mysqli_query($conn,$delete_sql)){
                    $_SESSION['message'] = $id." is deleted";
                    header("location:stafflist.php");
                } else{
                    echo "<script> alert('Error occur'); </script>";
                }
            }else{
                echo "<script> alert('You cannot delete your own account') </script>";
            }
        }

        if(isset($_POST['archivestaff'])){
            $id = $_POST['archive_id'];
            $archive_sql = "UPDATE staff SET archive = 1 WHERE username = '".$id."'"; 
            if (mysqli_query($conn,$archive_sql)){
                header("location:archivelist.php");
            } else{
                echo "<script> alert('Error occur'); </script>";
            }
        }

        if(isset($_POST['unarchivestaff'])){
            $id = $_POST['unarchive_id'];
            $archive_sql = "UPDATE staff SET archive = 0 WHERE username = '".$id."'"; 
            if (mysqli_query($conn,$archive_sql)){
                header("location:./archivelist.php");
            } else{
                echo "<script> alert('Error occur'); </script>";
            }
        }
    }  
?>