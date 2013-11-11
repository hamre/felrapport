<?php
include("../sys/core/init.inc.php");
$log = new user;
$log->logged_in_redirect();
include("inc/overall/header_overall.php");

if(empty($_POST) === false) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  
  if(empty($username) || empty($password)) {
    $errors[] = "All fields must be entered";
  } else {          
          $login = $log->login($username, $password);
          
          if($login === false) {
            $errors[] = "Username or password is incorrect";            
          } else {              
              $_SESSION['user_id'] = $login['user_id'];
              header("Location: index.php");
              exit();
            }
        }
}
if(!empty($errors)) {
print('<h2>There are one or more errors while logging in: </h2><br />'.$log->output_errors($errors));
}
include("inc/overall/footer_overall.php");
?>