<?php
include 'session.php';
 ?>
 <?php include 'database.php';

 $skillname = "";
 $skillcode= "";
 $skillprice = "";
$description = "";

 $file = "";
 $errors = array();
 $success = array();

 if(isset($_POST['submit'])){

   // receive all input values from the form to preventig injection
   $skillname = mysqli_real_escape_string($conn, $_POST['skillname']);
   $skillcode = mysqli_real_escape_string($conn, $_POST['skillcode']);
   $skillprice = mysqli_real_escape_string($conn, $_POST['skillprice']);
   $description = mysqli_real_escape_string($conn, $_POST['description']);


           //errors for the form
           if(empty($skillname))
           {array_push($errors,"skillname required ");}

           if(empty($description) )
           {array_push($errors,"description required ");}

           if(empty($skillcode) )
           {array_push($errors,"code required ");}

           if(empty($skillprice) )
           {array_push($errors,"price required ");}


 //if it doent exist register teh user
   // checking for errors
   // Finally, register user if there are no errors in the form
if (count($errors) == 0) {
   $maxsize = 15728640; // 5MB

  $name = $_FILES['file']['name'];
  $target_dir = "admin_uploads/";
$target_file = $target_dir . $_FILES["file"]["name"];

                           // Select file type
   $videoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

   // Valid file extensions
   $extensions_arr = array("jpg","png","jpeg");
                           // Check extension
                                     if( in_array($videoFileType,$extensions_arr) ){

                                         // Check file size
                                         if(($_FILES['file']['size'] >= $maxsize) || ($_FILES["file"]["size"] == 0)) {
                                             echo "File too large. File must be less than 5MB.";
                                         }else{
                                             // Upload
                                             if(move_uploaded_file($_FILES['file']['tmp_name'],$target_file))
                                             {
                                                 // Insert record
                                            

                            $query = "INSERT INTO admin_uploads (skillname,skillprice,skillcode,description,name,location)
                             VALUES ('$skillname','$skillprice','$skillcode','$description','".$name."','".$target_file."')";

                                                  $res =   mysqli_query($conn,$query);
                                                     if($res){
                                                       
                                               array_push($success,"product uploaded sucecssfully");
                                                     //  header("location:admin_upload.php");
                                                          
                                                       }
                                                   else{
                                                  array_push($errors,"database connection failed");
                                                     }
                                                 }
                                                
                                             
                                             else{
                                             array_push($errors,"upload failed");
                                             }
                                         }

                                     }else{
                                         array_push($errors,"Invalid file extension.");
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

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="st.css" rel="stylesheet">

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
        <h1><a href="index.php">Share  a<span> Skill Admin</span></a></h1>
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


  <main id="main">

    <section class=" bg-image" style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
      <div class="mask d-flex align-items-center h-100 gradient-custom-3">
        <div class="container">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6">
              <div class="card" style="border-radius: 15px;">
                <div class="card-body p-5">
                  <h5 class="text-uppercase text-center mb-5">UPLOAD PRODUCTS</h5>

                  <form method="POST"  enctype='multipart/form-data' action="">

<div class="alert alert-success" role="alert" style="text-align:center;  ">
<?php include 'success.php';
 ?>
                                                       </div>
 <div class="alert alert-danger" role="alert" style="text-align:center;  ">

<?php
 include 'errors.php';
?></div>

                <div class="form-outline mb-4">
                      <input type="file"  name="file" id="form3Example4cdg" class="form-control form-control-lg" required />
                      <label class="form-label" for="form3Example4cdg">UPLOAD PRODUCTS IMAGE </label>
                    </div>

                    <div class="form-outline mb-4">
                      <input type="text" id="form3Example1cg"  name="skillname" class="form-control form-control-lg"  placeholder=" enter product name" value="<?php echo $skillname;?>" />
                      <label class="form-label" for="form3Example1cg">PRODUCTS NAME</label>
                    </div>

                    <div class="form-outline mb-4">
                      <input type="number" id="form3Example1cg"  name="skillprice" class="form-control form-control-lg" placeholder=" eg 2255 " value="<?php echo $skillprice;?>"/>
                      <label class="form-label" for="form3Example1cg">PRODUCTS PRICE</label>
                    </div>

                    <div class="form-outline mb-4">
                      <input type="text" id="form3Example1cg"  name="skillcode" class="form-control form-control-lg"  placeholder="eg  A22b" value="<?php echo $skillcode;?>"/>
                      <label class="form-label" for="form3Example1cg">PRODUCTS CODE</label>
                    </div>

                    <div class="form-outline mb-4">
                      <textarea name="description" rows="8" cols="80" class="form-control form-control-lg" placeholder="description goes here..." value="<?php echo $description;?>"></textarea>
                      <label class="form-label" for="form3Example3cg">DESCRIBE SKILL</label>
                    </div>
                  
                    <div class=" justify-content-center">
                <input type="submit" name="submit" value="UPLOAD" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">
                    </div>
                  </form>
  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


    </section>

<div  class="container" data-aos="fade-up">

<table>
  <h1>order list  </h1>
  <tr>
  <th>S/n</th> 
  <th>email</th>
  <th>code</th>
  <th>contact</th>

  </tr>
  <?php
          $query = "select * from orders";
          $result = mysqli_query($conn,$query);
          if($result){

            while ($row  = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
            $email = $row['email'];
            $code = $row['code'];
            $contact= $row['contact'];
          
echo(' 
<tr>
<td>'.$id.'</td>
<td>'.$email.'</td>
<td>'.$code.'</td>
<td>'.$contact.'</td>
</tr>

');

            }
          }
                 ?>
  
</table>




    
        </div>


    
</div>

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
