
<?php include "includes/header.php";

   
if (isset($_SESSION['username'])){
    
    header ("Location: index.php");  

}

else{?>
    
   
    <h1 class="text-center" style="margin-top: 130px;"> LOG IN </h1>

    <form action="ldap_connect.php" method="post">
     
    <div class="card" style="width: 25rem; margin:auto; margin-top: 30px";>
      <div class="card-body">
        <h5 class="card-title">Username</h5>
        <input name="username" type="text" class="form-control" autocomplete="off">
        <h5 class="card-title">Password</h5>
        <input name="password" type="password" class="form-control">
        <p class="card-text"></p>
        <?php
            if (isset($_SESSION['retry']) == 1){
                ?>
               <h5 class="card-title"><font color='red'>Username and Password is Incorrect, Please Try Again</font></h5> 
                <?php $_SESSION['retry'] = null;
            }?>
        <input class="btn btn-primary" type="submit" name="submit" value="LOG IN">
      </div>
    </div>         
    </form>



    <?php include "includes/footer.php"?>
    <?php
    
    }
  
?>
    
    



