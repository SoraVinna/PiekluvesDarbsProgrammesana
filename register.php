<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'user already exist'; 
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }elseif($image_size > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $insert = mysqli_query($conn, "INSERT INTO `user_form`(name, email, password, image) VALUES('$name', '$email', '$pass', '$image')") or die('query failed');

         if($insert){
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'registered successfully!';
            header('location:login.php');
         }else{
            $message[] = 'registeration failed!';
         }
      }
   }

}

?>

<html>
    <meta charset="UTF-8">
    <head>
        <title>Mājas</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>

    <body>
        <header>
            <h1>Sastopamās īpaši aizsargājamās sugas <br>Bauskas dabas parkā</h1>
        </header>
        <nav>
            <a href="index.html">Mājas</a>
            <a href="parks.html">Bauskas parks</a>
            <a href="sugas.html">Sugas</a>
            <a href="atsauksmes.html">Sazināties</a>
            <a href="home.php">Ieeja</a>
        </nav>
        <main>
        <div class="form-container">

            <form action="" method="post" enctype="multipart/form-data">
               <h3>Reģistrēties tagad</h3>
               <?php
               if(isset($message)){
                  foreach($message as $message){
                     echo '<div class="message">'.$message.'</div>';
                  }
               }
               ?>
               <input type="text" name="name" placeholder="Ievadi lietotājvārdu" class="box" required>
               <input type="email" name="email" placeholder="Ievadi E-pastu" class="box" required>
               <input type="password" name="password" placeholder="Ievadi paroli" class="box" required>
               <input type="password" name="cpassword" placeholder="Apstiprini paroli" class="box" required>
               <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
               <input type="submit" name="submit" value="Reģistrējies tagad" class="btn">
               <p>Jau ir profils? <a href="login.php">Ieej tagad!</a></p>
            </form>

         </div>

        </main>

         <footer> 

            <br>
            <p>+371 245988063</p>
            <br>

            <img src="bildes/facebook.png"; width="50px"; height="auto">
            <p>Facebook:</p>
            <p class="tab">@BDPAS</p>
            <br>

            <img src="bildes/twitter.png"; width="50px"; height="auto">
            <p>Twitter:</p>
            <p class="tab">@BDPAS</p>

            <img src="bildes/instagram.png"; width="50px"; height="auto">
            <p>Instagram:</p>
            <p class="tab">@BDPAS</p>
            <br>
            
            <hr>
            <p style="text-align: end; letter-spacing: 2px; ">

                  <a href="atsauksmes.html">Reklāmdevēji</a>
                              
                  /
                  
                  <a href="atsauksmes.html">Sazināties</a>
                  
                  /  

                  <a href="Lietot_Ligums.html">Lietotāja līgums</a>

                  /  

                  <a href="priv_pol.html">Privātuma politika </a>
                  
                  </p>
            <br>

         </footer>

      </body>
</html>
