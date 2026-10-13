<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes Exclusivos - L'Éclipse</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold-primary: #d4af37;
            --amber-accent: #b45309;
            --dark-base: #0a0a0a;
            --dark-glass: rgba(15, 15, 15, 0.75);
            --dark-panel: rgba(25, 25, 25, 0.85);
            --border-glass: rgba(212, 175, 55, 0.2);
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
        }

        body { 
            font-family: 'Outfit', sans-serif; 
            margin: 0; 
            padding: 0;
            color: var(--text-light);
            background: 
                radial-gradient(circle at 10% 90%, rgba(212, 175, 55, 0.08), transparent 35%),
                radial-gradient(circle at 90% 10%, rgba(180, 83, 9, 0.1), transparent 35%),
                linear-gradient(180deg, #111111 0%, #050505 100%);
            background-color: var(--dark-base);
            background-attachment: fixed;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('https://www.transparenttextures.com/patterns/stardust.png');
            opacity: 0.1;
            pointer-events: none;
            z-index: -1;
        }

        .container { 
            max-width: 1000px; 
            margin: 40px auto; 
            padding: 0 20px;
        }

        h1, h2 { 
            font-family: 'Playfair Display', serif;
            color: var(--gold-primary); 
            font-weight: 400; 
            letter-spacing: 1px; 
        }

        h1 { font-size: 2.2rem; margin-bottom: 30px; text-align: center;}
        h2 { font-size: 1.5rem; margin-top: 0; border-bottom: 1px solid var(--border-glass); padding-bottom: 15px; margin-bottom: 25px; }

        .navbar { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            background: var(--dark-glass); 
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 20px 30px; 
            border-radius: 12px; 
            margin-bottom: 40px; 
            border: 1px solid var(--border-glass); 
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .navbar .user-info { font-weight: 300; letter-spacing: 0.5px; }
        .navbar strong { color: var(--gold-primary); font-weight: 500; }
        .navbar em { color: var(--amber-accent); font-style: normal; font-size: 0.85em; text-transform: uppercase; letter-spacing: 1px;}

        .nav-links a { 
            color: var(--text-light); 
            text-decoration: none; 
            margin-left: 20px; 
            font-weight: 400; 
            transition: color 0.3s;
            font-size: 0.95rem;
        }

        .nav-links a:hover { color: var(--gold-primary); }
        .nav-links a.logout { color: #f87171; }
        .nav-links a.logout:hover { color: #ef4444; }

        .stats-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); 
            gap: 25px; 
            margin-bottom: 40px; 
        }

        .stat-card { 
            background: var(--dark-panel); 
            backdrop-filter: blur(15px);
            padding: 30px 20px; 
            border-radius: 12px; 
            border: 1px solid rgba(255,255,255,0.05);
            border-top: 2px solid var(--gold-primary);
            text-align: center; 
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(212, 175, 55, 0.15);
        }

        .stat-card h3 { 
            margin: 0; 
            font-size: 0.95rem; 
            color: var(--text-muted); 
            font-weight: 400; 
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-card .value { 
            font-family: 'Playfair Display', serif;
            font-size: 3rem; 
            color: var(--gold-primary); 
            font-weight: 600; 
            margin-top: 15px; 
            text-shadow: 0 0 15px rgba(212, 175, 55, 0.3);
        }

        .table-card {
            background: var(--dark-panel);
            backdrop-filter: blur(20px);
            border-radius: 12px;
            padding: 35px;
            border: 1px solid var(--border-glass);
            box-shadow: 0 15px 35px rgba(0,0,0,0.6);
        }

        table { 
            width: 100%; 
            border-collapse: separate; 
            border-spacing: 0; 
        }

        th, td { 
            padding: 16px 20px; 
            border-bottom: 1px solid rgba(255,255,255,0.05); 
            text-align: left; 
        }

        th { 
            color: var(--gold-primary); 
            font-weight: 500; 
            text-transform: uppercase; 
            font-size: 0.85rem; 
            letter-spacing: 1px;
        }

        tr { transition: background-color 0.3s; }
        tr:hover td { background-color: rgba(212, 175, 55, 0.05); }
        tr:last-child td { border-bottom: none; }

        @media (max-width: 768px) {
            .navbar { flex-direction: column; gap: 15px; text-align: center; }
            .nav-links a { margin: 0 10px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="navbar">
            <div class="user-info">
                <strong>L'Éclipse</strong> &nbsp;|&nbsp;
                Gerencia: <?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?> 
                (<em><?php echo htmlspecialchars($_SESSION['role'] ?? ''); ?></em>)
            </div>
            <div class="nav-links">
                <a href="index.php?view=reservation&action=list">🔙 Volver a Sala</a>
                <a href="index.php?view=auth&action=logout" class="logout">Cerrar Sesión</a>
            </div>
        </div>

        <h1>📊 Métricas del Establecimiento</h1>
        <div style="text-align: center; margin-bottom: 30px;">
            <a href="index.php?view=report&action=download" style="display: inline-block; padding: 12px 24px; background: rgba(220, 38, 38, 0.15); border: 1px solid rgba(220, 38, 38, 0.3); color: #fca5a5; font-family: 'Outfit', sans-serif; font-weight: 500; text-transform: uppercase; text-decoration: none; border-radius: 8px; backdrop-filter: blur(10px); box-shadow: 0 4px 15px rgba(220, 38, 38, 0.15); transition: all 0.3s ease;">
                📄 Descargar Reporte en PDF
            </a>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Reservas Históricas</h3>
                <div class="value"><?php echo $totalReservations; ?></div>
            </div>
            <?php foreach ($statusCounts as $statusRow): ?>
            <div class="stat-card">
                <h3>Estado: <?php echo ucfirst($statusRow['status']); ?></h3>
                <div class="value"><?php echo $statusRow['count']; ?></div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="table-card">
            <h2>Áreas Más Solicitadas</h2>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Área / Número de Mesa</th>
                            <th>Frecuencia de Uso</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($topTables as $table): ?>
                        <tr>
                            <td>Área VIP #<?php echo $table['number']; ?></td>
                            <td style="color: var(--gold-primary); font-weight: 500;"><?php echo $table['used_count']; ?> reservaciones</td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($topTables)): ?>
                        <tr>
                            <td colspan="2" style="text-align: center; color: var(--text-muted); padding: 30px;">
                                No hay datos disponibles para procesar.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
