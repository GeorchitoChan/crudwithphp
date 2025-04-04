<?php require_once __DIR__ . "/shared/header.php"; ?>

    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="row w-100">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 mx-auto">
                <h2 class="text-center mb-4">Iniciar Sesión</h2>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/sherzer/public/authenticate">
                    <input type="hidden" class="form-control" name="csrf_token" value="<?= htmlspecialchars($csrf_token); ?>" >
                    <div class="form-group mb-3">
                        <label for="email">Correo:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese su Correo">
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Contraseña: </label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su Contraseña">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
            </div>
        </div>
    </div>

<?php require_once __DIR__ . "/shared/footer.php"; ?>