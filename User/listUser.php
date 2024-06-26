<?php
require('../configuration/connection.php');
require('../configuration/functions.php');

$tableAffected = 'tblusers';
$UserID = '';
$UserCreatedByID = '';
$Username = '';
$DisplayFields = '';

if(!isset($_GET['id']) && !isset($_GET['username']) && !isset($_GET['ucb']) && !isset($_GET['displ'])) 
{
    $UserID = '';
    $Username = '';
    $UserCreatedBy='';
    $DisplayFields = '';
}

if(isset($_GET['id']))
{
    $UserID = $_GET['id'];
}

if(isset($_GET['ucb']))
{
    $UserCreatedByID = $_GET['ucb'];
}

if(isset($_GET['username']))
{
    $Username = $_GET['username'];
}

if(isset($_GET['displ']))
{
    $DisplayFields = $_GET['displ'];
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

if($UserID <> '')
{
    $filter = ' where u.ID = ' . $UserID;
}

if($UserCreatedByID <> '')
{
    $filter = ' where u.CreatedByID = ' . $UserCreatedByID;
}

if($Username <> '')
{
    $filter = ' where u.Username = ' . $Username;
}

$SelectQuery = "u.ID,u.Username,u.RoleID,r.RoleCode,r.Description,u.CreatedById," . 
               "u.DateCreated,u.ModifiedByID,u.DateModfied,u.isActive,u.Remarks " .
               " from " . $tableAffected . " u left join tblroles r on u.RoleID = r.ID ";

$selectStatement= "Select ". $SelectQuery . ' ' . $filter . " order by u.Username asc;";

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