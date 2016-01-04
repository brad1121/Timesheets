<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


include_once "control.php"; 
$db = new DB_Connect();
$staff = $db->get_staff();
//print_r($_POST);

if(isset($_POST['export_times']) && $_POST['export_times']){
$start = $_POST['start']." 00:00:00";
$end = $_POST['end']." 23:59:59";
$staff = $_POST['staff'];
    
 $timeSheet = $db->export_times($start,$end,$staff);

$output = fopen("php://output",'w') or die("Can't open php://output");
header("Content-Type:application/csv;charset=utf-8;"); 
header("Content-Disposition:attachment;filename=Timesheet.csv;"); 
fputcsv($output, array('Task ID','Job No','Client','Job Category','Staff Member','Description','Start','End','Time'));
foreach($timeSheet as $product) {
    $s = strtotime($product['start']);
    $e = strtotime($product['end']);
    $d = abs($s-$e);
    $product['time'] = sprintf('%02d:%02d:%02d', ($d/3600),($d/60%60), $d%60);;
    fputcsv($output, $product);
}
fclose($output) or die("Can't close php://output");
exit();
}
include "header.php";
?>
 <div class="container">
        <div class="row" >
        	<div class="col-xs-12">
                <h4>Select time period to export</h4>
                <form method="post" action="" name="EXPORT_FORM">
                    <div class="input-daterange input-group" id="datepicker">
        <input type="text" class="input-sm form-control" name="start" />
        <span class="input-group-addon">to</span>
        <input type="text" class="input-sm form-control" name="end" />
    </div><br/>
                    Employee (optional) <select name="staff" id="staff_member">
      <option value="">Please select...</option>
                                    <?php
foreach($staff as $staffer){
    echo "<option data-name='".$staffer[name]."' value='".$staffer[id]."'>".$staffer[name]."</option>";
}
                                        ?>
                                    </select>
                <button type="submit" class="pull-right btn btn-success" value="true" name="export_times">Export</button>
                    </form>
            </div>
     </div>
</div>


<?php 
include "footer.php";
?>