<?php
// Database configuration
include('../../config.php');
include('../../system_functions.php');

// Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

// Search 
$searchQuery = "";
$params = array();
if (!empty($searchValue)) {
    $searchQuery = " AND (productname LIKE ? OR quantity LIKE ? OR serialnumber LIKE ? OR sellingprice LIKE ? OR username LIKE ?) ";
    $params = array('%' . $searchValue . '%', '%' . $searchValue . '%', '%' . $searchValue . '%', '%' . $searchValue . '%', '%' . $searchValue . '%');
}


// Total number of records without filtering
$sel = sqlsrv_query($conn, "SELECT COUNT(*) AS allcount FROM dbo.products WHERE status IS NULL");
$records = sqlsrv_fetch_array($sel, SQLSRV_FETCH_ASSOC);
$totalRecords = $records['allcount'];

// Total number of records with filtering
$params = array();
$sql = "SELECT COUNT(*) AS allcount FROM dbo.products WHERE status IS NULL" . $searchQuery;
$stmt = sqlsrv_prepare($conn, $sql, $params);
sqlsrv_execute($stmt);
$records = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
$totalRecordwithFilter = $records['allcount'];

// Fetch records
$params = array();
$sql = "SELECT * FROM dbo.products WHERE status IS NULL" . $searchQuery . " ORDER BY productname OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";
$params[] = $row;
$params[] = $rowperpage;
$stmt = sqlsrv_prepare($conn, $sql, $params);
sqlsrv_execute($stmt);

$data = array();
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $data[] = array(
        "product" => getProdName($row['prodid']),
        "serialnumber" => $row['serialnumber'],
        "quantity" => getQuantity($row['prodid']),
        "sellingprice" => $row['sellingprice'],
        "action" => getProductDetails($row['prodid'])
    );
}


// Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);
