<?php


session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
]);

session_start();

include '../db.php';


if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit;
}


header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


$mainResults = $conn->query("
    SELECT
        id,
        user_name,
        score,
        total_questions,
        timestamp
    FROM results
    ORDER BY score DESC, timestamp ASC
");


$tieResults = $conn->query("
    SELECT
        id,
        team_name,
        score,
        submitted_at
    FROM tie_results
    ORDER BY score DESC, submitted_at ASC
");


$totalTeams = 0;
$topScore = 0;
$averageScore = 0;

$statsResult = $conn->query("
    SELECT
        COUNT(*) AS total_teams,
        COALESCE(MAX(score), 0) AS top_score,
        COALESCE(AVG(score), 0) AS average_score
    FROM results
");

if ($statsResult) {
    $stats = $statsResult->fetch_assoc();

    $totalTeams = (int)$stats['total_teams'];
    $topScore = (int)$stats['top_score'];
    $averageScore = round((float)$stats['average_score'], 2);
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Admin Dashboard</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

@import url('https:

* {
    box-sizing: border-box;
}

body{
    font-family:Poppins,Arial,sans-serif;
    background:#f5f7fb;
    margin:0;
}

.header{
    background:linear-gradient(135deg,#1d2671,#c33764);
    color:#fff;
    padding:20px;
    text-align:center;
    position:relative;
}

.header h1{
    margin:0;
}

.container{
    padding:20px;
}

.stats{
    display:flex;
    gap:15px;
    margin-bottom:30px;
    flex-wrap:wrap;
}

.stat-card{
    flex:1;
    min-width:180px;
    background:#fff;
    padding:20px;
    border-radius:12px;
    box-shadow:0 5px 18px rgba(0,0,0,0.08);
    text-align:center;
}

.stat-card h3{
    margin:0;
    font-size:28px;
    color:#1d2671;
}

.stat-card p{
    margin:5px 0 0;
    color:#666;
}

table{
    border-collapse:collapse;
    width:100%;
    background:#fff;
    margin-bottom:40px;
    box-shadow:0 5px 18px rgba(0,0,0,0.05);
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

tr:nth-child(even){
    background:#fafafa;
}

h2{
    color:#1d2671;
}

.logout{
    position:absolute;
    right:20px;
    top:25px;
    color:#fff;
    text-decoration:none;
    font-weight:bold;
}

.rank-1{
    background:#fff4c2 !important;
    font-weight:bold;
}

.rank-2{
    background:#eeeeee !important;
    font-weight:bold;
}

.rank-3{
    background:#f7e4d4 !important;
    font-weight:bold;
}

.no-results{
    padding:20px;
    text-align:center;
    color:#666;
}

@media (max-width:700px){

    .container{
        padding:10px;
        overflow-x:auto;
    }

    table{
        min-width:650px;
    }

    .logout{
        position:static;
        display:block;
        margin-top:10px;
    }

}

</style>

</head>

<body>

<div class="header">

    <h1>Admin Dashboard</h1>

    <a href="logout.php" class="logout">Logout</a>

</div>

<div class="container">

    <!-- STATS -->

    <div class="stats">

        <div class="stat-card">

            <h3><?= $totalTeams ?></h3>

            <p>Total Teams</p>

        </div>

        <div class="stat-card">

            <h3><?= $topScore ?></h3>

            <p>Highest Score</p>

        </div>

        <div class="stat-card">

            <h3><?= $averageScore ?></h3>

            <p>Average Score</p>

        </div>

    </div>


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

        <?php if ($mainResults && $mainResults->num_rows > 0): ?>

            <?php
            $rank = 1;
            ?>

            <?php while ($row = $mainResults->fetch_assoc()): ?>

                <?php
                $rankClass = '';

                if ($rank === 1) {
                    $rankClass = 'rank-1';
                } elseif ($rank === 2) {
                    $rankClass = 'rank-2';
                } elseif ($rank === 3) {
                    $rankClass = 'rank-3';
                }
                ?>

                <tr class="<?= $rankClass ?>">

                    <td>

                        <?php
                        if ($rank === 1) {
                            echo '🥇 1';
                        } elseif ($rank === 2) {
                            echo '🥈 2';
                        } elseif ($rank === 3) {
                            echo '🥉 3';
                        } else {
                            echo $rank;
                        }
                        ?>

                    </td>

                    <td>
                        <?= htmlspecialchars($row['user_name'], ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <strong><?= (int)$row['score'] ?></strong>
                    </td>

                    <td>
                        <?= (int)$row['total_questions'] ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['timestamp'], ENT_QUOTES, 'UTF-8') ?>
                    </td>

                </tr>

                <?php $rank++; ?>

            <?php endwhile; ?>

        <?php else: ?>

            <tr>

                <td colspan="5" class="no-results">
                    No main quiz results found.
                </td>

            </tr>

        <?php endif; ?>

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

        <?php if ($tieResults && $tieResults->num_rows > 0): ?>

            <?php
            $rank = 1;
            ?>

            <?php while ($row = $tieResults->fetch_assoc()): ?>

                <?php
                $rankClass = '';

                if ($rank === 1) {
                    $rankClass = 'rank-1';
                } elseif ($rank === 2) {
                    $rankClass = 'rank-2';
                } elseif ($rank === 3) {
                    $rankClass = 'rank-3';
                }
                ?>

                <tr class="<?= $rankClass ?>">

                    <td>

                        <?php
                        if ($rank === 1) {
                            echo '🥇 1';
                        } elseif ($rank === 2) {
                            echo '🥈 2';
                        } elseif ($rank === 3) {
                            echo '🥉 3';
                        } else {
                            echo $rank;
                        }
                        ?>

                    </td>

                    <td>
                        <?= htmlspecialchars($row['team_name'], ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <strong><?= (int)$row['score'] ?></strong>
                    </td>

                    <td>
                        5
                    </td>

                    <td>
                        <?= htmlspecialchars($row['submitted_at'], ENT_QUOTES, 'UTF-8') ?>
                    </td>

                </tr>

                <?php $rank++; ?>

            <?php endwhile; ?>

        <?php else: ?>

            <tr>

                <td colspan="5" class="no-results">
                    No tie breaker results found.
                </td>

            </tr>

        <?php endif; ?>

    </table>

</div>

</body>
</html>