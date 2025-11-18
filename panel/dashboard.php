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
<html lang="fa" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>آکادمی ترید — وبلاگ حرفه‌ای</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f8faff;
            --card: #ffffffcc;
            --muted: #556070;
            --accent1: linear-gradient(135deg, #4f46e5, #06b6d4, #9333ea);
            --glass: rgba(255, 255, 255, 0.35);
            --glass-2: rgba(255, 255, 255, 0.25);
            --success: #10b981;
            --danger: #ef4444;
        }

        /* Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        html,
        body {
            height: 100%
        }

        body {
            font-family: 'Vazirmatn', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
            background: linear-gradient(160deg, #ffffff 0%, #eef4ff 30%, #e6faff 70%);
            color: #1a1a1a;
            -webkit-font-smoothing: antialiased;
            direction: rtl;
        }

        /* Top nav */
        header.topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 28px;
            gap: 12px;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.01));
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            position: sticky;
            top: 0;
            backdrop-filter: blur(6px);
            z-index: 50;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px
        }

        .brand .logo {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            background: var(--accent1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 18px;
            box-shadow: 0 6px 20px rgba(12, 8, 30, 0.6);
        }

        .brand h1 {
            font-size: 18px;
            font-weight: 700
        }

        nav.main-nav {
            display: flex;
            gap: 10px;
            align-items: center
        }

        nav.main-nav a {
            color: var(--muted);
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 8px
        }

        nav.main-nav a:hover {
            color: white;
            background: rgba(255, 255, 255, 0.03)
        }

        /* search / actions */
        .actions {
            display: flex;
            align-items: center;
            gap: 12px
        }

        .search {
            background: var(--glass);
            padding: 8px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            width: 320px;
            max-width: 40vw
        }

        .search input {
            background: transparent;
            border: none;
            color: inherit;
            outline: none;
            width: 100%
        }

        .icon-btn {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.03);
            padding: 8px;
            border-radius: 10px;
            cursor: pointer
        }

        /* Layout */
        .wrap {
            max-width: 1200px;
            margin: 28px auto;
            padding: 0 18px;
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 20px
        }

        /* Hero */
        .hero {
            grid-column: 1/3;
            display: flex;
            gap: 20px;
            align-items: center;
            justify-content: space-between;
            padding: 28px;
            border-radius: 14px;
            background: linear-gradient(90deg, rgba(124, 58, 237, 0.12), rgba(6, 182, 212, 0.06));
            box-shadow: 0 8px 30px rgba(2, 6, 23, 0.7)
        }

        .hero-left {
            max-width: 64%
        }

        .hero h2 {
            font-size: 28px;
            margin-bottom: 8px
        }

        .hero p {
            color: var(--muted);
            line-height: 1.6
        }

        .hero-cta {
            display: flex;
            gap: 12px;
            margin-top: 14px
        }

        .btn {
            padding: 10px 16px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-weight: 600
        }

        .btn-primary {
            background: linear-gradient(90deg, #4f46e5, #06b6d4, #9333ea);
            color: white
        }

        .btn-ghost {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.06);
            color: var(--muted)
        }

        /* Posts grid */
        .posts {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px
        }

        .card {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.01));
            padding: 16px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.03);
            box-shadow: 0 6px 20px rgba(2, 6, 23, 0.6)
        }

        .card h3 {
            margin-bottom: 6px
        }

        .meta {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 10px
        }

        .excerpt {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6
        }

        /* Sidebar */
        .sidebar {
            position: relative
        }

        .widget {
            margin-bottom: 16px
        }

        .widget .widget-title {
            font-weight: 700;
            margin-bottom: 8px
        }

        .watchlist {
            display: flex;
            flex-direction: column;
            gap: 10px
        }

        .watchlist .item {
            display: flex;
            justify-content: space-between;
            padding: 8px;
            border-radius: 8px;
            background: var(--glass-2)
        }

        .tag {
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.03)
        }

        /* responsive */
        @media (max-width:1000px) {
            .wrap {
                grid-template-columns: 1fr
            }

            .hero-left {
                max-width: 100%
            }

            .posts {
                grid-template-columns: 1fr
            }
        }

        /* floating helper */
        .fab {
            position: fixed;
            left: 18px;
            bottom: 18px;
            background: linear-gradient(90deg, #06b6d4, #7c3aed);
            padding: 12px;
            border-radius: 999px;
            box-shadow: 0 10px 30px rgba(7, 16, 30, 0.6);
            cursor: pointer
        }

        /* small utilities */
        .muted {
            color: var(--muted)
        }

        a.cta-link {
            color: #c7e9ff;
            text-decoration: none
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
    <header class="topbar">
        <div class="brand">
            <div class="logo">traidy</div>
            <div>
                <h1>Welcome <?php echo ucfirst($user_name) ?></h1>
                <div class="muted" style="font-size:12px">آموزش و ابزارهای حرفه‌ای برای تریدرها</div>
            </div>
        </div>

        <nav class="main-nav">
            <a href="#">مقالات</a>
            <a href="#">دوره‌ها</a>
            <a href="#">ابزارها</a>
        </nav>

        <div class="actions">
            <button class="icon-btn">ورود/عضویت</button>
            <button class="icon-btn"><a href="logout.php">خروج</a></button>
        </div>
    </header>

    <main class="wrap">
        <section class="hero">
            <div class="hero-left">
                <h2>یاد بگیر، تمرین کن، سود کن — مسیر حرفه‌ای شدن در ترید</h2>
                <p>دوره‌ها و مقالات عملی با تمرکز روی روانشناسی بازار، مدیریت سرمایه و استراتژی‌های تست‌شده. ابزارهای همبسته مثل واچ‌لیست و گزارش‌ساز برای دانشجویان حرفه‌ای فراهم است.</p>
                <div class="hero-cta">
                </div>
            </div>
        </section>

        <section>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                <h2 style="font-size:20px">جدیدترین مقالات</h2>
                <a class="cta-link" href="#">مشاهده همه »</a>
            </div>

            <div class="posts">
                <article class="card">
                    <div class="meta">استراتژی</div>
                    <h3>چگونه یک سیستم معاملاتی قابل آزمایش بسازیم</h3>
                    <p class="excerpt">در این مقاله گام‌به‌گام از صفر شروع به کار میکنیم ،تحلیل تکنیکال و فاندامنتال رو با هم بررسی میکنیم و ادامه میدیم تا به سطح متوسط برسیم</p>
                </article>

                <article class="card">
                    <div class="meta">روانشناسی</div>
                    <h3>مدیریت احساسات هنگام ضرر</h3>
                    <p class="excerpt">تکنیک‌های عملی برای کنترل طمع و ترس و حفظ دیسیپلین در شرایط ناپایدار بازار.</p>
                </article>

                <article class="card">
                    <div class="meta">1404/08/15 — آموزش</div>
                    <h3>راهنمای کامل نسبت ریسک به ریوارد</h3>
                    <p class="excerpt">اینجا بهت میگه استراتژیت سودده هست یا ضررده</p>
                    <button class="btn btn-primary"><a href="../trad/tradB.php">شروع</a></button>
                </article>

                <article class="card">
                    <div class="meta">1404/08/10 — ابزارها</div>
                    <h3>شبیه‌ساز معاملاتی: تمرین بدون از دست دادن سرمایه</h3>
                    <p class="excerpt">معرفی ابزارهایی برای تمرین ترید و ساخت سناریوهای بازار جهت بررسی رفتار استراتژی‌ها.</p>
                </article>
            </div>
        </section>

        <aside class="sidebar">
            <div class="widget card">
                <div class="widget-title">دوره‌های پیشنهادی</div>
                <div style="display:flex;flex-direction:column;gap:8px;margin-top:8px">
                    <div style="display:flex;justify-content:space-between;align-items:center">
                        <div>
                            <div style="font-weight:700">دوره پرایس اکشن</div>
                            <div class="muted" style="font-size:13px">سطح پیشرفته</div>
                        </div>
                        <div class="tag">پیشنهاد</div>
                    </div>

                    <div style="display:flex;justify-content:space-between;align-items:center">
                        <div>
                            <div style="font-weight:700">مدیریت سرمایه عملی</div>
                            <div class="muted" style="font-size:13px">سطح متوسط</div>
                        </div>
                        <div class="tag">پرطرفدار</div>
                    </div>
                </div>
            </div>

            <div class="widget card">
                <div class="widget-title">واچ‌لیست شما</div>
                <div class="watchlist" style="margin-top:8px">
                    <div class="item">
                        <div>BTCUSD</div>
                        <div class="muted">34,250</div>
                    </div>
                    <div class="item">
                        <div>Gold</div>
                        <div style="color:var(--success)">+0.8%</div>
                    </div>
                    <div class="item">
                        <div>EURUSD</div>
                        <div class="muted">1.0860</div>
                    </div>
                </div>
            </div>


        </aside>

    </main>

    <button class="fab" title="گزارش مشکل">!</button>

    <footer style="margin-top:40px;padding:28px 18px;text-align:center;color:var(--muted);font-size:14px">
        © 2025 آکادمی ترید — طراحی شده برای تریدرهای حرفه‌ای. تمامی حقوق محفوظ است.
    </footer>

    <script>
        // Dark mode toggle (simple)
        const toggle = document.getElementById('toggleDark');
        toggle.addEventListener('click', () => {
            if (document.documentElement.style.getPropertyValue('--bg')) {
                // emulate light mode by inverting palette (simple switch)
                document.body.style.filter = document.body.style.filter ? '' : 'invert(0.02) hue-rotate(180deg)';
            }
        });

        // Small progressive enhancement: replace demo posts with dynamic JSON if provided
        // window.__POSTS__ = [] // backend will inject
        // function renderPosts(){ /* example to mount dynamic content */ }
    </script>
</body>

</html>