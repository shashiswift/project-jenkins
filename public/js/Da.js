"use strict";
$(document).ready(function () {
    $.ajaxSetup({
        async: true
    });
    const base_url = $("body").attr("data-url");
    const _tokken = $('meta[name="_tokken"]').attr("content");

    let activityPageNo = 0;
    let standardPageNo = 0;
    let TaskPageNo = 0;
    let GraphSet = 'year';

    var statistics_chart = document.getElementById("myChart").getContext('2d');
    var GraphData = {
        labels: [],
        datasets: []
      };
    var myChart = new Chart(statistics_chart, {
      type: 'line',
      data: GraphData,
      options: {
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            gridLines: {
              display: false,
              drawBorder: false,
            },
            ticks: {
              stepSize: 150
            }
          }],
          xAxes: [{
            gridLines: {
              color: '#fbfbfb',
              lineWidth: 2
            }
          }]
        },
      }
    });

    function countShow(data) {
        if (!data) return;
        $.each(data, (e, v) => $(`*[data-key="${e}"]`).html(v.no));
    }
    function GraphDataSet(data) {
        if (!data) return;
        var dataset = [];
        GraphData.labels.splice(0,GraphData.labels.length)
        GraphData.datasets.splice(0,GraphData.datasets.length)
       $.each(data,((a,t)=>{GraphData.labels.push(t.date),dataset.push(t.no)}));
       GraphData.datasets.push({label:"Invoice",data:dataset,borderWidth:5,borderColor:"#6777ef",backgroundColor:"transparent",pointBackgroundColor:"#fff",pointBorderColor:"#6777ef",pointRadius:4});
       myChart.update();
    }
    function ActivityPage(activityPageNo){
        $.post(base_url+"Da/latestActivity/"+activityPageNo,{_tokken:_tokken},countShow,"json");
    }
    function StandardPage(standardPageNo){
        $.post(base_url+"Da/latestStandard/"+standardPageNo,{_tokken:_tokken},countShow,"json");
    }
    function TaskPage(TaskPageNo){
        $.post(base_url+"Da/TaskList/"+TaskPageNo,{_tokken:_tokken},countShow,"json");
    }
    function GraphChange(GraphSet){
        $.post(base_url+"Da/graphInvoice/"+GraphSet,{_tokken:_tokken},GraphDataSet,"json");
    }
   
    function AutoCall(){
      $.post(base_url+"Da/countDashboard",{_tokken:_tokken},countShow,"json");
      $.post(base_url+"Da/saleCount",{_tokken:_tokken},countShow,"json");
      ActivityPage(activityPageNo);
      TaskPage(TaskPageNo);
    }
    
    
    
    $(`div[data-key="activityPagination"]`).on("click", "a", function (e) {
      e.preventDefault();
        activityPageNo = $(this).attr("data-ci-pagination-page");
        ActivityPage(activityPageNo);
    });
    $(`div[data-key="standardPagination"]`).on("click", "a", function (e) {
      e.preventDefault();
      standardPageNo = $(this).attr("data-ci-pagination-page");
      StandardPage(standardPageNo);
    });
    $(`div[data-key="TaskPagination"]`).on("click", "a", function (e) {
      e.preventDefault();
      TaskPageNo = $(this).attr("data-ci-pagination-page");
      TaskPage(TaskPageNo)
    });
    $(document).on("click", `a[data-key="graphChange"]`, function (e) {
      GraphSet = $(this).data('value');
      var sibling = $(this).siblings('a')
        $.each(sibling,(i,v)=> v.classList.remove('btn-primary') );
        this.classList.add('btn-primary');
        GraphChange(GraphSet);
      });
      
    
      $.post(base_url+"Da/signatoryList",{_tokken:_tokken},countShow,"json");
      StandardPage(standardPageNo);
      GraphChange(GraphSet);
      AutoCall();
    setInterval(AutoCall,5000);
});