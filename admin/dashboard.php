<?php
session_start();

include 'db.php';

?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<style>
body{
    font-family:Poppins,Arial;
    background:#f5f7fb;
    margin:0;
}
.header{
    background:linear-gradient(135deg,#1d2671,#c33764);
    color:#fff;
    padding:20px;
    text-align:center;
}
.container{padding:20px;}
table{
    border-collapse:collapse;
    width:100%;
    background:#fff;
    margin-bottom:40px;
}
th,td{
    padding:10px;
    border:1px solid #ccc;
    text-align:center;
}
th{
    background:#1d2671;
    color:#fff;
}
h2{color:#1d2671;}
.logout{
    float:right;
    color:#fff;
    text-decoration:none;
    font-weight:bold;
}
</style>
</head>

<body>

<div class="header">
<h1>Admin Dashboard</h1>
<a href="logout.php" class="logout">Logout</a>
</div>

<div class="container">

<!-- MAIN QUIZ RESULTS -->
<h2>📊 Main Quiz Results</h2>
<table>
<tr>
<th>Rank</th>
<th>Team Name</th>
<th>Score</th>
<th>Total</th>
<th>Submitted</th>
</tr>

<?php
$r=1;
$res = $conn->query("SELECT * FROM tie_results ORDER BY score DESC, submitted_at ASC");
while($row=$res->fetch_assoc()):
?>
<tr>
<td><?= $r++ ?></td>
<td><?= htmlspecialchars($row['user_name']) ?></td>
<td><?= $row['score'] ?></td>
<td><?= $row['total_questions'] ?></td>
<td><?= $row['submitted_at'] ?></td>
</tr>
<?php endwhile; ?>
</table>

<!-- TIE BREAKER RESULTS -->
<h2>🔥 Tie Breaker Results</h2>
<table>
<tr>
<th>Rank</th>
<th>Team Name</th>
<th>Score</th>
<th>Total</th>
<th>Submitted</th>
</tr>

<?php
$r=1;
$res = $conn->query("SELECT * FROM tie_results ORDER BY score DESC, submitted_at ASC");
while($row=$res->fetch_assoc()):
?>
<tr>
<td><?= $r++ ?></td>
<td><?= htmlspecialchars($row['user_name']) ?></td>
<td><?= $row['score'] ?></td>
<td><?= $row['total_questions'] ?></td>
<td><?= $row['submitted_at'] ?></td>
</tr>
<?php endwhile; ?>
</table>

</div>
</body>
</html>
