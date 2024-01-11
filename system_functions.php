<?php

class NetworkDetails
{
    public static function getMacAddress()
    {
        ob_start();
        system('ipconfig /all');
        $mycom = ob_get_contents();
        ob_clean();

        $findme = 'physique';
        $pmac = strpos($mycom, $findme);
        $mac_address = substr($mycom, ($pmac + 33), 17);

        return $mac_address;
    }

    public static function getRealIpAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is passed from proxy
        {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }
        return $ip_address;
    }
}

// Usage
$mac_address = NetworkDetails::getMacAddress();
$ip_address = NetworkDetails::getRealIpAddress();


//Get Logo
function getLogo($conn)
{
    $getlogo = sqlsrv_query($conn, "SELECT * FROM system_config");
    if ($getlogo === false) {
        return "default_logo.png"; // Handle the case where the query fails
    }

    if (sqlsrv_has_rows($getlogo)) {
        $reslogo = sqlsrv_fetch_array($getlogo, SQLSRV_FETCH_ASSOC);
        return $reslogo['logo'] ?? "default_logo.png"; // Use null coalescing operator to handle null value
    } else {
        return "default_logo.png"; // Handle the case where no data is retrieved from the query
    }
}


//Get Company Name
function getCompanyName($conn)
{
    $getcomname = sqlsrv_query($conn, "SELECT * FROM system_config");
    $rescomname = sqlsrv_fetch_array($getcomname, SQLSRV_FETCH_ASSOC);
    return $rescomname['companyname'];
}

//Get Company Tagline
function getCompanyTagline($conn)
{
    $getcomname = sqlsrv_query($conn, "SELECT * FROM system_config");
    $rescomname = sqlsrv_fetch_array($getcomname, SQLSRV_FETCH_ASSOC);
    return $rescomname['tagline'];
}

//Get Company Address
function getCompanyAddress($conn)
{
    $getcomname = sqlsrv_query($conn, "SELECT * FROM system_config");
    $rescomname = sqlsrv_fetch_array($getcomname, SQLSRV_FETCH_ASSOC);
    return $rescomname['address'];
}

//Get Company Telephone
function getCompanyTelephone($conn)
{
    $getcomname = sqlsrv_query($conn, "SELECT * FROM system_config");
    $rescomname = sqlsrv_fetch_array($getcomname, SQLSRV_FETCH_ASSOC);
    return $rescomname['telephone'];
}

//Get whatsapp number
function getCompanyWhatsapp($conn)
{
    $getcomname = sqlsrv_query($conn, "SELECT * FROM system_config");
    $rescomname = sqlsrv_fetch_array($getcomname, SQLSRV_FETCH_ASSOC);
    return $rescomname['whatsapp'];
}

//Get email address
function getCompanyEmail($conn)
{
    $getcomname = sqlsrv_query($conn, "SELECT * FROM system_config");
    $rescomname = sqlsrv_fetch_array($getcomname, SQLSRV_FETCH_ASSOC);
    return $rescomname['emailaddress'];
}

//Get email address
function getStaffName($conn, $id)
{
    $getcomname = sqlsrv_query($conn, "select * from dbo.Employee where employeeNo = '$id'");
    $rescomname = sqlsrv_fetch_array($getcomname, SQLSRV_FETCH_ASSOC);
    return $rescomname['firstName'] . ' ' . $rescomname['middleName'] . ' ' . $rescomname['lastName'];
}


//Get Product Name
function getProductName($conn, $productNo)
{
    $getcomname = sqlsrv_query($conn, "SELECT * FROM dbo.Product where productNo = '$productNo'");
    $rescomname = sqlsrv_fetch_array($getcomname, SQLSRV_FETCH_ASSOC);
    return $rescomname['productName'];
}


//Get Product Name
function getProductPrice($conn, $productNo)
{
    $getcomname = sqlsrv_query($conn, "SELECT * FROM dbo.Product where productNo = '$productNo'");
    $rescomname = sqlsrv_fetch_array($getcomname, SQLSRV_FETCH_ASSOC);
    return $rescomname['unitPrice'];
}

//Get Customer name from orders
function getCustomerName($conn, $genNo)
{
    $getcomname = sqlsrv_query($conn, "SELECT * FROM dbo.Customer where genNo = '$genNo'");
    $rescomname = sqlsrv_fetch_array($getcomname, SQLSRV_FETCH_ASSOC);
    return $rescomname['customerName'];
}

//Get Customer telephone from orders
function getCustomerTel($conn, $genNo)
{
    $getcomname = sqlsrv_query($conn, "SELECT * FROM dbo.Customer where genNo = '$genNo'");
    $rescomname = sqlsrv_fetch_array($getcomname, SQLSRV_FETCH_ASSOC);
    return $rescomname['custTelNo'];
}


// Starting the session after establishing the connection
session_start();



//Get Product Details
function getProductDetails($id)
{
    return '
        <div class="text-center">
           
            <a class="editproductbtn" title="Edit Product Details" i_index=' . $id . '>
                <span class="icon-wrapper cursor-pointer"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                    stroke-linejoin="round" class="feather feather-edit">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                </span>
            </a>
            <a class="deleteproductbtn" title="Delete Product Details" i_index=' . $id . '>
                <span class="icon-wrapper cursor-pointer"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                    class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                </span>
            </a>
     
        </div>';
}



//Get Employee Details
function getUserDetails($id)
{
    return '
        <div class="text-center">
            <a class="viewproductbtn" title="View Product Details" i_index=' . $id . '>
                <span class="icon-wrapper cursor-pointer"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                    stroke-linejoin="round" class="feather feather-eye">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle></svg>
                </span>
            </a>
           
            <a class="deleteemployeebtn" title="Delete Product Details" i_index=' . $id . '>
                <span class="icon-wrapper cursor-pointer"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                    class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                </span>
            </a>
     
        </div>';
}


//Get Employee Details
function getCustomerDetails($id)
{
    return '
        <div class="text-center">
            <a class="viewcustomerbtn" title="View Customer Details" i_index=' . $id . '>
                <span class="icon-wrapper cursor-pointer"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                    stroke-linejoin="round" class="feather feather-eye">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle></svg>
                </span>
            </a>
           
            <a class="deletecustomerbtn" title="Delete Customer Details" i_index=' . $id . '>
                <span class="icon-wrapper cursor-pointer"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                    class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                </span>
            </a>
     
        </div>';
}


//Get order Details
function processOrder($id)
{
    return '
        <div class="text-center">
            <a href="#." class="processorderbtn" title="Process Order" i_index=' . $id . '>
                Process Order
            </a> <hr>
            <a href="#." class="printinvoicebtn" title="Process Order" i_index=' . $id . '>
            Print Invoice
        </a>
        </div>';
}


//process to shipping Details
function processShipping($id)
{
    return '
        <div class="text-center">
            <a href="#." class="processshipingbtn" title="Packaged and Shipped" i_index=' . $id . '>
                Packaged and Shipped
            </a> 
        </div>';
}


function getOrderCountForGenNo($conn, $genNo)
{
    $query = "SELECT COUNT(*) AS orderCount FROM dbo.tempOrder WHERE genNo = ?";
    $params = array($genNo);

    $result = sqlsrv_query($conn, $query, $params);

    if ($result === false) {
        echo "Error fetching order count: </br>";
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

    return ($row) ? $row['orderCount'] : 0;
}
