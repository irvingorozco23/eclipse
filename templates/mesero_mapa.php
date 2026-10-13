<!-- ==================== MAPA DE ZONAS (Solo Meseros) ==================== -->
<div class="app-card" id="seating-chart">
    <h2>Mapa de Zonas Arquitectónico (Clic para Seleccionar)</h2>

    <?php 
    if(isset($all_tables)) {
        $tables_array = $all_tables->fetchAll(PDO::FETCH_ASSOC);
        $resto_tables   = array_filter($tables_array, function($t) { return ($t['zone'] ?? 'restaurant') === 'restaurant'; });
        $antro_tables   = array_filter($tables_array, function($t) { return ($t['zone'] ?? '') === 'antro'; });
        $cabaret_tables = array_filter($tables_array, function($t) { return ($t['zone'] ?? '') === 'cabaret'; });

        // Como esto solo lo ve el mesero, tiene acceso total visualmente
        $canAntro   = true;
        $canCabaret = true;
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
    
    <!-- MAPA 2: ANTRO / SÓTANO (Visible en Night Mode clic 1) -->
    <div id="map-antro" class="table-map" style="display:none;">
        <h3>🪩 Sótano — Antro & Disco</h3>
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

    <!-- MAPA 3: CABARET (Visible en Night Mode doble clic) -->
    <div id="map-cabaret" class="table-map" style="display:none;">
        <h3>👠 2do Piso — Cabaret VIP (Exclusivo Diamante)</h3>
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

<!-- Contenedores Interactivos Separados -->
<div id="zona-antro" class="area-interactiva">
    <h2>Zona Antro</h2>
    <!-- Contenido del antro -->
</div>

<div id="zona-cabaret" style="display: none;" class="area-interactiva">
    <h2>Zona Cabaret (Diamante)</h2>
    <!-- Contenido del cabaret -->
</div>

<!-- ==================== LÓGICA DE JAVASCRIPT ==================== -->
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
    }

    // Lógica del botón de la barra de navegación (clic / doble-clic)
    if (nightModeBtn) {
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
            
            if (selectElement && tableId) {
                selectElement.value = tableId;
                document.querySelectorAll('.seat').forEach(s => s.classList.remove('selected'));
                this.classList.add('selected');
                selectElement.style.border = '2px solid #60a5fa';
                setTimeout(() => selectElement.style.border = '1px solid rgba(255,255,255,0.1)', 1000);
            }
        });
    });

    // Lógica del contenedor Zona Antro / Doble Clic
    document.addEventListener('DOMContentLoaded', () => {
        // Obtenemos el rol dinámicamente desde PHP. Al estar en esta vista, sabemos que es mesero, pero reforzamos la seguridad.
        const rolUsuario = '<?php echo $_SESSION["role"] ?? ""; ?>'; 
        const zonaAntro = document.getElementById('zona-antro');
        const zonaCabaret = document.getElementById('zona-cabaret');

        if (zonaAntro && zonaCabaret) {
            zonaAntro.addEventListener('dblclick', () => {
                // Validación estricta: Solo si el rol inyectado por backend es mesero
                if (rolUsuario === 'mesero') {
                    // Alternar la visibilidad del cabaret
                    if (zonaCabaret.style.display === 'none') {
                        zonaCabaret.style.display = 'block';
                        zonaCabaret.classList.add('animacion-aparecer');
                    } else {
                        zonaCabaret.style.display = 'none';
                    }
                } else {
                    console.log("Acceso denegado: Se requiere rol de mesero.");
                }
            });
        }
    });
</script>