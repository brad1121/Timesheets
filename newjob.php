<?php 
include "header.php";
include_once "control.php"; 
$db = new DB_Connect();

if($_POST['add_a_job']){

    $data = array(
    "job_id" => $_POST['jobid'],
    "client" => $_POST['client'],
    "job_name" => $_POST['jobname'],
    "quoted_cost" => $_POST['quoted'],
    );
   // print_r($data);

    if($db->add_job($data)){
    echo '<div class="alert alert-success" role="alert">'.$_POST['jobid'].' added sucessfully</div>';
    }else{
        echo '<div class="alert alert-danger" role="alert">failed to add job '.$_POST['jobid'].'</div>';
    }
}

?>
<div id="" class="container">

	<div id="heading">

	<h1>Create a new job</h1>

	</div>

	<div id="timesheet" class="row">
        <form method="post" action="">
    	<div id="job_id" class="col-xs-1">        
        	<input placeholder="Job No." type="text" name="jobid">            
        </div>        
        <div id="client_name" class="col-xs-2">        
        	<input placeholder="Client" type="text" name="client">                   
        </div>        
        <div id="job_name" class="col-xs-5">        
        	<input placeholder="Job Name" type="text" name="jobname">        
        </div>        
        <div id="quoted" class="col-xs-1">        
        	<input placeholder="Quoted $" type="text" name="quoted">        
        </div>        
        <div id="createjob" class="col-xs-1">        
        	<button type="submit" name="add_a_job" value="1" id="createjobbutton">Make Job</button>        
        </div>
        </form>
	</div>
    
    <div id="Jobs_list" class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead><tr><td>Job Number</td><td>Client</td><td>Job Name</td><td>Quoted</td><td>Actions</td></tr></thead>
            <tbody>
    <?php 
        $jobs = $db->get_jobs();
foreach($jobs as $job){

echo "<tr><td class='list_job_id'><span>".$job['job_id']."</span></td><td class='list_job_client'><span>".$job['client'].
"</span></td><td class='list_job_name'><span>".$job['job_name']."</span></td><td class='list_job_cost'><span>".$job['quoted_cost'].
"</span></td><td class='list_actions'>
<i title='Remove' class='remove_job fa fa-times' tid='".$job['id']."' job='".$job['job_id']."' ></i>
<i title='Edit' class='edit_job fa fa-pencil' tid='".$job['id']."' job='".$job['job_id']."' ></i>
</td></tr>";
    
}
    ?>
      </tbody>        
</table>
</div></div>

</div>


<?php 
include "footer.php";
?>
