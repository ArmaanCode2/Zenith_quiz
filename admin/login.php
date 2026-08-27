<?php


session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
]);

session_start();

if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    
    if ($username === "admin" && $password === "admin@123") {

        
        session_regenerate_id(true);

        $_SESSION['admin'] = true;

        header("Location: dashboard.php");
        exit;

    } else {

        $error = "Invalid login credentials";

    }
}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Login</title>

<style>

@import url('https:

*{
    box-sizing:border-box;
}

body{
    font-family:Poppins,Arial,sans-serif;
    background:linear-gradient(135deg,#1d2671,#c33764);
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    margin:0;
    padding:20px;
}

.box{
    background:#fff;
    padding:40px;
    border-radius:20px;
    width:350px;
    max-width:100%;
    text-align:center;
    box-shadow:0 15px 40px rgba(0,0,0,0.3);
}

.box h2{
    color:#1d2671;
    margin-bottom:25px;
}

input,button{
    width:100%;
    padding:10px;
    margin-top:10px;
    font-size:16px;
}

input{
    border:1px solid #ccc;
    border-radius:6px;
    outline:none;
}

input:focus{
    border-color:#1d2671;
    box-shadow:0 0 0 3px rgba(29,38,113,0.1);
}

button{
    background:#c33764;
    color:#fff;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-weight:600;
}

button:hover{
    opacity:0.9;
}

.error{
    color:red;
    margin-top:10px;
    font-size:14px;
}

</style>

</head>

<body>

<div class="box">

    <h2>Admin Panel Login</h2>

    <form method="post">

        <input
            type="text"
            name="username"
            placeholder="Username"
            autocomplete="username"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Password"
            autocomplete="current-password"
            required
        >

        <button type="submit" name="login">
            Login
        </button>

        <?php if ($error): ?>

            <div class="error">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>

        <?php endif; ?>

    </form>

</div>

</body>
</html>