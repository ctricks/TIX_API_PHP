<?php
require('../configuration/connection.php');
require('../configuration/functions.php');

$tableAffected = 'tblusers';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['CONTENT_TYPE']) || $_SERVER['CONTENT_TYPE'] !== 'application/json') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method or content type']);
    exit;
}

// Disable autocommit for database transactions
$conn->autocommit(false);

try {
    $requestData = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);

    //Check the Payload if has or none
    if (!isset($requestData['data'])) {
        throw new Exception('Missing required parameters: data');
    }
        
    
    //Get Value in Data Payload    
    $Username = $requestData['data'][0]['Username'];
    $Password = $requestData['data'][0]['Password'];

    if(!isset($Username))
    {
        throw new Exception('Invalid field. Please check your payload first.');
    }



    $selectStatement = "Select Username,RoleID from tblUsers where Username = '".$Username . "' and Password='" .$Password . "';";

    // Execute the query
    $result = $conn->query($selectStatement);
    
    // If query executed successfully, commit transaction and return success response
    if ($result) {
        // Fetch and return the data as JSON
        $data = $result->fetch_all(MYSQLI_ASSOC);
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