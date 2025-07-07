<?php
session_start();
include 'dbconnect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = mysqli_real_escape_string($link, $_SESSION['user_id']);

// Get all user goals
$userGoals = [];
$goalsQuery = "SELECT goal_id, goal_name, goal_initialamt, goal_curramt, goal_balance FROM goal WHERE user_id = '$user_id' ORDER BY goal_name";
$goalsResult = mysqli_query($link, $goalsQuery);
if ($goalsResult) {
    while ($goalRow = mysqli_fetch_assoc($goalsResult)) {
        $userGoals[] = $goalRow;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Smart Tiny Bank Tracker - Goal Navigator</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      color: white;
    }
    
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 40px 20px;
    }
    
    .header {
      text-align: center;
      margin-bottom: 40px;
    }
    
    .header h1 {
      font-size: 3rem;
      margin-bottom: 10px;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    
    .header p {
      font-size: 1.2rem;
      opacity: 0.9;
    }
    
    .goals-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 30px;
      margin-bottom: 40px;
    }
    
    .goal-card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      padding: 30px;
      color: #333;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .goal-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 35px rgba(0,0,0,0.2);
    }
    
    .goal-name {
      font-size: 1.8rem;
      font-weight: bold;
      color: #04182d;
      margin-bottom: 20px;
    }
    
    .goal-details {
      margin-bottom: 25px;
    }
    
    .goal-details p {
      margin: 8px 0;
      font-size: 1.1rem;
    }
    
    .goal-amount {
      font-size: 2rem;
      font-weight: bold;
      color: #28a745;
    }
    
    .action-buttons {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
    }
    
    .btn {
      padding: 12px 20px;
      border: none;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      text-decoration: none;
      text-align: center;
      transition: all 0.3s ease;
      flex: 1;
      min-width: 120px;
    }
    
    .btn-add {
      background: #28a745;
      color: white;
    }
    
    .btn-use {
      background: #dc3545;
      color: white;
    }
    
    .btn-view {
      background: #17a2b8;
      color: white;
    }
    
    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .no-goals {
      text-align: center;
      background: rgba(255, 255, 255, 0.1);
      padding: 60px 40px;
      border-radius: 20px;
      margin: 40px 0;
    }
    
    .no-goals h3 {
      font-size: 2rem;
      margin-bottom: 20px;
    }
    
    .no-goals p {
      font-size: 1.2rem;
      margin-bottom: 30px;
      opacity: 0.9;
    }
    
    .back-home {
      text-align: center;
      margin-top: 40px;
    }
    
    .back-home a {
      background: rgba(255, 255, 255, 0.2);
      color: white;
      padding: 15px 30px;
      border-radius: 25px;
      text-decoration: none;
      font-size: 1.1rem;
      transition: all 0.3s ease;
    }
    
    .back-home a:hover {
      background: rgba(255, 255, 255, 0.3);
      transform: translateY(-2px);
    }
  </style>
</head>
<body>

<div class="container">
  <div class="header">
    <h1><i class="fas fa-bullseye"></i> Your Goals</h1>
    <p>Choose a goal to manage your money</p>
  </div>

  <?php if (empty($userGoals)): ?>
    <div class="no-goals">
      <h3><i class="fas fa-plus-circle"></i> No Goals Yet</h3>
      <p>You haven't created any goals yet. Start by creating your first savings goal!</p>
      <a href="userHomepage.php#newgoal" class="btn btn-add" style="display: inline-block;">
        <i class="fas fa-plus"></i> Create Your First Goal
      </a>
    </div>
  <?php else: ?>
    <div class="goals-grid">
      <?php foreach ($userGoals as $goal): ?>
        <div class="goal-card">
          <div class="goal-name">
            <i class="fas fa-flag"></i> <?= htmlspecialchars($goal['goal_name']) ?>
          </div>
          
          <div class="goal-details">
            <p><strong>Target:</strong> <span class="goal-amount">RM <?= number_format($goal['goal_initialamt'], 2) ?></span></p>
            <p><strong>Current:</strong> RM <?= number_format($goal['goal_curramt'], 2) ?></p>
            <p><strong>Remaining:</strong> RM <?= number_format($goal['goal_balance'], 2) ?></p>
            
            <?php 
            $progress = ($goal['goal_initialamt'] > 0) ? (($goal['goal_curramt'] / $goal['goal_initialamt']) * 100) : 0;
            ?>
            <div style="background: #e9ecef; border-radius: 10px; height: 10px; margin: 15px 0;">
              <div style="background: #28a745; height: 100%; border-radius: 10px; width: <?= min($progress, 100) ?>%;"></div>
            </div>
            <p style="text-align: center; font-size: 0.9rem; color: #666;">
              <?= number_format($progress, 1) ?>% Complete
            </p>
          </div>
          
          <div class="action-buttons">
            <a href="addmoney.php?goal_id=<?= $goal['goal_id'] ?>" class="btn btn-add">
              <i class="fas fa-plus"></i> Add Money
            </a>
            <a href="usemoney.php?goal_id=<?= $goal['goal_id'] ?>" class="btn btn-use">
              <i class="fas fa-minus"></i> Use Money
            </a>
            <a href="cashflow.php?goal_id=<?= $goal['goal_id'] ?>" class="btn btn-view">
              <i class="fas fa-chart-pie"></i> View Chart
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <div class="back-home">
    <a href="userHomepage.php">
      <i class="fas fa-home"></i> Back to Homepage
    </a>
  </div>
</div>

</body>
</html>