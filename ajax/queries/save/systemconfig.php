<?php
include('../../../config.php');
include("../../../system_functions.php");

class SystemConfiguration
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function saveSystemConfig()
    {
        $companyname = $_POST['companyname'];
        $tagline = $_POST['tagline'];
        $telephone = $_POST['telephone'];
        $whatsapp = $_POST['whatsapp'];
        $emailaddress = $_POST['emailaddress'];
        $currency = $_POST['currency'];
        $address = $_POST['address'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $terms = $_POST['terms'];
        $sysconid = $_POST['sysconid'];

        $mac_address = NetworkDetails::getMacAddress();
        $ip_address = NetworkDetails::getRealIpAddress();
        $datetime = date('Y-m-d H:i:s');

        $insertSystemConfig = "INSERT INTO system_config 
                                (companyname, tagline, address, telephone, whatsapp, emailaddress, currency, terms, username, password, sysconid)
                                VALUES 
                                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $params = array(
            $companyname, $tagline, $address, $telephone, $whatsapp, $emailaddress,
            $currency, $terms, $username, $password, $sysconid
        );

        $stmt = sqlsrv_query($this->conn, $insertSystemConfig, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $insertLogs = "INSERT INTO logs 
                        (logdate, section, [message], [user], macaddress, ipaddress, action)
                        VALUES 
                        (?, ?, ?, ?, ?, ?, ?)";

        $logParams = array(
            $datetime, 'System Config', 'System configured successfully', $username,
            $mac_address, $ip_address, 'Successful'
        );

        $stmtLogs = sqlsrv_query($this->conn, $insertLogs, $logParams);

        if ($stmtLogs === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        echo 1;
    }
}

// Usage
$systemConfig = new SystemConfiguration($conn);
$systemConfig->saveSystemConfig();
