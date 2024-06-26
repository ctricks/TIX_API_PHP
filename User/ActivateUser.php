<?php
require('../configuration/connection.php');
require('../configuration/functions.php');

// Check if the request method is POST and content type is JSON
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method or content type']);
    exit;
}

$tableAffected = 'tblusers';

$UserID = isset($_GET['id']) ? $_GET['id']:'';
$Username = isset($_GET['username']) ? $_GET['username']:'';;



// Disable autocommit for database transactions
$conn->autocommit(false);

try {
    // Decode JSON data from request body 
    $filter = '';

    if($UserID <> '')
    {
        $filter = ' where ID = ' . $UserID;
    }
    
    if($Username <> '')
    {
        $filter = ' where Username = ' . $Username;
    }
    
    if($Username == '' && $UserID == '') // Update isActive status must been filtered in order to not apply in all records
    {
        throw new Exception('De-activate query failed. Please select a filter criteria first');
    }

    $updateStatement= "Update " . $tableAffected . ' set isActive = 1 ' . $filter . " order by Username asc;";

    // Execute the SQL query
    $result = $conn->query($updateStatement);

    // If query executed successfully, commit transaction and return success response
    if ($result) {
        $conn->commit();
        http_response_code(200);
        echo json_encode(['status' => 'success', 'message' => 'Data activated successfully']);
    } else {
        throw new Exception('Activate query failed');
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