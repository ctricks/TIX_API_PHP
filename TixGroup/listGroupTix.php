<?php
require('../configuration/connection.php');
require('../configuration/functions.php');

$tableAffected = 'tblgroupaccount';
$GroupID = '';
$UserCreatedByID = '';
$isActive = 1;
$DisplayFields = '';

if(!isset($_GET['id']) && !isset($_GET['isActive']) && !isset($_GET['ucb'])) 
{
    $GroupID = '';
    $UserCreatedByID = '';
    $isActive = 1;    
}

if(isset($_GET['id']))
{
    $GroupID = $_GET['id'];
}

if(isset($_GET['ucb']))
{
    $UserCreatedByID = $_GET['ucb'];
}

if(isset($_GET['isActive']))
{
    $isActive = $_GET['isActive'];
}


// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method or content type']);
    exit;
}

// Disable autocommit for database transactions
$conn->autocommit(false);

$filter = '';

if($GroupID <> '')
{
    $filter = ' where ID = ' . $GroupID;
}

if($UserCreatedByID <> '')
{
    $filter = ' where CreatedByID = ' . $UserCreatedByID;
}

if($isActive <> '' and $GroupID <> '')
{
    $filter .= ' and isActive = ' . $isActive;
}else
{
    $filter .= ' where isActive = ' . $isActive;
}

$selectStatement= "Select * from " . $tableAffected . ' ' . $filter . " order by GroupName asc;";

try {
   
    // Execute the query
    $result = $conn->query($selectStatement);
    
    // If query executed successfully, commit transaction and return success response
    if ($result) {
        // Fetch and return the data as JSON
        $data = $result->fetch_all(MYSQLI_ASSOC);

        if(mysqli_num_rows($result) <= 0)
        {
            throw new Exception('No Record Found');           
        }

        http_response_code(200); // OK
        echo json_encode(['status' => 'success', 'data' => $data]);

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