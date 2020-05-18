$(document).ready(function() {
    $('table.record').DataTable({
    "order": [[ 0, "desc" ]],
    "autoWidth": false,
    "ordering": false,
    "aoColumnDefs": [
      { "sClass": "my_class", "aTargets": [ 0 ] }
    ],
    dom: 'Bfrtip',
    paging: false,
    fixedHeader: {
      header:true,
      headerOffset: 45
    },
    // scrollY:        500,
    // deferRender:    true,
    // scroller:       true,
    buttons: [{ extend: 'excel', text: "Excel Download", className: 'mb-1 btn btn-sm'}],
    
          
	});
	// table.buttons().container()
 //        .appendTo( '#example_wrapper .col-md-6:eq(0)');
});


$('.demo').daterangepicker({
    "singleDatePicker": true,
    "timePicker": true,
    "timePicker24Hour": true,
    "timePickerSeconds": true,
    locale: {
      format: 'M/DD/YYYY hh:mm:ss A'
    }
    
    }, function(start, end, label) {
      console.log('New date range selected: ' + start.format('YYYY-MM-DD H:mm') + ' to ' + end.format('YYYY-MM-DD H:mm') + ' (predefined range: ' + label + ')');
    }
);

$('.searchdate').daterangepicker({
    "singleDatePicker": true,
    locale: {
    format: 'YYYY/MM/DD'
    }
    
    }, function(start, end, label) {
  console.log('New date range selected: ' + start.format('YYYY-MM-DD H:mm') + ' to ' + end.format('YYYY-MM-DD H:mm') + ' (predefined range: ' + label + ')');
    }
);

$('.m3_date').daterangepicker({
  "singleDatePicker": true,
  "timePicker": true,
  "timePicker24Hour": true,
  "timePickerSeconds": true,
  locale: {
  format: 'YYYY-MM-DD hh:mm:ss'
  }
  
  }, function(start, end, label) {
console.log('New date range selected: ' + start.format('YYYY-MM-DD H:mm') + ' to ' + end.format('YYYY-MM-DD H:mm') + ' (predefined range: ' + label + ')');
  }
);


//Chart
$(document).ready(function(){
    
    
    $.post(
        "chart/testers.php",
        function(data){
            //console.log(data);
            var dataObj = JSON.parse(data);
            console.log(dataObj);
                       
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';
            
            var tempDataSorted = dataObj.data.sort(function(a, b){return b - a});
            var maximum = tempDataSorted[0].value;
            var newMax = Number(maximum) + 5;
            
            // Area Chart Example
            var ctx = document.getElementById("ChartTester");
            var myLineChart = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: dataObj.labels,
                datasets: [{
                  label: "Quantity",
                  lineTension: 0.3,
                  backgroundColor: "rgba(2,117,216,0.2)",
                  borderColor: "rgba(2,117,216,1)",
                  pointRadius: 5,
                  pointBackgroundColor: "rgba(2,117,216,1)",
                  pointBorderColor: "rgba(255,255,255,0.8)",
                  pointHoverRadius: 5,
                  pointHoverBackgroundColor: "rgba(2,117,216,1)",
                  pointHitRadius: 50,
                  pointBorderWidth: 2,
                  data: dataObj.data
                }],
              },
              options: {
                scales: {
                  xAxes: [{
                    time: {
                      unit: 'date'
                    },
                    gridLines: {
                      display: false
                    },
                    ticks: {
                      maxTicksLimit: 7,
                      autoSkip: false
                    }
                  }],
                  yAxes: [{
                    ticks: {
                      min: 0,
                      max: maximum,
                      maxTicksLimit: 5
                    },
                    gridLines: {
                      color: "rgba(0, 0, 0, .125)",
                    }
                  }],
                },
                legend: {
                  display: false
                }
              }
            });
        }
    );

    $.post(
      "chart/machine.php",
      function(data){
          //console.log(data);
          var dataObj = JSON.parse(data);
          console.log(dataObj);
                     
          Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
          Chart.defaults.global.defaultFontColor = '#292b2c';
          
          var tempDataSorted = dataObj.data.sort(function(a, b){return b - a});
          var maximum = tempDataSorted[0].value;
          // Area Chart Example
          var ctx = document.getElementById("ChartMachine");
          var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: dataObj.labels,
              datasets: [{
                label: "Quantity",
                lineTension: 0.3,
                backgroundColor: "rgba(2,117,216,0.2)",
                borderColor: "rgba(2,117,216,1)",
                pointRadius: 5,
                pointBackgroundColor: "rgba(2,117,216,1)",
                pointBorderColor: "rgba(255,255,255,0.8)",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(2,117,216,1)",
                pointHitRadius: 50,
                pointBorderWidth: 2,
                data: dataObj.data
              }],
            },
            options: {
              scales: {
                xAxes: [{
                  time: {
                    unit: 'date'
                  },
                  gridLines: {
                    display: false
                  },
                  ticks: {
                    maxTicksLimit: 7,
                    autoSkip: false
                  }
                }],
                yAxes: [{
                  ticks: {
                    min: 0,
                    max: maximum,
                    maxTicksLimit: 5
                  },
                  gridLines: {
                    color: "rgba(0, 0, 0, .125)",
                  }
                }],
              },
              legend: {
                display: false
              }
            }
          });
      }
  );
  $.post(
    "chart/who.php",
    function(data){
        //console.log(data);
        var dataObj = JSON.parse(data);
        console.log(dataObj);
                   
        Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#292b2c';
        
        var tempDataSorted = dataObj.data.sort(function(a, b){return b - a});
        var maximum = tempDataSorted[0].value;
        // Area Chart Example
        var ctx = document.getElementById("ChartWho");
        var myLineChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: dataObj.labels,
            datasets: [{
              label: "Quantity",
              lineTension: 0.3,
              backgroundColor: "rgba(2,117,216,0.2)",
              borderColor: "rgba(2,117,216,1)",
              pointRadius: 5,
              pointBackgroundColor: "rgba(2,117,216,1)",
              pointBorderColor: "rgba(255,255,255,0.8)",
              pointHoverRadius: 5,
              pointHoverBackgroundColor: "rgba(2,117,216,1)",
              pointHitRadius: 50,
              pointBorderWidth: 2,
              data: dataObj.data
            }],
          },
          options: {
            scales: {
              xAxes: [{
                time: {
                  unit: 'date'
                },
                gridLines: {
                  display: false
                },
                ticks: {
                  maxTicksLimit: 7,
                  autoSkip: false
                }
              }],
              yAxes: [{
                ticks: {
                  min: 0,
                  max: maximum,
                  maxTicksLimit: 5
                },
                gridLines: {
                  color: "rgba(0, 0, 0, .125)",
                }
              }],
            },
            legend: {
              display: false
            }
          }
        });
    }
);

$.post(
  "chart/tester_report.php",
  function(data){
      //console.log(data);
      var dataObj = JSON.parse(data);
      console.log(dataObj);
                 
      Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = '#292b2c';
      
      var tempDataSorted = dataObj.data.sort(function(a, b){return b - a});
      var maximum = tempDataSorted[0].value;
      // Area Chart Example
      var ctx = document.getElementById("ChartPlatformTesterRepairReport");
      var myLineChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: dataObj.labels,
          datasets: [{
            label: "Quantity",
            lineTension: 0.3,
            backgroundColor: "rgba(2,117,216,0.2)",
            borderColor: "rgba(2,117,216,1)",
            pointRadius: 5,
            pointBackgroundColor: "rgba(2,117,216,1)",
            pointBorderColor: "rgba(255,255,255,0.8)",
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(2,117,216,1)",
            pointHitRadius: 50,
            pointBorderWidth: 2,
            data: dataObj.data
          }],
        },
        options: {
          scales: {
            xAxes: [{
              time: {
                unit: 'date'
              },
              gridLines: {
                display: false
              },
              ticks: {
                maxTicksLimit: 7,
                autoSkip: false
              }
            }],
            yAxes: [{
              ticks: {
                min: 0,
                max: maximum,
                maxTicksLimit: 5
              },
              gridLines: {
                color: "rgba(0, 0, 0, .125)",
              }
            }],
          },
          legend: {
            display: false
          }
        }
      });
  }
);

$.post(
  "chart/tester_preventive_maintenance.php",
  function(data){
      //console.log(data);
      var dataObj = JSON.parse(data);
      console.log(dataObj);
                 
      Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = '#292b2c';
      
      var tempDataSorted = dataObj.data.sort(function(a, b){return b - a});
      var maximum = tempDataSorted[0].value;
      // Area Chart Example
      var ctx = document.getElementById("ChartPlatformTesterTesterPreventiveMaintenance");
      var myLineChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: dataObj.labels,
          datasets: [{
            label: "Quantity",
            lineTension: 0.3,
            backgroundColor: "rgba(2,117,216,0.2)",
            borderColor: "rgba(2,117,216,1)",
            pointRadius: 5,
            pointBackgroundColor: "rgba(2,117,216,1)",
            pointBorderColor: "rgba(255,255,255,0.8)",
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(2,117,216,1)",
            pointHitRadius: 50,
            pointBorderWidth: 2,
            data: dataObj.data
          }],
        },
        options: {
          scales: {
            xAxes: [{
              time: {
                unit: 'date'
              },
              gridLines: {
                display: false
              },
              ticks: {
                maxTicksLimit: 7,
                autoSkip: false
              }
            }],
            yAxes: [{
              ticks: {
                min: 0,
                max: maximum,
                maxTicksLimit: 5
              },
              gridLines: {
                color: "rgba(0, 0, 0, .125)",
              }
            }],
          },
          legend: {
            display: false
          }
        }
      });
  }
);

$.post(
  "chart/tester_inhouse_reports.php",
  function(data){
      //console.log(data);
      var dataObj = JSON.parse(data);
      console.log(dataObj);
                 
      Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = '#292b2c';
      
      var tempDataSorted = dataObj.data.sort(function(a, b){return b - a});
      var maximum = tempDataSorted[0].value;
      // Area Chart Example
      var ctx = document.getElementById("ChartPlatformTesterInhouseModule");
      var myLineChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: dataObj.labels,
          datasets: [{
            label: "Quantity",
            lineTension: 0.3,
            backgroundColor: "rgba(2,117,216,0.2)",
            borderColor: "rgba(2,117,216,1)",
            pointRadius: 5,
            pointBackgroundColor: "rgba(2,117,216,1)",
            pointBorderColor: "rgba(255,255,255,0.8)",
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(2,117,216,1)",
            pointHitRadius: 50,
            pointBorderWidth: 2,
            data: dataObj.data
          }],
        },
        options: {
          scales: {
            xAxes: [{
              time: {
                unit: 'date'
              },
              gridLines: {
                display: false
              },
              ticks: {
                maxTicksLimit: 7,
                autoSkip: false
              }
            }],
            yAxes: [{
              ticks: {
                min: 0,
                max: maximum,
                maxTicksLimit: 5
              },
              gridLines: {
                color: "rgba(0, 0, 0, .125)",
              }
            }],
          },
          legend: {
            display: false
          }
        }
      });
  }
);

$.post(
  "chart/tester_defective.php",
  function(data){
      //console.log(data);
      var dataObj = JSON.parse(data);
      console.log(dataObj);
                 
      Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = '#292b2c';
      
      var tempDataSorted = dataObj.data.sort(function(a, b){return b - a});
      var maximum = tempDataSorted[0].value;
      // Area Chart Example
      var ctx = document.getElementById("ChartPlatformTesterDefective");
      var myLineChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: dataObj.labels,
          datasets: [{
            label: "Quantity",
            lineTension: 0.3,
            backgroundColor: "rgba(2,117,216,0.2)",
            borderColor: "rgba(2,117,216,1)",
            pointRadius: 5,
            pointBackgroundColor: "rgba(2,117,216,1)",
            pointBorderColor: "rgba(255,255,255,0.8)",
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(2,117,216,1)",
            pointHitRadius: 50,
            pointBorderWidth: 2,
            data: dataObj.data
          }],
        },
        options: {
          scales: {
            xAxes: [{
              time: {
                unit: 'date'
              },
              gridLines: {
                display: false
              },
              ticks: {
                maxTicksLimit: 7,
                autoSkip: false
              }
            }],
            yAxes: [{
              ticks: {
                min: 0,
                max: maximum,
                maxTicksLimit: 5
              },
              gridLines: {
                color: "rgba(0, 0, 0, .125)",
              }
            }],
          },
          legend: {
            display: false
          }
        }
      });
  }
);

$.post(
  "chart/testers_lsg.php",
  function(data){
      //console.log(data);
      var dataObj = JSON.parse(data);
      console.log(dataObj);
                 
      Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = '#292b2c';
      
      var tempDataSorted = dataObj.data.sort(function(a, b){return b - a});
      var maximum = tempDataSorted[0].value;
      var newMax = Number(maximum) + 5;
      
      // Area Chart Example
      var ctx = document.getElementById("ChartTester_LSG");
      var myLineChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: dataObj.labels,
          datasets: [{
            label: "Quantity",
            lineTension: 0.3,
            backgroundColor: "rgba(2,117,216,0.2)",
            borderColor: "rgba(2,117,216,1)",
            pointRadius: 5,
            pointBackgroundColor: "rgba(2,117,216,1)",
            pointBorderColor: "rgba(255,255,255,0.8)",
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(2,117,216,1)",
            pointHitRadius: 50,
            pointBorderWidth: 2,
            data: dataObj.data
          }],
        },
        options: {
          scales: {
            xAxes: [{
              time: {
                unit: 'date'
              },
              gridLines: {
                display: false
              },
              ticks: {
                maxTicksLimit: 7,
                autoSkip: false
              }
            }],
            yAxes: [{
              ticks: {
                min: 0,
                max: maximum,
                maxTicksLimit: 5
              },
              gridLines: {
                color: "rgba(0, 0, 0, .125)",
              }
            }],
          },
          legend: {
            display: false
          }
        }
      });
  }
);

$.post(
"chart/machine_lsg.php",
function(data){
    //console.log(data);
    var dataObj = JSON.parse(data);
    console.log(dataObj);
               
    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#292b2c';
    
    var tempDataSorted = dataObj.data.sort(function(a, b){return b - a});
    var maximum = tempDataSorted[0].value;
    // Area Chart Example
    var ctx = document.getElementById("ChartMachine_LSG");
    var myLineChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: dataObj.labels,
        datasets: [{
          label: "Quantity",
          lineTension: 0.3,
          backgroundColor: "rgba(2,117,216,0.2)",
          borderColor: "rgba(2,117,216,1)",
          pointRadius: 5,
          pointBackgroundColor: "rgba(2,117,216,1)",
          pointBorderColor: "rgba(255,255,255,0.8)",
          pointHoverRadius: 5,
          pointHoverBackgroundColor: "rgba(2,117,216,1)",
          pointHitRadius: 50,
          pointBorderWidth: 2,
          data: dataObj.data
        }],
      },
      options: {
        scales: {
          xAxes: [{
            time: {
              unit: 'date'
            },
            gridLines: {
              display: false
            },
            ticks: {
              maxTicksLimit: 7,
              autoSkip: false
            }
          }],
          yAxes: [{
            ticks: {
              min: 0,
              max: maximum,
              maxTicksLimit: 5
            },
            gridLines: {
              color: "rgba(0, 0, 0, .125)",
            }
          }],
        },
        legend: {
          display: false
        }
      }
    });
}
);
$.post(
"chart/who_lsg.php",
function(data){
  //console.log(data);
  var dataObj = JSON.parse(data);
  console.log(dataObj);
             
  Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#292b2c';
  
  var tempDataSorted = dataObj.data.sort(function(a, b){return b - a});
  var maximum = tempDataSorted[0].value;
  // Area Chart Example
  var ctx = document.getElementById("ChartWho_LSG");
  var myLineChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: dataObj.labels,
      datasets: [{
        label: "Quantity",
        lineTension: 0.3,
        backgroundColor: "rgba(2,117,216,0.2)",
        borderColor: "rgba(2,117,216,1)",
        pointRadius: 5,
        pointBackgroundColor: "rgba(2,117,216,1)",
        pointBorderColor: "rgba(255,255,255,0.8)",
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(2,117,216,1)",
        pointHitRadius: 50,
        pointBorderWidth: 2,
        data: dataObj.data
      }],
    },
    options: {
      scales: {
        xAxes: [{
          time: {
            unit: 'date'
          },
          gridLines: {
            display: false
          },
          ticks: {
            maxTicksLimit: 7,
            autoSkip: false
          }
        }],
        yAxes: [{
          ticks: {
            min: 0,
            max: maximum,
            maxTicksLimit: 5
          },
          gridLines: {
            color: "rgba(0, 0, 0, .125)",
          }
        }],
      },
      legend: {
        display: false
      }
    }
  });
}
);

    
});


//Data Change on CHangelist
//Syntax: Class or ID / Fuction/ Then Process
$(".empName").on("change", function(){
  // Assigning of Variables
      var selectedEmp = $(this).val();
  //Data List ID ---------------//Data attribute in the option tab 
     
      console.log(empID);
  //Post function like in php
      $.post(
  //Post Destination
          "functions/getEmployeeData.php",
          {
  //Name of Form - Content
            "empID" :   empID
  //Function             
          },function(data){
              console.log(data);
              var obj = JSON.parse(data);
             
              
  
          }
      );
  });



  $(document).on("select keyup change",".part_name", function(){
   
    var part_name = $(".part_name").val();
    $.post(
      "functions/part_name.php",
      {
        "part_name": part_name
      },
      function(data){
        
        var obj = JSON.parse(data);
        console.log(obj);
        $(".part_number").val(obj.part_number);
        // $.each(obj, function(i, part){
        //   console.log(part.part_name);
         
        // });    
      }
    );
  });

  $(document).on("select keyup change",".tester", function(){
   
     var machine = $(".tester").val();
    $.post(
      "functions/machine.php",
      {
        "machine": machine
      },
      function(data){
        
        var obj = JSON.parse(data);
        console.log(obj);
        $(".platform").val(obj.platform);
        // $.each(obj, function(i, part){
        //   console.log(part.part_name);
         
        // });    
      }
    );
  });

  $(document).on("select change","#setup-code", function(){
  //  alert("ok");
   var setup_code = $(this).val();
   switch(setup_code){
    case "P-SW":
      $("#ie-time").val(0.20);
      break;
    case "P-NW":
      $("#ie-time").val(0.30);
      break;
    case "CK-SW":
      $("#ie-time").val(1.89);
      break;
    case "CK-NW":
      $("#ie-time").val(3.72);
      break;
    case "LB-SW":
      $("#ie-time").val(0.58);
      break;
    case "LB-NW":
      $("#ie-time").val(0.97);
      break;
    case "HT-SW":
      $("#ie-time").val(4.57);
      break;
    case "HT-NW":
      $("#ie-time").val(4.91);
      break;
    case "TT-SW":
      $("#ie-time").val(1.60);
      break;
    case "TT-NW":
      $("#ie-time").val(1.60);
      break
    default:
      break;
   }

 });

 $(document).on("click", "#download-button", function () {

  var id = $(this).attr("data-get-document");
  
  // $.post(
  //     "functions/getAttachments.php",
  //     {
  //         "dr_id": id,
          
  //     },
  //     function (data_document) {
  //       // console.log(data_document);

  //         if (data_document != "") {
  //             $.each(JSON.parse(data_document), function (i, document) {
  //                 window.open("uploads/lsg_uploads/" + document.item_name, "_blank");
  //             })
  //         }

  //         else {
  //           alert("NO ATTACHMENTS FOUND");
  //         }
  //     });

      $.ajax({
        type: "POST",
        dataType: "json",
        url: "functions/getAttachments.php",
        data: {  "dr_id": id },
        success: function( data_document ) 
        { 
          if (data_document != "") {
            $.each(data_document, function (i, document) {
                window.open("uploads/lsg_uploads/" + document.item_name, "_blank");
            })
          }

          else {
            alert("NO ATTACHMENTS FOUND");
          }
        },
        error: function( error )
        {
          alert( error );
        }
     });

});


  






