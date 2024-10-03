<?php
$linkLog = "";
$name = "";
if (isset($_SESSION[$suser])) {
    $linkLog = "<a class='text-secondary text-decoration-none' href=\"./login.php?logout=0\">Logout</a>";
    $name = $_SESSION[$suser]['vorname'] . ', ' . $_SESSION[$suser]['name'];
} else {
    $linkLog = "<a class='text-secondary text-decoration-none' href=\"./login.php\">Login</a>";
}



?>
<div class="container">
    <footer class="d-flex flex-wrap justify-content-between  py-3 my-4 border-top">

        <span class="mb-3 mb-md-0 text-muted t"><?= $linkLog  ?></span>
        <?php if (isset($_SESSION[$suser])): ?>
            <span class="mb-3 mb-md-0 text-muted">Angemeldet als: <?= htmlspecialchars($name) ?></span>
        <?php endif; ?>
        <ul class="justify-content-evenly list-unstyled d-flex">
            <li class="ms-3 "> <a class='text-secondary text-decoration-none' href="impressum.php">Impressum & Datenschutz</a></li>
        </ul>
        <span class="mb-3 mb-md-0 text-muted "> <a class='text-secondary text-decoration-none' href="https://github.com/CBert2022">&copy; 2024 CBert2022</a></span>
    </footer>
</div>