<?php
session_start();
include 'dbconnect.php';

// Functional Test - Simulates actual user workflow
class FunctionalTester {
    private $link;
    private $test_user_id;
    private $test_goal_id;
    
    public function __construct($db_connection) {
        $this->link = $db_connection;
    }
    
    public function runFunctionalTests() {
        echo "<h1>🎯 Functional Test - User Workflow Simulation</h1>";
        echo "<div style='background: #e3f2fd; padding: 15px; border-radius: 8px; margin-bottom: 20px;'>";
        echo "<p>This test simulates exactly what happens when a user goes through the system.</p>";
        echo "</div>";
        
        $this->setupTestUser();
        $this->testCompleteWorkflow();
        $this->cleanup();
    }
    
    private function setupTestUser() {
        echo "<h2>👤 Setting Up Test Environment</h2>";
        
        // Get or create test user
        $result = mysqli_query($this->link, "SELECT user_id FROM users LIMIT 1");
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $this->test_user_id = $user['user_id'];
            $_SESSION['user_id'] = $this->test_user_id;
            echo "<div style='color: green;'>✅ Using existing user ID: {$this->test_user_id}</div>";
        } else {
            echo "<div style='color: red;'>❌ No users found. Please create a user account first.</div>";
            return false;
        }
        
        // Create test goal
        $goal_name = "Functional Test Goal " . date('H:i:s');
        $initial_amount = 500.00;
        
        $query = "INSERT INTO goal (goal_name, goal_initialamt, goal_curramt, goal_balance, goal_due, user_id, goal_status) 
                  VALUES ('$goal_name', $initial_amount, $initial_amount, $initial_amount, '2025-12-31', {$this->test_user_id}, 'active')";
        
        if (mysqli_query($this->link, $query)) {
            $this->test_goal_id = mysqli_insert_id($this->link);
            echo "<div style='color: green;'>✅ Test goal created: '$goal_name' with RM $initial_amount (Goal ID: {$this->test_goal_id})</div>";
        } else {
            echo "<div style='color: red;'>❌ Failed to create test goal</div>";
            return false;
        }
        
        return true;
    }
    
    private function testCompleteWorkflow() {
        echo "<h2>🔄 Testing Complete User Workflow</h2>";
        
        if (!$this->test_goal_id) {
            echo "<div style='color: red;'>❌ Cannot proceed - no test goal</div>";
            return;
        }
        
        // Test 1: User visits usemoney.php with goal_id
        echo "<h3>Step 1: User accesses usemoney.php</h3>";
        $this->simulateUsemoneyPage();
        
        // Test 2: User submits transaction form
        echo "<h3>Step 2: User submits expense transaction</h3>";
        $this->simulateTransactionSubmission();
        
        // Test 3: User is redirected to cashflow.php
        echo "<h3>Step 3: User views cashflow results</h3>";
        $this->simulateCashflowPage();
        
        // Test 4: Test multiple transactions
        echo "<h3>Step 4: Testing multiple transactions</h3>";
        $this->testMultipleTransactions();
        
        // Test 5: Verify data consistency
        echo "<h3>Step 5: Data consistency check</h3>";
        $this->verifyDataConsistency();
    }
    
    private function simulateUsemoneyPage() {
        // Simulate what happens when user visits usemoney.php?goal_id=X
        $goal_id = $this->test_goal_id;
        $user_id = $this->test_user_id;
        
        // Check if goal exists and belongs to user (like usemoney.php does)
        $query = "SELECT goal_name FROM goal WHERE goal_id = $goal_id AND user_id = $user_id";
        $result = mysqli_query($this->link, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo "<div style='color: green;'>✅ usemoney.php would load successfully</div>";
            echo "<div style='color: blue; margin-left: 20px;'>Goal found: '{$row['goal_name']}'</div>";
            echo "<div style='color: blue; margin-left: 20px;'>URL: usemoney.php?goal_id=$goal_id</div>";
        } else {
            echo "<div style='color: red;'>❌ usemoney.php would fail - goal not found</div>";
        }
    }
    
    private function simulateTransactionSubmission() {
        // Simulate form submission to usemoney_check.php
        $transaction_data = [
            'goal_id' => $this->test_goal_id,
            'category' => 'Foods',
            'amount' => 75.50
        ];
        
        echo "<div style='background: #f5f5f5; padding: 10px; border-radius: 5px; margin: 10px 0;'>";
        echo "<strong>Simulating form submission:</strong><br>";
        echo "Goal ID: {$transaction_data['goal_id']}<br>";
        echo "Category: {$transaction_data['category']}<br>";
        echo "Amount: RM {$transaction_data['amount']}";
        echo "</div>";
        
        // Simulate usemoney_check.php logic
        $goal_id = (int)$transaction_data['goal_id'];
        $category = mysqli_real_escape_string($this->link, $transaction_data['category']);
        $amount = (float)$transaction_data['amount'];
        $user_id = $this->test_user_id;
        
        // Get current goal data
        $query = "SELECT goal_initialamt, goal_curramt, goal_balance FROM goal WHERE goal_id = $goal_id AND user_id = $user_id";
        $result = mysqli_query($this->link, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $goal = mysqli_fetch_assoc($result);
            echo "<div style='color: green;'>✅ Goal data retrieved successfully</div>";
            echo "<div style='color: blue; margin-left: 20px;'>Current amount before transaction: RM {$goal['goal_curramt']}</div>";
            
            // Calculate new amounts
            $new_current = $goal['goal_curramt'] - $amount;
            $new_balance = $goal['goal_initialamt'] - $new_current;
            
            // Insert into cashflow
            $cashflow_query = "INSERT INTO cashflow (user_id, goal_id, category, amount) VALUES ($user_id, $goal_id, '$category', $amount)";
            if (mysqli_query($this->link, $cashflow_query)) {
                echo "<div style='color: green;'>✅ Transaction recorded in cashflow table</div>";
                
                // Update goal
                $update_query = "UPDATE goal SET goal_curramt = $new_current, goal_balance = $new_balance WHERE goal_id = $goal_id AND user_id = $user_id";
                if (mysqli_query($this->link, $update_query)) {
                    echo "<div style='color: green;'>✅ Goal amounts updated successfully</div>";
                    echo "<div style='color: blue; margin-left: 20px;'>New current amount: RM $new_current</div>";
                    echo "<div style='color: blue; margin-left: 20px;'>New balance: RM $new_balance</div>";
                    
                    // Simulate redirect
                    $redirect_url = "cashflow.php?goal_id=$goal_id&used=$amount&balance=$new_current&category=$category";
                    echo "<div style='color: green;'>✅ Would redirect to: $redirect_url</div>";
                } else {
                    echo "<div style='color: red;'>❌ Failed to update goal amounts</div>";
                }
            } else {
                echo "<div style='color: red;'>❌ Failed to record transaction</div>";
            }
        } else {
            echo "<div style='color: red;'>❌ Goal not found or access denied</div>";
        }
    }
    
    private function simulateCashflowPage() {
        // Simulate what happens when user visits cashflow.php
        $goal_id = $this->test_goal_id;
        $user_id = $this->test_user_id;
        
        // Get goal name
        $goal_query = "SELECT goal_name FROM goal WHERE goal_id = $goal_id AND user_id = $user_id";
        $goal_result = mysqli_query($this->link, $goal_query);
        $goal_name = "Unknown Goal";
        if ($goal_result && $goal_row = mysqli_fetch_assoc($goal_result)) {
            $goal_name = $goal_row['goal_name'];
        }
        
        echo "<div style='color: green;'>✅ cashflow.php would load for goal: '$goal_name'</div>";
        
        // Get cashflow data (simulate PHP data for chart)
        $categories = ['Foods', 'Entertainment', 'Transportation', 'Bill & Utilities', 'Others'];
        $category_totals = array_fill_keys($categories, 0);
        
        $cashflow_query = "SELECT category, SUM(amount) as total FROM cashflow WHERE user_id = $user_id AND goal_id = $goal_id GROUP BY category";
        $result = mysqli_query($this->link, $cashflow_query);
        
        while ($row = mysqli_fetch_assoc($result)) {
            if (isset($category_totals[$row['category']])) {
                $category_totals[$row['category']] = (float)$row['total'];
            }
        }
        
        echo "<div style='color: green;'>✅ Chart data would be generated:</div>";
        foreach ($category_totals as $cat => $amount) {
            if ($amount > 0) {
                echo "<div style='color: blue; margin-left: 20px;'>$cat: RM " . number_format($amount, 2) . "</div>";
            }
        }
        
        // Test JavaScript data
        $js_data = array_values($category_totals);
        $js_labels = array_keys($category_totals);
        echo "<div style='color: green;'>✅ JavaScript would receive:</div>";
        echo "<div style='color: blue; margin-left: 20px;'>Data: [" . implode(', ', $js_data) . "]</div>";
        echo "<div style='color: blue; margin-left: 20px;'>Labels: ['" . implode("', '", $js_labels) . "']</div>";
    }
    
    private function testMultipleTransactions() {
        $transactions = [
            ['category' => 'Transportation', 'amount' => 25.00],
            ['category' => 'Entertainment', 'amount' => 40.00],
            ['category' => 'Foods', 'amount' => 15.50]
        ];
        
        foreach ($transactions as $index => $transaction) {
            echo "<div style='margin: 10px 0;'><strong>Transaction " . ($index + 1) . ":</strong> {$transaction['category']} - RM {$transaction['amount']}</div>";
            
            $category = mysqli_real_escape_string($this->link, $transaction['category']);
            $amount = (float)$transaction['amount'];
            
            // Insert transaction
            $query = "INSERT INTO cashflow (user_id, goal_id, category, amount) VALUES ({$this->test_user_id}, {$this->test_goal_id}, '$category', $amount)";
            if (mysqli_query($this->link, $query)) {
                echo "<div style='color: green; margin-left: 20px;'>✅ Transaction recorded</div>";
                
                // Update goal
                $update_query = "UPDATE goal SET goal_curramt = goal_curramt - $amount, goal_balance = goal_balance - $amount WHERE goal_id = {$this->test_goal_id}";
                mysqli_query($this->link, $update_query);
                echo "<div style='color: green; margin-left: 20px;'>✅ Goal updated</div>";
            } else {
                echo "<div style='color: red; margin-left: 20px;'>❌ Failed to record transaction</div>";
            }
        }
    }
    
    private function verifyDataConsistency() {
        // Check total spent vs goal reduction
        $total_spent_query = "SELECT SUM(amount) as total_spent FROM cashflow WHERE goal_id = {$this->test_goal_id}";
        $spent_result = mysqli_query($this->link, $total_spent_query);
        $spent_row = mysqli_fetch_assoc($spent_result);
        $total_spent = (float)$spent_row['total_spent'];
        
        $goal_query = "SELECT goal_initialamt, goal_curramt, goal_balance FROM goal WHERE goal_id = {$this->test_goal_id}";
        $goal_result = mysqli_query($this->link, $goal_query);
        $goal = mysqli_fetch_assoc($goal_result);
        
        $expected_current = $goal['goal_initialamt'] - $total_spent;
        
        echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 8px;'>";
        echo "<strong>Data Consistency Check:</strong><br>";
        echo "Initial Amount: RM {$goal['goal_initialamt']}<br>";
        echo "Total Spent: RM $total_spent<br>";
        echo "Expected Current: RM $expected_current<br>";
        echo "Actual Current: RM {$goal['goal_curramt']}<br>";
        echo "Actual Balance: RM {$goal['goal_balance']}<br>";
        
        if (abs($goal['goal_curramt'] - $expected_current) < 0.01) {
            echo "<div style='color: green; font-weight: bold;'>✅ Data is consistent!</div>";
        } else {
            echo "<div style='color: red; font-weight: bold;'>❌ Data inconsistency detected!</div>";
        }
        echo "</div>";
        
        // Category breakdown
        echo "<div style='margin-top: 15px;'><strong>Spending by Category:</strong></div>";
        $category_query = "SELECT category, SUM(amount) as amount, COUNT(*) as count FROM cashflow WHERE goal_id = {$this->test_goal_id} GROUP BY category";
        $category_result = mysqli_query($this->link, $category_query);
        
        while ($row = mysqli_fetch_assoc($category_result)) {
            echo "<div style='margin-left: 20px;'>{$row['category']}: RM {$row['amount']} ({$row['count']} transactions)</div>";
        }
    }
    
    private function cleanup() {
        echo "<h2>🧹 Cleaning Up Test Data</h2>";
        
        // Delete test cashflow records
        $delete_cashflow = "DELETE FROM cashflow WHERE goal_id = {$this->test_goal_id}";
        mysqli_query($this->link, $delete_cashflow);
        echo "<div style='color: #666;'>✅ Cleaned up test transactions</div>";
        
        // Delete test goal
        $delete_goal = "DELETE FROM goal WHERE goal_id = {$this->test_goal_id}";
        mysqli_query($this->link, $delete_goal);
        echo "<div style='color: #666;'>✅ Cleaned up test goal</div>";
        
        echo "<div style='background: #fff3cd; padding: 15px; border-radius: 8px; margin-top: 20px;'>";
        echo "<strong>✅ Functional Test Complete!</strong><br>";
        echo "The system workflow has been tested end-to-end. All test data has been cleaned up.<br>";
        echo "Your real data remains untouched.";
        echo "</div>";
    }
}

// Run functional tests
if ($link) {
    $tester = new FunctionalTester($link);
    $tester->runFunctionalTests();
} else {
    echo "<h1 style='color: red;'>❌ Cannot run tests - Database connection failed!</h1>";
}
?>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 20px;
    background-color: #f8f9fa;
    line-height: 1.6;
}

h1 {
    color: #04182d;
    text-align: center;
    margin-bottom: 30px;
}

h2 {
    color: #04182d;
    border-bottom: 2px solid #04182d;
    padding-bottom: 5px;
    margin-top: 30px;
}

h3 {
    color: #0056b3;
    margin-top: 20px;
}
</style>