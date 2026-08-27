<?php
session_start();
if(isset($_POST['team_name'])){
    $_SESSION['tie_team'] = trim($_POST['team_name']);
    header("Location: tie_breaker.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tie Breaker Entry</title>
<style>
body{
    background:linear-gradient(135deg,#1d2671,#c33764);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    font-family:Poppins;
}
.box{
    background:#fff;
    padding:30px;
    border-radius:20px;
    width:400px;
    text-align:center;
}
input{
    width:100%;
    padding:12px;
    margin:15px 0;
    border-radius:8px;
    border:1px solid #ccc;
}
button{
    background:#c33764;
    color:#fff;
    padding:12px 30px;
    border:none;
    border-radius:10px;
    font-size:16px;
}
</style>
</head>

<body>
<div class="box">
<h2>🔥 Tie Breaker Round 🔥</h2>
<p>Enter your <b>Team Name</b> to begin</p>

<form method="post">
    <input type="text" name="team_name" placeholder="Team Name" required>
    <button type="submit">Start Tie Breaker</button>
</form>
</div>
</body>
</html>
