<?php
class FileUploader
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function uploadFile($randno)
    {
        $rand = rand(1, 100000);
        $ext = pathinfo($_FILES['Filedata']['name'], PATHINFO_EXTENSION);
        $newfile = 'uploads/' . date('Ymd') . $rand . "." . $ext;
        $target_path = "../../../uploads/" . date('Ymd') . $rand . "." . $ext;

        if (move_uploaded_file($_FILES['Filedata']['tmp_name'], $target_path)) {
            $query = "UPDATE system_config SET logo = '$newfile' WHERE sysconid = '$randno'";
            $savelogo = mssql_query($this->conn, $query);
            return "The file " . basename($_FILES['Filedata']['name']) . " has been uploaded";
        } else {
            return "There was an error uploading the file, please try again!";
        }
    }
}

// Usage
include('../../../config.php');

$fileUploader = new FileUploader($conn);
$randno = $_POST['randno'];

$result = $fileUploader->uploadFile($randno);
echo $result;
