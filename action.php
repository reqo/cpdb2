<?php
# process request to create contract
if (isset($_POST["create_course"])) {
	$course_name = $_POST["course_name"];
	$course_note = $_POST["course_note"];
	$course_date = $_POST["course_date"];	
	$lecturer_id = $_POST["lecturer_id"];

	$sql = "CALL sp_course_ops('i', 0, '{$course_name}', '{$course_note}', '{$course_date}', {$lecturer_id})";
	mysqli_query($conn, $sql);

	header("location: index.php");
}

# process request to delete contract
if (isset($_POST["delete_course"])) {
	$course_id = $_POST["course_id"];

	$sql = "CALL sp_course_ops('d',{$course_id},'','','',0)";
	mysqli_query($conn, $sql);

	header("location: index.php");
}

# process request to update contract
if (isset($_POST["update_course"])) {	
	$course_id = $_POST["course_id"];
	$course_name = $_POST["course_name"];
	$course_note = $_POST["course_note"];
	$course_date = $_POST["course_date"];	
	$lecturer_id = $_POST["lecturer_id"];

	$sql = "CALL sp_course_ops('u',{$course_id},'{$course_name}', '{$course_note}', '{$course_date}', {$lecturer_id})";
	mysqli_query($conn, $sql);

	header("location: index.php");
}

#process request to participate
if (isset($_POST["participation"])) {
	$course_id = $_POST["course_id"];
	$participant_name = $_POST["participant_name"];
	$participant_surname = $_POST["participant_surname"];
	$participant_age = $_POST["participant_age"];
	
	$sql = "insert into participants(course_id, participant_name, participant_surname, participant_age) 
	values ({$course_id}, '{$participant_name}', '{$participant_surname}', {$participant_age})";
	mysqli_query($conn, $sql);

	header("location: index.php");
}

#process request to add lecturer
if (isset($_POST["add_lecturer"])) {
	$lecturer_name = $_POST["lecturer_name"];
	$lecturer_surname = $_POST["lecturer_surname"];
	
	$sql = "insert into lecturer(lecturer_name, lecturer_surname) values('{$lecturer_name}','{$lecturer_surname}')";
	mysqli_query($conn, $sql);

	header("location: index.php");
}
?>