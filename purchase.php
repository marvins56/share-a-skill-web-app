<?php
include 'session.php';
include 'database.php';



$email= "";
$contact= "";
$code= "";

$errors = array();
$success = array();
if(isset($_POST['submit'])){

  // receive all input values from the form to preventig injection
  $code= mysqli_real_escape_string($conn, $_POST['code']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $contact = mysqli_real_escape_string($conn, $_POST['contact']);

          //errors for the form
          if(empty($contact ))
          {array_push($errors,"contact required ");}

          if(empty($email) || !preg_match("/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/", $email))
          {array_push($errors,"email required or invalid email format");}
          if(empty($code))
          {array_push($errors,"product code required ");}


//if it doent exist register teh user
  // checking for errors
  // Finally, register user if there are no errors in the form


  if (count($errors) == 0) {

      $query = "INSERT INTO orders (email,contact,code) VALUES ('$email','$contact','$code')";
      $result = mysqli_query($conn, $query);
      if($result){
        array_push($success,"product uploaded sucecssfully");
      }

       else {
    array_push($errors,"Incorrect Email or Password!!!");
      }

    }


}




  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Share A skill</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800|Montserrat:300,400,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Top Bar ======= -->
  <section id="topbar" class="d-flex align-items-center">
    <div class="container d-flex justify-content-center justify-content-md-between">

      <div class="social-links d-none d-md-flex align-items-center">
        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
      </div>
    </div>
  </section><!-- End Top Bar-->

  <!-- ======= Header ======= -->
  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex justify-content-between">

      <div id="logo">
        <h1><a href="index.php">Share  a<span> Skill </span></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.php"><img src="assets/img/logo.png" alt=""></a>-->
      </div>

      <nav id="navbar" class="navbar">
        <ul>
        <li><a class="nav-link scrollto" href="admin_upload.php">admin</a></li>
          <li><a class="nav-link scrollto active" href="index.php">Home</a></li>
          <li><a class="nav-link scrollto" href="skill.php">skill up page</a></li>
          <li><a class="nav-link scrollto" href="purchase.php">purchase page</a></li>
          <?php
                        $sql = mysqli_query($conn, "SELECT * FROM users WHERE id = {$_SESSION['id']}");
                        if(mysqli_num_rows($sql) > 0){
                          $row = mysqli_fetch_assoc($sql);
                            $location = $row['location'];
                        }
                      ?>
  <li><a class="nav-link scrollto" href="#about">
<?php echo('<img src="'.$location.'" alt=""style=" width:60px; border-radius:50%;" > <br>'); ?>

    </a></li>
      <li><a class="nav-link scrollto" href="logout.php">
         <i class="fas fa-sign-out-alt fa-5x"></i></a></li>

        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= hero Section ======= -->

  <div class="alert alert-danger" role="alert" style="text-align:center;  ">
<?php include 'errors.php';
 ?></div>
  <div class="alert alert-success" role="alert" style="text-align:center;  ">
<?php include 'success.php';
 ?></div>

  <main id="main">
    <!-- ======= Services Section ======= -->
    <section id="services">
      <div class="container" data-aos="fade-up">
        <div class="section-header">

          <h2>purchase products</h2>
          <p>Sed tamen tempor magna labore dolore dolor sint tempor duis magna elit veniam aliqua esse amet veniam enim export quid quid veniam aliqua eram noster malis nulla duis fugiat culpa esse aute nulla ipsum velit export irure minim illum fore</p>
        </div>

        <div class="row gy-4">
        <?php
          $query = "select * from admin_uploads";
          $result = mysqli_query($conn,$query);
          if($result){

            while ($row  = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $location = $row['location'];
                $skillname = $row['skillname'];
                $skillprice = $row['skillprice'];
                $skillcode = $row['skillcode'];
                $description = $row['description'];

echo('
<div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
<div class="box">
  <div class="icon"><img src="'.$location.'" alt="" class="img-fluid"  style="border-radius:15px;"></div>
  <h2 class="title"><a href="">'.$skillname.'</a></h2>
  <p class="description">'.$description.'</p>
  <p class="description">PRICE:'.$skillprice.'</p>
  <p class="description">PRODUCT CODE:'.$skillcode.'</p>
<button   class="form-control btn btn-light rounded submit px-3 "   data-toggle="modal" data-target="#myModal"> buy</button>
</div>
</div>


');

            }
          }
                 ?>

                </div>

        </div>

      </div>


    </section>


  



  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>skillshare</strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!--
        All the links in the footer should remain intact.
        You can delete the links only if you purchased the pro version.
        Licensing information: https://bootstrapmade.com/license/
        Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=Reveal
      -->

      </div>
    </div>
  </footer><!-- End Footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script type="text/javascript">

$(document).ready(function () {

window.setTimeout(function() {
    $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
        $(this).remove();
    });
}, 5000);

});
</script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>



</body>

</html>
