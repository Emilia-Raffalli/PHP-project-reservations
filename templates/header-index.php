<?php
include ("../_config.php");
include ("../function.php");
$tableShows = selectAllFromSql('shows');

$pdo = connect_db();
$query = 'SELECT * FROM shows ORDER BY startDate ASC LIMIT 3';
$statement = $pdo -> query($query);
$recentsShows = $statement ->fetchAll(PDO::FETCH_ASSOC);

var_dump($recentsShows);

// JE SOUHAITERAIS AFFICHER DANS CE HEADER INDEX LES TROIS PREMIERS SPECTACLES SOUS FORME DE BANNIERE //
?>

<!-- 
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$title?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="templates/styles.css">
  </head>
  <body>
 -->

 <!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Bootstrap Example</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body class="p-3 m-0 border-0 bd-example m-0 border-0">

    <!-- Example Code -->
    
    <div id="carouselExampleCaptions" class="carousel slide">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="" aria-label="Diapositive 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Diapositive 2" class=""></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Diapositive 3" class="active" aria-current="true"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item">
          <svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="400" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Espace réservé&nbsp;: Première diapositive" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">First slide</text></svg>
          <div class="carousel-caption d-none d-md-block">
            <h5><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Étiquette de la première diapositive</font></font></h5>
            <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Un contenu d'espace réservé représentatif pour la première diapositive.</font></font></p>
          </div>
        </div>
        <div class="carousel-item">
          <svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="400" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Espace réservé&nbsp;: Deuxième diapositive" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#666"></rect><text x="50%" y="50%" fill="#444" dy=".3em">Second slide</text></svg>
          <div class="carousel-caption d-none d-md-block">
            <h5><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Étiquette de la deuxième diapositive</font></font></h5>
            <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Un contenu d'espace réservé représentatif pour la deuxième diapositive.</font></font></p>
          </div>
        </div>
        <div class="carousel-item active">
          <svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="400" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Espace réservé&nbsp;: Troisième diapositive" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#555"></rect><text x="50%" y="50%" fill="#333" dy=".3em">Third slide</text></svg>
          <div class="carousel-caption d-none d-md-block">
            <h5><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Étiquette de la troisième diapositive</font></font></h5>
            <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Un contenu d'espace réservé représentatif pour la troisième diapositive.</font></font></p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Précédent</font></font></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Suivant</font></font></span>
      </button>
    </div>
    
    <!-- End Example Code -->
  </body>
</html>