<?php

//db pw +Ca[WEtlZT+?
//db name/user stan4_timesheet

include_once "config.php";

Class DB_Connect{

private $servername = "";
private $username = "";
private $password = "";
private $config = false;
private $conn = false;
    public function __construct() {
        try { 
            $this->config = new ts_config();
            $this->servername = $this->config->$servername;
            $this->username = $this->username->$username;
            $this->password = $this->password->$password;
            $this->conn = new PDO("mysql:host=$this->servername;dbname=timesheet", $this->username, $this->password);
                if(!$this->conn){
                    throw new exception("Failed to conntect to DB");
                }
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return true;
            }
        catch(PDOException $e)
            {
            echo "Connection failed: " . $e->getMessage();
            return false;
            
            }
    }
    
    function get_staff(){
        $sql = "SELECT * FROM staff";
        $staff = $this->conn->prepare($sql);
        $staff->execute();
        return $staff->fetchAll();
    }
    function get_jobs(){
        $sql = "SELECT * FROM jobs";
        $staff = $this->conn->prepare($sql);
        $staff->execute();
        return $staff->fetchAll();
    }
    function add_job($data){               
            $sql = "INSERT INTO jobs (job_id, client, job_name,quoted_cost)
            VALUES ('".$data['job_id']."', '".$data['client']."', '".$data['job_name']."','".$data['quoted_cost']."')";
            
        if(  $this->conn->exec($sql) ){      
        return true;
        }else{
            return false;
        }
    }
    function update_job($data){               
            $sql = "UPDATE jobs SET job_id = '".$data['job_id']."', client = '".$data['client']."', job_name = '".$data['job_name']."' ,quoted_cost = '".$data['quoted_cost']."' WHERE id = ".$data['id'];
        if(  $this->conn->exec($sql) ){      
        return 1;
        }else{
            return 0;
        }
    }
    function export_times($start,$end,$staff=null){
        if($staff==null){
            $sql = "SELECT tt.id,jj.job_id,jj.client,tt.category,ss.name,tt.description,tt.start,tt.end FROM timeTable as tt INNER JOIN staff ss ON ss.id = tt.staff INNER JOIN jobs jj ON jj.id = tt.job_id WHERE tt.start >= '".$start."' AND tt.end <= '".$end."' ORDER BY tt.start";
        }else{
            $sql = "SELECT tt.id,jj.job_id,jj.client,tt.category,ss.name,tt.description,tt.start,tt.end FROM timeTable as tt INNER JOIN staff ss ON ss.id = tt.staff INNER JOIN jobs jj ON jj.id = tt.job_id WHERE tt.start >= '".$start."' AND tt.end <= '".$end."' AND tt.staff = ".$staff." ORDER BY tt.start";
        }
        
        $timeSheet = $this->conn->prepare($sql);
        $timeSheet->execute();
        $timeSheetData = $timeSheet->fetchAll(PDO::FETCH_ASSOC);
       // echo $sql;
       // echo "<pre>";
       // print_r($timeSheetData);
       // echo "</pre>";
        return $timeSheetData;
    }
    function save_start($data){
        
            $now = date("Y-m-d H:i:s");
            $sql = "INSERT INTO timeTable (job_id, staff, description,start,category)
            VALUES ('".$data['job_id']."', '".$data['staff']."', '".$data['desc']."','".$now."','".$data['jobCat']."')";
            // use exec() because no results are returned
        if($this->conn->exec($sql)){
            echo "true|".strtotime($now)."|".$this->conn->lastInsertId();
        }else{
            echo "false";
        }
           
    }
    function save_end($data){
        $now = date("Y-m-d H:i:s");
       $sql = "UPDATE timeTable SET end = '".$now."' WHERE id=".$data['taskID'];
       if($this->conn->exec($sql)){
           
            echo "true|".strtotime($now);
        }else{
            echo "false";
        }
    }
}


