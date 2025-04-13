<!DOCTYPE html>
<html>
<head>
    <title>Transaction Success</title>
    <?php session_start(); ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=bookstore;charset=utf8', 'root', '');
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Ensure customer ID is set
$custID = isset($_SESSION['CustId']) ? $_SESSION['CustId'] : null;
if (!$custID) {
    die("Error: Customer ID not found in session.");
}

// Get posted data
$firstname = strtoupper(trim($_POST['fname']));
$lastname = strtoupper(trim($_POST['lname']));
$name = $firstname . " " . $lastname;

$Address1 = trim($_POST['add1']);
$Address2 = trim($_POST['add2']);
$City = strtoupper(trim($_POST['city']));
$state = strtoupper(trim($_POST['state']));
$code = trim($_POST['Zipcode']);
$country = strtoupper(trim($_POST['country']));
$Address = "<br>" . $Address1 . "<br>" . $Address2 . "<br>" . $City . " " . $state . "<br> ZipCode: " . $code . " " . $country . " ";

$email = trim($_POST['Email']);
$mno = trim($_POST['nummobile']);
$contact = "<br>Mobile No: " . $mno . "<br>Email: " . $email;

$Amount = trim($_POST['TXN_AMOUNT']);
$OrderId = trim($_POST['ORDER_ID']);

// Insert transaction details into the database
// Adjust the column names to match your actual database structure
$stmt = $db->prepare("INSERT INTO transcationbook (OrderID, Cid, name, Address, contactDetail, price, txnStatus) VALUES (?, ?, ?, ?, ?, ?, ?)");
$txnStatus = 'TXN_SUCCESS'; // Assuming the transaction is successful
$success = $stmt->execute([$OrderId, $custID, $name, $Address, $contact, $Amount, $txnStatus]);

if (!$success) {
    die("Error inserting transaction: " . implode(", ", $stmt->errorInfo()));
}

// Display success message
?>
<div class="container text-center">
    <div class="row text-center">
        <div class="col-md-12">
            <h1>Transaction Successful!</h1>
            <p>Your transaction has been recorded successfully.</p>
            <p>Order ID: <?php echo htmlspecialchars($OrderId); ?></p>
            <p>Amount: <?php echo htmlspecialchars($Amount); ?></p>
            <p>Name: <?php echo htmlspecialchars($name); ?></p>
            <p>Address: <?php echo $Address; ?></p>
            <p>Contact: <?php echo $contact; ?></p>
            <a href="profile.php" class="btn btn-outline-success">View Profile</a>
        </div>
    </div>
</div>
</body>
</html>