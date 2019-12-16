<?php  
include("includes/includedFiles.php");

session_start();

$errors = [];

if( isset($_SESSION["user_id"]) && ($_SESSION["user_id"] == $_POST["user_id"] || $_SESSION["role"] == 1) ) {
    
    $user_id=$_POST["user_id"];


} else if( isset($_POST["action"]) && $_POST["action"] == "delete" ) {

    $delete_query = "DELETE FROM users WHERE id = $user_id";
    $select_query = "SELECT * FROM users WHERE id = $user_id";

    if($user_result = mysqli_query($conn, $select_query)) {
        while($user_row = mysqli_fetch_array($user_result)){
            if($user_row["role"] !=1) {
                if(mysqli_query($conn, $delete_query)){
                    if($user_row["id"] == $_SESSION["user_id"]) {
                        session_destroy();
                        header("Location: http://" .$_SERVER["SERVER_NAME"]);
                    } else {
                        header("Location: http://" . $_SERVER["SERVER_NAME"] . "/homepage.php");
                    }
                    
                } else {
                    $errors[] = mysqli_error($conn);
                }

            } else {
                $errors[] = "cannot delete super admin!!!";
            }
        }
    } else {
        $errors[] = "User does not exist." .mysqli_error($con);
    }
}








?>