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


<?php
// اتصال به دیتابیس
$host = "localhost";
$db   = "trade";
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
            --card: #eef2ff;
            --border: #e2e8f0;
            --text: #1e293b;
            --muted: #64748b;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --input-bg: #f8fafc;
            --input-border: #cbd5e1;
            --input-hover: #e2e8f0;
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
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.16);
        }

        /* استایل یکسان برای input و select */
        input,
        select {
            background-color: var(--input-bg) !important;
            border: 1.5px solid var(--input-border) !important;
            color: var(--text) !important;
            padding: 0.75rem 1rem !important;
            border-radius: 1rem !important;
            font-size: 0.9375rem !important;
            transition: all 0.2s ease;
            width: 100%;
        }

        input:focus,
        select:focus {
            outline: none !important;
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2) !important;
        }

        input:hover,
        select:hover {
            border-color: var(--input-hover) !important;
            background-color: #f1f5f9 !important;
        }

        /* فلش سلکت */
        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: left 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.25em;
            padding-left: 2.5rem !important;
        }

        /* دکمه‌ها */
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

        /* جدول */
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

        /* رنگ سود و ضرر — واضح و قوی */
        tr.profit td {
            background: rgba(34, 197, 94, 0.1) !important;
            color: var(--success) !important;
            font-weight: 600;
        }

        tr.profit td:first-child {
            color: var(--text);
        }

        tr.loss td {
            background: rgba(239, 68, 68, 0.1) !important;
            color: var(--danger) !important;
            font-weight: 600;
        }

        tr.loss td:first-child {
            color: var(--text);
        }

        /* PNL و Amount هم رنگ بگیرن */
        tr.profit td:nth-child(2),
        tr.profit td:nth-child(3) {
            color: var(--success) !important;
        }

        tr.loss td:nth-child(2),
        tr.loss td:nth-child(3) {
            color: var(--danger) !important;
        }

        .account-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
        }

        .pamm {
            background: rgba(239, 68, 68, 0.15);
            color: #1f1c1ce7;
        }

        .real {
            background: rgba(34, 197, 94, 0.15);
            color: #16a34a;
        }

        /* چت بات و بقیه */
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

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
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
                <a href="jurnal.php" class="text-[var(--text)] font-semibold">گزارش کلی</a>
            </nav>
            <div class="flex items-center gap-4">
                <span class="text-sm text-[var(--muted)]"></span>
                <span class="font-bold text-lg"><?php echo ucfirst($user_name) ?></span>
                <div class="logo">traidy</div>
            </div>
        </header>
        
        <!-- فرم -->
        <div class="card mb-10">
            <div class="card mb-8 text-center" style="background-color: #1e293b;">
            <h1 class="text-3xl font-bold mb-2" style="color: #16a34a;">ثبت معاملات</h1>
            </div>
            <form method="POST">
                <input type="hidden" name="index" id="tradeIndex">
                <input type="hidden" name="delete" id="deleteIndex">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div><label class="block text-sm text-[var(--muted)] mb-1">تاریخ</label><input type="date" name="date" id="date" required></div>
                    <div><label class="block text-sm text-[var(--muted)] mb-1">روز</label>
                        <select name="day" id="day" required>
                            <option value="دوشنبه">دوشنبه</option>
                            <option value="سه‌شنبه">سه‌شنبه</option>
                            <option value="چهارشنبه">چهارشنبه</option>
                            <option value="پنج‌شنبه">پنج‌شنبه</option>
                            <option value="جمعه">جمعه</option>
                        </select>
                    </div>
                    <div><label class="block text-sm text-[var(--muted)] mb-1">نوع حساب</label>
                        <select name="account_type" id="account_type" required>
                            <option value="REAL">REAL</option>
                            <option value="PAMM">PAMM</option>
                        </select>
                    </div>
                    <div><label class="block text-sm text-[var(--muted)] mb-1">جفت ارز</label>
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
                    <div><label class="block text-sm text-[var(--muted)] mb-1">نوع</label>
                        <select name="type" id="type">
                            <option value="buy">Buy</option>
                            <option value="sell">Sell</option>
                        </select>
                    </div>
                    <div><label class="block text-sm text-[var(--muted)] mb-1">استراتژی</label>
                        <select name="strategy" id="strategy">
                            <option value="moving">مووینگ</option>
                            <option value="trend">خط روند / شکست</option>
                            <option value="kandel talaie">کندل طلایی</option>
                        </select>
                    </div>
                    <div><label class="block text-sm text-[var(--muted)] mb-1">نتیجه</label>
                        <select name="result" id="result">
                            <option value="profit">سود</option>
                            <option value="loss">ضرر</option>
                        </select>
                    </div>
                    <div><label class="block text-sm text-[var(--muted)] mb-1">حجم</label><input type="number" name="lot" id="lot" step="0.01"></div>
                    <div><label class="block text-sm text-[var(--muted)] mb-1">تایم‌فریم</label>
                        <select name="tf" id="tf">
                            <option value="">انتخاب کنید</option>
                            <option value="M1">M1</option>
                            <option value="M3">M3</option>
                            <option value="M5">M5</option>
                            <option value="M15">M15</option>
                        </select>
                    </div>
                    <div><label class="block text-sm text-[var(--muted)] mb-1">مقدار سود/ضرر</label><input type="number" name="amount" id="amount" step="0.01" min="-100000" required></div>
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
<!-- روز هفته را اتوماتیک پر می‌کند
✔ وقتی Edit را بزنی، اطلاعات را از جدول می‌کشد بالا داخل فرم
✔ قبل از حذف، ازت تأیید می‌گیرد و خطا نمی‌دهد -->
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