<?php
$tablegen = '<table cellpadding="0" cellspacing="0" border="0"> <thead> <tr>
<th> Предмет
<th> Дата
<th> Время
<th> Преподаватель
<th> Группа';

function tableBuilder($tablegen)
{
    $destroyer = '
            <div >
            <form action="teacherpage.php" method="POST">
                <input type="submit" name="destroy" value="Скрыть">
            </form>
        </div>';
        
    print $tablegen;
    require_once "../login/config.php";
    $start_query = "SELECT * FROM examdates";
$result_query = mysqli_query($link, $start_query);
while($data = mysqli_fetch_array($result_query)){
    print "<tr>" . "<td>" . $data['exam_name'] . "</td>" .
    "<td>" . $data['date'] .  "</td>" .
    "<td>" . $data['time'] .  "</td>" .
    "<td>" . $data['teacher'] .  "</td>" .
    "<td>" . $data['course_group'] .  "</td>";
   }	
print $destroyer;
}

function destroy($tablegen,){
    strip_tags($tablegen);
}
?>