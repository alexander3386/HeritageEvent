<div class="right_section">
    <?php echo $this->Flash->render() ?>
    <div class="col-md-12 graphs">
        <div class="xs">
            <div class="bs-example4" data-example-id="contextual-table">
                <table class="table" width="100%">
                    <thead>
                        <tr>
                            <th>
                                <h2 style="text-align: center">Welcome to Heritage Events Admin panel</h1>
                                <h3 style="text-align: center">Please use left navigation menu to browse different sections.</h3>
                            </th>
                        </tr>
                      </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!--div class="container">	
	<div class="row">
      <div class="col-md-3">
        <div class="panel panel-info">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-6">
                <i class="fa fa-users fa-5x"></i>
              </div>
              <div class="col-xs-6 text-right">
                <p class="announcement-heading" id="customer_count">0</p>
                <p class="announcement-text">Customers</p>
              </div>
            </div>
          </div>
          <a href="<?php echo $this->Url->build(['controller' => 'customers', 'action' => 'index']); ?>">
            <div class="panel-footer announcement-bottom">
              <div class="row">
                <div class="col-xs-6">
                  View
                </div>
                <div class="col-xs-6 text-right">
                  <i class="fa fa-arrow-circle-right"></i>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-md-3">
        <div class="panel panel-warning">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-6">
                <i class="fa fa-keyboard-o fa-5x"></i>
              </div>
              <div class="col-xs-6 text-right">
                <p class="announcement-heading" id="online_count">0</p>
                <p class="announcement-text">Online Orders</p>
              </div>
            </div>
          </div>
          <a href="<?php echo $this->Url->build(['controller' => 'orders', 'action' => 'index','order_type'=>'online']); ?>">
            <div class="panel-footer announcement-bottom">
              <div class="row">
                <div class="col-xs-6">
                  View
                </div>
                <div class="col-xs-6 text-right">
                  <i class="fa fa-arrow-circle-right"></i>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-md-3">
        <div class="panel panel-danger">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-6">
                <i class="fa fa-phone-square fa-5x"></i>
              </div>
              <div class="col-xs-6 text-right">
                <p class="announcement-heading" id="offline_count">0</p>
                <p class="announcement-text">Telephone Orders</p>
              </div>
            </div>
          </div>
          <a href="<?php echo $this->Url->build(['controller' => 'orders', 'action' => 'index','order_type'=>'telephone']); ?>">
            <div class="panel-footer announcement-bottom">
              <div class="row">
                <div class="col-xs-6">
                  View
                </div>
                <div class="col-xs-6 text-right">
                  <i class="fa fa-arrow-circle-right"></i>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-md-3">
        <div class="panel panel-success">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-6">
                <i class="fa fa-shopping-cart fa-5x"></i>
              </div>
              <div class="col-xs-6 text-right">
                <p class="announcement-heading" id="all_count">0</p>
                <p class="announcement-text">All Orders</p>
              </div>
            </div>
          </div>
          <a href="<?php echo $this->Url->build(['controller' => 'orders', 'action' => 'index']); ?>">
            <div class="panel-footer announcement-bottom">
              <div class="row">
                <div class="col-xs-6">
                  View
                </div>
                <div class="col-xs-6 text-right">
                  <i class="fa fa-arrow-circle-right"></i>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
	<div class="right_section">
		
		<div class="row ">
			<div class="col-md-12">
				<div class="col-md-3">
		        	<button id="daily" class="btn btn-primary order_repo">Daily</button>
		        </div>
		        <div class="col-md-3">
		        	<button id="week" class="btn btn-danger order_repo">Weekly</button>
		        </div>
		        <div class="col-md-3">
		        	<button id="month" class="btn btn-info order_repo">Monthly</button>
		        </div>
		        <div class="col-md-3">
		        	<button id="year" class="btn btn-success order_repo">Yearly</button>
			    </div>
		          
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 ">
			    <div class="graphs" id="canvas">
			    	<canvas id="barChart" ></canvas>
			    </div>
			</div>
			<div class="col-md-6">
			    <div class="graphs" id="canvas1">
			    	<canvas id="barChart1" ></canvas>
			    </div>
			</div>
			<div class="col-md-6">
			    <div class="graphs" id="canvas2">
			    	<canvas id="barChart2" ></canvas>
			    </div>
			</div>
			<div class="col-md-6">
			    <div class="graphs" id="canvas3">
			    	<canvas id="barChart3" ></canvas>
			    </div>
			</div>
		</div>
	</div>
</div-->
<script type="text/javascript">
    var barChart =function(dataVal,label_val,chart_lable){
    
        $('#barChart').remove(); // this is my <canvas> element
  		$('#canvas').append('<canvas id="barChart"><canvas>');
        var ctxB = document.getElementById("barChart").getContext('2d');
            var myBarChart = new Chart(ctxB, {
            type: 'bar',
            data: {
                labels: label_val,
                datasets: [{
                    label: '# of '+chart_lable,
                    data: dataVal,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    };
    
    var barChart1 =function(dataVal,label_val,chart_lable){
    
        $('#barChart1').remove(); // this is my <canvas> element
  		$('#canvas1').append('<canvas id="barChart1"><canvas>');
        var ctxB = document.getElementById("barChart1").getContext('2d');
            var myBarChart = new Chart(ctxB, {
            type: 'bar',
            data: {
                labels: label_val,
                datasets: [{
                    label: '# of '+chart_lable,
                    data: dataVal,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    };
    
    var barChart2 =function(dataVal,label_val,chart_lable){
    
        $('#barChart2').remove(); // this is my <canvas> element
  		$('#canvas2').append('<canvas id="barChart2"><canvas>');
        var ctxB = document.getElementById("barChart2").getContext('2d');
            var myBarChart = new Chart(ctxB, {
            type: 'bar',
            data: {
                labels: label_val,
                datasets: [{
                    label: '# of '+chart_lable,
                    data: dataVal,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    };
    var barChart3 =function(dataVal){
    
        $('#barChart3').remove(); // this is my <canvas> element
  		$('#canvas3').append('<canvas id="barChart3"><canvas>');
        var ctxB = document.getElementById("barChart3").getContext('2d');
            var myBarChart = new Chart(ctxB, {
            type: 'bar',
            data: {
                labels: ["Online Orders","Telephone Orders"],
                datasets: [{
                    label: '# of all orders',
                    data: dataVal,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    };
    var getDailylable =function(id){
		var label_arr = [];
		
		if(id == 'week')
		{
			label_arr = ["1 week","2 week","3 week","4 week","5 week","6 week" ,"Current week"];
			
	    }
		else if(id == 'month')
		{
			var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
			var today = new Date();
			var d;
			var month;

			for(var i = 6; i >= 0; i -= 1) {
				d = new Date(today.getFullYear(), today.getMonth() - i, 1);
				month = monthNames[d.getMonth()];
				label_arr.push(month);
			}
		}
		else if(id == 'year')
		{
			var today = new Date();
			var d;
			var year;
			for(var i = 6; i >= 0; i -= 1) {
				d = new Date(today.getFullYear()-i, 1, 1);
				year = d.getFullYear();
				label_arr.push(year);
			}
		}
		else
		{
			for(var i =6;i>=0 ;i--)
	    	{
	    		var days 	= i ; // Days you want to subtract
				var date 	= new Date();
				var last 	= new Date(date.getTime() - (days * 24 * 60 * 60 * 1000));
				var day 	= last.getDate();
				var month 	= last.getMonth()+1;
				var year 	= last.getFullYear();
				var newdate = day+'-'+month+'-'+year;
				label_arr.push(newdate);
	    	}
		}
    	return label_arr;
    };
    
    $(document).ready(function(){
        var id = 'daily';
       
        var label_val 	= getDailylable(id);

        var dataVal 	= barChartData(id , 'customer');
        var dataVal1 	= barChartData(id , 'online');
        var dataVal2 	= barChartData(id , 'telephone');
        var dataVal3 	= barChartData(id , 'all');

        barChart(dataVal,label_val,'Customers');
        barChart1(dataVal1,label_val,'Online Orders');
        barChart2(dataVal2,label_val,'Telephone Orders');
        barChart3(dataVal3);
        getCustomerTotalCount();
        getTelephoneTotalCount();
        getOnlineTotalCount();
        getOrderTotalCount();
    });
    
    $(".order_repo").click(function(){
       var id = $(this).attr('id');
    
        var label_val 	= getDailylable(id);
        
        var dataVal 	= barChartData(id , 'customer');
        var dataVal1 	= barChartData(id , 'online');
        var dataVal2 	= barChartData(id , 'telephone');
        var dataVal3 	= barChartData(id , 'all');

        barChart(dataVal,label_val,'Customers');
        barChart1(dataVal1,label_val,'Online Orders');
        barChart2(dataVal2,label_val,'Telephone Orders');
        barChart3(dataVal3);
        
       
    });
    
    var barChartData = function(id, searchfor){
    	if(searchfor == 'online'){
        	url  = "/admin/reports/getonlineordercount";
        	
        }    
        else if(searchfor == 'telephone'){
        	url = "/admin/reports/gettelephoneordercount";
        	
        }
        else if(searchfor == 'all'){
        	url = "/admin/reports/comparebothorder";
        	
        }
        else
        {
        	var url  = "/admin/reports/getcustomercount";
        	
        }
        var dataVal = [];
		         	
        if(url != '')
        {
         	$.ajax({
		        type:"POST",
		        url:url,
		        data: {filter : id},
		        type: 'post',
		        dataType: 'json',
		        async:false,
		        success: function(response){
		        	console.log(response);
		         	$.each(response.data, function(index, value) {
					    dataVal.push(value);
					});

		         	
        		},
		        error: function (response) {
		        	alert("Oops an error occur");
		        }
		    });
        }
        return dataVal;
    };
    

    var getCustomerTotalCount = function(){
    	$.ajax({
		        type:"POST",
		        url:"/admin/reports/getcustomertotal",
		        //data: {filter : id},
		        type: 'post',
		        //dataType: 'json',
		        async:false,
		        success: function(response){
		        	$("#customer_count").html(response);
        		},
		        error: function (response) {
		        	$("#customer_count").html("0");
		        }
		    });
    };
    var getTelephoneTotalCount = function(){
    	$.ajax({
		        type:"POST",
		        url:"/admin/reports/getofflineordrtotal",
		        //data: {filter : id},
		        type: 'post',
		        //dataType: 'json',
		        async:false,
		        success: function(response){
		        	$("#offline_count").html(response);
        		},
		        error: function (response) {
		        	$("#offline_count").html("0");
		        }
		    });
    };
     var getOnlineTotalCount = function(){
    	$.ajax({
		        type:"POST",
		        url:"/admin/reports/getonlineordrtotal",
		        //data: {filter : id},
		        type: 'post',
		        //dataType: 'json',
		        async:false,
		        success: function(response){
		        	$("#online_count").html(response);
		         	
        		},
		        error: function (response) {
		        	$("#online_count").html('0');
		        }
		    });
    };
     var getOrderTotalCount = function(){
    	$.ajax({
		        type:"POST",
		        url:"/admin/reports/getordrtotal",
		        //data: {filter : id},
		        type: 'post',
		        //dataType: 'json',
		        async:false,
		        success: function(response){
		        	$("#all_count").html(response);
		         	
        		},
		        error: function (response) {
		        	$("#all_count").html('0');
		        }
		    });
    };
</script>