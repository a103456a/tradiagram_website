<!DOCTYPE html>
<html lang="zh">
<head>
<?php require_once("../default.php"); ?>
  <title><?php echo web_name . " 即時列車資訊" ?></title>
  
<?php include "../head.html" ?>

<body style = "padding-top:40px;">

<!-- 功能表 -->
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">目錄</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav">
			<li class="active"><a href="../"><span class="glyphicon glyphicon-home"></span> Home</a></li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">西部幹線<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href = '../lines.php?lineKind=west_link_north'>北段</a></li>
					<li><a href = '../lines.php?lineKind=west_link_moutain'>山線</a></li>
					<li><a href = '../lines.php?lineKind=west_link_sea'>海線</a></li>
					<li><a href = '../lines.php?lineKind=west_link_south'>南段</a></li>
					<li><a href = '../lines.php?lineKind=pingtung'>屏東線</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">東部幹線<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href = '../lines.php?lineKind=yilan'>宜蘭線</a></li>
					<li><a href = '../lines.php?lineKind=north_link'>北迴線</a></li>
					<li><a href = '../lines.php?lineKind=taitung'>台東線</a></li>
				</ul>
			</li>
			<li><a href = '../lines.php?lineKind=south_link'>南迴線</a></li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">支線<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href = '../lines.php?lineKind=pingxi'>平溪深澳線</a></li>
					<li><a href = '../lines.php?lineKind=neiwan'>內灣線</a></li>
					<li><a href = '../lines.php?lineKind=jiji'>集集線</a></li>
					<li><a href = '../lines.php?lineKind=shalun'>沙崙線</a></li>
				</ul>
			</li>
			<li><a href = '../special_use.php?'>特殊運用</a></li>
      <li><a href = '../lines.php?lineKind=thsr'>台灣高鐵</a></li>
      <li><a href = '../liveboard'>即時列車資訊</a></li>
			<!-- <li><a href='http://tradiagram.com/timetable.php'><span class="fa fa-train"></span> 時刻表查詢</a></li> -->
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">其他<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href='https://github.com/billy1125/TRA_time_space_diagram'><span class="fa fa-github"></span> GitHub(台鐵運行圖)</a></li>
					<li><a href='https://github.com/billy1125/THSR_time_space_diagram'><span class="fa fa-github"></span> GitHub(高鐵運行圖)</a></li>
					<li><a href='https://www.facebook.com/traDiagram/'><span class="fa fa-facebook-official"></span> facebook</a></li>
					<li><a href='https://www.dropbox.com/sh/iexq2p8egjpvomt/AACIKnznt-9IwQeUs1n4ft0Ka?dl=0'><span class="fa fa-dropbox"></span> DropBox</a></li>
					<li><a href='about.php'><span class="fa fa-exclamation-circle"></span> about</a></li>
					<li><a href='mailto:billy1125@gmail.com'><span class="fa fa-envelope"></span> contact</a></li>
				</ul>
			</li>
		</ul>

    </div>
  </div>
</nav>

<div class="jumbotron">
  <div class="container text-center">
    <h1>即時列車資訊</h1>      
  </div>
</div>

<form onsubmit="return false;" method='post' id="my_form" class="form-inline">
  <div class="container"> 
  <h3>選擇車站</h3>  
    <div class="form-group">
      <select class="form-control" id="sel1">
        <option value="0">請選擇地區</option>
        <option value="1">台北地區</option>
        <option value="2">桃園地區</option>
        <option value="3">新竹地區</option>
        <option value="4">苗栗地區</option>
        <option value="5">台中地區</option>
        <option value="6">彰化地區</option>
        <option value="7">雲林地區</option>
        <option value="8">嘉義地區</option>
        <option value="9">台南地區</option>
        <option value="10">高雄地區</option>
        <option value="11">屏東地區</option>
        <option value="12">台東地區</option>
        <option value="13">花蓮地區</option>
        <option value="14">宜蘭地區</option>
        <option value="15">內灣線</option>
        <option value="16">集集線</option>
        <option value="17">沙崙線</option>
          <option value="18">平溪線</option>
      </select> 
    </div>
    <div class="form-group">
      <select class="form-control" id="sel2" name="start_station">
        <option value="0">...</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">查詢</button>
  </div>
</form>

<div class="container">
  <h2>目前即將到站列車</h2>
  備註：列車到站資訊為公開平台所提供，可能與現場有所差異，僅供參考。
  <div id="div_data"></div>
  <h1></h1>  
</div>

<script>

function padLeft(str, len) {
    str = '' + str;
    if (str.length >= len) {
        return str;
    } else {
        return padLeft("0" + str, len);
    }
}
 

$("#sel1").change(function(){

	var select = parseInt($(this).val());

	$("#sel2 option").remove();
	
	if (select != 0){
		$.ajax({
		url: "/timetable/stations.json",
		cache: true,
		dataType: "json",
		type: "GET",
		success: function(results){
			//console.log("ready!");
			console.log(results);
			var i = 0;
			
			$.each(results, function(key, value) {
				if (results[i].EXTRA3 == select){
					$("#sel2").append($("<option value='" + results[i].ID + "'>" + results[i].DSC + "</option>"));
					
				}
			i++;
					
			// $.each(results[select].STATIONS, function(key, value) {
				// $("#sel2").append($("<option value='" + value.ID + "'>" +value.DSC + "</option>"));
				// $("#JSON_table").append("<tr>" +
									  // "<td>" + value.ID + "</td>" +
									  // "<td>" + value.DSC + "</td>" +
									  // //"<td>" + results[0].STATIONS[i].DSC + "</td>" +
									  // //"<td>" + results[i].ID + "</td>" +
									  // "</tr>");
				// i++;
			});
		},
		error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		});	
	}
});
	
</script>

<footer class="container-fluid text-center">
<?php echo footer ?>
</footer>

</body>
</html>

<script>
  $(document).ready(function(){
    $("form").submit(function(e){
      //alert($("#sel2").find(":selected").val());
      $('#div_data').empty();
      checkRegAcc($("#sel2").find(":selected").val());
    });
  });
  checkRegAcc = function (stationID){
    $.ajax({
      url: "http://tradiagram.com/liveboard/liveboard_json.php?stationID="+stationID,
      type: "GET",
      dataType: "json",
      success: function(JData) {
        //alert("SUCCESS!!!");
        var i = 0;
        //這裡改用.each這個函式來取出JData裡的物件
        $.each(JData, function() {
          //呼叫方式也稍微改變了一下，意思等同於上述的的JData[i]["idx_Key"]    $("#mytable tbody").append("<tr>" +
          
          $("#div_data").append("<div class='panel panel-" +　JData[i].Panel + "'>" +
                                "<div class='panel-heading'><span class='badge'>" + JData[i].DelayTime + "</span>" + "    車次：" 
                                  + JData[i].TrainNo  + "｜車種：" + JData[i].TrainTypeName.Zh_tw + "｜"
                                　+ JData[i].Direction + "｜開往：" + JData[i].EndingStationName + 
                                "</div>" +
                                "<div class='panel-body'>" +
                                  "預計到站時間：" + JData[i].ScheduledArrivalTime    + "<br>" +
                                  "預計離站時間：" + JData[i].ScheduledDepartureTime + "<br>" +
                                  "更新時間：" + JData[i].UpdateTime + "<br>" +
                                "</div></div>");
          i++;
        });
      },
      
      error: function() {
        alert("ERROR!!!");
      }
    });
  };
</script>