<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login.php');
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
        <main>
            <div class="container">

               <div class="profile">
                  <?php
                     $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
                     if(mysqli_num_rows($select) > 0){
                        $fetch = mysqli_fetch_assoc($select);
                     }
                     if($fetch['image'] == ''){
                        echo '<img src="bildes/default-avatar.png">';
                     }else{
                        echo '<img src="uploaded_img/'.$fetch['image'].'">';
                     }
                  ?>
                  <h3><?php echo $fetch['name']; ?></h3>

                  <div class="btn-container">
                     <a href="update_profile.php" class="btn">Atjaunināt profilu</a>
                  </div>
                  <div class="btn-container">
                     <a href="home.php?logout=<?php echo $user_id; ?>" class="delete-btn">Iziet</a>
                  </div>
                  <p>No jauna <a href="login.php">ieiet</a> or <a href="register.php">Reģistrēties</a></p>


               </div>

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
   
