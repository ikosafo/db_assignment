<?php
## Database configuration
include('../../config.php');
include("../../system_functions.php");

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($mysqli, $_POST['search']['value']); // Search value

## Search 
$searchQuery = " ";
if ($searchValue != '') {
    $searchQuery = " and (productname like '%" . $searchValue . "%' or 
   quantity like '%" . $searchValue . "%' or 
   serialnumber like '%" . $searchValue . "%' or
   sellingprice like '%" . $searchValue . "%' or
   username like '%" . $searchValue . "%') ";
}

## Total number of records without filtering
$sel = mysqli_query($mysqli, "select count(*) as allcount from product where status IS NULL ");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysqli_query($mysqli, "select count(*) as allcount from product WHERE status IS NULL AND 1 " . $searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select * from product WHERE status IS NULL AND 1 " . $searchQuery . " order by productname limit " . $row . "," . $rowperpage;
$empRecords = mysqli_query($mysqli, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "product" => getProdName($row['prodid']),
        "serialnumber" => $row['serialnumber'],
        "quantity" => getQuantity($row['prodid']),
        "reorderlevel" => $row['reorderlevel'],
        "reorderquantity" => $row['reorderquantity'],
        "sellingprice" => $row['sellingprice'],
        "action" => getProductDetails($row['prodid'])
    );
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);
