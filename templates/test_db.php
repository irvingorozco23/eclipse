<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Conexión BD</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #0f172a; margin: 0; padding: 40px 20px; color: #f8fafc; display: flex; justify-content: center; align-items: center; min-height: 80vh; }
        .container { width: 100%; max-width: 600px; background: #1e293b; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.5); border: 1px solid #334155; text-align: center; }
        h1 { color: #f8fafc; font-weight: 300; font-size: 2.2rem; letter-spacing: 1px; margin-bottom: 30px; }
        
        .status-box { padding: 30px; border-radius: 12px; margin-bottom: 30px; animation: scaleIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .status-box.success { background-color: rgba(34, 197, 94, 0.1); border: 1px solid #22c55e; }
        .status-box.error { background-color: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; }
        
        .icon { font-size: 4rem; margin-bottom: 20px; }
        .message-title { font-size: 1.5rem; font-weight: 600; margin-bottom: 10px; }
        .success .message-title { color: #4ade80; }
        .error .message-title { color: #f87171; }
        
        .error-details { background: #0f172a; border-left: 4px solid #ef4444; text-align: left; padding: 15px; border-radius: 4px; font-family: monospace; font-size: 0.9rem; color: #cbd5e1; margin-top: 20px; overflow-x: auto; }
        
        .btn { display: inline-block; padding: 12px 24px; border-radius: 8px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; text-decoration: none; transition: transform 0.2s, box-shadow 0.2s; background: linear-gradient(135deg, #334155, #475569); color: white; border: none; cursor: pointer; margin-top: 20px; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3); }
        .btn.primary { background: linear-gradient(135deg, #0284c7, #38bdf8); }
        .btn.primary:hover { box-shadow: 0 6px 20px rgba(56, 189, 248, 0.4); }

        @keyframes scaleIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
    </style>
</head>
<body>
    <div class="container">
        <h1>Estado de la Base de Datos</h1>
        
        <?php if ($status === 'success'): ?>
            <div class="status-box success">
                <div class="icon">✅</div>
                <div class="message-title">¡Conexión Exitosa!</div>
                <p><?php echo htmlspecialchars($message); ?></p>
            </div>
        <?php elseif ($status === 'error'): ?>
            <div class="status-box error">
                <div class="icon">❌</div>
                <div class="message-title">Error de Conexión</div>
                <p>No se pudo establecer la conexión con la base de datos PostgreSQL.</p>
                <div class="error-details">
                    <strong>Detalles del error:</strong><br>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            </div>
        <?php else: ?>
            <div class="status-box">
                <div class="icon">⏳</div>
                <div class="message-title">Estado Desconocido</div>
                <p>No se pudo determinar el estado de la conexión.</p>
            </div>
        <?php endif; ?>

        <div>
            <a href="index.php" class="btn primary">Ir al Sistema</a>
            <a href="test_conexion.php" class="btn">Volver a Probar</a>
        </div>
    </div>
</body>
</html>
