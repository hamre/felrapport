<aside>
  <?php     
  $check = new user();
    if($check->logged_in() === true){
      include("inc/widgets/loggedin.php");
    } else {
        include("inc/widgets/login.php");
    }
    include("inc/widgets/user_count.php");
  ?>
</aside>