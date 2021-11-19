<?php
$tablegen = '<table cellpadding="0" cellspacing="0" border="0"> <thead> <tr>
<th> Предмет
<th> Дата
<th> Время
<th> Преподаватель
<th> Оставшееся время';



function tableBuilderOnGroup($tablegen)
{
    $destroyer = '
            <div >
            <form action="authmainpage.php" method="POST">
                <input type="submit" name="destroy" value="Скрыть">
            </form>
        </div>';
        
    print $tablegen;
    require_once "../login/config.php";
    $start_query = "SELECT * FROM examdates WHERE course_group='$_SESSION[course_group]'";
$result_query = mysqli_query($link, $start_query);
while($data = mysqli_fetch_array($result_query)){
    print "<tr>" . "<td>" . $data['exam_name'] . "</td>" .
    "<td>" . $data['date'] .  "</td>" .
    "<td>" . $data['time'] .  "</td>" .
    "<td>" . $data['teacher'] .  "</td>" .
    "<td>" . DateTime::createFromFormat('Y-m-d', date('Y-m-d'))->diff(DateTime::createFromFormat('Y-m-d', $data['date']))->format("%r%a") . " Дней</td>";
}	
print $destroyer;
}
function tableBuilderOnTeacher($teacher)
{
    $destroyer = '
            <div >
            <form action="authmainpage.php" method="POST">
                <input type="submit" name="destroy" value="Скрыть">
            </form>
        </div>';

    $tablegen2 = '<table cellpadding="0" cellspacing="0" border="0"> <thead> <tr>
    <th> Предмет
    <th> Дата
    <th> Время
    <th> Группа
    <th> Преподаватель';
    print $tablegen2;
    require_once "../login/config.php";
    $start_query = "SELECT * FROM examdates WHERE teacher='$teacher'";
$result_query = mysqli_query($link, $start_query);
while($data = mysqli_fetch_array($result_query)){
    print "<tr>" . "<td>" . $data['exam_name'] . "</td>" .
    "<td>" . $data['date'] .  "</td>" .
    "<td>" . $data['time'] .  "</td>" .
    "<td>" . $data['course_group'] .  "</td>" .
    "<td>" . $data['teacher'] .  "</td>" ;
}	
    print $destroyer;
}

function destroy($tablegen,){
    strip_tags($tablegen);
}
?>