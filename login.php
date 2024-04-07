<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['id'];
      header('location:home.php');
   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>

<html>
    <meta charset="UTF-8">
    <head>
        <title>Ieeja</title>
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
         <div class="form-container">

            <form action="" method="post" enctype="multipart/form-data">
               <h3>Ieej tagad</h3>
               <?php
               if(isset($message)){
                  foreach($message as $message){
                     echo '<div class="message">'.$message.'</div>';
                  }
               }
               ?>
               <input type="email" name="email" placeholder="Ievadi E-pastu" class="box" required>
               <br>
               <input type="password" name="password" placeholder="Ievadi paroli" class="box" required>
               <br>
               <input type="submit" name="submit" value="Ieej tagad" class="btn">
               <br>
               <p>Vēl nav profila? <a href="register.php">Reģistrēties tagad!</a></p>
            </form>

         </div>

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
