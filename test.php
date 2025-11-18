//form asli khodam
<?php
require_once "functions.php";
session_start();
if (isset($_SESSION['user'])) {
    header('location:index.php');
    exit;
}

$error = "";

if (isset($_POST['submit'])) {
    if (
        isset($_POST['email']) && !empty($_POST['email'])
        && isset($_POST['password']) && !empty($_POST['password'])
    ) {
        $password = $_POST['password'];
        $user = checkUser($_POST['email']);
        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user'] = $user->id;
            header('location: index.php');
            exit;
        } else {
            $error = "اطلاعات وارد شده صحیح نیست";
        }
    } else {
        $error = "لطفا تمام فیلد ها را تکمیل کنید";
    }
}


?>






<?php
// require_once "functions.php";
// $error = "";
// $message = "";

// session_start();

// if (isset($_POST['submit'])) {
//     if (
//         isset($_POST['email']) && !empty($_POST['email']) &&
//         isset($_POST['password']) && !empty($_POST['password'])
//     ) {
//         $user = checkuser($_POST['email']);


//         if ($user && password_verify($_POST['password'], $user->password)) {
//             $_SESSION['user'] = $user->id;
//             header('location: index.php');
//             exit;
//         } else {
//             $error = "1اطلاعات وارد شده صحیح نیست";
//         }
//     } else {
//         $error = "2اطلاعات وارد شده صحیح نیست";
//     }
// } else {
//     $error = "فیلد را پر کنید";
// }

?>
<!-- 

<?php
echo "<pre style='background:#000;color:#0f0;font-family:Consolas;padding:15px;border:1px solid #0f0;'>";
echo "دیباگ شروع شد...\n";
echo "زمان: " . date('H:i:s') . "\n\n";
echo "--------------------------------------------\n";
$error = "";
$message = "";
require_once "functions.php";
echo "فایل functions.php لود شد.\n";

session_start();
echo "جلسه شروع شد. SESSION ID: " . session_id() . "\n";

if (isset($_SESSION['user'])) {
    echo "کاربر قبلاً وارد شده. ریدایرکت به index.php\n";
    header('location: index.php');
    exit;
}
echo "کاربر وارد نشده. ادامه...\n";

// --- بررسی submit ---
if (isset($_POST['submit'])) {
    echo "\nفرم ارسال شده!\n";
    echo "داده‌های POST:\n";
    print_r($_POST);

    // --- بررسی فیلدها ---
    if (
        isset($_POST['email']) && !empty($_POST['email']) &&
        isset($_POST['password']) && !empty($_POST['password'])
    ) {
        echo "\nفیلدهای ایمیل و رمز پر هستند.\n";
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        echo "ایمیل: $email\n";
        echo "رمز (خام): $password\n";

        // --- فراخوانی checkUser ---
        echo "\nدر حال فراخوانی تابع checkUser('$email')...\n";
        $user = checkUser($email);

        if ($user === false) {
            echo "تابع checkUser مقدار false برگرداند (هیچ کاربری پیدا نشد).\n";
        } elseif ($user === null) {
            echo "تابع checkUser مقدار null برگرداند (خطا در کوئری).\n";
        } elseif (is_object($user)) {
            echo "کاربر پیدا شد! اطلاعات:\n";
            echo "ID: " . $user->id . "\n";
            echo "Email: " . $user->email . "\n";
            echo "Password Hash: " . substr($user->password, 0, 20) . "...\n";
        } else {
            echo "نوع غیرمنتظره از checkUser برگشت: " . gettype($user) . "\n";
            var_dump($user);
        }

        // --- بررسی password_verify ---
        if ($user && is_object($user) && isset($user->password)) {
            echo "\nدر حال بررسی رمز با password_verify...\n";
            $verify_result = password_verify($password, $user->password);
            echo "نتیجه password_verify: " . ($verify_result ? "درست" : "غلط") . "\n";

            if ($verify_result) {
                echo "\nرمز درست است! ورود موفق.\n";
                $_SESSION['user'] = $user->id;
                echo "SESSION['user'] = " . $_SESSION['user'] . "\n";

                echo "\nریدایرکت به index.php...\n";
                header('location: index.php');
                exit;
            } else {
                echo "\nرمز اشتباه است.\n";
                $error = "اطلاعات وارد شده صحیح نیست";
            }
        } else {
            echo "\n$user یا $user->password وجود ندارد.\n";
            $error = "اطلاعات وارد شده صحیح نیست";
        }
    } else {
        echo "\nیکی از فیلدها خالی یا وجود ندارد.\n";
        $error = "لطفا تمام فیلد ها را تکمیل کنید";
    }
} else {
    echo "\nفرم ارسال نشده. منتظر ورود کاربر...\n";
}

echo "\n--------------------------------------------\n";
echo "خطاها:\n";
if ($error) {
    echo "خطا: $error\n";
} else {
    echo "بدون خطا (تا اینجا)\n";
}
echo "</pre>";
?>
 -->
