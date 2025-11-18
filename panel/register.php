<?php
require_once "../function/functions.php";

session_start();

if (isset($_SESSION['user'])) {
  header('location: dashboard.php');
}


$error = "";
$message = "";

if (isset($_POST['submit'])) {
  $trade_level = $_POST['trade_level'];
  if (
    isset($_POST['name']) && !empty($_POST['name']) &&
    isset($_POST['email']) && !empty($_POST['email']) &&
    isset($_POST['password']) && !empty($_POST['password']) &&
    !empty($trade_level)
  ) {

    if (checkuser($_POST['email'])) {
      $error = "???";
    } else {
      if (checkpassword($_POST['password'])) {
        createuser($_POST['name'], $_POST['email'], $_POST['password']);
        header('location: login.php');
      } else {
        $error = "رمز عبور شما امنیت پایینی دارد";
      }
    }
  } else {
    $error = "لطفا تمام فیلدها را وارد کنید";
  }
}


?>

<!doctype html>
<html lang="fa" dir="rtl">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ثبت نام تریدر</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;600&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Vazirmatn', sans-serif;
    }

    body {
      background-color: #0f0f11;
      color: #eaeaea;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    header {
      background-color: #1a1a1d;
      padding: 15px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
    }

    header h1 {
      font-size: 22px;
      color: #e61919ff;
    }

    nav a {
      color: #aaa;
      margin-left: 20px;
      text-decoration: none;
      font-size: 15px;
      transition: color 0.3s;
    }

    nav a:hover {
      color: #8a2be2;
    }

    main {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 30px 5px;
      flex: 1;
      background: radial-gradient(circle at top left, #141414, #0b0b0b);
    }

    .register-card {
      background-color: rgba(25, 25, 30, 0.95);
      border-radius: 20px;
      padding: 20px;
      width: 100%;
      max-width: 500px;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.6);
      border: 1px solid rgba(80, 80, 120, 0.3);
      transition: all 0.3s ease;
    }

    .register-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 0 35px rgba(100, 100, 255, 0.3);
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #b9b9ff;
    }

    h1 {
      text-align: center;
      color: red;
    }

    .form-group {
      margin-bottom: 25px;
      display: flex;
      flex-direction: column;
    }

    label {
      font-size: 14px;
      color: #aaa;
      margin-bottom: 8px;
    }

    input {
      background-color: #1e1e22;
      border: 1px solid #333;
      border-radius: 10px;
      padding: 12px;
      color: #fff;
      font-size: 15px;
      outline: none;
      transition: 0.3s;
    }

    input:focus {
      border-color: #8a2be2;
      box-shadow: 0 0 10px rgba(138, 43, 226, 0.4);
      background-color: #222227;
    }

    button {
      width: 100%;
      background: linear-gradient(135deg, #4a4aff, #8a2be2);
      border: none;
      border-radius: 10px;
      padding: 12px;
      color: #fff;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
    }

    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 0 20px rgba(138, 43, 226, 0.6);
    }

    footer {
      background-color: #1a1a1d;
      text-align: center;
      padding: 15px;
      font-size: 13px;
      color: #777;
    }

    footer a {
      color: #8a2be2;
      text-decoration: none;
    }

    footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <header>
    <nav>
      <a href="#">ارتباط با ما</a>
    </nav>
  </header>
  <h1> لطفا در انتخاب سطح دقت فرمایید تا در مسیر درست قدم برداریم...</h1>
  <main>
    <div class="register-card">
      <h2>ثبت نام تریدر جدید</h2>
      <p style="color: red;"><?php echo $error ?></p>
      <p style="color: green;"><?php echo $message ?></p>
      <form action="register.php" method="post">
        <div class="form-group">
          <label for="name">نام کامل</label>
          <input type="text" id="name" name="name" placeholder="نام خود را وارد کنید">
        </div>

        <div class="form-group">
          <label for="email">ایمیل</label>
          <input type="email" id="email" name="email" placeholder="example@email.com">
        </div>

        <div class="form-group">
          <label for="password">رمز عبور</label>
          <input type="password" id="password" name="password" placeholder="رمز عبور را وارد کنید">
        </div>

        <div class="form-group">
          <label for="trade_level">سطح ترید</label>
          <select name="trade_level" required>
            <option value="../trad/tradC.php">مبتدی</option>
            <option value="../trad/tradB.php">متوسط</option>
            <option value="../trad/tradA.php">حرفه‌ای</option>
          </select>
        </div>
        <button type="submit" name="submit">ثبت نام</button>
        <p class="text-center text-sm text-gray-400 mt-6" style="text-align: center; margin-top: 10%;">
          عضویت داری؟
          <a href="login.php" class="text-purple-400 hover:underline">اینجا وارد شو</a>
        </p>
      </form>
    </div>
  </main>

  <footer>
    © 2025 همه حقوق محفوظ است | ساخته شده با ❤️ توسط شما
  </footer>
</body>

</html>