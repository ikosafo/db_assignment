<?php
include("../../../config.php");
include("../../../system_functions.php");


class UserAuthenticator
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function authenticateUser($username, $password, $mac_address, $ip_address)
    {
        $mac_address = NetworkDetails::getMacAddress();
        $ip_address = NetworkDetails::getRealIpAddress();
        $datetime = date('Y-m-d H:i:s');
        $password = md5($password);

        $query = "SELECT * FROM dbo.system_config WHERE username = ? AND password = ?";
        $params = array($username, $password);
        $stmt = sqlsrv_query($this->conn, $query, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $rowcount = sqlsrv_has_rows($stmt);

        $queryStaff = "SELECT * FROM dbo.staff WHERE username = ? AND password = ?";
        $stmtStaff = sqlsrv_query($this->conn, $queryStaff, $params);

        if ($stmtStaff === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $rowcountStaff = sqlsrv_has_rows($stmtStaff);

        if ($rowcount == 0 && $rowcountStaff == 0) {
            $this->logError($username, $datetime, $mac_address, $ip_address);
            return 2; // Error: Wrong username or password
        } else {
            $this->logSuccess($username, $datetime, $mac_address, $ip_address);
            $_SESSION['username'] = $username;
            return 1; // Success: Logged in
        }
    }

    private function logError($username, $datetime, $mac_address, $ip_address)
    {
        $queryError = "INSERT INTO dbo.logs (logdate, section, [message], [user], macaddress, ipaddress, action)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $paramsError = array(
            $datetime, 'login', 'Log in error (Wrong username or password)',
            $username, $mac_address, $ip_address, 'Failed'
        );

        $stmtError = sqlsrv_query($this->conn, $queryError, $paramsError);
        if ($stmtError === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    private function logSuccess($username, $datetime, $mac_address, $ip_address)
    {
        $querySuccess = "INSERT INTO dbo.logs (logdate, section, [message], [user], macaddress, ipaddress, action)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $paramsSuccess = array(
            $datetime, 'Login', $username . ' logged in Successfully',
            $username, $mac_address, $ip_address, 'Successful'
        );

        $stmtSuccess = sqlsrv_query($this->conn, $querySuccess, $paramsSuccess);
        if ($stmtSuccess === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    }
}

// Usage
$userAuthenticator = new UserAuthenticator($conn);

$username = $_POST['username'];
$password = $_POST['password'];

$result = $userAuthenticator->authenticateUser($username, $password, $mac_address, $ip_address);
echo $result;
