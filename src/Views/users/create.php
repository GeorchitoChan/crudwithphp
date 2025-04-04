<?php require_once __DIR__ . "/../shared/header.php"; ?>

    <div class="container">
        <h2 class="text-center mb-4"><?= htmlspecialchars($title); ?></h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="/sherzer/public/users/store">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token); ?>">

            <div class="form-group mb-3">
                <label for="name">Nombre:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" required>
            </div>
            <div class="form-group mb-3">
                <label for="email">Correo:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Correo electrónico" required>
            </div>
            <div class="form-group mb-3">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Crear Usuario</button>
        </form>
    </div>

<?php require_once __DIR__ . "/../shared/footer.php"; ?>
