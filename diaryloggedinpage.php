<?php

 session_start();
 
 $diaryContent ="";
 
 if(array_key_exists("id", $_COOKIE)) {
     
     $_SESSION['id'] = $_COOKIE['id'];
 }
 
 if(array_key_exists("id", $_SESSION) && $_SESSION['id']) {
     
     include("connection.php");
     
     $query= "SELECT diary FROM users WHERE id ='".mysqli_real_escape_string($link, $_SESSION['id'])."' LIMIT 1";
     
     $result = mysqli_query($link, $query);
     
     $row = mysqli_fetch_assoc($result);
     
     $diaryContent = $row['diary'];
     
 } else {
     
     header("Location: index.php");
 }
 
 include("header.php");

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-fixed-top">
<div class="container-fluid"><a class="navbar-brand" href="#">Secret Diary</a>
<div class="pull-xs-right"><a href="index.php?logout=1"><button class="btn btn-outline-success">Log Out</button></a></div>
</div>
</nav>
<div class="diary"><textarea class="form-control"><?php echo $diaryContent; ?></textarea></div>
<?php

 include("footer.php");

?>