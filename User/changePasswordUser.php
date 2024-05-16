<?php
require('../configuration/connection.php');
require('../configuration/functions.php');

// Check if the request method is POST and content type is JSON
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['CONTENT_TYPE']) || $_SERVER['CONTENT_TYPE'] !== 'application/json') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method or content type']);
    exit;
}

$tableAffected = 'tblusers';

// Disable autocommit for database transactions
$conn->autocommit(false);

try {
    // Decode JSON data from request body
    $requestData = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);

    // Check if 'data' parameter exists in the request data
    if (!isset($requestData['data'])) {
        throw new Exception('Missing required parameters: data');
    }


    // Prepare SQL query for insertion
    $table = $tableAffected; //$requestData['table'];
    $dataToUpdate = $requestData['data'][0];
    $dataWhoModified = $requestData['data'][0]['ModifiedBy'];

    //Check first the user who modifies
    $dataUser = $requestData['data'][0]['username'];
    $dataWhoUpdate = (int)$requestData['data'][0]['ModifiedBy'];
    $dataOldPassword = $requestData['data'][0]['old_password'];
    $dataPasswordUpdate = $requestData['data'][0]['new_password'];
    $remarks = $requestData['data'][0]['Remarks'];

    if(!isset($dataWhoUpdate))
    {
        throw new Exception('Error Update: ID of user who update this is not found.');
    }
    
    if($dataWhoUpdate < 1)
    {
        throw new Exception('Error Update: ID of user who update this is not found.');
    }

    $sql_check_user_role = "Select ID from tblusers where ID = " .$dataWhoModified;


    $result = $conn->query($sql_check_user_role);
    
      // If query executed successfully, commit transaction and return success response
    if ($result) {
        //Count record matched user using username        
        $rowcount=mysqli_num_rows($result);
        
        if($rowcount <= 0)
        {        
            echo json_encode(['status' => 'Failed', 'data' => 'Role ID not found...']);            
        }
    } else {
        // If query failed, throw an exception
        throw new Exception('Query failed');
    }
    

    $sql = "UPDATE $table SET password='" . $dataPasswordUpdate . "',ModifiedByID = '" .$dataWhoUpdate . 
            "',Remarks = '" . $remarks .
            "',DateModified = now() where password = '" . 
            $dataOldPassword ."' and username = '" .$dataUser . "'";
    
    // Execute the SQL query
    $result = $conn->query($sql);

    // If query executed successfully, commit transaction and return success response
    if ($result) {
        $conn->commit();
        http_response_code(201);
        echo json_encode(['status' => 'success', 'message' => 'Data updated successfully']);
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