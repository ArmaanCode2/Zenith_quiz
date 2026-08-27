<?php
session_start();
if(isset($_SESSION['admin'])) header("Location: dashboard.php");

$error = "";
if(isset($_POST['login'])){
    if($_POST['username']=="admin" && $_POST['password']=="admin@123"){
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
<title>Admin Login</title>
<style>
body{
    font-family:Poppins,Arial;
    background:linear-gradient(135deg,#1d2671,#c33764);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}
.box{
    background:#fff;
    padding:40px;
    border-radius:20px;
    width:350px;
    text-align:center;
    box-shadow:0 15px 40px rgba(0,0,0,0.3);
}
input,button{
    width:100%;
    padding:10px;
    margin-top:10px;
    font-size:16px;
}
button{
    background:#c33764;
    color:#fff;
    border:none;
    border-radius:6px;
}
.error{color:red;margin-top:10px;}
</style>
</head>

<body>
<div class="box">
<h2>Admin Panel Login</h2>
<form method="post">
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<button name="login">Login</button>
<?php if($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
</form>
</div>
</body>
</html>
