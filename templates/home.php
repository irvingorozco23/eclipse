<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - L'Éclipse Restaurant & Bar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold-primary: #d4af37;
            --gold-hover: #b89122;
            --dark-base: #0a0a0a;
            --dark-glass: rgba(15, 15, 15, 0.75);
            --dark-panel: rgba(25, 25, 25, 0.85);
            --border-glass: rgba(212, 175, 55, 0.2);
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
        }

        body { 
            font-family: 'Outfit', sans-serif; 
            margin: 0; padding: 0;
            color: var(--text-light);
            background: 
                radial-gradient(circle at 80% 20%, rgba(212, 175, 55, 0.08), transparent 40%),
                radial-gradient(circle at 20% 80%, rgba(180, 83, 9, 0.1), transparent 40%),
                linear-gradient(180deg, #111111 0%, #050505 100%);
            background-color: var(--dark-base);
            background-attachment: fixed;
            position: relative;
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

        .container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }

        h1, h2, h3 { 
            font-family: 'Playfair Display', serif;
            color: var(--gold-primary); font-weight: 400; letter-spacing: 1px; 
        }
        h1 { font-size: 2.8rem; margin-bottom: 5px; }
        h2 { font-size: 2rem; margin-top: 0; padding-bottom: 15px; margin-bottom: 25px; text-align: center; }

        /* Navbar */
        .navbar { 
            display: flex; justify-content: space-between; align-items: center; 
            background: var(--dark-glass); backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 20px 30px; border-radius: 12px; margin-bottom: 40px; 
            border: 1px solid var(--border-glass); 
        }
        .navbar .user-info { font-weight: 300; letter-spacing: 0.5px; }
        .navbar strong { color: var(--gold-primary); font-weight: 500; font-family: 'Playfair Display', serif; font-size:1.3rem; }
        .navbar em { color: var(--text-muted); font-style: normal; font-size: 0.85em; text-transform: uppercase; letter-spacing: 1px; background: rgba(255,255,255,0.05); padding: 4px 8px; border-radius: 4px; margin-left: 8px;}

        .nav-links a { color: var(--text-light); text-decoration: none; margin-left: 20px; font-weight: 400; transition: color 0.3s; font-size: 0.95rem; }
        .nav-links a:hover { color: var(--gold-primary); }
        .nav-links a.logout { color: #f87171; }
        .nav-links a.logout:hover { color: #ef4444; }

        /* Tier Badges */
        .tier-badge { font-size: 0.7rem; padding: 3px 10px; border-radius: 20px; margin-left: 8px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; display: inline-block; }
        .tier-bronce  { background: linear-gradient(135deg, #cd7f32, #8b4513); color: #fff; border: 1px solid #cd7f32; }
        .tier-plata   { background: linear-gradient(135deg, #c0c0c0, #808080); color: #1a1a1a; border: 1px solid #c0c0c0; }
        .tier-oro     { background: linear-gradient(135deg, #ffd700, #daa520); color: #1a1a1a; border: 1px solid #ffd700; }
        .tier-diamante { background: linear-gradient(135deg, #b9f2ff, #00bfff); color: #0a0a2e; border: 1px solid #00bfff; box-shadow: 0 0 10px rgba(0,191,255,0.4); }

        /* Hero Banner */
        .hero { position: relative; width: 100%; height: 400px; border-radius: 16px; overflow: hidden; margin-bottom: 50px; border: 1px solid var(--border-glass); box-shadow: 0 15px 40px rgba(0,0,0,0.8); }
        .hero img { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.6); }
        .hero-text { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; width: 100%; pointer-events: none; }
        .hero-text p { font-size: 1.2rem; color: #d1d5db; letter-spacing: 2px; text-transform: uppercase; }

        /* Promos */
        .promo-card { background: linear-gradient(135deg, rgba(212,175,55,0.1), rgba(180,83,9,0.1)); border: 1px solid var(--border-glass); border-radius: 12px; padding: 25px; margin-bottom: 40px; text-align: center; }
        .promo-card h3 { color: #fbbf24; margin-top:0; }
        .promo-card p { color: var(--text-muted); margin: 5px 0; }
        .promo-tag { background: rgba(251,191,36,0.15); color: #fbbf24; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; border: 1px solid rgba(251,191,36,0.3); }

        /* Menu Section */
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-bottom: 60px; }
        .menu-item { background: var(--dark-panel); border: 1px solid var(--border-glass); border-radius: 12px; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s; }
        .menu-item:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(212, 175, 55, 0.15); }
        .menu-img { width: 100%; height: 200px; object-fit: cover; border-bottom: 1px solid var(--border-glass); }
        .menu-info { padding: 20px; }
        .menu-info h3 { margin: 0 0 10px 0; font-size: 1.3rem; }
        .menu-info p { margin: 0; color: var(--text-muted); font-size: 0.9rem; line-height: 1.4; }

        /* Forms and Tables */
        .app-card { background: var(--dark-panel); backdrop-filter: blur(20px); border-radius: 12px; padding: 35px; border: 1px solid var(--border-glass); box-shadow: 0 15px 35px rgba(0,0,0,0.6); margin-bottom: 40px; }
        form { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        input, select { width: 100%; box-sizing: border-box; padding: 14px 18px; font-size: 15px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); background-color: rgba(0,0,0,0.5); color: var(--text-light); font-family: 'Outfit', sans-serif; outline: none; transition: border-color 0.3s, background-color 0.3s; }
        input:focus, select:focus { border-color: var(--gold-primary); background-color: rgba(0,0,0,0.7); }
        button { grid-column: span 2; padding: 16px; background: linear-gradient(135deg, var(--gold-primary), var(--gold-hover)); color: #000; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-family: 'Outfit', sans-serif; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 5px 15px rgba(212, 175, 55, 0.2); transition: all 0.3s ease; margin-top: 10px; }
        button:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4); }

        /* Mapas Visuales */
        .table-map { text-align: center; margin-bottom: 30px; position:relative; }
        .map-bg { background: rgba(10,10,20, 0.7); border: 2px solid rgba(212, 175, 55, 0.3); border-radius: 20px; padding: 40px; max-width: 900px; margin: 0 auto; box-shadow: inset 0 0 50px rgba(0,0,0,1); }
        .row { display: flex; justify-content: center; gap: 20px; margin-bottom: 30px; flex-wrap: wrap; }
        .stage { background: #3b0707; border-top: 4px solid #f87171; border-radius: 6px; padding: 20px; margin: 30px auto 0; width: 60%; color: white; font-weight: bold; letter-spacing: 2px; text-transform: uppercase; box-shadow: 0 -10px 40px rgba(248, 113, 113, 0.4); }
        .dance-floor { border: 2px dashed #bf00ff; border-radius: 50%; width: 250px; height: 150px; margin: 30px auto; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #bf00ff; box-shadow: 0 0 30px rgba(191, 0, 255, 0.3); }
        .bar-area { background: #1f2937; padding: 15px; border-radius: 8px; margin-bottom: 30px; color: #9ca3af; letter-spacing: 1px; font-weight: bold; border-bottom: 3px solid #60a5fa; }
        
        .seat { position:relative; width: 65px; height: 65px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; box-shadow: 0 4px 10px rgba(0,0,0,0.5); font-size: 0.9rem; transition: transform 0.2s; cursor: pointer; }
        .seat::before { content: ''; position: absolute; inset: -8px; border-radius: inherit; border: 4px dashed rgba(255,255,255,0.4); pointer-events: none; transition: border-color 0.3s; }
        .seat.green { background: radial-gradient(circle at 30% 30%, #4ade80, #166534); border: 2px solid #22c55e; }
        .seat.red { background: radial-gradient(circle at 30% 30%, #f87171, #991b1b); border: 2px solid #ef4444; }
        .seat.locked { background: radial-gradient(circle at 30% 30%, #6b7280, #374151); border: 2px solid #4b5563; cursor: not-allowed; opacity: 0.5; }
        .seat.locked::before { border-color: rgba(107,114,128,0.3); }
        .seat.rect { border-radius: 12px; width: 95px; height: 60px; }
        .seat:hover { transform: scale(1.1); box-shadow: 0 8px 20px rgba(0,0,0,0.8); z-index: 10; }
        .seat:hover::before { border-color: rgba(255,255,255,0.8); }
        .seat.selected { transform: scale(1.15); box-shadow: 0 0 25px #60a5fa; border-color: #60a5fa; z-index: 10; }
        .seat.selected::before { border-color: #60a5fa; border-style: solid; box-shadow: inset 0 0 10px #60a5fa; }
        .night-grid .seat { border-radius: 12px; width: 80px; height: 80px; font-size: 0.85rem;}
        
        /* Night Mode */
        body.night-mode {
            --gold-primary: #ff007f; --gold-hover: #e60073; --dark-base: #05051a; 
            --border-glass: rgba(255, 0, 127, 0.4);
            background: radial-gradient(circle at 80% 20%, rgba(255, 0, 127, 0.15), transparent 40%), radial-gradient(circle at 20% 80%, rgba(0, 255, 255, 0.1), transparent 40%), linear-gradient(180deg, #050510 0%, #000000 100%);
            background-color: var(--dark-base);
        }
        body.night-mode h1, body.night-mode h2, body.night-mode h3 { text-shadow: 0 0 10px rgba(255, 0, 127, 0.6); }
        body.night-mode .hero img { filter: brightness(0.5) hue-rotate(280deg); }
        body.night-mode button { background: linear-gradient(135deg, var(--gold-primary), #bf00ff); color: #fff; }

        /* Cabaret Mode (deeper purple) */
        body.cabaret-mode {
            --gold-primary: #9333ea; --gold-hover: #7e22ce; --dark-base: #0a0014;
            --border-glass: rgba(147, 51, 234, 0.4);
            background: radial-gradient(circle at 80% 20%, rgba(147, 51, 234, 0.2), transparent 40%), radial-gradient(circle at 20% 80%, rgba(236, 72, 153, 0.15), transparent 40%), linear-gradient(180deg, #0a0014 0%, #000000 100%);
            background-color: var(--dark-base);
        }
        body.cabaret-mode h1, body.cabaret-mode h2, body.cabaret-mode h3 { text-shadow: 0 0 15px rgba(147, 51, 234, 0.7); }
        body.cabaret-mode button { background: linear-gradient(135deg, #9333ea, #ec4899); color: #fff; }

        table { width: 100%; border-collapse: separate; border-spacing: 0; }
        th, td { padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.05); text-align: left; }
        th { color: var(--gold-primary); font-weight: 500; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px; background: rgba(0,0,0,0.3); }
        tr:hover td { background-color: rgba(212, 175, 55, 0.05); }

        .success, .error { text-align: center; font-weight: 400; padding: 15px; border-radius: 8px; margin-bottom: 30px; backdrop-filter: blur(4px); }
        .success { background-color: rgba(34, 197, 94, 0.1); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.3); }
        .error { background-color: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); }

        .night-hint { color: var(--text-muted); font-size: 0.8rem; margin-top: 5px; font-style: italic; }

        @media (max-width: 768px) {
            form { grid-template-columns: 1fr; }
            button { grid-column: span 1; }
            .navbar { flex-direction: column; gap: 15px; text-align: center; }
            .nav-links a { margin: 0 10px; }
        }
    </style>
</head>
<body>
    <?php 
        $isMesero = isset($_SESSION['role']) && ($_SESSION['role'] === 'mesero' || $_SESSION['role'] === 'admin');
        $userTier = $_SESSION['tier'] ?? '';
        $userRole = $_SESSION['role'] ?? '';
    ?>
    <div class="container">
        
        <div class="navbar">
            <div class="user-info">
                <strong>L'Éclipse</strong> &nbsp;|&nbsp;
                Usuario: <?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?> 
                <em><?php echo htmlspecialchars($userRole); ?></em>
                <?php if($userTier): ?>
                    <span class="tier-badge tier-<?php echo $userTier; ?>"><?php echo strtoupper($userTier); ?></span>
                <?php endif; ?>
            </div>
            <div class="nav-links">
                <?php if(!$isMesero): ?>
                    <a href="#menu">Nuestro Menú</a>
                <?php endif; ?>
                <a href="#reservas">Reservaciones</a>
                <?php if($isMesero): ?>
                    <a href="#" id="toggleNightMode">🌙 Modo Night</a>
                    <span class="night-hint">(Doble clic = Cabaret)</span>
                <?php endif; ?>
                
                <?php if(in_array($userRole, ['admin', 'gerente'])): ?>
                    <a href="index.php?view=report&action=view">Reportes VIP</a>
                <?php endif; ?>
                <a href="index.php?view=auth&action=logout" class="logout">Salir</a>
            </div>
        </div>

        <?php if(!$isMesero): ?>
        <div class="hero">
            <img src="https://images.unsplash.com/photo-1514933651103-005eec06c04b?q=80&w=1500&auto=format&fit=crop" alt="Restaurant Interior">
            <div class="hero-text">
                <h1>Vive la Experiencia L'Éclipse</h1>
                <p>Gastronomía de Autor & Nightlife Lounge</p>
            </div>
        </div>

        <!-- PROMOS DEL DÍA (Solo plata, oro, diamante) -->
        <?php if(in_array($userTier, ['plata', 'oro', 'diamante'])): ?>
        <div class="promo-card">
            <h3>🔥 Promociones del Día — Exclusivo para ti</h3>
            <p><span class="promo-tag">2x1</span> en Cocktails de Autor (Lunes a Jueves, 18:00–20:00)</p>
            <p><span class="promo-tag">-30%</span> Corte Tomahawk en cena para 2 personas</p>
            <p><span class="promo-tag">GRATIS</span> Postre de cortesía al reservar zona lounge</p>
        </div>
        <?php endif; ?>

        <div id="menu">
            <h2>Nuestra Especialidad</h2>
            <div class="menu-grid">
                <div class="menu-item">
                    <img class="menu-img" src="https://images.unsplash.com/photo-1544148103-0773bf10d330?q=80&w=600&auto=format&fit=crop" alt="Platillo Signature">
                    <div class="menu-info">
                        <h3>Corte Tomahawk Oro</h3>
                        <p>Corte premium madurado a 40 días, flameado en brandy a la mesa y servido con infusión de romero fresco.</p>
                    </div>
                </div>
                <div class="menu-item">
                    <img class="menu-img" src="https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=600&auto=format&fit=crop" alt="Cocktail Mixology">
                    <div class="menu-info">
                        <h3>Mixología "Eclipse"</h3>
                        <p>Nuestro coctel insignia con Gin botánico, esencias cítricas oscuras, y humo de cardamomo encapsulado.</p>
                    </div>
                </div>
                <div class="menu-item">
                    <img class="menu-img" src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=600&auto=format&fit=crop" alt="Lounge Privado">
                    <div class="menu-info">
                        <h3>Experiencia Privada (VIP)</h3>
                        <p>Acceso exclusivo a salas apartadas con servicio de sommelier y mixólogo personal (Solo socios).</p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if(isset($_GET['success'])): ?>
            <div class="success">✓ Tu reservación ha sido confirmada y procesada.</div>
        <?php endif; ?>

        <?php if(isset($_GET['error']) && $_GET['error'] == 'not_vip'): ?>
            <div class="error">❌ Acceso Denegado: Tienes que ser 'Miembro Oficial' para rentar un área privada o VIP.</div>
        <?php endif; ?>
        <?php if(isset($_GET['error']) && $_GET['error'] == 'past_date'): ?>
            <div class="error">❌ Fecha Inválida: No es posible reservar en una fecha u hora que ya ha transcurrido.</div>
        <?php endif; ?>
        <?php if(isset($_GET['error']) && $_GET['error'] == 'table_occupied'): ?>
            <div class="error">❌ Mesa Ocupada: Esa mesa ya se encuentra agendada para ese día.</div>
        <?php endif; ?>
        <?php if(isset($_GET['error']) && $_GET['error'] == 'no_antro'): ?>
            <div class="error">❌ Acceso Restringido: Necesitas membresía <strong>Oro</strong> o <strong>Diamante</strong> para reservar en el Antro.</div>
        <?php endif; ?>
        <?php if(isset($_GET['error']) && $_GET['error'] == 'no_cabaret'): ?>
            <div class="error">❌ Acceso Restringido: Necesitas membresía <strong>Diamante</strong> para acceder al Cabaret VIP.</div>
        <?php endif; ?>


        <!-- ==================== MAPA DE ZONAS ==================== -->
        <div class="app-card" id="seating-chart">
            <h2>Mapa de Zonas Arquitectónico (Clic para Seleccionar)</h2>

            <?php 
            if(isset($all_tables)) {
                $tables_array = $all_tables->fetchAll(PDO::FETCH_ASSOC);
                $resto_tables   = array_filter($tables_array, function($t) { return ($t['zone'] ?? 'restaurant') === 'restaurant'; });
                $antro_tables   = array_filter($tables_array, function($t) { return ($t['zone'] ?? '') === 'antro'; });
                $cabaret_tables = array_filter($tables_array, function($t) { return ($t['zone'] ?? '') === 'cabaret'; });

                // Determinar acceso del cliente a las zonas
                $canAntro   = $isMesero || in_array($userTier, ['oro', 'diamante']);
                $canCabaret = $isMesero || $userTier === 'diamante';
            }
            ?>

            <!-- MAPA 1: RESTAURANTE (Siempre visible por defecto) -->
            <div id="map-restaurant" class="table-map">
                <h3>🍽️ Plano 1er Piso — Restaurante (Anfiteatro)</h3>
                <div class="map-bg">
                    <?php 
                    if(isset($resto_tables)) {
                        $resto_indexed = array_values($resto_tables);
                        $render_row = function($start, $count, $is_rect=false) use ($resto_indexed) {
                            $slice = array_slice($resto_indexed, $start, $count);
                            echo "<div class='row'>";
                            foreach($slice as $t) {
                                $color = ($t['status'] == 'occupied' || $t['status'] == 'pending') ? 'red' : 'green';
                                $rect_class = $is_rect ? 'rect' : '';
                                echo "<div class='seat $color $rect_class' data-id='{$t['id']}' data-zone='restaurant' title='Cap. {$t['capacity']} pax'>T-{$t['number']}</div>";
                            }
                            echo "</div>";
                        };
                        $render_row(0, 4, true);  
                        $render_row(4, 6);       
                        $render_row(10, 8);       
                        $render_row(18, 5);      
                    }
                    ?>
                    <div class="stage">🎙️ ESCENARIO PRINCIPAL</div>
                </div>
            </div>
            
            <!-- MAPA 2: ANTRO / SÓTANO (Solo visible en Night Mode clic 1) -->
            <div id="map-antro" class="table-map" style="display:none;">
                <h3>🪩 Sótano — Antro & Disco</h3>
                <?php if(!$canAntro && isset($canAntro)): ?>
                    <p style="color:#f87171; font-weight:500;">🔒 Necesitas membresía <strong>Oro</strong> o <strong>Diamante</strong> para acceder a esta zona.</p>
                <?php endif; ?>
                <div class="map-bg" style="border-color: rgba(255, 0, 127, 0.4); box-shadow: inset 0 0 80px rgba(0,0,0,0.8);">
                    <div class="bar-area">🍸 BARRA CENTRAL</div>
                    <?php 
                    if(isset($antro_tables)) {
                        $antro_indexed = array_values($antro_tables);
                        $antro_render = function($start, $count) use ($antro_indexed, $canAntro) {
                            $slice = array_slice($antro_indexed, $start, $count);
                            echo "<div class='row night-grid'>";
                            foreach($slice as $t) {
                                $color = ($t['status'] == 'occupied' || $t['status'] == 'pending') ? 'red' : 'green';
                                $lock = (!$canAntro) ? 'locked' : '';
                                if($lock) $color = 'locked';
                                echo "<div class='seat $color' data-id='{$t['id']}' data-zone='antro' title='Cap. {$t['capacity']} pax'>A-{$t['number']}</div>";
                            }
                            echo "</div>";
                        };
                        $antro_render(0, 3);
                        echo "<div class='row night-grid' style='align-items:center;'>";
                            echo "<div style='display:flex; flex-direction:column; gap:20px;'>"; $antro_render(3, 1); echo "</div>";
                            echo "<div class='dance-floor'>💃 PISTA DE BAILE</div>";
                            echo "<div style='display:flex; flex-direction:column; gap:20px;'>"; $antro_render(4, 1); echo "</div>";
                        echo "</div>";
                        $antro_render(5, 3);
                    }
                    ?>
                    <div class="stage" style="border-color: #bf00ff; color:#fff; background:#1a0525; box-shadow: 0 -10px 40px rgba(191, 0, 255, 0.3);">🎧 DJ BOOTH / SHOWTIME</div>
                </div>
            </div>

            <!-- MAPA 3: CABARET (Solo visible en Night Mode doble clic) -->
            <div id="map-cabaret" class="table-map" style="display:none;">
                <h3>👠 2do Piso — Cabaret VIP (Exclusivo Diamante)</h3>
                <?php if(!$canCabaret && isset($canCabaret)): ?>
                    <p style="color:#f87171; font-weight:500;">🔒 Necesitas membresía <strong>Diamante</strong> para acceder al Cabaret VIP.</p>
                <?php endif; ?>
                <div class="map-bg" style="border-color: rgba(147, 51, 234, 0.4); box-shadow: inset 0 0 80px rgba(30,0,50,0.9);">
                    <div class="bar-area" style="border-color: #9333ea; color: #c084fc;">🍾 CHAMPAGNE LOUNGE</div>
                    <?php 
                    if(isset($cabaret_tables)) {
                        $cab_indexed = array_values($cabaret_tables);
                        $cab_render = function($start, $count) use ($cab_indexed, $canCabaret) {
                            $slice = array_slice($cab_indexed, $start, $count);
                            echo "<div class='row night-grid'>";
                            foreach($slice as $t) {
                                $color = ($t['status'] == 'occupied' || $t['status'] == 'pending') ? 'red' : 'green';
                                $lock = (!$canCabaret) ? 'locked' : '';
                                if($lock) $color = 'locked';
                                echo "<div class='seat $color' data-id='{$t['id']}' data-zone='cabaret' title='Cap. {$t['capacity']} pax' style='border-radius:12px;'>CAB-{$t['number']}</div>";
                            }
                            echo "</div>";
                        };
                        $cab_render(0, 4);
                        $cab_render(4, 4);
                    }
                    ?>
                    <div class="stage" style="border-color: #9333ea; color:#e9d5ff; background: linear-gradient(180deg, #1a0525, #2d0040); box-shadow: 0 -10px 40px rgba(147, 51, 234, 0.4);">👠 ESCENARIO CABARET / GO-GOs</div>
                </div>
            </div>
        </div>

        <!-- ==================== FORMULARIO ==================== -->
        <div id="reservas" class="app-card">
            <h2>Formulario de Reservación</h2>
            <form action="index.php?view=reservation&action=create" method="POST">
                <div>
                    <input type="text" name="customer_name" placeholder="Nombre completo" required>
                </div>
                <div>
                    <input type="email" name="customer_email" placeholder="Correo de contacto" required>
                </div>
                <div>
                    <input type="datetime-local" name="reservation_date" style="color-scheme: dark;" min="<?php echo date('Y-m-d\TH:i'); ?>" required>
                </div>
                <div>
                    <select name="table_id" id="table_select" required>
                        <option value="" disabled selected>Selecciona tu espacio en el mapa (o lista)...</option>
                        <?php 
                        if (isset($tables_array)) {
                            foreach ($tables_array as $row): 
                                $z = $row['zone'] ?? 'restaurant';
                                $prefix = $z === 'cabaret' ? 'CAB-' : ($z === 'antro' ? 'A-' : 'T-');
                                $zoneLabel = strtoupper($z);
                        ?>
                                <option value="<?php echo $row['id']; ?>">
                                    <?php echo $prefix . $row['number']; ?> [<?php echo $zoneLabel; ?>] — (Cap. <?php echo $row['capacity']; ?> pax)
                                    <?php echo ($row['status'] == 'occupied') ? ' ❌ [OCUPADA]' : ''; ?>
                                </option>
                        <?php 
                            endforeach; 
                        }
                        ?>
                    </select>
                </div>
                <button type="submit">Solicitar Reservación</button>
            </form>
        </div>

        <!-- ==================== AGENDA MESEROS ==================== -->
        <?php if($isMesero): ?>
        <div class="app-card">
            <h2>Agenda de Hoy / Control Meseros</h2>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Invt. Vip/Nombre</th>
                            <th>Fecha</th>
                            <th>Área</th>
                            <th>Status</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $reservations->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td>#<?php echo str_pad($row['id'], 4, '0', STR_PAD_LEFT); ?></td>
                            <td style="font-weight: 500;"><?php echo htmlspecialchars($row['customer_name']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($row['reservation_date'])); ?></td>
                            <td>Mesa <?php echo $row['table_number']; ?></td>
                            <td>
                                <span style="background: rgba(212, 175, 55, 0.1); color: var(--gold-primary); padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 500; border: 1px solid rgba(212, 175, 55, 0.3); text-transform: uppercase;">
                                    <?php echo ucfirst($row['status']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if($row['status'] == 'pending'): ?>
                                    <a href="index.php?view=reservation&action=update_status&id=<?php echo $row['id']; ?>&status=confirmed" style="color: #4ade80; text-decoration: none; font-size: 0.9em; margin-right: 8px;">✓</a>
                                    <a href="index.php?view=reservation&action=update_status&id=<?php echo $row['id']; ?>&status=cancelled" style="color: #f87171; text-decoration: none; font-size: 0.9em;">✗</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php if ($reservations->rowCount() == 0): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">
                                No hay reservaciones registradas por ahora.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <script>
        const nightModeBtn = document.getElementById('toggleNightMode');
        let nightState = localStorage.getItem('nightState') || 'day'; // day | antro | cabaret
        let dblClickTimer = null;

        function setMapView(state) {
            const mapResto   = document.getElementById('map-restaurant');
            const mapAntro   = document.getElementById('map-antro');
            const mapCabaret = document.getElementById('map-cabaret');

            // Reset
            document.body.classList.remove('night-mode', 'cabaret-mode');
            if(mapResto)   mapResto.style.display   = 'none';
            if(mapAntro)   mapAntro.style.display   = 'none';
            if(mapCabaret) mapCabaret.style.display  = 'none';

            if (state === 'antro') {
                document.body.classList.add('night-mode');
                if(mapAntro) mapAntro.style.display = 'block';
            } else if (state === 'cabaret') {
                document.body.classList.add('cabaret-mode');
                if(mapCabaret) mapCabaret.style.display = 'block';
            } else {
                if(mapResto) mapResto.style.display = 'block';
            }

            nightState = state;
            localStorage.setItem('nightState', state);
        }

        // Restaurar estado al cargar
        if (nightModeBtn) {
            setMapView(nightState);
        } else {
            // Clientes: solo ven restaurante
            setMapView('day');
        }

        // Lógica de clic/doble-clic
        if(nightModeBtn) {
            nightModeBtn.addEventListener('click', function(e) {
                e.preventDefault();

                if (dblClickTimer) {
                    // DOBLE CLIC -> Cabaret
                    clearTimeout(dblClickTimer);
                    dblClickTimer = null;
                    setMapView(nightState === 'cabaret' ? 'day' : 'cabaret');
                } else {
                    // Esperar para ver si es doble clic
                    dblClickTimer = setTimeout(function() {
                        dblClickTimer = null;
                        // CLIC SIMPLE -> Antro (toggle)
                        if (nightState === 'antro') {
                            setMapView('day');
                        } else {
                            setMapView('antro');
                        }
                    }, 300);
                }
            });
        }

        // Selección gráfica de asiento
        document.querySelectorAll('.seat').forEach(seat => {
            seat.addEventListener('click', function() {
                if (this.classList.contains('red') || this.classList.contains('locked')) {
                    if(this.classList.contains('locked')) {
                        alert('🔒 No tienes acceso a esta zona. Actualiza tu membresía.');
                    } else {
                        alert('Esta mesa ya se encuentra ocupada. Selecciona una en verde.');
                    }
                    return;
                }
                
                const tableId = this.dataset.id;
                const selectElement = document.getElementById('table_select');
                
                if(selectElement && tableId) {
                    selectElement.value = tableId;
                    document.querySelectorAll('.seat').forEach(s => s.classList.remove('selected'));
                    this.classList.add('selected');
                    selectElement.style.border = '2px solid #60a5fa';
                    setTimeout(() => selectElement.style.border = '1px solid rgba(255,255,255,0.1)', 1000);
                }
            });
        });
    </script>
</body>
</html>
