<?php
require('../configuration/connection.php');
require('../configuration/functions.php');

$tableAffected = 'tblsupportconvo';

// Check if the request method is POST and content type is JSON
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['CONTENT_TYPE']) || $_SERVER['CONTENT_TYPE'] !== 'application/json') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method or content type']);
    exit;
}

// Disable autocommit for database transactions
$conn->autocommit(false);

try {
    // Decode JSON data from request body
    $requestData = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);

    // Check if 'data' parameter exists in the request data
    if (!isset($requestData)) {
        throw new Exception('Missing required parameters: data');
    }else{

    }

    //Validation of Data like (Ticket number and user who comment)
    $ticketNum = '';

    
    if (!isset($requestData['data'][0]['TicketID'])) {
        throw new Exception('Missing required parameters: Ticket ID');
    }else
    {
        $ticketNum = $requestData['data'][0]['TicketID'];
    }

    if($ticketNum == '')
    {
        throw new Exception('Invalid Ticket Number');    
    }
    
    $selectTicketQuery = "Select * from tblticket where ID = " . $ticketNum;

    $result = $conn->query($selectTicketQuery);
        
    if ($result) {        
        if(mysqli_num_rows($result) <= 0)
        {
            throw new Exception('No Ticket Number Found');           
        }            
        $conn->commit();
    } else {
        throw new Exception('Query failed');
    }


    if (!isset($requestData['data'][0]['UserCommentID'])) {
        throw new Exception('Missing required parameters: UserCommentID');
    }else
    {
        $UserID = $requestData['data'][0]['UserCommentID'];
    }

    if($UserID == '')
    {
        throw new Exception('Invalid User');    
    }

    $selectUserQuery = "Select * from tblUsers where ID = " . $UserID;

    $result = $conn->query($selectUserQuery);
        
    if ($result) {        
        if(mysqli_num_rows($result) <= 0)
        {
            throw new Exception('No User Found');           
        }            
        $conn->commit();
    } else {
        throw new Exception('Query failed');
    }

    

    // Prepare SQL query for insertion
    $table = $tableAffected;//For fixed table name;
    $columns = implode(',', array_keys($requestData['data'][0]));
    $values = [];
    foreach ($requestData['data'] as $item) {
        $values[] = "'" . implode("','", $item) . "'";
    }
    $valuesString = implode('),(', $values);
    $sql = "INSERT INTO $table ($columns) VALUES ($valuesString)";

    // Execute the SQL query
    $result = $conn->query($sql);

    // If query executed successfully, commit transaction and return success response
    if ($result) {
        $conn->commit();
        http_response_code(201);
        echo json_encode(['status' => 'success', 'message' => 'Data inserted successfully']);
    } else {
        // If query failed, throw an exception
        throw new Exception('Query failed');
    }

} catch (Exception $e) {
    // Rollback transaction in case of exception and return error response
    $conn->rollback();
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} finally {
    // Close database connection
    $conn->close();
}