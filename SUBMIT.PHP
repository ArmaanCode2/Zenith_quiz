<?php
session_start();

include 'db.php';

$user_name = $_POST['user_name'];
$answers = $_POST['answer'] ?? [];

/* Save responses */
foreach($answers as $q_id => $selected){
    $res = $conn->query("SELECT correct_option FROM questions WHERE id=$q_id");
    $row = $res->fetch_assoc();
    $is_correct = ($selected === $row['correct_option']) ? 1 : 0;

    $stmt = $conn->prepare(
        "INSERT INTO responses (user_name, question_id, selected_option, is_correct) 
         VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("sisi", $user_name, $q_id, $selected, $is_correct);
    $stmt->execute();
}

/* Save final score (hidden from user) */
$total_questions = count($_SESSION['questions']);
$score = 0;
foreach($answers as $q_id => $selected){
    $res = $conn->query("SELECT correct_option FROM questions WHERE id=$q_id");
    $row = $res->fetch_assoc();
    if($selected === $row['correct_option']) $score++;
}
$stmt = $conn->prepare(
    "INSERT INTO results (user_name, score, total_questions) VALUES (?, ?, ?)"
);
$stmt->bind_param("sii", $user_name, $score, $total_questions);
$stmt->execute();

unset($_SESSION['questions']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz Submitted</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
        body{
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg,#1d2671,#c33764);
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
            margin:0;
        }
        .message-box{
            background:#fff;
            padding:50px;
            border-radius:20px;
            box-shadow:0 25px 50px rgba(0,0,0,0.25);
            text-align:center;
            max-width:600px;
            animation:fadeIn 1s ease-in-out;
        }
        .message-box h2{
            color:#1d2671;
            margin-bottom:20px;
            font-size:28px;
        }
        .message-box p{
            font-size:18px;
            color:#444;
            line-height:1.6;
        }
        @keyframes fadeIn{
            0%{opacity:0; transform: translateY(-20px);}
            100%{opacity:1; transform: translateY(0);}
        }
        .suspense{
            color:#c33764;
            font-weight:700;
            font-size:20px;
            margin-top:20px;
            animation:blink 1.2s infinite;
        }
        @keyframes blink{
            0%,50%,100%{opacity:1;}
            25%,75%{opacity:0;}
        }
    </style>
</head>
<body>

<div class="message-box">
    <h2>Quiz Submitted Successfully ✅</h2>
    <p>Thank you for participating, <b><?= htmlspecialchars($user_name) ?></b>!  
    Your responses have been recorded safely.</p>

    <p class="suspense">
        The results will be revealed soon…  
        Keep your eyes glued to our <b>Instagram page</b> for the big announcement! 📣
    </p>

    <p>Who will emerge as the champion? The suspense is real… 👀🔥</p>
</div>

</body>
</html>
