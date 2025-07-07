<?php
include 'dbconnect.php';

echo "<h1>🔍 Database Structure Checker</h1>";
echo "<div style='background: #e8f5e8; padding: 15px; border-radius: 8px; margin-bottom: 20px;'>";
echo "<p>This will show you the exact structure of your database tables.</p>";
echo "</div>";

if (!$link) {
    echo "<div style='background: #ffe6e6; padding: 15px; border-radius: 8px; color: red;'>";
    echo "<strong>❌ Database connection failed!</strong>";
    echo "</div>";
    exit;
}

// Check users table structure
echo "<h2>👤 Users Table Structure</h2>";
$users_check = mysqli_query($link, "DESCRIBE users");
if ($users_check) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 20px;'>";
    echo "<tr style='background: #f8f9fa;'><th>Column Name</th><th>Data Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while ($row = mysqli_fetch_assoc($users_check)) {
        echo "<tr>";
        echo "<td style='padding: 8px; font-weight: bold;'>{$row['Field']}</td>";
        echo "<td style='padding: 8px;'>{$row['Type']}</td>";
        echo "<td style='padding: 8px;'>{$row['Null']}</td>";
        echo "<td style='padding: 8px;'>{$row['Key']}</td>";
        echo "<td style='padding: 8px;'>{$row['Default']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<div style='color: red;'>❌ Users table not found or error accessing it</div>";
}

// Show sample data from users table
echo "<h3>📋 Sample Users Data</h3>";
$sample_users = mysqli_query($link, "SELECT * FROM users LIMIT 3");
if ($sample_users && mysqli_num_rows($sample_users) > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 20px;'>";
    
    // Get column headers
    $first_row = true;
    while ($row = mysqli_fetch_assoc($sample_users)) {
        if ($first_row) {
            echo "<tr style='background: #f8f9fa;'>";
            foreach (array_keys($row) as $column) {
                echo "<th style='padding: 8px;'>$column</th>";
            }
            echo "</tr>";
            $first_row = false;
        }
        
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td style='padding: 8px;'>" . htmlspecialchars($value) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<div style='color: orange;'>⚠️ No users found in the table</div>";
}

// Check other important tables
$tables = ['goal', 'review', 'cashflow'];
foreach ($tables as $table) {
    echo "<h2>📊 $table Table Structure</h2>";
    $table_check = mysqli_query($link, "DESCRIBE $table");
    if ($table_check) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 20px;'>";
        echo "<tr style='background: #f8f9fa;'><th>Column Name</th><th>Data Type</th><th>Null</th><th>Key</th></tr>";
        while ($row = mysqli_fetch_assoc($table_check)) {
            echo "<tr>";
            echo "<td style='padding: 8px; font-weight: bold;'>{$row['Field']}</td>";
            echo "<td style='padding: 8px;'>{$row['Type']}</td>";
            echo "<td style='padding: 8px;'>{$row['Null']}</td>";
            echo "<td style='padding: 8px;'>{$row['Key']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Show count of records
        $count_result = mysqli_query($link, "SELECT COUNT(*) as count FROM $table");
        $count = mysqli_fetch_assoc($count_result);
        echo "<p style='color: #666;'>Records in table: {$count['count']}</p>";
    } else {
        echo "<div style='color: red;'>❌ $table table not found</div>";
    }
}

// Suggest correct login query
echo "<h2>🔧 Suggested Login Query Fix</h2>";
$users_columns = mysqli_query($link, "DESCRIBE users");
$user_columns = [];
while ($row = mysqli_fetch_assoc($users_columns)) {
    $user_columns[] = $row['Field'];
}

echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 8px;'>";
echo "<h4>Based on your users table structure, use this in login_check.php:</h4>";

// Determine username column
if (in_array('user_id', $user_columns)) {
    $username_col = 'user_id';
} elseif (in_array('username', $user_columns)) {
    $username_col = 'username';
} else {
    $username_col = 'email';
}

// Determine password column
if (in_array('user_pass', $user_columns)) {
    $password_col = 'user_pass';
} elseif (in_array('password', $user_columns)) {
    $password_col = 'password';
} else {
    $password_col = 'pass';
}

echo "<code style='background: #e9ecef; padding: 10px; display: block; margin: 10px 0;'>";
echo "\$query = \"SELECT * FROM users WHERE $username_col='\$user' AND $password_col='\$pass'\";";
echo "</code>";

echo "<p><strong>Username Column:</strong> $username_col</p>";
echo "<p><strong>Password Column:</strong> $password_col</p>";
echo "</div>";

// Test login functionality
echo "<h2>🧪 Test Login</h2>";
echo "<div style='background: #e3f2fd; padding: 15px; border-radius: 8px;'>";
echo "<p>To test login, try these credentials based on your data:</p>";

$test_user = mysqli_query($link, "SELECT * FROM users LIMIT 1");
if ($test_user && mysqli_num_rows($test_user) > 0) {
    $user_data = mysqli_fetch_assoc($test_user);
    echo "<p><strong>Username:</strong> " . htmlspecialchars($user_data[$username_col]) . "</p>";
    echo "<p><strong>Password:</strong> " . htmlspecialchars($user_data[$password_col]) . "</p>";
    
    echo "<div style='margin-top: 15px;'>";
    echo "<a href='login.php' style='background: #04182d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Test Login Page</a>";
    echo "</div>";
} else {
    echo "<p style='color: orange;'>No users found to test with. Create a user first.</p>";
    echo "<a href='register.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Register New User</a>";
}
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

table {
    font-size: 14px;
}

th {
    background-color: #04182d !important;
    color: white !important;
}

code {
    font-family: 'Courier New', monospace;
    font-size: 14px;
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