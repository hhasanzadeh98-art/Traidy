// داشبورد-1

<!-- <img style="width: 5%; height: 5%;" src="../image/logo.png" alt="Traidy Logo"> -->
<?php
require_once "../function/functions.php";
session_start();

$user_name = "کاربر ناشناس"; // مقدار پیش‌فرض

if (isset($_SESSION['user'])) {
    $id = $_SESSION['user']; // id ذخیره شده در سشن
    $user = getuserbyid($id); // واکشی کل اطلاعات کاربر از DB

    if ($user) {
        $user_name = $user->name;
    }
}
?>

<!DOCTYPE html>
<html lang="fa">

<head>
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v30.1.0/dist/font-face.css" rel="stylesheet" type="text/css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>traidy</title>
    <link rel="icon" href="../image/logo.png" type="image/png">

    <style>
        /* ===== تم تیره پایه ===== */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #121212;
            color: #eee;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* ===== هدر ===== */
        header {
            background-color: #1f1f1f;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        }

        header .logo {
            font-size: 1.5rem;
            /* font-weight: bold; */
            color: #4ade80;
            /* سبز روشن */
        }

        header .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        header .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #4ade80;
        }

        header .logout-btn {
            background-color: #ef4444;
            color: #fff;
            padding: 8px 15px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.2s;
        }

        header .logout-btn:hover {
            background-color: #dc2626;
        }

        /* ===== داشبورد ===== */
        main {
            padding: 30px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            background-color: #1f1f1f;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-10px) scale(1.05);
            background-color: #272727;
            box-shadow: 0 5px 15px rgba(94, 255, 45, 0.6);
            cursor: pointer;
        }

        .card h3 {
            margin-bottom: 10px;
            color: #4ade80;
            text-align: center;
        }

        .card p {
            color: #ccc;
            text-align: center;
        }

        /* ===== فوتر ===== */
        footer {
            background-color: #1f1f1f;
            padding: 15px 30px;
            text-align: center;
            color: #888;
            margin-top: 30px;
            border-top: 1px solid #333;
        }

        /* ===== ریسپانسیو ===== */
        @media(max-width: 600px) {
            header {
                flex-direction: column;
                gap: 10px;
            }

            .cards {
                grid-template-columns: 1fr;
            }
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

        /* جداکننده */
        .divider {
            margin: 0 6px;
            color: #777;
        }

        /* متن tagline */
        .tagline {
            color: #aaa;
            font-weight: 400;
        }

        /* افکت Fade اولیه هنگام لود */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* افکت نئونی چشمک‌زن نرم */
        @keyframes glowPulse {

            0%,
            100% {
                text-shadow: 0 0 8px #00ffc3, 0 0 16px #00ffc3, 0 0 24px #00ffc3;
                opacity: 1;
            }

            50% {
                text-shadow: 0 0 3px #00ffc3, 0 0 6px #00ffc3, 0 0 9px #00ffc3;
                opacity: 0.8;
            }
        }
    </style>
</head>

<body>

    <!-- هدر -->
    <header>
        <!-- <div class="logo">Trading Education</div> -->

        <div class="brand-slogan">
            <span class="logo-name">Traidy</span>
            <span class="divider">=</span>
            <span class="tagline">Think. Learn. Trade...</span>
        </div>
        <div class="user-info">
            <span><?php echo ucfirst($user_name) ?></span>
            <button onclick="location.href='logout.php'" class="logout-btn">Exit</button>
        </div>

    </header>
    <h1 style="text-align: center; color: #0594d6ff; margin: 5%;">!سطح ترید خود را مشخص کنید</h1>

    <!-- داشبورد اصلی -->
    <main>
        <div class="cards">
            <a href="../trad/tradA.php">
                <div class="card">
                    <h3>تریدر حرفه ای</h3>
                    <p>بهینه سازی استراتژی</p>
                </div>
            </a>
            <a href="../trad/tradB.php">
                <div class="card">
                    <h3>تریدر متوسط</h3>
                    <p>آموزش استراتژی های پول ساز</p>
                </div>
            </a>
            <a href="../trad/tradC.php">
                <div class="card">
                    <h3>تریدر مبتدی</h3>
                    <p>صفر تا متوسط ترید</p>
                </div>
            </a>
        </div>
    </main>

    <!-- فوتر -->
    <footer style="position: absolute; width: 100%; bottom: 0;">
        © 2025 آموزش ترید | تمام حقوق محفوظه
    </footer>

</body>

</html>

//داشبورد1-



//ترید بی 1-

<?php
// اتصال به دیتابیس
$host = "localhost";
$db   = "journal";
$user = "root";
$pass = "";
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// ثبت/ویرایش/حذف
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['index'] ?? '';
    $delete = $_POST['delete'] ?? '';

    if ($delete !== '') {
        $stmt = $conn->prepare("DELETE FROM trades WHERE id=?");
        $stmt->execute([$delete]);
    } else {
        $date = $_POST['date'];
        $day = $_POST['day'];
        $account_type = $_POST['account_type'];
        $pair = $_POST['pair'];
        $type = $_POST['type'];
        $strategy = $_POST['strategy'];
        $result = $_POST['result'];
        $lot = $_POST['lot'] ?: 0;
        $tf = $_POST['tf'] ?: '';
        $amount = floatval($_POST['amount']);
        $description = $_POST['description'] ?? '';
        $pnl = ($result === "profit") ? $amount : -$amount;

        if ($id !== '') {
            $stmt = $conn->prepare("UPDATE trades SET date=?, day=?, account_type=?, pair=?, type=?, strategy=?, result=?, lot=?, tf=?, amount=?, description=?, pnl=? WHERE id=?");
            $stmt->execute([$date, $day, $account_type, $pair, $type, $strategy, $result, $lot, $tf, $amount, $description, $pnl, $id]);
        } else {
            $stmt = $conn->prepare("INSERT INTO trades (date, day, account_type, pair, type, strategy, result, lot, tf, amount, description, pnl) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$date, $day, $account_type, $pair, $type, $strategy, $result, $lot, $tf, $amount, $description, $pnl]);
        }
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// دریافت معاملات
$stmt = $conn->query("SELECT * FROM trades ORDER BY date DESC, id DESC");
$trades = $stmt->fetchAll();

// گروه‌بندی هفتگی + جمع جداگانه
function groupWeeklyWithSeparateTotals($trades)
{
    $weeks = [];
    $currentWeek = [];
    $totals = ['PAMM' => 0, 'REAL' => 0];
    $currentWeekStart = null;

    if (empty($trades)) return $weeks;

    foreach ($trades as $t) {
        $timestamp = strtotime($t['date']);
        $weekStart = date('Y-m-d', strtotime('monday this week', $timestamp));

        if ($currentWeekStart === null || $weekStart !== $currentWeekStart) {
            if (!empty($currentWeek)) {
                $weeks[] = [
                    'trades' => array_reverse($currentWeek),
                    'pamm_total' => $totals['PAMM'],
                    'real_total' => $totals['REAL'],
                    'start' => $currentWeekStart,
                    'end' => date('Y-m-d', strtotime('friday this week', strtotime($currentWeekStart)))
                ];
            }
            $currentWeek = [];
            $totals = ['PAMM' => 0, 'REAL' => 0];
            $currentWeekStart = $weekStart;
        }
        $currentWeek[] = $t;
        $totals[$t['account_type']] += $t['pnl'];
    }

    if (!empty($currentWeek)) {
        $weeks[] = [
            'trades' => array_reverse($currentWeek),
            'pamm_total' => $totals['PAMM'],
            'real_total' => $totals['REAL'],
            'start' => $currentWeekStart,
            'end' => date('Y-m-d', strtotime('friday this week', strtotime($currentWeekStart)))
        ];
    }

    return array_reverse($weeks); // قدیمی‌ترین بالا
}

$weeks = groupWeeklyWithSeparateTotals($trades);
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

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

<body>


    <div class="container">
        <header>
            <!-- <div class="logo">Trading Education</div> -->

            <div class="brand-slogan">
                <span class="logo-name">Traidy</span>
            </div>

            <div class="header">
                <button class="exit-btn"><a href="../panel/dashboard.php">صفحه اصلی</a></button>
            </div>

            <!-- فرم -->
            <form method="POST" class="form-card">
                <input type="hidden" name="index" id="tradeIndex">
                <input type="hidden" name="delete" id="deleteIndex">
                <div class="form-grid">
                    <div class="form-group"><label>تاریخ</label><input type="date" name="date" id="date" required></div>
                    <div class="form-group"><label>روز</label>
                        <select name="day" id="day" required>
                            <option value="دوشنبه">دوشنبه</option>
                            <option value="سه‌شنبه">سه‌شنبه</option>
                            <option value="چهارشنبه">چهارشنبه</option>
                            <option value="پنج‌شنبه">پنج‌شنبه</option>
                            <option value="جمعه">جمعه</option>
                        </select>
                    </div>
                    <div class="form-group"><label>نوع حساب</label>
                        <select name="account_type" id="account_type" required>
                            <option value="REAL">REAL</option>
                            <option value="PAMM">PAMM</option>
                        </select>
                    </div>
                    <div class="form-group"><label>جفت ارز</label>
                        <select name="pair" id="pair" required>
                            <option value="">انتخاب کنید…</option>
                            <option>XAUUSD</option>
                            <option>AUDUSD</option>
                            <option>GBPUSD</option>
                            <option>USDJPY</option>
                            <option>GBPJPY</option>
                            <option>USDCAD</option>
                            <option>EURUSD</option>
                            <option>CADJPY</option>
                            <option>USDCHF</option>
                            <option>US30</option>
                            <option>NDX</option>
                        </select>
                    </div>
                    <div class="form-group"><label>نوع</label>
                        <select name="type" id="type">
                            <option value="buy">Buy</option>
                            <option value="sell">Sell</option>
                        </select>
                    </div>
                    <div class="form-group"><label>استراتژی</label>
                        <select name="strategy" id="strategy">
                            <option value="moving">مووینگ</option>
                            <option value="trend">خط روند / شکست</option>
                            <option value="experience">تجربه</option>
                        </select>
                    </div>
                    <div class="form-group"><label>نتیجه</label>
                        <select name="result" id="result">
                            <option value="profit">سود</option>
                            <option value="loss">ضرر</option>
                        </select>
                    </div>
                    <div class="form-group"><label>حجم</label><input type="number" name="lot" id="lot" step="0.01"></div>
                    <div class="form-group"><label>تایم‌فریم</label>
                        <select name="tf" id="tf">
                            <option value="">انتخاب کنید</option>
                            <option value="M1">M1</option>
                            <option value="M3">M3</option>
                            <option value="M5">M5</option>
                            <option value="M15">M15</option>
                        </select>
                    </div>
                    <div class="form-group"><label>مقدار سود/ضرر</label><input type="number" name="amount" id="amount" step="0.01" min="-100000" required></div>
                    <div class="form-group" style="grid-column:1/-1;"><label>توضیحات</label><textarea name="description" id="description" placeholder="مثلاً: ورود در شکست سقف، خروج در تارگت ۲"></textarea></div>
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">ثبت معامله</button>
                    <button type="submit" class="btn btn-danger" id="deleteBtn">حذف</button>
                </div>
            </form>

            <!-- نمایش هفته‌ها -->
            <?php if (empty($weeks)): ?>
                <div style="text-align:center; padding:50px; color:#aaa; font-size:18px;">
                    هنوز معامله‌ای ثبت نشده است.
                </div>
            <?php else: ?>
                <?php foreach ($weeks as $week): ?>
                    <div class="week-block">
                        <div class="week-header">
                            <div>هفته معاملاتی: <?= $week['start'] ?> تا <?= $week['end'] ?></div>
                            <div class="account-totals">
                                <span class="pamm-total">PAMM: <?= $week['pamm_total'] ?></span>
                                <span style="margin:0 8px; color:#aaa;">|</span>
                                <span class="real-total">REAL: <?= $week['real_total'] ?></span>
                            </div>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>ویرایش</th>
                                    <th>PNL</th>
                                    <th>Amount</th>
                                    <th>توضیحات</th>
                                    <th>تایم فریم</th>
                                    <th>حجم</th>
                                    <th>نتیجه</th>
                                    <th>استراتژی</th>
                                    <th>نوع</th>
                                    <th>ارز</th>
                                    <th>حساب</th>
                                    <th>روز</th>
                                    <th>تاریخ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($week['trades'] as $t): ?>
                                    <tr class="<?= $t['pnl'] > 0 ? 'profit' : 'loss' ?>">
                                        <td><button class="edit-btn" data-id="<?= $t['id'] ?>">ویرایش</button></td>
                                        <td><?= $t['pnl'] ?></td>
                                        <td><?= $t['amount'] ?></td>
                                        <td style="max-width:180px; word-wrap:break-word; font-size:13px; color:#ccc;"><?= $t['description'] ?: '-' ?></td>
                                        <td><?= $t['tf'] ?: '-' ?></td>
                                        <td><?= $t['lot'] ?: '-' ?></td>
                                        <td><?= $t['result'] === 'profit' ? 'profit' : 'loss' ?></td>
                                        <td><?= $t['strategy'] ?></td>
                                        <td><?= $t['type'] ?></td>
                                        <td><?= $t['pair'] ?></td>
                                        <td><span class="account-badge <?= $t['account_type'] === 'PAMM' ? 'pamm' : 'real' ?>"><?= $t['account_type'] ?></span></td>
                                        <td><?= $t['day'] ?></td>
                                        <td><?= $t['date'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="footer">© 2025 آموزش ترید | تمام حقوق محفوظه</div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#date').on('change', function() {
            const d = new Date(this.value);
            const days = ['یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه'];
            $('#day').val(days[d.getDay()]);
        });

        $(document).on('click', '.edit-btn', function() {
            const row = $(this).closest('tr');
            const cells = row.find('td');
            $('#tradeIndex').val($(this).data('id'));
            $('#deleteIndex').val('');

            $('#date').val(cells.eq(12).text().trim());
            $('#day').val(cells.eq(11).text().trim());
            $('#account_type').val(cells.eq(10).find('span').text().trim());
            $('#pair').val(cells.eq(9).text().trim());
            $('#type').val(cells.eq(8).text().trim());
            $('#strategy').val(cells.eq(7).text().trim());
            $('#result').val(cells.eq(6).text().trim() === 'profit' ? 'profit' : 'loss');
            $('#lot').val(cells.eq(5).text().trim() === '-' ? '' : cells.eq(5).text().trim());
            $('#tf').val(cells.eq(4).text().trim() === '-' ? '' : cells.eq(4).text().trim());
            $('#amount').val(cells.eq(2).text().trim());
            $('#description').val(cells.eq(3).text().trim() === '-' ? '' : cells.eq(3).text().trim());

            $('html, body').animate({
                scrollTop: 0
            }, 500);
        });

        $('#deleteBtn').click(function(e) {
            if ($('#tradeIndex').val() === '') {
                alert('ابتدا یک معامله را انتخاب کنید!');
                e.preventDefault();
            } else if (confirm('آیا از حذف این معامله مطمئن هستید؟')) {
                $('#deleteIndex').val($('#tradeIndex').val());
            } else {
                e.preventDefault();
            }
        });
    </script>
</body>

</html>

//ترید بی1-



//ترید بی 2-


<?php
// اتصال به دیتابیس
$host = "localhost";
$db   = "journal";
$user = "root";
$pass = "";
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// ثبت/ویرایش/حذف
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['index'] ?? '';
    $delete = $_POST['delete'] ?? '';

    if ($delete !== '') {
        $stmt = $conn->prepare("DELETE FROM trades WHERE id=?");
        $stmt->execute([$delete]);
    } else {
        $date = $_POST['date'];
        $day = $_POST['day'];
        $account_type = $_POST['account_type'];
        $pair = $_POST['pair'];
        $type = $_POST['type'];
        $strategy = $_POST['strategy'];
        $result = $_POST['result'];
        $lot = $_POST['lot'] ?: 0;
        $tf = $_POST['tf'] ?: '';
        $amount = floatval($_POST['amount']);
        $description = $_POST['description'] ?? '';
        $pnl = ($result === "profit") ? $amount : -$amount;

        if ($id !== '') {
            $stmt = $conn->prepare("UPDATE trades SET date=?, day=?, account_type=?, pair=?, type=?, strategy=?, result=?, lot=?, tf=?, amount=?, description=?, pnl=? WHERE id=?");
            $stmt->execute([$date, $day, $account_type, $pair, $type, $strategy, $result, $lot, $tf, $amount, $description, $pnl, $id]);
        } else {
            $stmt = $conn->prepare("INSERT INTO trades (date, day, account_type, pair, type, strategy, result, lot, tf, amount, description, pnl) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$date, $day, $account_type, $pair, $type, $strategy, $result, $lot, $tf, $amount, $description, $pnl]);
        }
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// دریافت معاملات
$stmt = $conn->query("SELECT * FROM trades ORDER BY date DESC, id DESC");
$trades = $stmt->fetchAll();

// گروه‌بندی هفتگی + جمع جداگانه
function groupWeeklyWithSeparateTotals($trades)
{
    $weeks = [];
    $currentWeek = [];
    $totals = ['PAMM' => 0, 'REAL' => 0];
    $currentWeekStart = null;

    if (empty($trades)) return $weeks;

    foreach ($trades as $t) {
        $timestamp = strtotime($t['date']);
        $weekStart = date('Y-m-d', strtotime('monday this week', $timestamp));

        if ($currentWeekStart === null || $weekStart !== $currentWeekStart) {
            if (!empty($currentWeek)) {
                $weeks[] = [
                    'trades' => array_reverse($currentWeek),
                    'pamm_total' => $totals['PAMM'],
                    'real_total' => $totals['REAL'],
                    'start' => $currentWeekStart,
                    'end' => date('Y-m-d', strtotime('friday this week', strtotime($currentWeekStart)))
                ];
            }
            $currentWeek = [];
            $totals = ['PAMM' => 0, 'REAL' => 0];
            $currentWeekStart = $weekStart;
        }
        $currentWeek[] = $t;
        $totals[$t['account_type']] += $t['pnl'];
    }

    if (!empty($currentWeek)) {
        $weeks[] = [
            'trades' => array_reverse($currentWeek),
            'pamm_total' => $totals['PAMM'],
            'real_total' => $totals['REAL'],
            'start' => $currentWeekStart,
            'end' => date('Y-m-d', strtotime('friday this week', strtotime($currentWeekStart)))
        ];
    }

    return array_reverse($weeks); // قدیمی‌ترین بالا
}

$weeks = groupWeeklyWithSeparateTotals($trades);
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ژورنال معاملاتی - Traidy</title>
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v30.1.0/dist/font-face.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
<style>
    :root {
        --primary: #3b82f6;
        --primary-light: #60a5fa;
        --bg: #f8fafc;
        --card: #ffffff;
        --border: #e2e8f0;
        --text: #1e293b;
        --muted: #64748b;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --select-bg: #f1f5f9;
        --select-border: #cbd5e1;
        --select-hover: #e2e8f0;
    }
    body {
        background-color: var(--bg);
        color: var(--text);
        font-family: 'Vazirmatn', 'Inter', sans-serif;
        padding: 1.5rem;
    }
    .card {
        background: var(--card);
        border-radius: 1.5rem;
        padding: 1.5rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        border: 1px solid var(--border);
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.16); /* سایه تیره‌تر در هاور */
    }
    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 9999px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        transition: all 0.3s;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
    }
    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 9999px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }
    .btn-warning {
        background: #f59e0b;
        color: black;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
    }
    .price-badge {
        background: #f1f5f9;
        color: #0f172a;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-weight: 600;
        font-size: 0.875rem;
    }
    .chat-bubble {
        position: fixed;
        bottom: 20px;
        left: 20px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
        cursor: pointer;
        z-index: 50;
        animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .logo {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
    }
    .account-badge {
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: bold;
    }
    .pamm { background: rgba(239, 68, 68, 0.15); color: #dc2626; }
    .real { background: rgba(34, 197, 94, 0.15); color: #16a34a; }
    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
    }
    th {
        background: #f8fafc;
        padding: 1rem;
        text-align: center;
        font-weight: 600;
        font-size: 0.875rem;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
    }
    td {
        background: #ffffff;
        padding: 1rem;
        text-align: center;
        font-size: 0.875rem;
        border-bottom: 1px solid #e2e8f0;
    }
    tr.profit td { background: rgba(34, 197, 94, 0.05); }
    tr.loss td { background: rgba(239, 68, 68, 0.05); }

    /* استایل سلکت‌ها — گرد + کادر تیره‌تر + لیست گرد */
    select {
        appearance: none;
        background-color: var(--select-bg) !important;
        border: 1.5px solid var(--select-border) !important;
        color: var(--text) !important;
        padding: 0.75rem 2.5rem 0.75rem 1rem !important;
        border-radius: 1rem !important;
        font-size: 0.9375rem !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: left 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1.25em;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    select:focus {
        outline: none !important;
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2) !important;
    }
    select:hover {
        border-color: var(--select-hover) !important;
        background-color: #e2e8f0 !important;
    }

    /* لیست بازشده سلکت — گرد و تمیز */
    select option {
        background: white;
        color: var(--text);
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
    }
    /* برای مرورگرهای مدرن: لیست گرد */
    select::-webkit-calendar-picker-indicator { display: none; }
    select::-ms-expand { display: none; }
</style>
</head>

<body>

    <!-- چت بات -->
    <div class="chat-bubble">i</div>

    <div class="container mx-auto max-w-7xl">

        <!-- هدر -->
        <header class="flex justify-between items-center mb-8">
            <nav class="flex gap-6 text-sm font-medium text-[var(--muted)]">
                <a href="../panel/dashboard.php" class="text-[var(--text)] font-semibold">داشبورد</a>
                <a href="#" class="hover:text-[var(--primary)]">ژورنال</a>
                <a href="#" class="hover:text-[var(--primary)]">آمار</a>
                <a href="#" class="hover:text-[var(--primary)]">گزارش‌ها</a>
            </nav>
            <div class="flex items-center gap-4">
                <span class="text-sm text-[var(--muted)]">Welcome</span>
                <span class="font-bold text-lg">Hamed</span>
                <div class="logo">T</div>
            </div>
        </header>

        <!-- فرم -->
        <div class="card mb-10">
            <form method="POST">
                <input type="hidden" name="index" id="tradeIndex">
                <input type="hidden" name="delete" id="deleteIndex">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div><label class="block text-sm text-[var(--muted)] mb-1">تاریخ</label><input type="date" name="date" id="date" class="w-full px-4 py-2 border border-[var(--border)] rounded-xl focus:outline-none focus:border-[var(--primary)]" required></div>
                    <div><label class="block text-sm text-[var(--muted)] mb-1">روز</label>
                        <select name="day" id="day" class="w-full px-4 py-2 border border-[var(--border)] rounded-xl focus:outline-none focus:border-[var(--primary)]" required>
                            <option value="دوشنبه">دوشنبه</option>
                            <option value="سه‌شنبه">سه‌شنبه</option>
                            <option value="چهارشنبه">چهارشنبه</option>
                            <option value="پنج‌شنبه">پنج‌شنبه</option>
                            <option value="جمعه">جمعه</option>
                        </select>
                    </div>
                    <div><label class="block text-sm text-[var(--muted)] mb-1">نوع حساب</label>
                        <select name="account_type" id="account_type" class="w-full px-4 py-2 border border-[var(--border)] rounded-xl focus:outline-none focus:border-[var(--primary)]" required>
                            <option value="REAL">REAL</option>
                            <option value="PAMM">PAMM</option>
                        </select>
                    </div>
                    <div><label class="block text-sm text-[var(--muted)] mb-1">جفت ارز</label>
                        <select name="pair" id="pair" class="w-full px-4 py-2 border border-[var(--border)] rounded-xl focus:outline-none focus:border-[var(--primary)]" required>
                            <option value="">انتخاب کنید…</option>
                            <option>XAUUSD</option>
                            <option>AUDUSD</option>
                            <option>GBPUSD</option>
                            <option>USDJPY</option>
                            <option>GBPJPY</option>
                            <option>USDCAD</option>
                            <option>EURUSD</option>
                            <option>CADJPY</option>
                            <option>USDCHF</option>
                            <option>US30</option>
                            <option>NDX</option>
                        </select>
                    </div>
                    <div><label class="block text-sm text-[var(--muted)] mb-1">نوع</label>
                        <select name="type" id="type" class="w-full px-4 py-2 border border-[var(--border)] rounded-xl focus:outline-none focus:border-[var(--primary)]">
                            <option value="buy">Buy</option>
                            <option value="sell">Sell</option>
                        </select>
                    </div>
                    <div><label class="block text-sm text-[var(--muted)] mb-1">استراتژی</label>
                        <select name="strategy" id="strategy" class="w-full px-4 py-2 border border-[var(--border)] rounded-xl focus:outline-none focus:border-[var(--primary)]">
                            <option value="moving">مووینگ</option>
                            <option value="trend">خط روند / شکست</option>
                            <option value="experience">تجربه</option>
                        </select>
                    </div>
                    <div><label class="block text-sm text-[var(--muted)] mb-1">نتیجه</label>
                        <select name="result" id="result" class="w-full px-4 py-2 border border-[var(--border)] rounded-xl focus:outline-none focus:border-[var(--primary)]">
                            <option value="profit">سود</option>
                            <option value="loss">ضرر</option>
                        </select>
                    </div>
                    <div><label class="block text-sm text-[var(--muted)] mb-1">حجم</label><input type="number" name="lot" id="lot" step="0.01" class="w-full px-4 py-2 border border-[var(--border)] rounded-xl focus:outline-none focus:border-[var(--primary)]"></div>
                    <div><label class="block text-sm text-[var(--muted)] mb-1">تایم‌فریم</label>
                        <select name="tf" id="tf" class="w-full px-4 py-2 border border-[var(--border)] rounded-xl focus:outline-none focus:border-[var(--primary)]">
                            <option value="">انتخاب کنید</option>
                            <option value="M1">M1</option>
                            <option value="M3">M3</option>
                            <option value="M5">M5</option>
                            <option value="M15">M15</option>
                        </select>
                    </div>
                    <div><label class="block text-sm text-[var(--muted)] mb-1">مقدار سود/ضرر</label><input type="number" name="amount" id="amount" step="0.01" min="-100000" class="w-full px-4 py-2 border border-[var(--border)] rounded-xl focus:outline-none focus:border-[var(--primary)]" required></div>
                </div>
                <div class="mb-6">
                    <label class="block text-sm text-[var(--muted)] mb-1">توضیحات</label>
                    <textarea name="description" id="description" placeholder="مثلاً: ورود در شکست سقف، خروج در تارگت ۲" class="w-full px-4 py-3 border border-[var(--border)] rounded-xl focus:outline-none focus:border-[var(--primary)]" rows="3"></textarea>
                </div>
                <div class="flex justify-center gap-4">
                    <button type="submit" class="btn-primary">ثبت معامله</button>
                    <button type="submit" class="btn-danger" id="deleteBtn">حذف</button>
                </div>
            </form>
        </div>

        <!-- هفته‌ها -->
        <?php if (empty($weeks)): ?>
            <div class="text-center py-16 text-[var(--muted)] text-lg">هنوز معامله‌ای ثبت نشده است.</div>
        <?php else: ?>
            <?php foreach ($weeks as $week): ?>
                <div class="card mb-8">
                    <div class="bg-gradient-to-r from-[var(--primary)] to-[var(--primary-light)] text-white p-4 rounded-t-xl flex justify-between items-center">
                        <div class="font-bold">هفته معاملاتی: <?= $week['start'] ?> تا <?= $week['end'] ?></div>
                        <div class="text-sm">
                            <span class="pamm">PAMM: <?= $week['pamm_total'] ?></span>
                            <span class="mx-2">|</span>
                            <span class="text-green-100">REAL: <?= $week['real_total'] ?></span>
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ویرایش</th>
                                <th>PNL</th>
                                <th>Amount</th>
                                <th>توضیحات</th>
                                <th>تایم فریم</th>
                                <th>حجم</th>
                                <th>نتیجه</th>
                                <th>استراتژی</th>
                                <th>نوع</th>
                                <th>ارز</th>
                                <th>حساب</th>
                                <th>روز</th>
                                <th>تاریخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($week['trades'] as $t): ?>
                                <tr class="<?= $t['pnl'] > 0 ? 'profit' : 'loss' ?>">
                                    <td><button class="btn-warning edit-btn" data-id="<?= $t['id'] ?>">ویرایش</button></td>
                                    <td><?= $t['pnl'] ?></td>
                                    <td><?= $t['amount'] ?></td>
                                    <td class="text-xs text-[var(--muted)]"><?= $t['description'] ?: '-' ?></td>
                                    <td><?= $t['tf'] ?: '-' ?></td>
                                    <td><?= $t['lot'] ?: '-' ?></td>
                                    <td><?= $t['result'] === 'profit' ? 'profit' : 'loss' ?></td>
                                    <td><?= $t['strategy'] ?></td>
                                    <td><?= $t['type'] ?></td>
                                    <td><?= $t['pair'] ?></td>
                                    <td><span class="account-badge <?= $t['account_type'] === 'PAMM' ? 'pamm' : 'real' ?>"><?= $t['account_type'] ?></span></td>
                                    <td><?= $t['day'] ?></td>
                                    <td><?= $t['date'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <footer class="text-center text-xs text-[var(--muted)] mt-12">
            © 2025 آموزش ترید | تمام حقوق محفوظه
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#date').on('change', function() {
            const d = new Date(this.value);
            const days = ['یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه'];
            $('#day').val(days[d.getDay()]);
        });

        $(document).on('click', '.edit-btn', function() {
            const row = $(this).closest('tr');
            const cells = row.find('td');
            $('#tradeIndex').val($(this).data('id'));
            $('#deleteIndex').val('');

            $('#date').val(cells.eq(12).text().trim());
            $('#day').val(cells.eq(11).text().trim());
            $('#account_type').val(cells.eq(10).find('span').text().trim());
            $('#pair').val(cells.eq(9).text().trim());
            $('#type').val(cells.eq(8).text().trim());
            $('#strategy').val(cells.eq(7).text().trim());
            $('#result').val(cells.eq(6).text().trim() === 'profit' ? 'profit' : 'loss');
            $('#lot').val(cells.eq(5).text().trim() === '-' ? '' : cells.eq(5).text().trim());
            $('#tf').val(cells.eq(4).text().trim() === '-' ? '' : cells.eq(4).text().trim());
            $('#amount').val(cells.eq(2).text().trim());
            $('#description').val(cells.eq(3).text().trim() === '-' ? '' : cells.eq(3).text().trim());

            $('html, body').animate({
                scrollTop: 0
            }, 500);
        });

        $('#deleteBtn').click(function(e) {
            if ($('#tradeIndex').val() === '') {
                alert('ابتدا یک معامله را انتخاب کنید!');
                e.preventDefault();
            } else if (confirm('آیا از حذف این معامله مطمئن هستید؟')) {
                $('#deleteIndex').val($('#tradeIndex').val());
            } else {
                e.preventDefault();
            }
        });
    </script>
</body>

</html>


//ترید بی 2-



//امار ژورنالی 1


<?php
session_start();

$host = "localhost";
$db   = "journal";
$user = "root";
$pass = "";
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

try {
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// هفته جاری
$today = new DateTime('now', new DateTimeZone('Asia/Tehran'));
$monday = clone $today;
$monday->modify('monday this week');
$friday = clone $monday;
$friday->modify('+4 days');

$start = $monday->format('Y-m-d');
$end   = $friday->format('Y-m-d');

$stmt = $conn->prepare("SELECT pair, result, pnl FROM trades WHERE date BETWEEN ? AND ?");
$stmt->execute([$start, $end]);
$trades = $stmt->fetchAll();

// آمار هر جفت ارز
$stats = [];
foreach ($trades as $t) {
    $pair = $t['pair'] ?: 'نامشخص';
    if (!isset($stats[$pair])) {
        $stats[$pair] = ['total' => 0, 'profit' => 0, 'loss' => 0, 'pnl' => 0];
    }
    $stats[$pair]['total']++;
    if ($t['result'] === 'profit') {
        $stats[$pair]['profit']++;
    } else {
        $stats[$pair]['loss']++;
    }
    $stats[$pair]['pnl'] += $t['pnl'];
}

uasort($stats, fn($a, $b) => $b['total'] <=> $a['total']);
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>گزارش هفتگی جفت ارزها - Traidy</title>
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v30.1.0/dist/font-face.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #3b82f6;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --bg: #f8fafc;
            --card: #ffffff;
            --border: #e2e8f0;
            --text: #1e293b;
            --muted: #64748b;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Vazirmatn', sans-serif;
            padding: 1.5rem;
        }

        .card {
            background: var(--card);
            border-radius: 1.5rem;
            padding: 1.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border);
            transition: all 0.3s;
        }

        .card:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.16);
        }

        .logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: bold;
        }

        .profit {
            background: rgba(34, 197, 94, 0.15);
            color: var(--success);
        }

        .loss {
            background: rgba(239, 68, 68, 0.15);
            color: var(--danger);
        }
    </style>
</head>

<body>

    <div class="container mx-auto max-w-7xl">

        <!-- هدر -->
        <header class="flex justify-between items-center mb-8">
            <nav class="flex gap-6 text-sm font-medium text-[var(--muted)]">
                <a href="../panel/dashboard.php" class="hover:text-[var(--primary)]">داشبورد</a>
                <a href="journal.php" class="hover:text-[var(--primary)]">ژورنال</a>
                <a href="#" class="text-[var(--primary)] font-bold">گزارش هفتگی</a>
            </nav>
            <div class="flex items-center gap-4">
                <span class="text-sm text-[var(--muted)]">Welcome</span>
                <span class="font-bold text-lg">Hamed</span>
                <div class="logo">T</div>
            </div>
        </header>

        <!-- عنوان + تاریخ شمسی -->
        <div class="card mb-8 text-center">
            <h1 class="text-3xl font-bold mb-2">ژورنال معاملاتی</h1>
            <?php
            function miladi_to_shamsi($date)
            {
                $d = new DateTime($date);
                $y = (int)$d->format('Y');
                $m = (int)$d->format('m');
                $day = (int)$d->format('d');
                $g_d = $day;
                $g_m = $m;
                $g_y = $y;
                if ($g_y < 1600) return "$day/$m/$y";

                $jy = 979;
                $gy = $g_y - 1600;
                $gm = $g_m - 1;
                $gd = $g_d - 1;
                $g_day_no = 365 * $gy + floor(($gy + 3) / 4) - floor(($gy + 99) / 100) + floor(($gy + 399) / 400);
                for ($i = 0; $i < $gm; ++$i) $g_day_no += [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][$i];
                if ($gm > 1 && (($gy % 4 == 0 && $gy % 100 != 0) || ($gy % 400 == 0))) ++$g_day_no;
                $g_day_no += $gd;

                $j_day_no = $g_day_no - 79;
                $j_np = floor($j_day_no / 12053);
                $j_day_no %= 12053;
                $jy += 979 * $j_np;
                $jy += 365 * floor($j_day_no / 1461) + floor(($j_day_no % 1461) / 365);
                $j_day_no = $j_day_no - 365 * floor($j_day_no / 1461) - floor((floor($j_day_no / 1461) % 33 + 3) / 4);
                if ($j_day_no < 186) {
                    $jm = 1 + floor($j_day_no / 31);
                    $jd = $j_day_no % 31 + 1;
                } else {
                    $j_day_no -= 186;
                    $jm = 7 + floor($j_day_no / 30);
                    $jd = $j_day_no % 30 + 1;
                }
                // $months = [1=>'فروردین',2=>'اردیبهشت',3=>'خرداد',4=>'تیر',5=>'مرداد',6=>'شهریور',7=>'مهر',8=>'آبان',9=>'آذر',10=>'دی',11=>'بهمن',12=>'اسفند'];
                // return "$jd {$months[$jm]} $jy";
            }
            ?>
            <!-- <p class="text-[var(--muted)] mt-3">
            هفته معاملاتی: <span class="font-bold"><?= miladi_to_shamsi($start) ?></span> تا <span class="font-bold"><?= miladi_to_shamsi($end) ?></span>
        </p> -->
        </div>

        <!-- نمودار دایره‌ای
        <div class="card mb-10">
            <canvas id="pairChart" height="320"></canvas>
        </div> -->

        <!-- جدول -->
        <div class="card">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <!-- کارت کوچک: توزیع جفت ارزهای این هفته -->
                    <?php
                    // محاسبه آمار این هفته (دقیقاً مثل report.php)
                    $today = new DateTime('now', new DateTimeZone('Asia/Tehran'));
                    $monday = clone $today;
                    $monday->modify('monday this week');
                    $friday = clone $monday;
                    $friday->modify('+4 days');
                    $start_week = $monday->format('Y-m-d');
                    $end_week = $friday->format('Y-m-d');

                    $stmt_week = $conn->prepare("SELECT pair FROM trades WHERE date BETWEEN ? AND ? AND pair IS NOT NULL AND pair != ''");
                    $stmt_week->execute([$start_week, $end_week]);
                    $week_trades = $stmt_week->fetchAll(PDO::FETCH_COLUMN);

                    $pair_count = array_count_values($week_trades);
                    arsort($pair_count); // بیشترین معامله اول
                    $total_this_week = array_sum($pair_count);
                    ?>

                    <?php if ($total_this_week > 0): ?>
                        <div class="card mb-8 p-5 bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="font-bold text-lg">توزیع معاملات این هفته</h3>
                                <span class="text-sm text-[var(--muted)]">مجموع: <?= $total_this_week ?> معامله</span>
                            </div>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
                                <div class="order-2 lg:order-1">
                                    <canvas id="miniPairChart" height="180"></canvas>
                                </div>
                                <div class="order-1 lg:order-2 space-y-2">
                                    <?php foreach (array_slice($pair_count, 0, 6, true) as $p => $c):
                                        $percent = round(($c / $total_this_week) * 100);
                                    ?>
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="font-medium"><?= $p ?></span>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold"><?= $c ?> معامله</span>
                                                <span class="text-[var(--muted)]">(<?= $percent ?>%)</span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <?php if (count($pair_count) > 6): ?>
                                        <div class="text-xs text-[var(--muted)] pt-2 border-t border-blue-200">
                                            و <?= count($pair_count) - 6 ?> جفت ارز دیگر...
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const miniCtx = document.getElementById('miniPairChart').getContext('2d');
                                new Chart(miniCtx, {
                                    type: 'doughnut',
                                    data: {
                                        labels: <?= json_encode(array_keys($pair_count), JSON_UNESCAPED_UNICODE) ?>,
                                        datasets: [{
                                            data: <?= json_encode(array_values($pair_count)) ?>,
                                            backgroundColor: [
                                                '#3b82f6', '#10b981', '#ef4444', '#f59e0b', '#8b5cf6',
                                                '#ec4899', '#14b8a6', '#f97316', '#6366f1', '#84cc16'
                                            ],
                                            borderWidth: 3,
                                            borderColor: '#ffffff',
                                            hoverOffset: 6
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        cutout: '72%',
                                        plugins: {
                                            legend: {
                                                display: false
                                            },
                                            tooltip: {
                                                callbacks: {
                                                    label: ctx => `${ctx.label}: ${ctx.raw} معامله`
                                                }
                                            }
                                        }
                                    }
                                });
                            });
                        </script>
                    <?php endif; ?>
                    <thead class="border-b">
                        <tr class="text-[var(--muted)]">
                            <th class="text-right py-4">جفت ارز</th>
                            <th class="py-4">تعداد</th>
                            <th class="py-4">سود</th>
                            <th class="py-4">ضرر</th>
                            <th class="py-4">Win Rate</th>
                            <th class="py-4">PNL</th>
                            <th class="py-4">وضعیت</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stats as $pair => $s):
                            $winrate = $s['total'] > 0 ? round(($s['profit'] / $s['total']) * 100, 1) : 0;
                        ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4 font-bold"><?= $pair ?></td>
                                <td class="text-center font-bold"><?= $s['total'] ?></td>
                                <td class="text-center text-[var(--success)] font-bold"><?= $s['profit'] ?></td>
                                <td class="text-center text-[var(--danger)] font-bold"><?= $s['loss'] ?></td>
                                <td class="text-center <?= $winrate >= 60 ? 'text-[var(--success)]' : ($winrate >= 40 ? 'text-[var(--warning)]' : 'text-[var(--danger)]') ?> font-bold">
                                    <?= $winrate ?>%
                                </td>
                                <td class="text-center font-bold <?= $s['pnl'] >= 0 ? 'text-[var(--success)]' : 'text-[var(--danger)]' ?>">
                                    <?= number_format($s['pnl'], 2) ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge <?= $s['pnl'] >= 0 ? 'profit' : 'loss' ?>">
                                        <?= $s['pnl'] >= 0 ? 'سودده' : 'ضررده' ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($stats)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-12 text-[var(--muted)] text-lg">این هفته معامله‌ای ثبت نشده است.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <footer class="text-center text-xs text-[var(--muted)] mt-12">
            © 2025 Traidy - آموزش ترید حرفه‌ای
        </footer>
    </div>



</body>

</html>



//امار ژورنالی1-




//amar final

//amar back4 final

<?php
session_start();

$host = "localhost";
$db   = "journal";
$user = "root";
$pass = "";
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

try {
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


// ۱. همه معاملات برای جدول اصلی (نه فقط این هفته)
$stmt = $conn->prepare("SELECT pair, result, pnl FROM trades WHERE pair IS NOT NULL AND pair != ''");
$stmt->execute();
$trades = $stmt->fetchAll();

// آمار هر جفت ارز (کل تاریخ)
$stats = [];
foreach ($trades as $t) {
    $pair = $t['pair'] ?: 'نامشخص';
    if (!isset($stats[$pair])) {
        $stats[$pair] = ['total' => 0, 'profit' => 0, 'loss' => 0, 'pnl' => 0];
    }
    $stats[$pair]['total']++;
    if ($t['result'] === 'profit') {
        $stats[$pair]['profit']++;
    } else {
        $stats[$pair]['loss']++;
    }
    $stats[$pair]['pnl'] += $t['pnl'];
}
uasort($stats, fn($a, $b) => $b['total'] <=> $a['total']);


// --- محاسبه وین‌ریت کلی (کل معاملات) ---
$total_trades_all = array_sum(array_column($stats, 'total'));
$total_profits_all = array_sum(array_column($stats, 'profit'));
$overall_winrate = $total_trades_all > 0 ? round(($total_profits_all / $total_trades_all) * 100, 1) : 0;

// رنگ مناسب برای وین‌ریت
$winrate_color = $overall_winrate >= 60 ? 'text-green-600 bg-green-50' : ($overall_winrate >= 40 ? 'text-amber-600 bg-amber-50' : 'text-red-600 bg-red-50');


// ۲. همه معاملات برای نمودار دونات و لیست "جفت ارز دیگر"
$stmt_week = $conn->prepare("SELECT pair FROM trades WHERE pair IS NOT NULL AND pair != ''");
$stmt_week->execute();
$week_trades = $stmt_week->fetchAll(PDO::FETCH_COLUMN);

$pair_count = array_count_values($week_trades);
arsort($pair_count);
$total_this_week = array_sum($pair_count);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>گزارش هفتگی جفت ارزها - Traidy</title>
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v30.1.0/dist/font-face.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #3b82f6;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --bg: #f8fafc;
            --card: #ffffff;
            --border: #e2e8f0;
            --text: #1e293b;
            --muted: #64748b;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Vazirmatn', sans-serif;
            padding: 1.5rem;
        }

        .card {
            background: var(--card);
            border-radius: 1.5rem;
            padding: 1.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border);
            transition: all 0.3s;
        }

        .card:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.16);
        }

        .logo {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: #4f46e5;
            /* رنگ پایه */
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 18px;
            box-shadow: 0 0 10px #4f46e5, 0 0 20px #4f46e5;
            animation: glowPulse 2.5s ease-in-out infinite alternate;
        }

        @keyframes glowPulse {
            0% {
                box-shadow: 0 0 5px #4f46e5, 0 0 10px #4f46e5;
                background-color: #4f46e5;
            }

            50% {
                box-shadow: 0 0 15px #7c3aed, 0 0 30px #7c3aed;
                background-color: #7c3aed;
            }

            100% {
                box-shadow: 0 0 5px #4f46e5, 0 0 10px #4f46e5;
                background-color: #4f46e5;
            }
        }

        .badge {
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: bold;
        }

        .profit {
            background: rgba(34, 197, 94, 0.15);
            color: var(--success);
        }

        .loss {
            background: rgba(239, 68, 68, 0.15);
            color: var(--danger);
        }
    </style>
</head>

<body>

    <div class="container mx-auto max-w-7xl">

        <!-- هدر -->
        <header class="flex justify-between items-center mb-8">
            <nav class="flex gap-6 text-sm font-medium text-[var(--muted)]">
                <a href="../panel/dashboard.php" class="hover:text-[var(--primary)]">داشبورد</a>
            </nav>
            <div class="flex items-center gap-4">
                <span class="font-bold text-lg">Hamed</span>
                <div class="logo">Traidy</div>
            </div>
        </header>

        <!-- عنوان + تاریخ شمسی -->
        <div class="card mb-8 text-center">
            <h1 class="text-3xl font-bold mb-2">ژورنال معاملاتی</h1>
            <?php
            function miladi_to_shamsi($date)
            {
                $d = new DateTime($date);
                $y = (int)$d->format('Y');
                $m = (int)$d->format('m');
                $day = (int)$d->format('d');
                $g_d = $day;
                $g_m = $m;
                $g_y = $y;
                if ($g_y < 1600) return "$day/$m/$y";

                $jy = 979;
                $gy = $g_y - 1600;
                $gm = $g_m - 1;
                $gd = $g_d - 1;
                $g_day_no = 365 * $gy + floor(($gy + 3) / 4) - floor(($gy + 99) / 100) + floor(($gy + 399) / 400);
                for ($i = 0; $i < $gm; ++$i) $g_day_no += [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][$i];
                if ($gm > 1 && (($gy % 4 == 0 && $gy % 100 != 0) || ($gy % 400 == 0))) ++$g_day_no;
                $g_day_no += $gd;

                $j_day_no = $g_day_no - 79;
                $j_np = floor($j_day_no / 12053);
                $j_day_no %= 12053;
                $jy += 979 * $j_np;
                $jy += 365 * floor($j_day_no / 1461) + floor(($j_day_no % 1461) / 365);
                $j_day_no = $j_day_no - 365 * floor($j_day_no / 1461) - floor((floor($j_day_no / 1461) % 33 + 3) / 4);
                if ($j_day_no < 186) {
                    $jm = 1 + floor($j_day_no / 31);
                    $jd = $j_day_no % 31 + 1;
                } else {
                    $j_day_no -= 186;
                    $jm = 7 + floor($j_day_no / 30);
                    $jd = $j_day_no % 30 + 1;
                }
                // $months = [1=>'فروردین',2=>'اردیبهشت',3=>'خرداد',4=>'تیر',5=>'مرداد',6=>'شهریور',7=>'مهر',8=>'آبان',9=>'آذر',10=>'دی',11=>'بهمن',12=>'اسفند'];
                // return "$jd {$months[$jm]} $jy";
            }
            ?>
            <!-- <p class="text-[var(--muted)] mt-3">
            هفته معاملاتی: <span class="font-bold"><?= miladi_to_shamsi($start) ?></span> تا <span class="font-bold"><?= miladi_to_shamsi($end) ?></span>
        </p> -->
        </div>

        <!-- نمودار دایره‌ای
        <div class="card mb-10">
            <canvas id="pairChart" height="320"></canvas>
        </div> -->

        <!-- جدول -->
        <div class="card">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <!-- کارت کوچک: توزیع جفت ارزهای این هفته -->
                    <?php
                    // محاسبه آمار این هفته (دقیقاً مثل report.php)
                    // --- تغییر فقط اینجا ---
                    $stmt_week = $conn->prepare("SELECT pair FROM trades WHERE pair IS NOT NULL AND pair != ''");
                    $stmt_week->execute();
                    $week_trades = $stmt_week->fetchAll(PDO::FETCH_COLUMN);
                    // --- تمام ---         $week_trades = $stmt_week->fetchAll(PDO::FETCH_COLUMN);

                    $pair_count = array_count_values($week_trades);
                    arsort($pair_count); // بیشترین معامله اول
                    $total_this_week = array_sum($pair_count);
                    ?>

                    <?php if ($total_this_week > 0): ?>
                        <div class="card mb-8 p-5 bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="font-bold text-lg">توزیع معاملات</h3>
                                <span class="text-sm text-[var(--muted)]">مجموع: <?= $total_this_week ?> معامله</span>
                            </div>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
                                <div class="order-2 lg:order-1">
                                    <canvas id="miniPairChart" height="180"></canvas>
                                </div>
                                <div class="order-1 lg:order-2 space-y-2">
                                    <?php foreach (array_slice($pair_count, 0, 6, true) as $p => $c):
                                        $percent = round(($c / $total_this_week) * 100);
                                    ?>
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="font-medium"><?= $p ?></span>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold"><?= $c ?> معامله</span>
                                                <span class="text-[var(--muted)]">(<?= $percent ?>%)</span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <?php if (count($pair_count) > 6): ?>
                                        <div class="text-xs text-[var(--muted)] pt-2 border-t border-blue-200">
                                            و <?= count($pair_count) - 6 ?> جفت ارز دیگر...
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const miniCtx = document.getElementById('miniPairChart').getContext('2d');
                                new Chart(miniCtx, {
                                    type: 'doughnut',
                                    data: {
                                        labels: <?= json_encode(array_keys($pair_count), JSON_UNESCAPED_UNICODE) ?>,
                                        datasets: [{
                                            data: <?= json_encode(array_values($pair_count)) ?>,
                                            backgroundColor: [
                                                '#3b82f6', '#10b981', '#ef4444', '#f59e0b', '#8b5cf6',
                                                '#ec4899', '#14b8a6', '#f97316', '#6366f1', '#84cc16'
                                            ],
                                            borderWidth: 3,
                                            borderColor: '#ffffff',
                                            hoverOffset: 6
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        cutout: '72%',
                                        plugins: {
                                            legend: {
                                                display: false
                                            },
                                            tooltip: {
                                                callbacks: {
                                                    label: ctx => `${ctx.label}: ${ctx.raw} معامله`
                                                }
                                            }
                                        }
                                    }
                                });
                            });
                        </script>
                    <?php endif; ?>
                    <thead class="border-b">
                        <tr class="text-[var(--muted)]">
                            <th class="text-right py-4">جفت ارز</th>
                            <th class="py-4">تعداد</th>
                            <th class="py-4">سود</th>
                            <th class="py-4">ضرر</th>
                            <th class="py-4">PNL</th>
                            <th class="py-4">وضعیت</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stats as $pair => $s):
                            $winrate = $s['total'] > 0 ? round(($s['profit'] / $s['total']) * 100, 1) : 0;
                        ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4 font-bold"><?= $pair ?></td>
                                <td class="text-center font-bold"><?= $s['total'] ?></td>
                                <td class="text-center text-[var(--success)] font-bold"><?= $s['profit'] ?></td>
                                <td class="text-center text-[var(--danger)] font-bold"><?= $s['loss'] ?></td>
                                <td class="text-center font-bold <?= $s['pnl'] >= 0 ? 'text-[var(--success)]' : 'text-[var(--danger)]' ?>">
                                    <?= number_format($s['pnl'], 2) ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge <?= $s['pnl'] >= 0 ? 'profit' : 'loss' ?>">
                                        <?= $s['pnl'] >= 0 ? 'سودده' : 'ضررده' ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($stats)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-12 text-[var(--muted)] text-lg">این هفته معامله‌ای ثبت نشده است.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <!-- ردیف جمع کل PNL -->
                    <?php
                    $total_pnl_all = array_sum(array_column($stats, 'pnl'));
                    $total_trades_display = number_format($total_trades_all);
                    $total_pnl_display = number_format($total_pnl_all, 2);
                    ?>
                    <tfoot class="bg-gray-50 border-t-2 border-gray-300">
                        <tr class="text-lg font-bold">
                            <td class="py-5 text-right">جمع کل معاملات</td>
                            <td class="text-center"><?= $total_trades_display ?></td>
                            <td colspan="3" class="text-center">مجموع PNL کل دوره</td>
                            <td class="text-center <?= $total_pnl_all >= 0 ? 'text-green-600' : 'text-red-600' ?>">
                                <?= $total_pnl_all >= 0 ? '+' : '' ?><?= $total_pnl_display ?>
                            </td>
                            <td class="text-center">
                                <span class="badge text-lg <?= $total_pnl_all >= 0 ? 'profit' : 'loss' ?>">
                                    <?= $total_pnl_all >= 0 ? 'سود کل' : 'ضرر کل' ?>
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- کارت وین‌ریت کلی -->
        <div class="card mb-8 p-6 bg-gradient-to-br from-purple-50 to-indigo-50 border border-purple-200">
            <div class="flex flex-col items-center text-center">
                <div class="text-5xl font-bold <?= $winrate_color ?> mb-2">
                    <?= $overall_winrate ?>%
                </div>
                <div class="text-lg font-semibold text-gray-700">وین‌ریت کلی (تمام معاملات)</div>
                <div class="text-sm text-gray-500 mt-1">
                    از مجموع <?= number_format($total_trades_all) ?> معامله ثبت‌شده
                </div>
                <?php if ($overall_winrate >= 60): ?>
                    <div class="mt-3 text-sm font-medium text-green-600">عالیه! ادامه بده قهرمان</div>
                <?php elseif ($overall_winrate >= 40): ?>
                    <div class="mt-3 text-sm font-medium text-amber-600">متوسط رو به بالا — با مدیریت ریسک بهتر می‌شه عالی شد</div>
                <?php else: ?>
                    <div class="mt-3 text-sm font-medium text-red-600">نیاز به بازنگری استراتژی</div>
                <?php endif; ?>
            </div>
        </div>
        <footer class="text-center text-xs text-[var(--muted)] mt-12">
            © 2025 Traidy - آموزش ترید حرفه‌ای
        </footer>
    </div>



</body>

</html>

//amar back final