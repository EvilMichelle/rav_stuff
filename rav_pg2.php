<?php

include "./db_connect.inc";
$query = "select * from rav_codes where rav_name = '" . $_POST['n'] . "'";
//echo $query;
$result = mysql_query($query);
$row = mysql_fetch_object($result);

?>

<html>
<head>
      
<script type="text/javascript" charset="utf-8">
RavelryThing = function() {
	var progressData = null;
	var happy=0;
	var dur=0;
	var comp=0;
	var prog=0;
	var all=0;
	var wips=0;
	var hib=0;
	var frog=0;
	var pro_list="";

return {
	progressReceived: function(data) {
	progressData = data;
},

calcStats: function(options) {
	if (!progressData) return;
        
	var selectedProjects = progressData.projects;
	for (var i=0; i < selectedProjects.length; i++) {
		happy += selectedProjects[i].happiness;
		if (selectedProjects[i].status == "finished") {
			comp+=1;
			if (selectedProjects[i].progress != 100) {
				prog+=1;
				pro_list+="&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; " + selectedProjects[i].permalink + "<br>";
			}
			var ed=new String(selectedProjects[i].completed);
			var edlist=ed.split("-");
			var edt = new Date();
			edt.setFullYear(edlist[0],edlist[1]-1,edlist[2]);
			var sd=new String(selectedProjects[i].started);
			var sdlist=sd.split("-");
			var sdt= new Date();
			sdt.setFullYear(sdlist[0],sdlist[1]-1,sdlist[2]);
			var foo =Math.round((edt-sdt)/86400000) +1;
			if (foo > 0) {
				dur+=foo;
			}
			//document.write ("duration = " + selectedProjects[i].completed + " - " + selectedProjects[i].started + " = "  + blah+ "<br>");

		} // end finished project calcs

		if (selectedProjects[i].status == "in-progress") {
			wips+=1;
		}
		if (selectedProjects[i].status == "hibernating") {
			hib+=1;
		}
		if (selectedProjects[i].status == "frogged") {
			frog+=1;
		}

	  all+=1;
	} // end for loop

	document.write("Total # projects: <b>" + all + "</b><br><br>");
	document.write("Total # projects completed: <b>" + comp + "</b><br><br>");
	document.write("Total # WIPs: <b>" + wips + "</b><br><br>");
	document.write("Total # projects hibernating: <b>" + hib + "</b><br><br>");
	document.write("Total # projects frogged: <b>" + frog + "</b><br><br>");
	document.write("Percent of projects completed: <b>" + Math.round(comp/all * 100) + "%</b><br><br>");
	document.write("Average Duration of Completed Projects: <b>" + Math.round(dur/comp * 100) / 100 + " </b>Days<br><br>");
	document.write("Average Happiness of All Projects: <b>" +  Math.round(happy/comp * 100) / 100 + "</b><br><br>");
	document.write("# Projects marked as finished but not at 100% progress: <b>" + prog + "</b><br>" + pro_list + "<br>");
}
}
}();

</script>
<script src="http://api.ravelry.com/projects/<?php print $row->rav_name ?>/progress.json?callback=RavelryThing.progressReceived&key=<?php print $row->rav_api ?>&status=in-progress+hibernating+finished+frogged&version=0"></script>
</head>
<body background="./bg1.jpg">
<br><br>
Ravelry Project Dashboard for <b><?php print $row->rav_name ?></b>
<br><br>
<script> RavelryThing.calcStats(); </script> 
<br><br><a href=./rav_pg1.php>Back to Search</a>
</body>
</html>