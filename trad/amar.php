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
        <div class="chat-bubble">i</div>
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
        <div class="card mb-8 text-center" style="background-color: #1e293b;">
            <h1 class="text-3xl font-bold mb-2" style="color: white;">ژورنال معاملاتی</h1>
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
                                    <?php
                                    // رنگ‌های دقیقاً همون‌هایی که توی چارت استفاده کردی
                                    $colors = [
                                        '#3b82f6',
                                        '#10b981',
                                        '#ef4444',
                                        '#f59e0b',
                                        '#8b5cf6',
                                        '#ec4899',
                                        '#14b8a6',
                                        '#f97316',
                                        '#6366f1',
                                        '#84cc16'
                                    ];
                                    $color_index = 0;
                                    foreach (array_slice($pair_count, 0, 6, true) as $p => $c):
                                        $percent = round(($c / $total_this_week) * 100);
                                        $current_color = $colors[$color_index % 10]; // حداکثر ۱۰ رنگ داریم
                                        $color_index++;
                                    ?>
                                        <div class="flex justify-between items-center text-sm">
                                            <div class="flex items-center gap-3">
                                                <!-- نقطه رنگی کنار اسم جفت ارز -->
                                                <div class="w-3 h-3 rounded-full" style="background-color: <?= $current_color ?>"></div>
                                                <span class="font-medium"><?= $p ?></span>
                                            </div>
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