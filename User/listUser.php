<?php
require('../configuration/connection.php');
require('../configuration/functions.php');

$tableAffected = 'tblusers';
$UserID = '';
$Username = '';

if(!isset($_GET['id']) && !isset($_GET['username']))
{
    $UserID = '';
    $Username = '';
}

if(isset($_GET['id']))
{
    $UserID = $_GET['id'];
}

if(isset($_GET['username']))
{
    $Username = $_GET['username'];
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method or content type']);
    exit;
}

// Disable autocommit for database transactions
$conn->autocommit(false);

$filter = '';

if($UserID <> '')
{
    $filter = ' where ID = ' . $UserID;
}

if($Username <> '')
{
    $filter = ' where Username = ' . $Username;
}

$selectStatement= "Select * from " . $tableAffected . ' ' . $filter . " order by Username asc;";

try {
   
    // Execute the query
    $result = $conn->query($selectStatement);
    
    // If query executed successfully, commit transaction and return success response
    if ($result) {
        // Fetch and return the data as JSON
        $data = $result->fetch_all(MYSQLI_ASSOC);
        http_response_code(200); // OK
        echo json_encode(['status' => 'success'.$userID, 'data' => $data]);

        // Commit the transaction if everything is successful
        $conn->commit();
    } else {
        // If query failed, throw an exception
        throw new Exception('Query failed');
    }
} catch (Exception $e) {
    // Rollback the transaction on any exception
    $conn->rollback();
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} finally {
    // Close the database connection
    $conn->close();
}