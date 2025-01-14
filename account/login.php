<?php
require '../api/database.php';

// Initialize variables
$username = '';
$password = '';
$errorMessage = '';
 
// Check to see if the form has been submitted
if (isset($_POST['submit'])) {

    // Get the username and password from the form 
    $username = $_POST['username']; 
    $password = $_POST['password'];

    // Make sure the username and password are not empty 
    if (!empty($username) && !empty($password)) {

        // Get the user from the database 
        $sql = "SELECT * FROM $table WHERE $nicknameColumn='$username'"; 

        // Execute query and get result 
        $result = mysqli_query($conn, $sql);
       

        // Make sure there is a user with that username in the database 
        if (mysqli_num_rows($result) > 0) {

            // Get user data from database row 
            $userData = mysqli_fetch_assoc($result);

            if (password_verify($password, $userData[$passwordColumn])) {

                // Login successful! Redirect to homepage.  

                $_SESSION['logged_user'] = $username;

                header('Location: index.php');  

            } else {  

                // Login failed - incorrect password. Set error message.  
                $errorMessage = 'Неверное имя пользователя или пароль.';  

            }  

        } else {  

            // Login failed - no such user exists. Set error message.  
            $errorMessage = 'Неверное имя пользователя или пароль.';  

        }  

    } else {  

        // Login failed - empty fields. Set error message.  
        $errorMessage = 'Пустые поля.';  

    }    																	     
} else { 
    $errorMessage = 'Not post or submit';
}
echo '<div id="errors" style="color:red;">' .$errorMessage. '</div><hr>';

?>