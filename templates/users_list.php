<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios (Orientado a Objetos)</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #0f172a; margin: 0; padding: 40px 20px; color: #f8fafc; }
        .container { max-width: 1000px; margin: auto; background: #1e293b; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.5); border: 1px solid #334155; }
        h1 { color: #38bdf8; text-align: center; margin-bottom: 30px; font-weight: 300; }
        table { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 20px; border-radius: 8px; overflow: hidden; }
        th, td { padding: 15px; border-bottom: 1px solid #334155; text-align: left; }
        th { background-color: #0f172a; color: #38bdf8; font-weight: 600; text-transform: uppercase; font-size: 0.9rem; }
        tr:hover td { background-color: #334155; transition: background-color 0.3s; }
        .hash { font-family: monospace; color: #cbd5e1; font-size: 0.85rem; background: #0f172a; padding: 5px 10px; border-radius: 6px; }
        .role { background: #3b82f6; color: white; padding: 4px 10px; border-radius: 12px; font-size: 0.85rem; text-transform: uppercase; }
        .btn { display: inline-block; padding: 10px 20px; margin-top: 20px; border-radius: 8px; text-decoration: none; background: linear-gradient(135deg, #0284c7, #38bdf8); color: white; border: none; cursor: pointer; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <h1>👥 Usuarios (MVC y Singleton)</h1>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Contraseña (Hash Bcrypt)</th>
                    <th>Rol</th>
                    <th>Fecha de Creación</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($users->rowCount() > 0): ?>
                    <?php while ($user = $users->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td>#<?php echo $user['id']; ?></td>
                        <td><strong><?php echo htmlspecialchars($user['username']); ?></strong></td>
                        <td><span class="hash"><?php echo htmlspecialchars($user['password']); ?></span></td>
                        <td><span class="role"><?php echo htmlspecialchars($user['role']); ?></span></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: #94a3b8;">No hay usuarios registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="index.php" class="btn">Volver al Sistema</a>
        </div>
    </div>
</body>
</html>
