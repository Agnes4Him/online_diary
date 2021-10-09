   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

   <script type="text/javascript">
         
        $(".toggleForms").click(function() {
            
            $("#signUpForm").toggle();
            $("#logInForm").toggle();
        }); 
        
        $("#diary").bind("input propertychange", function() {
            
            $.ajax({
                
                method: "POST",
                url: "updatedatabase.php",
                data: {content: $("#diary").val()}
                
            });
            
        });
         
     </script>
 
  </body>

</html>