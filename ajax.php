<?php
include_once "control.php";

$db = new DB_Connect();

if(isset($_POST["start_job"]) && $_POST["start_job"]){
    $data = array(    
    "job_id"=>$_POST['job'],
    "staff"=>$_POST['staff'],
    "desc"=>$_POST['desc'],
    "jobCat"=>$_POST['Job_Category']
        );
  echo $db->save_start($data);
exit();
}

if(isset($_POST["end_job"]) && $_POST["end_job"]){
    $data = array(    
    "taskID"=>$_POST['taskID'],
          );
  echo $db->save_end($data);
exit();
}
if(isset($_POST["get_staff"]) && $_POST["get_staff"]){
      echo json_encode($db->get_staff());
exit();
}

if(isset($_POST["get_jobs"]) && $_POST["get_jobs"]){
      echo json_encode($db->get_jobs());
exit();
}

if(isset($_POST['update_job']) && $_POST['update_job']){

  $data = array(
    "id" => $_POST["id"],
    "job_id" => $_POST['job_id'],
    "client" => $_POST['client'],
    "job_name" => $_POST['job_name'],
    "quoted_cost" => $_POST['quoted_cost'],
    );
    echo $db->update_job($data);
  exit();
}