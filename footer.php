 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="js/main.js"></script>
  <script type="text/javascript">
$(function($) {
      $(".edit_job").on("click",function(){
            var job_id = $(this).attr("job");
            var tid = $(this).attr("tid");
            var row = $(this).parent().parent("tr");
            console.log(row);
            row.find("span").hide();
            row.find(".list_job_id").append("<input type='text' class='edit_job_id-"+job_id+"' value='"+job_id+"' />");
            row.find(".list_job_client").append("<input type='text' class='edit_job_client-"+job_id+"' value='"+row.find(".list_job_client").text()+"' />");
            row.find(".list_job_name").append("<input type='text' class='edit_job_name-"+job_id+"' value='"+row.find(".list_job_name").text()+"' />");
            row.find(".list_job_cost").append("<input type='text' class='edit_job_cost-"+job_id+"' value='"+row.find(".list_job_cost").text()+"' />");
            row.find(".list_actions").append("<button class='btn btn-success edit_job_save' tid='"+tid+"' job='"+job_id+"'>Save</button>");
      });

      $("#Jobs_list").on('click',".edit_job_save",function(){
            var job_id = $(this).attr("job");
            var tid = $(this).attr("tid");
            var row = $(this).closest("tr");
            console.log(row);
            var new_job_id = row.find(".list_job_id input").val()
            var new_job_client = row.find(".list_job_client input").val();
            var new_job_name = row.find(".list_job_name input").val();
            var new_job_cost = row.find(".list_job_cost input").val();
            	if(isNaN(new_job_cost)){
            		alert("Quoted Price must be only numbers.")
            		return;
            	}
            row.find("input").remove();
            row.find(".list_actions button").remove();
            row.find(".list_job_id span").text(new_job_id).show();
            row.find(".list_job_client span").text(new_job_client).show();
            row.find(".list_job_name span").text(new_job_name).show();
            row.find(".list_job_cost span").text(new_job_cost).show();
            $.post("/ts/ajax.php",{"update_job":true,
            						"id": tid,
            						"job_id" : new_job_id,
								    "client" : new_job_client,								    
								    "job_name" : new_job_name,
								    "quoted_cost" : new_job_cost,     
								    },function(response){
								    	console.log(response);
								    	if(response){
								    		row.css({"background-color":"green"});
								    			setTimeout(function(){row.removeAttr("style");},2000);							    	
								    	}else{
								    		alert("There was an error saving the changes. Please try again later");
								    	}
								    });

      });
  });

  </script>
  </body>
</html>
