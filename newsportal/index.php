<?php 
session_start();
include('includes/config.php');
    ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Пост</title>
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
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
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


              <div style="padding: 2em 1px;" class="row">
                <?php 
   
$query=mysqli_query($con,"select tblposts.id as pid,tblposts.PostTitle as posttitle,tblposts.PostImage,tblposts.PostDetails as postdetails from tblposts  where tblposts.Is_Active=1 order by tblposts.id desc");
while ($row=mysqli_fetch_array($query)) {
?>
                <div class="col-md-3">
                  <div class="card">
                    <img class="card-img-top" src="admin/postimages/<?php echo htmlentities($row['PostImage']);?>" alt="<?php echo htmlentities($row['posttitle']);?>">
                    <div class="card-body">
                      <h5 class="card-title"><?php echo htmlentities($row['posttitle']);?></h5>
<!--                       <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                       <a href="news-details.php?nid=<?php echo htmlentities($row['pid'])?>" class="btn btn-primary">Толық</a>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
</body>
</html>
