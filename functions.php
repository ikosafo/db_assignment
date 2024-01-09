<?php
//include_once ('config.php');

function lock($item)
{
    return base64_encode(base64_encode(base64_encode($item)));
}
function unlock($item)
{
    return base64_decode(base64_decode(base64_decode($item)));
}



ob_start();
system('ipconfig /all');
$mycom = ob_get_contents();
ob_clean();
$findme = 'physique';
$pmac = strpos($mycom, $findme);
$mac_address = substr($mycom, ($pmac + 33), 17);

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    return $ip_address;
}
$ip_add = getRealIpAddr();



// Date Period
function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}



//Get User Details
function getUser($id)
{
    //global $mysqli;
    return '
        <div class="text-center">
            <a class="edituserbtn" title="Edit User Details" i_index=' . $id . '>
                <span class="icon-wrapper cursor-pointer"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                    stroke-linejoin="round" class="feather feather-edit">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                </span>
            </a>
            <a class="deleteuserbtn" title="Delete User Details" i_index=' . $id . '>
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




//Get Customer Details
function getCustomer($id)
{
    //global $mysqli;
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
            <a class="editcustomerbtn" title="Edit User Details" i_index=' . $id . '>
                <span class="icon-wrapper cursor-pointer"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                    stroke-linejoin="round" class="feather feather-edit">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                </span>
            </a>
            <a class="deletecustomerbtn" title="Delete User Details" i_index=' . $id . '>
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




//Get Product Details
function getProductDetails($id)
{
    //global $mysqli;
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




function getProdName($id)
{
    global $mysqli;
    $getname = $mysqli->query("select * from product where prodid = '$id'");
    $resname = $getname->fetch_assoc();
    $productname = $resname['productname'];

    return '<div>
        <div class="fw-bolder">' . $productname . '</div>
    </div>';
}



function getQuantity($id)
{
    global $mysqli;

    $getname = $mysqli->query("select * from product where prodid = '$id'");
    $resname = $getname->fetch_assoc();
    $quantitysale = $resname['quantity'];
    $reorderlevel = $resname['reorderlevel'];

    if ($reorderlevel == $quantitysale) {
        $colorbadge = "badge-light-warning";
    } else if ($reorderlevel > $quantitysale) {
        $colorbadge = "badge-light-danger";
    } else {
        $colorbadge = "badge-light-success";
    }

    return '<div class="d-flex flex-column text-center">
                <span class="badge ' . $colorbadge . ' fw-bolder mb-25">' . $quantitysale . '</span>
             </div>';
}
