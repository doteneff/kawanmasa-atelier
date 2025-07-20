<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Review - Kawanmasa Atelier</title>
    <style>
        body {
            background: #f6f6fb; /* same as write.php */
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
        .review-card {
            background: #232136; /* reviewed color */
            border-radius: 1.25rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            padding: 2.5rem 2.5rem 2rem 2.5rem;
            max-width: 430px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }
        .review-title {
            font-size: 1.45rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.3rem;
        }
        .review-subtitle {
            font-size: 1.08rem;
            font-weight: 600;
            color: #fff;
            margin-bottom: 2.2rem;
        }
        .appointment-info {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-bottom: 1.2rem;
        }
        .appointment-datetime {
            font-size: 1.15rem;
            font-weight: 700;
            color: #a78bfa;
            background: #232136;
            border-radius: 0.5rem;
            padding: 0.3rem 1rem;
            margin-right: 0.7rem;
        }
        .appointment-pipe {
            font-size: 1.15rem;
            color: #a78bfa;
            font-weight: 700;
            margin: 0 0.5rem;
        }
        .appointment-time {
            font-size: 1.15rem;
            font-weight: 700;
            color: #fff;
            background: #232136;
            border-radius: 0.5rem;
            padding: 0.3rem 1rem;
        }
        .review-form {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }
        .review-textarea {
            width: 100%;
            min-height: 300px;
            border-radius: 0.75rem;
            border: 1.5px solid #a78bfa;
            padding: 1rem;
            font-size: 1.1rem;
            font-family: inherit;
            resize: none;
            background: #232136;
            color: #fff;
            margin-bottom: 0;
            transition: border 0.2s;
            box-sizing: border-box;
        }
        .review-btn {
            background: #a78bfa;
            color: #fff;
            border: none;
            border-radius: 0.5rem;
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            width: 100%;
        }
        .review-btn:hover {
            background: #7c3aed;
            transform: scale(1.03);
        }
    </style>
</head>
<body>
    <div class="topbar">
        <button class="home-btn" onclick="window.location.href='/schedules'">Kawanmasa | Atelier</button>
        <button class="logout-btn" onclick="window.location.href='/logout'">Logout</button>
    </div>
    <div class="review-card">
        <div class="review-title">Thank you for your review!</div>
        <div class="review-subtitle">Your feedback help improve our service.</div>
        <?php
            $dt = new DateTime($appointment["appointment_at"]);
            $date = $dt->format('d M Y');
            $time = $dt->format('H:i');
        ?>
        <div class="appointment-info">
            <span class="appointment-datetime"><?= $date ?></span>
            <span class="appointment-pipe">|</span>
            <span class="appointment-time"><?= $time ?></span>
        </div>
        <form class="review-form">
            <textarea 
                class="review-textarea"
                placeholder="No review yet."
                disabled
            ><?= esc($appointment['review']) ?></textarea>
            <button type="button" class="review-btn" onclick="window.location.href='/appointments'">Back to Appointment</button>
        </form>
    </div>
</body>
</html>