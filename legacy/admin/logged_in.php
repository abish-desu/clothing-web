<?php 
 include('./templates/top.php');
 include ('./templates/navbar.php');

 session_start();

include('../pages/connect.php');


if(isset($_SESSION['admin_logged_in'])){
  header('location:index.php');
  exit;
}

if(isset($_POST['login_btn'])){
  $email = $_POST['email'];
  $password = md5($_POST['password']);

  $stmt=$conn->prepare("SELECT admin_id, admin_name, admin_email, admin_password FROM admin WHERE admin_email=? AND admin_password=? LIMIT 1");
  $stmt->bind_param('ss', $email, md5($password));
  $stmt->execute();
 if($stmt->execute()){
  $stmt->bind_result($admin_id, $admin_name, $admin_email,$admin_password);
  $stmt->store_result();

  if($stmt->num_rows()==1){
    $stmt->fetch();

    $_SESSION['admin_id']=$admin_id;
    $_SESSION['admin_name']=$admin_name;
    $_SESSION['admin_email']=$admin_email;
    $_SESSION['admin_logged_in']=true;

    header('location:index.php?login=successfully logged in');
  }
  else{
    header('location:login.php?error=login error');
  
  }

 }
 //if error occur
 else{
    header('location:login.php?error=login error');
 }
}

?>


<section class="my-3 py-3">
        <div class="container text-center mt-2 pt-3 ">
            <h1 style="color: antiquewhite; background-color: black;" class="form-weight-bold">Login</h1>
            <hr>
        </div>

        
        <div class="mx-auto container">
            <form id="login-form" enctype="multipart/form-data" action="login.php" method="post">
              <h5><?php if(isset($_GET['error'])) {echo $_GET['error'];}?></h5>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="login-email" name="email" placeholder="example@gmail.com" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="login-password" name="password" placeholder="password" required>
                </div>

                <div class="form-group">
                    <input type="submit" name="login_btn" class="btn" id="login-btn" value="Login">
                </div>

            </form>

        </div>   
            
    </section>




<!-- <?php include "./templates/footer.php"; ?>

<script type="text/javascript" src="./js/main.js"></script> -->
