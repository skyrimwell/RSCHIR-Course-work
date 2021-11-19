<?php
include_once '../login/config.php';
if(isset($_POST['save']))
{	 
	 $exam_name = $_POST['exam_name'];
	 $date = $_POST['date'];
	 $time = $_POST['time'];
	 $teacher = $_POST['teacher'];
     $course_group = $_POST['course_group'];
	 $sql = "INSERT INTO examdates (exam_name , date , time , teacher , course_group)
	 VALUES ('$exam_name','$date','$time','$teacher', '$course_group')";
	 if (mysqli_query($link, $sql)) {
		echo "New record created successfully !";
	 } else {
		echo "Error: " . $sql . "
" . mysqli_error($link);
	 }
	 mysqli_close($link);

     header("../admin/teacherpage.php");
}
?>