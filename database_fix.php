<?php
include 'dbconnect.php';

echo "<h1>🔧 Database Fix for Smart Tiny Bank Tracker</h1>";
echo "<div style='background: #e8f5e8; padding: 15px; border-radius: 8px; margin-bottom: 20px;'>";
echo "<p>This script will fix database structure issues.</p>";
echo "</div>";

if (!$link) {
    echo "<div style='background: #ffe6e6; padding: 15px; border-radius: 8px; color: red;'>";
    echo "<strong>❌ Database connection failed!</strong>";
    echo "</div>";
    exit;
}

echo "<h2>🔍 Checking and Fixing Database Structure</h2>";

// 1. Fix review table - add review_name column
echo "<h3>1. Fixing Review Table</h3>";
$check_review_name = mysqli_query($link, "SHOW COLUMNS FROM review LIKE 'review_name'");
if (mysqli_num_rows($check_review_name) == 0) {
    echo "<div style='color: orange;'>⚠️ Adding missing review_name column...</div>";
    $add_review_name = "ALTER TABLE review ADD COLUMN review_name VARCHAR(100) DEFAULT 'Anonymous'";
    if (mysqli_query($link, $add_review_name)) {
        echo "<div style='color: green;'>✅ review_name column added successfully</div>";
    } else {
        echo "<div style='color: red;'>❌ Failed to add review_name column: " . mysqli_error($link) . "</div>";
    }
} else {
    echo "<div style='color: green;'>✅ review_name column already exists</div>";
}

// 2. Create cashflow table if missing
echo "<h3>2. Checking Cashflow Table</h3>";
$check_cashflow = mysqli_query($link, "SHOW TABLES LIKE 'cashflow'");
if (mysqli_num_rows($check_cashflow) == 0) {
    echo "<div style='color: orange;'>⚠️ Creating cashflow table...</div>";
    $create_cashflow = "CREATE TABLE `cashflow` (
        `cashflow_id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` varchar(100) NOT NULL,
        `goal_id` int(11) NOT NULL,
        `category` varchar(50) NOT NULL,
        `amount` decimal(10,2) NOT NULL,
        `date_created` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`cashflow_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
    
    if (mysqli_query($link, $create_cashflow)) {
        echo "<div style='color: green;'>✅ Cashflow table created successfully</div>";
    } else {
        echo "<div style='color: red;'>❌ Failed to create cashflow table: " . mysqli_error($link) . "</div>";
    }
} else {
    echo "<div style='color: green;'>✅ Cashflow table already exists</div>";
}

// 3. Fix goal table structure
echo "<h3>3. Checking Goal Table Structure</h3>";
$goal_columns = mysqli_query($link, "DESCRIBE goal");
$existing_columns = [];
while ($row = mysqli_fetch_assoc($goal_columns)) {
    $existing_columns[] = $row['Field'];
}

$required_columns = [
    'goal_initialamt' => 'DECIMAL(10,2) DEFAULT 0',
    'goal_curramt' => 'DECIMAL(10,2) DEFAULT 0', 
    'goal_balance' => 'DECIMAL(10,2) DEFAULT 0',
    'goal_status' => 'VARCHAR(20) DEFAULT "active"'
];

foreach ($required_columns as $column => $definition) {
    if (!in_array($column, $existing_columns)) {
        echo "<div style='color: orange;'>⚠️ Adding missing column: $column</div>";
        $alter_query = "ALTER TABLE goal ADD COLUMN $column $definition";
        if (mysqli_query($link, $alter_query)) {
            echo "<div style='color: green;'>✅ Column $column added successfully</div>";
        } else {
            echo "<div style='color: red;'>❌ Failed to add column $column: " . mysqli_error($link) . "</div>";
        }
    } else {
        echo "<div style='color: green;'>✅ Column $column exists</div>";
    }
}

// 4. Update existing goals with proper values
echo "<h3>4. Updating Existing Goals</h3>";
$update_goals = "UPDATE goal SET 
    goal_curramt = COALESCE(NULLIF(goal_curramt, 0), goal_initialamt, goal_amount, 1000),
    goal_balance = COALESCE(NULLIF(goal_balance, 0), goal_initialamt, goal_amount, 1000),
    goal_status = COALESCE(goal_status, 'active')
    WHERE goal_curramt IS NULL OR goal_curramt = 0 OR goal_balance IS NULL";

if (mysqli_query($link, $update_goals)) {
    $affected = mysqli_affected_rows($link);
    echo "<div style='color: green;'>✅ Updated $affected goals with proper amounts</div>";
} else {
    echo "<div style='color: red;'>❌ Failed to update goals: " . mysqli_error($link) . "</div>";
}

// 5. Show current structure
echo "<h2>📋 Current Database Structure</h2>";

// Show tables
$tables = ['users', 'goal', 'review', 'cashflow'];
foreach ($tables as $table) {
    echo "<h4>$table table:</h4>";
    $result = mysqli_query($link, "DESCRIBE $table");
    if ($result) {
        echo "<div style='background: #f8f9fa; padding: 10px; border-radius: 5px; margin: 5px 0;'>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "• {$row['Field']} - {$row['Type']}<br>";
        }
        echo "</div>";
    } else {
        echo "<div style='color: red;'>❌ Table $table does not exist</div>";
    }
}

echo "<div style='background: #d4edda; padding: 20px; border-radius: 8px; margin-top: 30px; text-align: center;'>";
echo "<h3 style='color: #155724; margin: 0 0 15px 0;'>🎉 Database Fix Complete!</h3>";
echo "<p style='color: #155724; margin: 0;'>Your database structure has been fixed. Try accessing your pages again.</p>";
echo "<div style='margin-top: 15px;'>";
echo "<a href='userHomepage.php' style='background: #04182d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>Test User Homepage</a>";
echo "<a href='cashflow.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>Test Cashflow</a>";
echo "</div>";
echo "</div>";

mysqli_close($link);
?>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 20px;
    background-color: #f8f9fa;
    line-height: 1.6;
}

h1, h2, h3 {
    color: #04182d;
}

a {
    text-decoration: none;
    border-radius: 5px;
    display: inline-block;
}

a:hover {
    opacity: 0.8;
}
</style>