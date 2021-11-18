<?php

function tableBuilder()
{
    print "<table>" . "<thead>" . "<tr>".
    "<th>" . "Предмет" .
    "<th>" . "Дата" .
    "<th>" . "Время" .
    "<th>" . "Преподаватель";
    require_once "../login/config.php";
$start_query = "SELECT * FROM examdates WHERE course_group='$_SESSION[course_group]'";
$result_query = mysqli_query($link, $start_query);
while($data = mysqli_fetch_array($result_query)){
    print "<tr>" . "<td>" . $data['exam_name'] . "</td>" .
    "<td>" . $data['date'] .  "</td>" .
    "<td>" . $data['time'] .  "</td>" .
    "<td>" . $data['teacher'] .  "</td>" ;
}	
}


?>