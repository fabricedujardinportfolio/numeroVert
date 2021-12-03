<?php require '../classes/database.php';?>
<?php include("../model/header.php");?>
<!-- SCRIPT ICI -->


</head>

<body>
    <?php
$msg = "";
  if (isset($_POST["valider"]))
      # code...
      try {
        //   var_dump($_POST);
        $msg = '';
        // echo "test";
        // var_dump($_POST);
        $name = $_POST["name"];
        // var_dump($name);
        $first_name = $_POST["first_name"];
        // var_dump($first_name);
        $pole_service = $_POST["pole_service"];  
        // var_dump($pole_service);      
        $function = $_POST["function"];
        // var_dump($function);
        $passwords = $_POST["passwords"];
        // var_dump($passwords);
        $active = $_POST["active"];
        // var_dump($active);
        $email = $_POST["email"];        
        $role_ressource = 0;
        // var_dump($email);

        $stmt = $conn->prepare('INSERT INTO `agents` VALUES ("",?, ?, ?, ?, ?, ? ,?,? )');
        $stmt->execute([$name,$first_name,$function,$passwords,$active,$email,$pole_service,$role_ressource]);  
        $msg = '<div class="alert alert-success" role="alert">
        Créer avec succès!
      </div>';
      header("refresh:2; add_agents.php");
    } catch (PDOException $e) {
          //throw $th;
          echo "
          <div class='alert alert-warning text-center' role='alert'>
          <strong>Contacter l'administrateur.</strong>
          </div>
          " ;
        }
        else {
          // echo"test";
        }      
  ?>
  <?php 
//   var_dump($_SESSION["user_pole"]);
  $poleUser = $_SESSION["user_pole"];
 
if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] == false || $_SESSION["user_pole"] !== "1" ):
    ?>
<?php
        header("refresh:0; login.php");
    else: 
?>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
    <div class="text-center col-12 mt-4">
        <div class="col-12">
            <img src="../public/images/logo.png" alt="logo du giep" width="110" height="72">
        </div>
        <div class="col-12">
            <button onclick="location.href='../index.php';" class="btn btn-lg btn btn-primary btn-block mt-4 text-center" style="background-color:#2e4f9b;color:white;">Retour</button>
        </div>
    </div>
    <div class="text-center">
        <h1><strong class="text-uppercase text-center">Rajouter un nouvel agent</strong></a></h1>
    </div>
    <div class="container-fluid d-flex">
        <div class="col-3">
        </div>
        <div class="col-6">
            <form action="add_agents.php" method="POST" class="container">
                <div class="col-12">
                    <label for="name" class="form-label">Nom</label>
                    <input id="name" type="text" name="name" placeholder="Le nom de l'agent SVP" class="form-control">
                </div>
                <div class="col-12">
                    <label for="first_name" class="form-label">Prénom</label>
                    <input id="first_name" type="text" name="first_name" placeholder="Le Prénom de l'agent SVP"
                        class="form-control">
                </div>
                <div class="col-12">
                    <div>
                        <label for="pole_service" class="form-label">Pôle service</label>
                        <select class="form-select" id="inputGroupSelect01" name="pole_service">
                            <option  value="1">COMMUNICATION / DOCUMENTATION​</option>
                            <option  value="2">DIRECTION</option>
                            <option  value="3">FINANCE ET RESSOURCE HUMAINE​</option>
                            <option  value="4">MÉTIERS DE LA MER​​</option>
                            <option  value="5">SPOT​</option>
                            <option  value="6">MAINTENANCE AUTOMOBILE / ENGINS​</option>
                            <option  value="7">INFORMATION ORIENTATION​</option>
                            <option  value="8">NUMÉRO VERT​</option>
                            <option  value="9">INDUSTRIE​</option>
                            <option  value="10">HÔTELLERIE RESTAURATION​</option>
                            <option  value="11">MOYENS GÉNÉRAUX​</option>
                            <option  value="12">COORDINATION ET PÉRI-FORMATION BOURAIL​</option>
                            <option  value="13">TRANSPORT LOGISTIQUE​</option>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <label for="function" class="form-label">Fonction</label>
                    <input id="function" type="text" name="function" placeholder="Fonction de l'agent SVP"
                        class="form-control">
                </div>
                <div class="col-12">
                    <label for="passwords" class="form-label">Passwords</label>
                    <input id="passwords" type="password" name="passwords" value="123456" readonly class="form-control">
                </div>
                <div class="col-12">
                    <label for="active" class="form-label">Présence de l'agent dans l'entreprise"</label>
                    <select name="active" id="active" class="form-select">
                        <option value="1">Oui</option>
                        <option value="0">Non</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="text" name="email" placeholder="Email de l'agent SVP" class="form-control">
                </div>
                <div class="col-md-12 mt-3 text-center pb-5">
                    <button type="submit" name="valider" class="btn btn-primary"
                        style="background-color:#2e4f9b">VALIDER</button>
                </div>
            </form>
        </div>
        <div class="col-3">
        </div>
    </div>
    
  <?php endif;