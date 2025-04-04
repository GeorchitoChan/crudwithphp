<?php require_once __DIR__ . "/../shared/header.php"; ?>
    <div class="container">
        <h2 class="text-center mb-4"><?= htmlspecialchars($title); ?></h2>

        <div class="mb-4">
            <a href="/sherzer/public/users/create" class="btn btn-success btn-sm">Agregar Nuevo Usuario</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']); ?></td>
                        <td><?= htmlspecialchars($user['name']); ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td>
                            <a href="/sherzer/public/users/edit/<?= $user['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="/sherzer/public/users/destroy/<?= $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php require_once __DIR__ . "/../shared/footer.php"; ?>
