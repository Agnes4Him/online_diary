<?php

$link = mysqli_connect("localhost:8889", "root", "root", "secret_diary");
    
       if (mysqli_connect_error()) {
          
          die("Connection could not be established");
          
       }

?>