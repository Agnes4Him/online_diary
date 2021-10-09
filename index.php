<?php

 session_start();
 
 if (array_key_exists("logout", $_GET)) {
     
     unset($_SESSION);
     setcookie("id", "", time()-60*60);
     $_COOKIE['id'] = "";
 
     
 } else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
     
     header("Location:diaryloggedinpage.php");
 }
 
  $error=""; 
 
 if (array_key_exists("submit", $_POST)) {
     
     include("connection.php");
     
     if (!$_POST['email']) {
         
         $error .= "Email address is required<br>";
     }
     
     if (!$_POST['password']) {
         
         $error .= "Password is required<br>";
     }
     
     if ($error != "") {
         
         $error = '<div class="alert alert-danger" role="alert">The following fields are required:<br>' .$error. '</div>';
                                                       
     } else {
         
         if ($_POST['signUp'] == "1") {
         
         $query = "SELECT id FROM users WHERE email='".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
         
         $result = mysqli_query($link, $query);
         
         if (mysqli_num_rows($result) > 0) {
             
             $error = '<div class="alert alert-danger" role="alert">That email address has been taken</div>';
         } else {
             
             $query = "INSERT INTO users (email, password) VALUES('".mysqli_real_escape_string($link, $_POST['email'])."','".mysqli_real_escape_string($link, $_POST['password'])."')";
             
             if(!mysqli_query($link, $query)) {
                 
                 $error = '<div class="alert alert-danger" role="alert">Sign up was unsuccessful, please try again.</div>';

             } else {

                 $_SESSION["id"] = mysqli_insert_id($link); 
                 
                 $query = "UPDATE users SET password ='".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id ='".mysqli_insert_id($link)."' LIMIT 1";
                 
                 mysqli_query($link, $query);
                 
                   if ($_POST['stayLoggedIn'] == "1") {
                       
                       setcookie("id", mysqli_insert_id($link), time() + 60*60*24*365);
                   }
                 
                 header("Location:diaryloggedinpage.php");
             }
         }
         
       } else {
           
           $query = "SELECT * FROM user WHERE email ='".mysqli_real_escape_string($link, $_POST['email'])."'";
           
           $result = mysqli_query($link, $query);
           
           $row = mysqli_fetch_assoc($result);
           
           if(isset($row)) {
           
             $hashedPassword = md5(md5($row['id']).$_POST['password']);
             
             if ($hashedPassword == $row['password']) {
                 
                 $_SESSION['id'] = $row['id'];
                 
                 if ($_POST['stayLoggedIn'] == '1') {
                       
                       setcookie("id", $row['id'], time() + 60*60*24*365);
                   }
                 
                 header("Location:diaryloggedinpage.php");
             } else {
                 
                 $error = '<div class="alert alert-danger" role="alert">That Email and Password combination can not be found</div>';
             }
           
           } else {
               
               $error = '<div class="alert alert-danger" role="alert">That Email and Password combination could not be found</div>';
           }
       }
     }

  }
 
?>


<?php include("header.php"); ?>
    
    <div class="container" id="homePageContainer">
        
       <h1>Secret Diary</h1>
       
       <p><strong>Store Your Deepest Thoughts Securedly</strong></p>
        
       <div id="error"><?php echo $error ?></div>
    
       <form method="POST" id="signUpForm">
           
        <p>Interested? Sign Up now!</p>
           
        <fieldset class="form-group">

         <input class="form-control email" type="email" name="email" placeholder="Your Email">
        
        </fieldset>
        
        <fieldset class="form-group">
            
         <input class="form-control password" type="password" name="password" placeholder="Password">
         
        </fieldset>
        
        <div class="checkbox">
            
         <label>
         
          <input type="checkbox" name="stayLoggedIn" value="1"> Stay LoggedIn
         
         </label>
         
        </div>
        
        <fieldset class="form-group">
         
         <input type="hidden" name="signUp" value="1">

         <button type="submit" name="submit" class="btn btn-success button">Sign up!</button>
         
        </fieldset>
        
        <p><a class="toggleForms">Log In</a></p>
    
       </form>
    
       <form method="POST" id="logInForm">
           
        <p>Log In with your email and password</p>
           
        <fieldset class="form-group">

         <input class="form-control email" type="email" name="email" placeholder="Your Email">
         
        </fieldset>
        
        
        <fieldset class="form-group">
         
         <input class="form-control password" type="password" name="password" placeholder="Password">
         
        </fieldset>
        
        
        <div class="checkbox">
            
         <label>
         
          <input type="checkbox" name="stayLoggedIn" value="1">Stay LoggedIn
         
         </label>
         
        </div>
         
         <input type="hidden" name="signUp" value="0">

         <button type="submit" name="submit" class="btn btn-success button">Log in!</button>
         
        <p><a class="toggleForms">Sign Up</a></p>
    
      </form>

    </div>
    
<?php include("footer.php"); ?>