<?php
require 'vendor/autoload.php';
$filename='算表';
header('Content-type:application/vnd.ms-excel');  //宣告網頁格式
header("Content-Disposition: attachment; filename=$filename.xls");  //設定檔案名稱

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spreadsheet = $reader->load($_FILES['my_file']['tmp_name']);

try {
    $spreadsheet = $reader->load($_FILES['my_file']['tmp_name']);
} catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
    die($e->getMessage());
}

$sheet = $spreadsheet->getActiveSheet();
$student = "0";
echo "<table border='3px'>";
$res = array();
$addPoint1 = array();
$addPoint2 = array();
$addPoint3 = array();
$yearPoint1 = array();
$yearPoint2 = array();
$yearPoint3 = array();
foreach ($sheet->getRowIterator(2) as $row) {
    $tmp = array();
    foreach ($row->getCellIterator() as $cell) {
        $tmp[] = $cell->getFormattedValue();
    }
    $res[$row->getRowIndex()] = $tmp;
    if($tmp[9]=="必"){
    $point = $tmp[10]*$tmp[11];
    echo "<tr>";
    //echo '<td>'. $tmp[0].'</td>';
    //echo '<td>'. $tmp[1].'</td>';
    echo '<td>'. $tmp[2].'</td>';
    //echo '<td>'. $tmp[3].'</td>';
    //echo '<td>'. $tmp[4].'</td>';
    //echo '<td>'. $tmp[5].'</td>';
    //echo '<td>'. $tmp[6].'</td>';
    echo '<td>'. $tmp[7].'</td>';
    //echo '<td>'. $tmp[8].'</td>';
    //echo '<td>'. $tmp[9].'</td>';
    echo '<td>'. $tmp[10].'</td>';
    echo '<td>'. $tmp[11].'</td>';
    echo '<td>'. $point.'</td>';
    //echo '<td>'. $tmp[12].'</td>';
    //echo '<td>'. $tmp[13].'</td>';
    //echo '<td>'. $tmp[14].'</td>';
    //echo '<td>'. $tmp[15].'</td>';
    //echo '<td>'. $tmp[16].'</td>';
    echo "</tr>";
    if($student == $tmp[2]){
        switch ($tmp[5]) {
            case "醫資一":
                array_push($addPoint1, $point);
                array_push($yearPoint1, $tmp[10]);
                break;
            case "醫資二":
                array_push($addPoint2, $point);
                array_push($yearPoint2, $tmp[10]);
              break;
            case "醫資三":
                array_push($addPoint3, $point);
                array_push($yearPoint3, $tmp[10]);
              break;
            }    
    }
    elseif($student=="0"){
        $student=$tmp[2];
    }
    else{
        $totalPoint1=array_sum($addPoint1);
        $totalPoint2=array_sum($addPoint2);
        $totalPoint3=array_sum($addPoint3);
        $yearPointTotal1=array_sum($yearPoint1);
        $yearPointTotal2=array_sum($yearPoint2);
        $yearPointTotal3=array_sum($yearPoint3);
        echo '<tr><td>一年級積分</td><td>'.$totalPoint1.'</td><td>一年級學分</td><td>'.$yearPointTotal1.'</td></tr>';
        echo '<tr><td>二年級積分</td><td>'.$totalPoint2.'</td><td>二年級學分</td><td>'.$yearPointTotal2.'</td></tr>';
        echo '<tr><td>三年級積分</td><td>'.$totalPoint3.'</td><td>三年級學分</td><td>'.$yearPointTotal3.'</td></tr>';
        $finalPoint="自己算啦幹";
        echo '<tr><td>總積分</td><td>'.$finalPoint.'</td></tr>';
        $addPoint1 = array();
        $addPoint2 = array();
        $addPoint3 = array();
        $yearPoint1 = array();
        $yearPoint2 = array();
        $yearPoint3 = array();
    }
    $student=$tmp[2];
    }
    //echo var_dump($tmp);
    //echo "<br>";
}
echo "</table>";



?>