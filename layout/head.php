<head>
    <meta charset="UTF-8">
    <title>ژورنال معاملاتی - Traidy</title>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #1a1a1a;
            --card: #2d2d28;
            --text: #e0e0e0;
            --green: #00ff88;
            --red: #ff3b5c;
            --blue: #00d4ff;
            --yellow: #ffb800;
            --border: #444;
            --week-bg: #2a3d45;
            --pamm: #ff6b6b;
            --real: #4ecdc4;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Vazirmatn', sans-serif;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border);
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            color: var(--green);
        }

        .logo span {
            color: var(--text);
            font-weight: 400;
        }

        .exit-btn {
            background: var(--red);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
        }

        .main-title {
            text-align: center;
            font-size: 36px;
            color: var(--blue);
            margin: 40px 0;
            font-weight: 700;
        }

        .tabs {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .tab {
            background: var(--card);
            color: #aaa;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 16px;
            cursor: pointer;
            min-width: 180px;
            text-align: center;
        }

        .tab.active {
            background: var(--green);
            color: black;
            font-weight: 600;
        }

        .form-card {
            background: var(--card);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            margin-bottom: 40px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            color: #aaa;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border);
            background: #3a3a3a;
            color: var(--text);
            border-radius: 8px;
            font-size: 15px;
        }

        .form-group textarea {
            min-height: 80px;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--green);
        }

        .btn-group {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            font-size: 15px;
            min-width: 140px;
        }

        .btn-primary {
            background: var(--green);
            color: black;
        }

        .btn-danger {
            background: var(--red);
            color: white;
        }

        .btn-success {
            background: #00b359;
            color: white;
        }

        .week-block {
            background: var(--week-bg);
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .week-header {
            background: #1e2d35;
            padding: 12px 20px;
            font-weight: bold;
            color: var(--blue);
            font-size: 16px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .account-totals {
            font-size: 14px;
        }

        .pamm-total {
            color: var(--pamm);
            font-weight: bold;
        }

        .real-total {
            color: var(--real);
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #3a3a3a;
            padding: 16px;
            text-align: center;
            font-weight: 600;
            font-size: 14px;
            color: #ccc;
        }

        td {
            padding: 14px;
            text-align: center;
            font-size: 14px;
            border-bottom: 1px solid var(--border);
            word-wrap: break-word;
            max-width: 150px;
        }

        tr.profit {
            background: rgba(0, 255, 136, 0.1);
        }

        tr.loss {
            background: rgba(255, 59, 92, 0.1);
        }

        .edit-btn {
            background: var(--yellow);
            color: black;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
        }

        .account-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
        }

        .pamm {
            background: rgba(255, 107, 107, 0.2);
            color: var(--pamm);
        }

        .real {
            background: rgba(78, 205, 196, 0.2);
            color: var(--real);
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            color: #aaa;
            font-size: 14px;
        }

        /* فونت و ساختار کلی */
        .brand-slogan {
            text-align: left;
            font-family: 'Poppins', sans-serif;
            font-size: 1.4rem;
            letter-spacing: 1px;
            color: #e0e0e0;
            margin-top: 10px;
            animation: fadeIn 2s ease-in-out;
        }

        /* افکت چشمک‌زن نئونی برای کلمه Traidy */
        .logo-name {
            font-weight: 700;
            color: #00ffc3;
            text-shadow: 0 0 10px #00ffc3, 0 0 20px #00ffc3;
            animation: glowPulse 3s ease-in-out infinite;
        }
    </style>
</head>