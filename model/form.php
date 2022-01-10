<?php
if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] == false) :
?>
<?php
  header("refresh:0; views/login.php");
elseif ($_SESSION["user_droit"] == "2") :
  //  Affichage du formulaire pour compte utilisateur simple de l'application numéro vert 
?>
  <?php
  // var_dump($_SESSION);
  $calInfos = [];
  try {
    //récupérer le nom de agent connecter par rapport à la session
    $agentId = $_SESSION["agentsid"];
    $select_stmt = $conn->prepare("SELECT * FROM `agents` 
    WHERE agents.id=:agentId ");
    $select_stmt->execute(array(':agentId' => $agentId));
    $userInfo = $select_stmt->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    $e->getMessage();
  }
  // name table in bdd = numvert_callinfo
  if (isset($_REQUEST['valider']))  //button name is "btn_login"
  {
    $dateDeb = $_POST['dateDeb'];
    $datFin = $_POST['datFin'];
    $valider = $_POST['valider'];
    $agentId = $_SESSION["agentsid"];
    try {
      $select_stmt = $conn->prepare("SELECT * FROM `numvert_callinfo` 
      WHERE date_resa BETWEEN :dateDeb  AND :datFin ORDER BY date_resa");
      $select_stmt->execute(array(':dateDeb' => $dateDeb, 'datFin' => $datFin));  //execute query with bind parameter
      $calInfos = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
      // var_dump($calInfos);
    } catch (PDOException $e) {
      $e->getMessage();
    }
  }
  $dateNow = date("d-m-Y H:i:s");
  $date = date("d/m/Y");
  $heureDefaultApp = date("H:i");


  if (isset($_REQUEST['valider2'])) {
    $valider = $_POST['valider2'];
    $date_resa = $_POST['date_resa'];
    $date_resa_default = $_POST['date_resa_default'];
    $heure_resa = $_POST['heure_resa'];
    if ($heure_resa == '') {
      $heure_resa = $heureDefaultApp;
    } else {      
      $heure_resa = $_POST['heure_resa'];
    }
    
    $objet_resa = $_POST['objet_resa'];
    $nature_resa = $_POST['nature_resa'];
    $statut_resa = $_POST['statut_resa'];
    $resultat_resa = $_POST['resultat_resa'];
    $genre_resa = $_POST['genre_resa'];
    // var_dump($heure_resa);
    $byagentId_resa = $_SESSION["agentsid"];
    try {
      $stmt = $conn->prepare('INSERT INTO `numvert_callinfo` VALUES ("",?, ?,?, ?, ?, ?, ? ,?,? )');
      $stmt->execute([$date_resa, $date_resa_default, $heure_resa, $objet_resa, $nature_resa, $statut_resa, $resultat_resa, $genre_resa, $byagentId_resa]);
      $loginMsg = "Insertion réussie...";
      header("refresh:2;");
    } catch (PDOException $e) {
      $e->getMessage();
    }
  }

  ?>
  <style>
    .couleur {
      background-color: #2e4f9b !important;
      color: white !important;
    }
  </style>
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-12">
        <!-- Image du site  -->
        <div class="container">
          <img src="" alt="" srcset="">
        </div>
        <!-- Info User -->
        <div class="container">
          <div class="row">
            <div class="col-12 "></div>
            <div class="col-12  ">
              <p class="text-center">Bonjour <?php echo $userInfo["first_name"]; ?></p>
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary couleur" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Saisir un appel
              </button>
              <?php

              if (isset($loginMsg)) {
              ?>
                <div class="alert alert-success">
                  <strong><?php echo $loginMsg; ?></strong>
                </div>
              <?php
              }
              ?>
              <!-- Modal -->
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 660px !important;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Saisir un appel</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="post">
                      <div class="container">
                        <div class="container-fluid  pt-2 mt-3" style="padding-left: 1px;"><label for="objet_resa" class="p-1" style="background: #2e4f9b none repeat scroll 0 0;color:white;">Informations appelant</label></div>
                        <div class="container border px-3 py-2" style="background-color: #94c123;">
                          <div class="container-fluid border p-1 m-1 mb-2">
                            <div class="row">
                              <div class="col-4">
                                <label for="genre_resa">Genre</label>
                              </div>
                              <div class="col-8" id="genre_resa">
                                <div class="row">
                                  <div class="col-6">
                                    <input type="radio" name="genre_resa" id="genre_homme" value="2" checked>
                                    <label for="genre_homme">Homme</label>
                                  </div>
                                  <div class="col-6">
                                    <input type="radio" name="genre_resa" id="genre_femme" value="1">
                                    <label for="genre_femme">Femme</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="container-fluid border p-1 m-1 mb-2">
                            <div class="row">
                              <div class="col-4">
                                <label for="nature_resa">Type</label>
                              </div>
                              <div class="col-8">
                                <select name="nature_resa" id="nature_resa" required style="width: 100%;">
                                  <option value=""></option>
                                  <option value="INTERESSE">INTERESSE</option>
                                  <option value="PROFESSIONNEL">PROFESSIONNEL</option>
                                  <option value="TIERS">TIERS</option>
                                  <option value="PARTENAIRE">PARTENAIRE</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="container-fluid border p-1 m-1 mb-2">
                            <div class="row">
                              <div class="col-4">
                                <label for="statut_resa">Statut</label>
                              </div>
                              <div class="col-8">
                                <select name="statut_resa" id="statut_resa" required style="width: 100%;">
                                  <option value=""></option>
                                  <option value="DEMANDEUR D'EMPLOI">DEMANDEUR D'EMPLOI</option>
                                  <option value="EN ACTIVITE PROFESSIONNELLE">EN ACTIVITE PROFESSIONNELLE</option>
                                  <option value="ETUDIANT">ETUDIANT</option>
                                  <option value="Stagiaire FPC">STAGIAIRE FPC</option>
                                  <option value="RETRAITE">RETRAITE</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- #94C11F -->
                        <div class="container-fluid pr-2 pt-2 mt-3" style="padding-left: 1px;"><label for="objet_resa" class="p-1" style="background: #2e4f9b none repeat scroll 0 0;color:white;">Informations appel</label></div>
                        <div class="container border py-2" style="background-color: #86AF38; ">
                          <div class="container border p-1 m-1 mb-2">
                            <div class="row">
                              <div class="col-6">
                                <div class="row">
                                  <div class="col-5">
                                    <span class="p-1"> <label for="date_resa"> Date</label> </span>
                                  </div>
                                  <div class="col-7">
                                    <input type="date" name="date_resa" id="dayNow" value="<?php echo $date ?>" required style="width: 100%;">
                                    <input type="text" name="date_resa_default" id="date_resa_default" value="<?php echo $dateNow ?>" required style="width: 100%;" class="d-none">
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="row">
                                  <div class="col-3">
                                    <span class="p-1"> <label for="heure_resa"> Heure </label> </span>
                                  </div>
                                  <div class="col-9">
                                    <input type="time" name="heure_resa" id="heure_resa"  value ="<?php echo $heureDefaultApp ?>"style="width: 100%;">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="container-fluid border p-1 m-1 mb-2">
                            <div class="row">
                              <div class="col-4">
                                <label for="objet_resa">Objet de l'appel</label>
                              </div>
                              <div class="col-8">
                                <select name="objet_resa" id="objet_resa" required style="width: 100%;">
                                  <option value=""></option>
                                  <option value="AIDE FINANCIERE">AIDE FINANCIERE</option>
                                  <option value="AUTRE INFORMATION">AUTRE INFORMATION</option>
                                  <option value="CONFIRMATION RCI">CONFIRMATION RCI</option>
                                  <option value="COVID - Emploi / Formation">COVID - Emploi / Formation</option>
                                  <option value="DISPOSITIF MOBILITE">DISPOSITIF MOBILITE</option>
                                  <option value="FORMATION CONTINUE">FORMATION CONTINUE</option>
                                  <option value="FORMATION INITIALE">FORMATION INITIALE</option>
                                  <option value="PROJET PROFESSIONNEL">PROJET PROFESSIONNEL</option>
                                  <option value="RECHERCHE EMPLOI">RECHERCHE EMPLOI</option>
                                  <option value="SERVICE ENVIRONNEMENT STAGIAIRE">SERVICE ENVIRONNEMENT STAGIAIRE</option>
                                  <option value="SUIVI CANDIDAT">SUIVI CANDIDAT</option>
                                  <option value="VAE">VAE</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="container-fluid border p-1 m-1 mb-2">
                            <div class="row">
                              <div class="col-4">
                                <label for="resultat_resa">Résultat</label>
                              </div>
                              <div class="col-8">
                                <select name="resultat_resa" id="resultat_resa" required style="width: 100%;">
                                  <option value=""></option>
                                  <option value="GIEP-NC">GIEP-NC</option>
                                  <option value="INFORMATION FINALE">INFORMATION FINALE</option>
                                  <option value="PARTENAIRES">PARTENAIRES</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="container-fluid">
                            <div class="row">
                              <div class="col-12 col-sm-6 text-center">
                                <input type="reset" id="effacer" class="btn" value="Effacer" style="background: #f7ab59 none repeat scroll 0 0;color: maroon;">
                              </div>
                              <div class="col-12 col-sm-6 text-center">
                                <button type="submit" name="valider2" class="btn btn-success">Valider</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                    <div class="modal-footer">
                      <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 "></div>
          </div>
        </div>
        <!-- Les stats du site -->
        <div class="container">
          <form action="" method="post">
            <div class="container border p-1 m-1 mb-2">
              <div class="row">
                <div class="col-6">
                  <div class="row">
                    <div class="col-5">
                      <span class="p-1"> <label for="date_resa"> Date de début :</label> </span>
                    </div>
                    <div class="col-7">
                      <input type="date" name="dateDeb" id="dateDeb" required style="width: 100%;">
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="row">
                    <div class="col-3">
                      <span class="p-1"> <label for="heure_resa"> Date de fin : </label> </span>
                    </div>
                    <div class="col-9">
                      <input type="date" name="datFin" id="datFin" required style="width: 100%;">
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
              <button type="submit" name="valider" class="border" style="background: #94c123 none repeat scroll 0 0;
    color: #ffffff;
    font-size: 15px;
    line-height: 1.5;
    padding: 6px 13px;">Etat de tous les appels</button>
            </div>
            <div class="col-2"></div>
          </div>
        </div>
        </form>
      </div>
      <div class="container-fluid">
        <div class="table-responsive-sm ">
          <table class="table border" id="intermediateTable">
            <thead class="couleur thead-dark ">
              <tr>
                <th>Date </th>
                <th>Heure </th>
                <th>Genre</th>
                <th>Type</th>
                <th>Statut</th>
                <th>Objet d'appel</th>
                <th>Resultat</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (count($calInfos) > 0) {
                # Je compte le nombre d'itération que contient la variable calInfos et si elle est supérieur a 0 je rentre dans ma condition
                foreach ($calInfos as $calInfo) {
              ?>
                  <tr>
                    <td>
                      <?php
                      echo date('d-m-Y', strtotime($calInfo['date_resa'])); ?> 
                    </td>
                    <td>
                      <?php
                      echo  $calInfo['heure_resa'] ?> H
                    </td>
                    <td>
                      <?php
                      if ($calInfo['genre_resa'] == 2) {
                      ?>Homme</td>
                    <?php
                      } elseif ($calInfo['genre_resa'] == 1) {
                    ?>Femme</td>
                  <?php
                      }
                  ?>
                  <td><?php echo $calInfo['nature_resa'] ?></td>
                  <td><?php echo $calInfo['statut_resa'] ?></td>
                  <td><?php echo $calInfo['objet_resa'] ?></td>
                  <td><?php echo $calInfo['resultat_resa'] ?></td>
                  </tr>
                <?php
                }
              } else {
                ?>
                <tr>
                  <td colspan="11" class="table-active text-center">Aucun appel</td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
        <div class="container p-2">
          <div class="row">
            <div class="col-9"></div>
            <div class="col-3">
              <a href="#" id="downloadIntermidiate" class="noExl"><img src="Microsoft_Office_Excel.png" alt="" srcset="" style="width:25px;height:auto;" class="m-1">: Télécharger</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <script>
    //table2excel.js
    ;
    (function($, window, document, undefined) {
      var pluginName = "table2excel",

        defaults = {
          exclude: ".noExl",
          name: "Table2Excel"
        };

      // The actual plugin constructor
      function Plugin(element, options) {
        this.element = element;
        // jQuery has an extend method which merges the contents of two or
        // more objects, storing the result in the first object. The first object
        // is generally empty as we don't want to alter the default options for
        // future instances of the plugin
        //
        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
      }

      Plugin.prototype = {
        init: function() {
          var e = this;

          e.template = {
            head: "<html xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns=\"http://www.w3.org/TR/REC-html40\"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets>",
            sheet: {
              head: "<x:ExcelWorksheet><x:Name>",
              tail: "</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet>"
            },
            mid: "</x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body>",
            table: {
              head: "<table>",
              tail: "</table>"
            },
            foot: "</body></html>"
          };

          e.tableRows = [];

          // get contents of table except for exclude
          $(e.element).each(function(i, o) {
            var tempRows = "";
            $(o).find("tr").not(e.settings.exclude).each(function(i, o) {
              tempRows += "<tr>" + $(o).html() + "</tr>";
            });
            e.tableRows.push(tempRows);
          });

          e.tableToExcel(e.tableRows, e.settings.name);
        },

        tableToExcel: function(table, name) {
          var e = this,
            fullTemplate = "",
            i, link, a;

          e.uri = "data:application/vnd.ms-excel;base64,";
          e.base64 = function(s) {
            return window.btoa(unescape(encodeURIComponent(s)));
          };
          e.format = function(s, c) {
            return s.replace(/{(\w+)}/g, function(m, p) {
              return c[p];
            });
          };
          e.ctx = {
            worksheet: name || "Worksheet",
            table: table
          };

          fullTemplate = e.template.head;

          if ($.isArray(table)) {
            for (i in table) {
              //fullTemplate += e.template.sheet.head + "{worksheet" + i + "}" + e.template.sheet.tail;
              fullTemplate += e.template.sheet.head + "Table" + i + "" + e.template.sheet.tail;
            }
          }

          fullTemplate += e.template.mid;

          if ($.isArray(table)) {
            for (i in table) {
              fullTemplate += e.template.table.head + "{table" + i + "}" + e.template.table.tail;
            }
          }

          fullTemplate += e.template.foot;

          for (i in table) {
            e.ctx["table" + i] = table[i];
          }
          delete e.ctx.table;

          if (typeof msie !== "undefined" && msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) // If Internet Explorer
          {
            if (typeof Blob !== "undefined") {
              //use blobs if we can
              fullTemplate = [fullTemplate];
              //convert to array
              var blob1 = new Blob(fullTemplate, {
                type: "text/html"
              });
              window.navigator.msSaveBlob(blob1, getFileName(e.settings));
            } else {
              //otherwise use the iframe and save
              //requires a blank iframe on page called txtArea1
              txtArea1.document.open("text/html", "replace");
              txtArea1.document.write(e.format(fullTemplate, e.ctx));
              txtArea1.document.close();
              txtArea1.focus();
              sa = txtArea1.document.execCommand("SaveAs", true, getFileName(e.settings));
            }

          } else {
            link = e.uri + e.base64(e.format(fullTemplate, e.ctx));
            a = document.createElement("a");
            a.download = getFileName(e.settings);
            a.href = link;

            document.body.appendChild(a);

            a.click();

            document.body.removeChild(a);
          }

          return true;
        }
      };

      function getFileName(settings) {
        return (settings.filename ? settings.filename : "table2excel") + ".xls";
      }

      $.fn[pluginName] = function(options) {
        var e = this;
        e.each(function() {
          if (!$.data(e, "plugin_" + pluginName)) {
            $.data(e, "plugin_" + pluginName, new Plugin(this, options));
          }
        });

        // chain jQuery functions
        return e;
      };

    })(jQuery, window, document);


    $("#downloadIntermidiate").click(function() {

      $("#intermediateTable").table2excel({
        exclude: ".noExl",
        name: "Excel Document intermediateTable",
        filename: "ExportNumeroVert"
      });

    });
    $(document).ready(function() {


      var now = new Date();
      var day = ("0" + now.getDate()).slice(-2);
      var month = ("0" + (now.getMonth() + 1)).slice(-2);

      var today = now.getFullYear() + "-" + (month) + "-" + (day);
      $("#dayNow").val(today);

      $("#dayNow").change(function () {  
            var date_start = $('#dayNow').val();
            var time_start = $("#heure_resa").val();
            var rightNow = new Date();
            console.log(rightNow);
            var dateNow = rightNow.toISOString().slice(0,10);
            if ((Date.parse(date_start) > Date.parse(dateNow))) {
                alert("Attention vous effectuez une réservation pour une date futur ");
                // document.getElementById("date_start").valueAsDate = null;                
            $("#dayNow").val(today);
            }
        });

    });
  </script>
<?php
// //  Affichage du formulaire pour compte administrateur de l'application numéro vert 
elseif ($_SESSION["user_droit"] == "1") :
  // var_dump($_SESSION);
  $agentId = $_SESSION["agentsid"];
  
  $heureDefaultApp = date("H:i");
  try {
    //récupérer le nom de agent connecter par rapport à la session
    $select_stmt = $conn->prepare("SELECT * FROM `agents` WHERE agents.id=:agentId ");
    $select_stmt->execute(array(':agentId' => $agentId));
    $userInfo = $select_stmt->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    $e->getMessage();
  }
  if (isset($_REQUEST['valider'])) {
    $valider = $_POST['valider'];
    $date_resa = $_POST['date_resa'];
    $date_resa_default = $_POST['date_resa_default'];
    $heure_resa = $_POST['heure_resa'];
    $heure_resa = $_POST['heure_resa'];
    if ($heure_resa == '') {
      $heure_resa = $heureDefaultApp;
    } else {      
      $heure_resa = $_POST['heure_resa'];
    }
    $objet_resa = $_POST['objet_resa'];
    $nature_resa = $_POST['nature_resa'];
    $statut_resa = $_POST['statut_resa'];
    $resultat_resa = $_POST['resultat_resa'];
    $genre_resa = $_POST['genre_resa'];
    // var_dump($genre_resa);
    $byagentId_resa = $_SESSION["agentsid"];
    try {
      $stmt = $conn->prepare('INSERT INTO `numvert_callinfo` VALUES ("",?, ?,?, ?, ?, ?, ? ,?,? )');
      $stmt->execute([$date_resa, $date_resa_default, $heure_resa, $objet_resa, $nature_resa, $statut_resa, $resultat_resa, $genre_resa, $byagentId_resa]);
      $loginMsg = "Insertion réussie...";
      header("refresh:2;");
    } catch (PDOException $e) {
      $e->getMessage();
    }
  }
  $dateNow = date("d-m-Y H:i:s");
  $date = date("d/m/Y");
  // echo $date;
?>
  <div class="container " style="min-height: 100vw;">
    <div class="container" style="height: 70px;"></div>
    <div class="row">
      <div class="container">
        <div class="row">
          <div class="col-3"></div>
          <div class="col-6">
            <h3 class="text-center">Bonjour, <?php echo $userInfo["first_name"]; ?></h3>
          </div>
          <div class="col-3"></div>
        </div>
      </div>
      <?php

      if (isset($loginMsg)) {
      ?>
        <div class="alert alert-success">
          <strong><?php echo $loginMsg; ?></strong>
        </div>
      <?php
      }
      ?>
      <div class="container mt-4">
        <div class="row">
          <div class="col-3"></div>
          <div class="col-6">
            <form action="" method="post">
              <div class="container">
                <div class="container-fluid  pt-2 mt-3" style="padding-left: 1px;"><label for="objet_resa" class="p-1" style="background: #2e4f9b none repeat scroll 0 0;color:white;">Informations appelant</label></div>
                <div class="container border px-3 py-2" style="background-color: #94c123;">
                  <div class="container-fluid border p-1 m-1 mb-2">
                    <div class="row">
                      <div class="col-4">
                        <label for="genre_resa">Genre</label>
                      </div>
                      <div class="col-8" id="genre_resa">
                        <div class="row">
                          <div class="col-6">
                            <input type="radio" name="genre_resa" id="genre_homme" value="2" checked>
                            <label for="genre_homme">Homme</label>
                          </div>
                          <div class="col-6">
                            <input type="radio" name="genre_resa" id="genre_femme" value="1">
                            <label for="genre_femme">Femme</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="container-fluid border p-1 m-1 mb-2">
                    <div class="row">
                      <div class="col-4">
                        <label for="nature_resa">Type</label>
                      </div>
                      <div class="col-8">
                        <select name="nature_resa" id="nature_resa" required style="width: 100%;">
                          <option value=""></option>
                          <option value="INTERESSE">INTERESSE</option>
                          <option value="PROFESSIONNEL">PROFESSIONNEL</option>
                          <option value="TIERS">TIERS</option>
                          <option value="PARTENAIRE">PARTENAIRE</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="container-fluid border p-1 m-1 mb-2">
                    <div class="row">
                      <div class="col-4">
                        <label for="statut_resa">Statut</label>
                      </div>
                      <div class="col-8">
                        <select name="statut_resa" id="statut_resa" required style="width: 100%;">
                          <option value=""></option>
                          <option value="DEMANDEUR D'EMPLOI">DEMANDEUR D'EMPLOI</option>
                          <option value="EN ACTIVITE PROFESSIONNELLE">EN ACTIVITE PROFESSIONNELLE</option>
                          <option value="ETUDIANT">ETUDIANT</option>
                          <option value="STAGIAIRE FPC">STAGIAIRE FPC</option>
                          <option value="RETRAITE">RETRAITE</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- #94C11F -->
                <div class="container-fluid pr-2 pt-2 mt-3" style="padding-left: 1px;"><label for="objet_resa" class="p-1" style="background: #2e4f9b none repeat scroll 0 0;color:white;">Informations appel</label></div>
                <div class="container border py-2" style="background-color: #86AF38; ">
                  <div class="container border p-1 m-1 mb-2">
                    <div class="row">
                      <div class="col-6">
                        <div class="row">
                          <div class="col-5">
                            <span class="p-1"> <label for="date_resa"> Date</label> </span>
                          </div>
                          <div class="col-7">
                            <input type="date" name="date_resa" id="dayNow" value="<?php echo $date ?>" required style="width: 100%;">
                            <input type="text" name="date_resa_default" id="date_resa_default" value="<?php echo $dateNow ?>" required style="width: 100%;" class="d-none">
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="row">
                          <div class="col-3">
                            <span class="p-1"> <label for="heure_resa"> Heure </label> </span>
                          </div>
                          <div class="col-9">
                            <input type="time" name="heure_resa" id="heure_resa"  value ="<?php echo $heureDefaultApp ?>" style="width: 100%;">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="container-fluid border p-1 m-1 mb-2">
                    <div class="row">
                      <div class="col-4">
                        <label for="objet_resa">Objet de l'appel</label>
                      </div>
                      <div class="col-8">
                        <select name="objet_resa" id="objet_resa" required style="width: 100%;">
                          <option value=""></option>
                          <option value="AIDE FINANCIERE">AIDE FINANCIERE</option>
                          <option value="AUTRE INFORMATION">AUTRE INFORMATION</option>
                          <option value="CONFIRMATION RCI">CONFIRMATION RCI</option>
                          <option value="COVID - Emploi / Formation">COVID - Emploi / Formation</option>
                          <option value="DISPOSITIF MOBILITE">DISPOSITIF MOBILITE</option>
                          <option value="FORMATION CONTINUE">FORMATION CONTINUE</option>
                          <option value="FORMATION INITIALE">FORMATION INITIALE</option>
                          <option value="PROJET PROFESSIONNEL">PROJET PROFESSIONNEL</option>
                          <option value="RECHERCHE EMPLOI">RECHERCHE EMPLOI</option>
                          <option value="SERVICE ENVIRONNEMENT STAGIAIRE">SERVICE ENVIRONNEMENT STAGIAIRE</option>
                          <option value="SUIVI CANDIDAT">SUIVI CANDIDAT</option>
                          <option value="VAE">VAE</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="container-fluid border p-1 m-1 mb-2">
                    <div class="row">
                      <div class="col-4">
                        <label for="resultat_resa">Résultat</label>
                      </div>
                      <div class="col-8">
                        <select name="resultat_resa" id="resultat_resa" required style="width: 100%;">
                          <option value=""></option>
                          <option value="GIEP-NC">GIEP-NC</option>
                          <option value="INFORMATION FINALE">INFORMATION FINALE</option>
                          <option value="PARTENAIRES">PARTENAIRES</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-12 col-sm-6 text-center">
                        <input type="reset" id="effacer" class="btn" value="Effacer" style="background: #f7ab59 none repeat scroll 0 0;color: maroon;">
                      </div>
                      <div class="col-12 col-sm-6 text-center">
                        <button type="submit" name="valider" class="btn btn-success">Valider</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="col-3"></div>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function() {


      var now = new Date();
      var day = ("0" + now.getDate()).slice(-2);
      var month = ("0" + (now.getMonth() + 1)).slice(-2);

      var today = now.getFullYear() + "-" + (month) + "-" + (day);
      $("#dayNow").val(today);

      $("#dayNow").change(function () {  
            var date_start = $('#dayNow').val();
            var time_start = $("#heure_resa").val();
            var rightNow = new Date();
            console.log(rightNow);
            var dateNow = rightNow.toISOString().slice(0,10);
            if ((Date.parse(date_start) > Date.parse(dateNow))) {
                alert("Attention vous effectuez une réservation pour une date futur ");
                // document.getElementById("date_start").valueAsDate = null;                
            $("#dayNow").val(today);
            }
        });
      
    });
  </script>
<?php
else :

?>
<?php
endif;
