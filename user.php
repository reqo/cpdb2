<?php
# check for a user session
if (!isset($_SESSION["user"])) {
	header("location: login.php");
}
?>

<h2>Available courses</h2>

<?php
if (isset($_GET["action"]) && $_GET["action"] == "participate") {
?>
	<a href="index.php">Back</a>
<?php
}
?>

<?php 
if (isset($_GET["action"]) && ($_GET["action"] == "participate")) {
?>
	<h3>Register for the course</h3>
	<form method="post" action="index.php">
		<input type="hidden" value="<?= $_GET["id"] ?>" name="course_id" />		
		Name: <input type="text" name="participant_name"><p></p>
		Surname: <input type="text" name="participant_surname"><p></p>
		Age: <input type="text" name="participant_age"><p></p>
		<input type="submit" name="participation" value="Confirm" />
	</form>
<?php
} else {
?>
	<table border="1">
		<tr>			
			<th>Course name</th>
			<th>Course date</th>
			<th>Lecturer</th>
			<th>Note</th>
			<th>Action</th>
		</tr>
	<?php	
	# retrieve and display data about contracts
	$sql = "SELECT * from course_lecturer";
	$result = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_assoc($result)) {
		?>
		<tr>			
			<td><?= $row["course_name"] ?></td>
			<td><?= $row["course_date"] ?></td>
			<td><?= $row["Lecturer"] ?></td>
			<td><?= $row["course_note"] ?></td>
			<td>
				<a href="index.php?action=participate&id=<?= $row["course_id"] ?>">Participate</a>				
			</td>
		</tr>
		<?php
	}
	?>
	</table>
<?php
}
?>