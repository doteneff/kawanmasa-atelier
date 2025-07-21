<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Kawanmasa Atelier') ?></title>
    <style>
        body {
            background: #f6f6fb;
            min-height: 100vh;
            margin: 0;
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .topbar {
            position: absolute;
            top: 2rem;
            left: 2rem;
            right: 2rem;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .home-btn {
            background: #a78bfa;
            color: #fff;
            border: none;
            border-radius: 2rem;
            padding: 0.5rem 1.2rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: background 0.2s, transform 0.1s;
            margin-right: 1rem;
        }
        .home-btn:hover {
            background: #7c3aed;
            transform: scale(1.05);
        }
        .home-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            pointer-events: none;
        }
        .logout-btn {
            background: #a78bfa;
            color: #fff;
            border: none;
            border-radius: 2rem;
            padding: 0.5rem 1.2rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: background 0.2s, transform 0.1s;
        }
        .logout-btn:hover {
            background: #7c3aed;
            transform: scale(1.05);
        }
        .logout-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            pointer-events: none;
        }
    </style>
    <?= $this->renderSection('head') ?>
</head>
<body>
    <div class="topbar">
        <button class="home-btn" onclick="window.location.href='/schedules'">Kawanmasa | Atelier</button>
        <button class="logout-btn" onclick="window.location.href='/logout'">Logout</button>
    </div>
    <?= $this->renderSection('content') ?>
</body>
</html>