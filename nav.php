<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Lifestyle Shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item <?= $no[0] ?> ">
                    <a class="nav-link <?= $ac[0] ?>" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item <?= $no[1] ?>  ">
                    <a class="nav-link <?= $ac[1] ?>" href="shop_liste2.php">Shop</a>
                </li>
                <li class="nav-item <?= $no[2] ?>  ">
                    <a class="nav-link <?= $ac[2] ?>" href="admin-log.php">Bestellungen</a>
                </li>
                <!-- <li class="nav-item <?= $no[3] ?>">
                    <a class="nav-link  <?= $ac[3] ?>" href="profil.php">Profil</a>
                </li> -->
                <li class="nav-item <?= $no[4] ?>  ">
                    <a class="nav-link <?= $ac[4] ?>" href="registrierung.php">Registrierung</a>
                </li>
                <li class="nav-item <?= $no[5] ?> ">
                    <a class="nav-link   <?= $ac[5] ?> " href="login.php">Login</a>
                </li>
                <li class="nav-item <?= $no[6] ?> ">
                    <a class="nav-link   <?= $ac[6] ?> " href="prod_erfassen.php">Produkte hinzufügen</a>
                </li>
                <li class="nav-item <?= $no[7] ?> ">
                    <a class="nav-link   <?= $ac[7] ?> " href="prod_liste.php">Produkte bearbeiten</a>
                </li>
                <li class="nav-item <?= $no[8] ?> ">
                    <a class="nav-link <?= $ac[8] ?> " href="shop_cart.php"><i name="cart" class="fa-solid fa-cart-shopping"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>