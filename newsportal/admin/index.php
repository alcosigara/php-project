<?php
 session_start();
//Database Configuration File
include('includes/config.php');
//error_reporting(0);
if(isset($_POST['login']))
  {
 
    // Getting username/ email and password
     $uname=$_POST['username'];
    $password=md5($_POST['password']);
    // Fetch data from database on the basis of username/email and password
$sql =mysqli_query($con,"SELECT AdminUserName,AdminEmailId,AdminPassword,userType FROM tbladmin WHERE (AdminUserName='$uname' && AdminPassword='$password')");
 $num=mysqli_fetch_array($sql);
if($num>0)
{

$_SESSION['login']=$_POST['username'];
$_SESSION['utype']=$num['userType'];
    echo "<script type='text/javascript'> document.location = 'manage-posts.php'; </script>";
  }else{
echo "<script>alert('Invalid Details');</script>";
  }
 
}
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Главная</title>
</head>
<body>
<div class="container col-md-6" style="padding: 10em 10em;">
  <form method="post" class="form-horizontal">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email</label>
    <input class="form-control" type="text" required="" name="username" placeholder="Username or email" autocomplete="off">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Пароль</label>
    <input class="form-control" type="password" name="password" required="" placeholder="Password" autocomplete="off">
  </div>
  <button type="submit" class="btn btn-primary" name="login">Вход</button>
</form>
</div>
</body>
</html>