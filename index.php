<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "header.php";

include_once "control.php"; 
$db = new DB_Connect();
$staff = $db->get_staff();
$jobs = $db->get_jobs();
?>
    <div class="container">
        <div class="row" >
        	<div class="col-xs-12">
        	    <div class="well" id="intro_text">
    
    	Record your work here and increase your efficiency!
    
    </div>
    </div>
    </div>
        
        <div class="row">
      	
  <div class="col-md-3">   
  
      <div id="staff_box">
      					<div id="page_heading"><span id="span_title"></span>Time Sheet<br/></div>
                        Employee <select id="staff_member">
      <option value="">Please select...</option>
                                    <?php
foreach($staff as $staffer){
    echo "<option data-name='".$staffer[name]."' value='".$staffer[id]."'>".$staffer[name]."</option>";
}
                                        ?>
                                    </select>
          </div>
                 </div>                             
              
        <div class="col-md-9">       
        
        </div>
        </div>
            <div id="timesheet" class="container">
            	
            
            	
            		<div id="details" class="row">
                    
               	 		
                        <div class="col-xs-3">
                    	
                      	Job Number <select id="Job_Numbers">
      <option value="">Please select...</option>
                                    <?php
foreach($jobs as $theJob){
    echo "<option data-jobname='".$theJob[job_id]." ".$theJob[client]."' data-id='".$theJob[id]."' value='".$theJob[id]."'>".$theJob[job_id]." ".$theJob[client]."</option>";
}
                                        ?>
                                    </select>
                          Job Category <select id="Job_Category">
                                <option value="">Please Select</option>
                            <option value="Design">Design</option>
                            <option value="Development">Development</option>
                                <option value="Content">Content</option>
                               <option value="Other">Other</option>
                            </select>
                                         
                		</div>
                    
                    	<div class="col-xs-8">
                    	
                        	<input placeholder="Description" type="text" id="description" name="description">
                        	                  
                		</div>
                     
                     	<div class="col-xs-1">
                    	
                        	<button type="button" class="btn btn-success" id="jobStart">START</button>
                            <button class="_off btn btn-danger" type="button" id="jobEnd">STOP</button>
                            <span class="_off" id="jobTime"></span>
                	                                               
                        </div>                     
                      
                        
                                                                 
                	</div>
                
                <div id="time_log" class="row">
                    <table id="time_log_table" class="table">
                    <thead>
                    <tr>
                    <td>Job Number</td>   <td>Description</td>    <td>Total Time</td> 
                    </tr>    
                    </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr><td>Total Time:</td><td></td><td data-tallyraw="0" id="tally_time"></td></tr>
                        </tfoot>
                    </table>
                </div>
              
            </div>

     
     

    </div><!-- /.container -->


   <?php 
include "footer.php";
?>
