<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "excel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo "fail connect";
}
require 'vendor/autoload.php';

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spreadsheet = $reader->load($_FILES['my_file']['tmp_name']);

try {
    $spreadsheet = $reader->load($_FILES['my_file']['tmp_name']);
} catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
    die($e->getMessage());
}

$sheet = $spreadsheet->getActiveSheet();

$res = array();
foreach ($sheet->getRowIterator(2) as $row) {
    $a = array();
    foreach ($row->getCellIterator() as $cell) {
        $a[] = $cell->getFormattedValue();
    }
    $res[$row->getRowIndex()] = $a;
    //$sql ="INSERT INTO score VALUES('$a[0]','$a[1]','$a[2]','$a[3]','$a[4]','$a[5]','$a[6]','$a[7]','$a[8]','$a[9]','$a[10]','$a[11]','$a[12]','$a[13]','$a[14]','$a[15]','$a[16]')";
    echo var_dump($a);
    echo "<br>";
}

?>