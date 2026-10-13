<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Exclusivo - Premium Nightlife</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold-primary: #d4af37;
            --gold-hover: #b89122;
            --dark-base: #0a0a0a;
            --dark-glass: rgba(20, 20, 20, 0.75);
            --border-glass: rgba(212, 175, 55, 0.2);
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
        }

        body { 
            font-family: 'Outfit', sans-serif; 
            margin: 0; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh;
            color: var(--text-light);
            /* Premium Nightclub / High-end Dinner Background via CSS Gradients */
            background: 
                radial-gradient(circle at 15% 50%, rgba(212, 175, 55, 0.1), transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(180, 83, 9, 0.15), transparent 30%),
                linear-gradient(135deg, #111111 0%, #050505 100%);
            background-color: var(--dark-base);
            position: relative;
            overflow: hidden;
        }

        /* Subtle ambient light orbs */
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('https://www.transparenttextures.com/patterns/stardust.png');
            opacity: 0.15;
            pointer-events: none;
        }

        .login-container { 
            width: 100%; 
            max-width: 420px; 
            padding: 50px 40px; 
            border-radius: 16px; 
            /* Glassmorphism Effect */
            background: var(--dark-glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-glass);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8), 
                        inset 0 1px 0 rgba(255, 255, 255, 0.05);
            position: relative;
            z-index: 10;
        }

        .brand-logo {
            text-align: center;
            margin-bottom: 40px;
        }

        h1 { 
            font-family: 'Playfair Display', serif;
            color: var(--gold-primary); 
            text-align: center; 
            margin: 0 0 10px 0; 
            font-weight: 400; 
            font-size: 2.2rem; 
            letter-spacing: 2px; 
        }

        p.subtitle {
            text-align: center;
            color: var(--text-muted);
            margin: 0 0 30px 0;
            font-weight: 300;
            letter-spacing: 1px;
            font-size: 0.95rem;
            text-transform: uppercase;
        }

        form { 
            display: flex; 
            flex-direction: column; 
            gap: 22px; 
        }

        .input-group {
            position: relative;
        }

        input { 
            width: 100%;
            box-sizing: border-box;
            padding: 16px 20px; 
            font-size: 16px; 
            border-radius: 8px; 
            border: 1px solid rgba(255,255,255,0.1); 
            background-color: rgba(0,0,0,0.4); 
            color: var(--text-light); 
            font-family: 'Outfit', sans-serif;
            outline: none; 
            transition: all 0.3s ease; 
        }

        input:focus { 
            border-color: var(--gold-primary); 
            box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.15);
            background-color: rgba(0,0,0,0.6);
        }

        input::placeholder {
            color: #64748b;
        }

        button { 
            padding: 16px; 
            background: linear-gradient(135deg, var(--gold-primary), var(--gold-hover)); 
            color: #000; 
            border: none; 
            border-radius: 8px;
            cursor: pointer; 
            font-weight: 600; 
            font-size: 1rem;
            font-family: 'Outfit', sans-serif;
            text-transform: uppercase; 
            letter-spacing: 1.5px; 
            box-shadow: 0 8px 20px rgba(212, 175, 55, 0.25); 
            transition: all 0.3s ease; 
            margin-top: 10px;
        }

        button:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.4); 
        }

        .error { 
            background-color: rgba(220, 38, 38, 0.1); 
            color: #f87171; 
            text-align: center; 
            font-weight: 400; 
            padding: 15px; 
            border-radius: 8px; 
            border: 1px solid rgba(220, 38, 38, 0.3); 
            margin-bottom: 25px; 
            font-size: 0.95rem;
            backdrop-filter: blur(4px);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="brand-logo">
            <h1>L'Éclipse</h1>
            <p class="subtitle">Restaurant & Bar</p>
        </div>
        
        <?php if(isset($_GET['error'])): ?>
            <div class="error">❌ Credenciales incorrectas. Verifique su acceso exclusivo.</div>
        <?php endif; ?>

        <form action="index.php?view=auth&action=authenticate" method="POST">
            <div class="input-group">
                <input type="text" name="username" placeholder="Usuario" autocomplete="off" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>
