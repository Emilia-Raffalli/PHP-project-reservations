<nav class="navbar navbar-expand-lg bg-body-tertiary navbar bg-dark border-bottom border-body" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">LOGO</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
           <a class="nav-link" href="logout.php">Se deconnecter</a>
        </li>
        <?php if (isset($_SESSION)) : ?>
          <li class="nav-item">
            <a class="nav-link disabled" aria-disabled="true"><?=$_SESSION['firstName']?></a>
          </li>
        <?php endif?>
      </ul>
      <form action ="search.php" class="d-flex align-center" role="search" method="POST">
        <label for="title"></label>
        <input class="form-control m-3" type="search" name="title" placeholder="Titre du spectacle" aria-label="Search">

        <label for="day"></label>
        <input class="form-control m-3" type="date" name="day" placeholder="Jour de représentation" aria-label="Search" >

        <label for="theater"></label>
        <input class="form-control m-3" type="text" name="theater" placeholder="Théâtre" aria-label="Search">

        <button class="btn btn-outline-light" type="submit">Rechercher</button>
      </form>
      <a href ="cart.php"><i class="fa-solid m-3 fa-cart-shopping" style="color: #ffffff;"></i></a>
      <a href ="mon-compte.php"> <i class="fa-solid m-3 fa-user" style="color: #ffffff;"></i></a>

    </div>
  </div>
</nav>

