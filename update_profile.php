<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(isset($_POST['update_profile'])){

   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

   mysqli_query($conn, "UPDATE `user_form` SET name = '$update_name', email = '$update_email' WHERE id = '$user_id'") or die('query failed');

   $old_pass = $_POST['old_pass'];
   $update_pass = mysqli_real_escape_string($conn, md5($_POST['update_pass']));
   $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
   $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));

   if(!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)){
      if($update_pass != $old_pass){
         $message[] = 'Vecā parole nav atjaunināta!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'Parole nav atjaunināta!';
      }else{
         mysqli_query($conn, "UPDATE `user_form` SET password = '$confirm_pass' WHERE id = '$user_id'") or die('query failed');
         $message[] = 'Parole atjaunināta!';
      }
   }

   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = 'uploaded_img/'.$update_image;

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image is too large';
      }else{
         $image_update_query = mysqli_query($conn, "UPDATE `user_form` SET image = '$update_image' WHERE id = '$user_id'") or die('query failed');
         if($image_update_query){
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
         }
         $message[] = 'image updated succssfully!';
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
            <div class="update-profile">

               <?php
                  $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
                  if(mysqli_num_rows($select) > 0){
                     $fetch = mysqli_fetch_assoc($select);
                  }
               ?>

               <form action="" method="post" enctype="multipart/form-data">
                  <?php
                     if($fetch['image'] == ''){
                        echo '<img src="bildes/default-avatar.png">';
                     }else{
                        echo '<img src="uploaded_img/'.$fetch['image'].'">';
                     }
                     if(isset($message)){
                        foreach($message as $message){
                           echo '<div class="message">'.$message.'</div>';
                        }
                     }
                  ?>
                     <div>
                        <div class="flex">
                           <div class="inputBox">
                              <span>Lietotājvārds :</span>
                              <input type="text" name="update_name" value="<?php echo $fetch['name']; ?>" class="box">
                              <span>E-pasts :</span>
                              <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
                              <span>Profila bilde :</span>
                              <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
                           </div>
                           <div class="inputBox">
                              <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
                              <span>Vecā parole :</span>
                              <input type="password" name="update_pass" placeholder="Ievadiet veco paroli" class="box">
                              <span>Jaunā parole :</span>
                              <input type="password" name="new_pass" placeholder="Ievadiet jauno paroli" class="box">
                              <span>Paroles apstiprināšana :</span>
                              <input type="password" name="confirm_pass" placeholder="Apstipriniet jauno paroli" class="box">
                           </div>
                        </div>
                     </div>
                  <input type="submit" value="Atjauno profilu" name="update_profile" class="btn">
                  <a href="home.php" class="delete-btn">Atpakaļ</a>
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