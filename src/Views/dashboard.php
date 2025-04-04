<?php
    use Core\Auth;

    require_once __DIR__ . "/shared/header.php";
?>

<h1>Bienvenido, <?= htmlspecialchars(Auth::getUser()['name']); ?>!</h1>
<a href="logout">Cerrar Sesión</a>

<?php require_once __DIR__ . "/shared/footer.php"; ?>
