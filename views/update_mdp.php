<?php
include("../model/header.php");
require_once '../classes/database.php';
// if(!isset($_SESSION["user_login"]))	//check condition user login not direct back to index.php page
// {
// 	header("location: ../index.php");
// }

$msg = "";
$msgupdate = "";
if(isset($_POST['valider']))
      try {
        // var_dump($_POST);
        $msgupdate="";
      if (!empty($_POST)) {
        $oldpasword = $_POST['oldpasword'];
        // var_dump($oldpasword);
        $newpaswword = $_POST['newpaswword']; 
        $agentsid = $_POST['agentsid'];    
        $email = $_SESSION["user_email"];      
        $to = $email;
        // var_dump($to);
        $subject = 'Changement de mot de passe';
        $message = "Votre nouveau mot de passe pour les applications interne au GIEP-NC : '$newpaswword'"; 
        // var_dump($message);
        // var_dump($from);
        // // Update posts table
        $stmt = $conn->prepare('UPDATE agents SET passwords = ? WHERE id = ?');
        $stmt->execute([$newpaswword,$agentsid]);
        // // $test = header('refresh:2; index.php');
        $msgupdate = '<spans class="alert alert-success mt-5 mt-md-0" role="alert">Mis à jour avec succés un email vous a été envoyé !</span>'; 
        if(mail($to, $subject, $message)){
          // echo 'Votre message a été envoyé avec succès!';          
        session_destroy();        
        header("refresh:2; login_mdp.php");
      } else{
          echo "Impossible d'envoyer des emails. Veuillez réessayer.";
      }
      }
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      else {
        // echo"";
      }
?>
<?php 
if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] == false):
    ?>
<?php
        header("refresh:0; login_mdp.php");
    else: 
        $psw = $_SESSION["user_psw"];
        $email = $_SESSION["user_email"];        
        $agentsid = $_SESSION["user_login"];
        // var_dump($email);
        // if ($psw ) {
        //     # code...
        // }
        // var_dump($psw);
?>
<?php

// Envoi d'email

?>
<div class="container d-flex">
    <div class="col-1"></div>
    <div class="col-10">    
                  
                <div class="text-center col-12 mt-1">
                    <img  src="../public/images/logo.png" alt="logo du giep" width="110" height="72">
                </div>
        <div class="text-center p-3">
            <h1><strong class="text-uppercase">Mise à jour du mots de passe</strong></h1>
        </div>
        <form action="" method="post" >
        <span style="display:none"> <input type="text" name="agentsid" value="<?php echo "$agentsid"?>"></span>
        <h2 class="text-center" >Bonjour : <?php echo"$email" ?></h2>
        <?php if ($msgupdate): ?>
        <p class="text-center mt-5"><?=$msgupdate?></p>
        <?php endif; ?>
            <div class="form-group">
                <label for="update_mdp" >Ancien mots de passe</label>
                <input type="text" placeholder="<?php echo "$psw" ?>" class="form-control"  value="<?php echo "$psw" ?>" name="oldpasword" readonly >
            </div>
            <div class="form-group">
                <label for="update_mdp">Nouveau mots de passe</label>
                <input type="text" placeholder="Nouveau mdp" class="form-control" name="newpaswword">
            </div>
            <div class="text-center  mb-3">
                <button class="btn btn-lg btn btn-primary btn-block mt-4 text-center" type="submit" name="valider" value="S'authentifier" style="background-color:#2e4f9b;color:white;">Mettre à jour</button>
            </div>
        </form>
        <a href="logout.php">Déconnexion</a></span>
    </div>
    <div class="col-1"></div>
</div>
<?php include("../model/footer.php");?>
<?php endif;