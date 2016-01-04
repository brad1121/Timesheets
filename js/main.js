job_active = false;
$(function(){
$('.input-daterange').datepicker({
    clearBtn: true,
    orientation: "top left",
    forceParse: false,
    calendarWeeks: true,
    format: "yyyy-mm-dd"
});
$('#jobStart').click(function(){
var staff = $("#staff_member").val();
    if(staff == ""){
    alert("Please Select a staff member");
        return;
    }
    var jobno = $('#Job_Numbers').val();
    var desc = $("#description").val();
    var jobcat = $("#Job_Category").val();
    if(jobno == "" || desc == ""){
    alert("Please ensure Job Number and Description are set");
        return;
    }
$.post('',{"post_request":true,"start_job":true,"Job_Category":jobcat,"job":jobno,"staff":staff,"desc":desc},function(response){
console.log(response);
if(response == "false"){
	alert("Failed to save time in database. Try again");
	return;	
	}
var responsePrams = response.split("|");

job_active = true;
$('#jobTime').text(responsePrams[1]);//.removeClass('_off');
$('#jobStart').addClass('_off');
$('#jobEnd').attr("taskID",responsePrams[2]).removeClass('_off');

});
    });

    $("#staff_member").change(function(){
        $("#span_title").text( $("option:selected", this).data('name')+'\'s ');    
    });
  
  $('#jobEnd').click(function(){

$.post('',{"post_request":true,"end_job":true,"taskID":$(this).attr("taskID")},function(response){
console.log(response);
if(response == "false"){
	alert("Failed to save time in database. Try again");
	return;	
	}
var responsePrams = response.split("|");
    var start_time = $('#jobTime').text();
    var end_time = responsePrams[1];
var total_time = (Math.abs(start_time - end_time));
var total_time_raw = total_time;
    total_time = formatSeconds(total_time);
    

$('#jobTime').text(total_time).removeClass('_off');

$('#jobEnd').addClass('_off');
    
   Process_Completed_task(total_time,total_time_raw);

});
    });
  
});

function Process_Completed_task(time_of_task,total_time_raw){
//time_log_table
job_active = false;
    var Job = $('#Job_Numbers option:selected').data('jobname');
    var Desc = $("#description").val();
    var html_string = "<tr><td>"+Job+"</td><td>"+Desc+"</td><td data-sec='"+total_time_raw+"'>"+time_of_task+"</td></tr>";
    $("#time_log_table tbody").append(html_string);
    
     $('#Job_Numbers').prop('selectedIndex',0);
    $('#description').val("");
    $('#jobTime').text("").addClass('_off');
$('#jobStart').removeClass('_off');
$('#jobEnd').addClass('_off').attr("taskID","");
    var new_tally = $('#tally_time').data('tallyraw')+total_time_raw;
    $('#tally_time').data('tallyraw',new_tally);
    $('#tally_time').text(formatSeconds(new_tally));
}

function formatSeconds(seconds)
{
    var date = new Date(1970,0,1);
    date.setSeconds(seconds);
    return date.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
}

window.onbeforeunload = confirmExit;
  function confirmExit()
  {
    if(job_active){
        $("#jobEnd").stop().css({"height":"100px","width":"100px"}).animate({"height":"34px","width":"71px"},5000);        
    return "You have attempted to leave this page. But it seems you have a timer active. Are you sure you want to exit this page?";
    }

}