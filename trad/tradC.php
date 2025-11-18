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
    <title>traidy beginner</title>
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
            background-color: #31313177;
            color: #eee;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* ===== هدر ===== */
        header {
            background-color: #1f1f1fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        }

        header {
            background: linear-gradient(90deg, #10b981, #3b82f6, #9333ea);
            padding: 15px 30px;
            /* text-align: center; */
            color: #fff;
            /* font-size: 22px; */
            /* font-weight: bold; */
            letter-spacing: 1px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            animation: gradientMove 6s ease infinite;
            background-size: 300% 300%;
        }


        header .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #000000ff;
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
            background-color: #50505049;
            padding: 15px 30px;
            text-align: center;
            color: #000000ff;
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

        body {
            font-family: 'Tahoma', sans-serif;
            background-color: #1e1e2f;
            color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
            margin: 50px auto;
            padding: 30px;
            background: #2c2c3e;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
            text-align: right;
        }

        h1 {
            text-align: center;
            color: #ffcc00;
            margin-bottom: 20px;
        }

        p {
            line-height: 1.8;
            font-size: 18px;
        }

        ul {
            margin-top: 20px;
            padding-left: 20px;
        }

        li {
            margin-bottom: 10px;
            font-weight: bold;
            color: #ff9966;
        }
    </style>
</head>

<!-- محتوای شما اینجا قرار می‌گیرد -->



<!-- هدر -->
<header>
    <div class="logo">Beginner Trader</div>
    <div class="user-info">
        <span><?php echo ucfirst($user_name) ?></span>
        <button onclick="location.href='../panel/logout.php'" class="logout-btn">Exit</button>
        <button onclick="location.href='../panel/dashboard.php'" class="logout-btn">dashvoard</button>
    </div>
</header>

<div style="direction: rtl; text-align: right;">
<!-- داشبورد اصلی -->
<main>
    
    
    <body>
        <div style="max-width:700px;margin:30px auto;padding:25px;background:#1e1e2f;color:#f5f5f5;border-radius:15px;font-family:sans-serif;line-height:1.6;">
            <h2 style="text-align:center;color:#ffcc00;">آموزش تریدر مبتدی تا متوسط</h2>
                <h3 style="color:#ffa500;">1. آشنایی با بازارهای مالی</h3>
                <p>بازارهای مالی مانند بورس و ارزهای دیجیتال، جایی هستند که افراد می‌توانند با خرید و فروش دارایی‌ها سود کسب کنند. شما باید با مفاهیم پایه مانند <strong>عرضه و تقاضا</strong>، <strong>نقدینگی</strong> و <strong>ریسک</strong> آشنا شوید.</p>

                <h3 style="color:#ffa500;">2. مفاهیم اولیه تحلیل</h3>
                <ul>
                    <li><strong>تحلیل تکنیکال:</strong> بررسی نمودارها و الگوها برای پیش‌بینی حرکت قیمت.</li>
                    <li><strong>تحلیل بنیادی:</strong> بررسی عوامل اقتصادی و اخبار برای ارزش‌گذاری دارایی.</li>
                </ul>

                <h3 style="color:#ffa500;">3. مدیریت ریسک</h3>
                <p>همیشه قبل از ورود به معامله، میزان ریسک خود را مشخص کنید. از ابزارهایی مانند <strong>استاپ لاس</strong> و <strong>حد سود</strong> استفاده کنید تا ضررهای احتمالی محدود شود.</p>

                <h3 style="color:#ffa500;">4. روانشناسی معامله</h3>
                <p>کنترل احساسات در معاملات بسیار مهم است. ترس و طمع می‌توانند تصمیمات شما را تحت تأثیر قرار دهند. برای موفقیت، باید <strong>برنامه معاملاتی مشخص</strong> و <strong>انضباط</strong> داشته باشید.</p>

                <h3 style="color:#ffa500;">5. تمرین با حساب دمو</h3>
                <p>قبل از سرمایه‌گذاری واقعی، از حساب دمو برای تمرین استفاده کنید. این کار به شما کمک می‌کند با محیط بازار آشنا شوید و استراتژی‌های خود را بدون ریسک تست کنید.</p>

                <h3 style="color:#ffa500;">6. رسیدن به سطح متوسط</h3>
                <p>پس از کسب تجربه در سطح مبتدی، می‌توانید مفاهیم پیچیده‌تر مانند <strong>اندیکاتورها</strong>، <strong>الگوهای کندل‌استیک</strong> و <strong>استراتژی‌های ترکیبی</strong> را یاد بگیرید و در معاملات واقعی استفاده کنید.</p>


                <p style="text-align:center;margin-top:15px;font-size:0.9em;color:#aaa;">شروع کنید، تمرین کنید و تجربه کسب کنید تا تبدیل به یک تریدر حرفه‌ای شوید!</p>


            </div>

        </body>

</div>
</div>

</html>

</main>

<!-- فوتر -->
<footer >
    © 2025 آموزش ترید | تمام حقوق محفوظه
</footer>

</body>

</html>