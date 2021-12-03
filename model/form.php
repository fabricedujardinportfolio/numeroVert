<?php 
if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] == false):
    ?>
<?php
        header("refresh:0; views/login.php");
    else: 
?>
<div class="container">
  <div class="row">
    <div class="col-12 col-md-2"></div>
    <div class="col-12 col-md-8">
      <!-- Image du site  -->
      <div class="container">
        <img src="" alt="" srcset="">
      </div>
      <!-- Info User -->
      <div class="container">
        <div class="row">
          <div class="col-12 "></div>
          <div class="col-12  ">
            <p class="text-center">Bonjour Fabrice</p>
          </div>
          <div class="col-12 "></div>
        </div>
      </div>
      <!-- Les stats du site -->
      <div class="container">
        <form action="" method="post">
          <div class="container border p-1">
            <div class="row m-2">
              <div class="col-1 col-lg-12"></div>
              <div class="col-10 col-lg-12">
                <div class="row">                  
                  <div class="col-12 col-xl-6">
                    <div class="row">
                      <div class="col-12 col-sm-6"><label for="datDeb">Date de début :</label></div>
                      <div class="col-12 col-sm-6"><input type="date" name="dateDeb" id="dateDeb"></div>
                    </div>
                  </div>
                  <div class="col-12 col-xl-6">                
                    <div class="row">
                        <div class="col-12 col-sm-6"><label for="datFin">Date de fin :</label></div>
                        <div class="col-12 col-sm-6"><input type="date" name="datFin" id="datFin"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-1 col-lg-12"></div>
          </div>   
          <div class="container  p-2">
            <div class="row">
              <div class="col-2"></div>
              <div class="col-8 text-center">
                  <button type="submit" name="valider">Etat de tous les appels</button>
              </div>
              <div class="col-2"></div>
            </div>
          </div>
        </form>
      </div>
      <div class="container-fluid">
        <div class="container pt-2">
          <div class="table-responsive-sm">
            <table class="table">
                <thead class=" table table-dark thead-dark">
                  <tr>
                    <th scope="col-2">Date / Heure</th>
                    <th scope="col-2">Objet d'appel</th>
                    <th scope="col-2">Nature de l'appel</th>
                    <th scope="col-2">Statu</th>
                    <th scope="col-4">Resultat</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">18/12/2021:15h</th>
                    <td>Suivi candidat</td>
                    <td>Interessé</td>
                    <td>Demandeur d'emploie</td>
                    <td>INFORMATION </td>
                  </tr>
                  <tr>
                  <th scope="row">14/12/2021:12h</th>
                    <td>Suivi candidat</td>
                    <td>Interessé</td>
                    <td>Demandeur d'emploie</td>
                    <td>INFORMATION </td>
                  </tr>
                  <tr>
                  <th scope="row">12/12/2021:11h</th>
                    <td>Suivi candidat</td>
                    <td>Interessé</td>
                    <td>Demandeur d'emploie</td>
                    <td>INFORMATION </td>
                  </tr>
                </tbody>
              </table>
            </div>
        </div>
        <div class="container p-2">
              <div class="row">
                <div class="col-9"></div>
                <div class="col-3">
                  <a href="#"><img src="Microsoft_Office_Excel.png" alt="" srcset="" style="width:25px;height:auto;" class="m-1">: Télècharger</a>
                </div>
              </div>
            </div>
        </div>
      </div>
    <div class="col-12 col-md-2"></div>
  </div>
</div>
<?php endif;