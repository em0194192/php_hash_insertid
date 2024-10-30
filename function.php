<?php
$dsn = "mysql:host=localhost;dbname=my_guitar_shop2";
$username = "root";
$password = "";

try {
    $db = new PDO($dsn, $username, $password);
    echo ("connected");
} catch (PDOException $e) {
    echo "<p>Error message: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit(); // Ensure the script stops on failure
}

// Prepared statements (enhances security - prevents sql injection)
function preparedStatements()
{
    global $db;
    // 1) Select all from customers
    $stmt1 = $db->prepare("SELECT * FROM customers");
    $stmt1->execute();
    echo "All Customers:<br>";
    //Notice PDO::FETCH_ASSOC When you fetch all, just give me the associative array portion
    $rows = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    //print_r($rows);
    foreach($rows as $row)
    {
        // 
        echo ("Customer: " . htmlspecialchars($row['firstName']) .  htmlspecialchars($row['emailAddress']) . "<br>");
        
    }
}

function preparedParameters()
{
    global $db;
    $sql = "select * from customers where customerID = :customerID";
    $statement = $db->prepare($sql);
    $statement->execute([':customerID' => 1]);
    $cust = $statement->fetch(PDO::FETCH_ASSOC);  // PDO::FETCH_BOTH default or PDO::FETCH_ASSOC
    print_r($cust);


}

// Hash Password Function
function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

function checkPassword($enteredPassword, $hashedPassword)
{
    // Password verification

    if (password_verify($enteredPassword, $hashedPassword)) {
        echo 'Password is valid!';
    } else {
        echo 'Invalid password.';
    }
}

function saveCustomer($password)
{
    echo ("here");
    global $db; 
    // Insert customer data using prepared statement
    $sql = "INSERT INTO customers (emailAddress, password, firstName, lastName) 
        VALUES (:email, :password, :firstName, :lastName)";
    
    $stmt = $db->prepare($sql);

    $stmt->execute([
        ':email' => 'kirsten@otc.edu',
        ':password' => $password,
        ':firstName' => 'Kirsten',
        ':lastName' => 'Markley'
    ]);

    $customerId = $db->lastInsertId();
    
    echo "New customer ID: $customerId<br>";
    SaveOrder($customerId);

}

