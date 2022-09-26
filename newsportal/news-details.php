<?php 
session_start();
include('includes/config.php');
//Genrating CSRF Token
if (empty($_SESSION['token'])) {
 $_SESSION['token'] = bin2hex(random_bytes(32));
}

if(isset($_POST['submit']))
{
  //Verifying CSRF Token
if (!empty($_POST['csrftoken'])) {
    if (hash_equals($_SESSION['token'], $_POST['csrftoken'])) {
$name=$_POST['name'];
$email=$_POST['email'];
$comment=$_POST['comment'];
$postid=intval($_GET['nid']);
$st1='0';
$query=mysqli_query($con,"insert into tblcomments(postId,name,email,comment,status) values('$postid','$name','$email','$comment','$st1')");
if($query):
  echo "<script>alert('комментарий успешно отправлен. Комментарий будет отображаться после проверки администратором');</script>";
  unset($_SESSION['token']);
else :
 echo "<script>alert('Что-то пошло не так. Пожалуйста, попробуйте еще раз.');</script>";  

endif;

}
}
}
$postid=intval($_GET['nid']);

    $sql = "SELECT viewCounter FROM tblposts WHERE id = '$postid'";
    $result = $con->query($sql);    
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Пост Детайл</title>
</head>
  <body>
      <div class="container">
        <div class="row">
          <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
              <div class="container-fluid">
                <a class="navbar-brand" href="index.php">LOGO</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="index.php">Главная</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="admin/manage-posts.php">Admin</a>
                    </li>
                  </ul>
                </div>
              </div>
            </nav>
          </header>
        </div>
        <div class="row" style="margin-top: 4%">
           <div class="col-md-8">
            <?php
              $pid=intval($_GET['nid']);
              $currenturl="http://".$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];;
               $query=mysqli_query($con,"select tblposts.PostTitle as posttitle,tblposts.PostImage,
                tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate from tblposts where tblposts.id='$pid'");
              while ($row=mysqli_fetch_array($query)) {
              ?>
              <div class="card mb-4">
                <div class="card-body">
                  <h5 class="card-title"><?php echo htmlentities($row['posttitle']);?></h5>
                  <p><?php echo htmlentities($row['postingdate']);?></p><hr/>
                  <img class="img-fluid rounded" src="admin/postimages/<?php echo htmlentities($row['PostImage']);?>" alt="<?php echo htmlentities($row['posttitle']);?>">
                  <p class="card-text"><?php $pt=$row['postdetails']; echo  (substr($pt,0));?></p>
                  <div class="card-footer text-muted"></div>
                </div>
              </div><?php } ?>
            </div>
        </div>
        <div class="row" style="margin-top: -8%">
          <div class="col-md-8">
            <div class="card my-4">
            <h5 class="card-header">Коментарии:</h5>
              <div class="card-body">
                <form name="Comment" method="post">
                  <input type="hidden" name="csrftoken" value="<?php echo htmlentities($_SESSION['token']); ?>" />
                  <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Имя" required>
                  </div><br>
                  <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="email" required>
                  </div><br>
                  <div class="form-group">
                    <textarea class="form-control" name="comment" rows="3" placeholder="Коментарии" required></textarea>
                  </div><br>
                  <button type="submit" class="btn btn-primary" name="submit">Отправить</button>
                </form>
              </div>
            </div>
             <?php 
             $sts=1;
             $query=mysqli_query($con,"select name,comment,postingDate from  tblcomments where postId='$pid' and status='$sts'");
            while ($row=mysqli_fetch_array($query)) {
            ?>
            <div class="media mb-4">
                        <img class="d-flex mr-3 rounded-circle" src="images/usericon.png" alt="">
                        <div class="media-body">
                          <h5 class="mt-0"><?php echo htmlentities($row['name']);?> <br />
                              <span style="font-size:11px;"><b>at</b> <?php echo htmlentities($row['postingDate']);?></span>
                        </h5>
                       
                         <?php echo htmlentities($row['comment']);?>            </div>
                      </div>
            <?php } ?>
          </div>
        </div>
      </div>
  </body>
</html>
