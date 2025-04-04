<?php require_once __DIR__ . "/../shared/header.php"; ?>
    <div class="container">
        <h2 class="text-center mb-4"><?= htmlspecialchars($title); ?></h2>

        <form method="POST" action="/sherzer/public/users/update/<?= $user['id']; ?>">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token); ?>">

            <div class="form-group mb-3">
                <label for="name">Nombre:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="email">Correo:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Actualizar Usuario</button>
        </form>
    </div>

<?php require_once __DIR__ . "/../shared/footer.php"; ?>
