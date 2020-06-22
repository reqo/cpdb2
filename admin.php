<?php
# check for a user session
if (!isset($_SESSION["user"])) {
	header("location: login.php");
}
?>

<h2>Courses</h2>

<p>
	<?php
	# if the page is in record's create/update or delete mode (action parameter is set) - show 'back' link
	if (isset($_GET["action"]) && ($_GET["action"] == "create" || $_GET["action"] == "update" 
		|| $_GET["action"] == "delete" || $_GET["action"] == "new_lecturer")) {
	?>
		<a href="index.php">Back</a>
	<?php
	# otherwise - show 'new record' link
	} else {
	?>
		<a href="index.php?action=create">New course</a>
		<a href="index.php?action=new_lecturer">Add lecturer</a>
	<?php
	}
	?>
</p>


<?php
# check for action parameter
# show create/update or delete form if it is set
if (isset($_GET["action"]) && ($_GET["action"] == "create" || $_GET["action"] == "update" || $_GET["action"] == "delete")) {
?>
	<form method="post" action="index.php">
		<input type="hidden" value="<?= $_GET["id"] ?>" name="course_id" />
		<?php
		# if the current mode is create/update
		# show corresponding form with the required fields and buttons
		if ($_GET["action"] == "create" || $_GET["action"] == "update") {
		?>
		<p>
			<b>Lecturer</b>
		</p>
		<p>
			<select name="lecturer_id">
			<?php
			# retrieve suppliers ids/info to display select control
			$sql = "SELECT lecturer_id, concat(lecturer_name,' ',lecturer_surname) as 'Name' FROM lecturer";
			$result = mysqli_query($conn, $sql);

			while ($row = mysqli_fetch_assoc($result)) {
				?><option value="<?= $row["lecturer_id"] ?>"><?= $row["Name"] ?></option><?php
			}
			?>
			</select>
		</p>
		<p>
			<b>Course date</b>
		</p>
			<input type="text" name="course_date"/>
		<p>
			<b>Course name</b>
		</p>
			<input type="text" name="course_name"/>
		<p>
			<b>Note</b>
		</p>
		<p>
			<?php
			# retrieve and display contract note of the updated contract
			if (isset($_GET["action"]) && $_GET["action"] == "update") {
				$course_id = $_GET["id"];

				$sql = "SELECT course_note FROM course WHERE course_id = {$course_id}";
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($result);
			}
			?>
			<textarea name="course_note" rows="5" cols="50"><?= isset($row["course_note"]) ?></textarea>
		</p>
		<p>
			<?php
			# set proper names for create/update buttons
			if (isset($_GET["action"]) && $_GET["action"] == "create") {
			?>
				<input type="submit" name="create_course" value="Save" />
			<?php
			} else if (isset($_GET["action"]) && $_GET["action"] == "update") {
			?>
				<input type="submit" name="update_course" value="Save" />
			<?php
			}
			?>
		</p>
		<?php
		# if the current mode is delete
		# display the corresponding question and button
		} else if ($_GET["action"] == "delete") {
		?>
			<b>Delete the course #<?= $_GET["id"] ?>?</b>
			<p>
				<input type="submit" name="delete_course" value="Continue" />
			</p>
		<?php
		}
		?>
	</form>
<?php
} elseif (isset($_GET["action"]) && $_GET["action"] == "new_lecturer") {
?>
	<h3>Add new lecturer</h3>
	<form method="post" action="index.php">
		<p>Name:</p>
		<input type="text" name="lecturer_name">
		<p>Surname:</p>
		<input type="text" name="lecturer_surname">
		<input type="submit" name="add_lecturer" value="Add">			
	</form>
<?php
} else {
?>
	<table border="1">
		<tr>
			<th>Course id</th>
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
			<td><a href="index.php?action=info&id=<?= $row["course_id"] ?>"><?= $row["course_id"] ?></a></td>
			<td><?= $row["course_name"] ?></td>
			<td><?= $row["course_date"] ?></td>
			<td><?= $row["Lecturer"] ?></td>
			<td><?= $row["course_note"] ?></td>
			<td>
				<a href="index.php?action=update&id=<?= $row["course_id"] ?>">Update</a>
				<a href="index.php?action=delete&id=<?= $row["course_id"] ?>">Delete</a>
			</td>
		</tr>
	<?php
	}
	?>
	</table>
<?php
}

# if the action mode is info
if (isset($_GET["action"]) && $_GET["action"] == "info") {
	$course_id = $_GET["id"];
?>
	<h3>Participants by course #<?= $course_id ?></h3>
	<p>
	<a href="index.php">Hide</a>
	</p>
	<?php
	# retrieve data about selected products
	$sql = "SELECT concat(participant_name,' ',participant_surname) as 'Name', participant_age
		FROM participants
		WHERE course_id = {$course_id}";		
	$result = mysqli_query($conn, $sql);

	# check the size of a result set
	if (mysqli_num_rows($result) > 0) {
		?>
		<table border="1">
			<tr>
				<th>Name</th>
				<th>Age</th>				
			</tr>
		<?php
		# display products if the contract is not empty
		while ($row = mysqli_fetch_assoc($result)) {
			?>
			<tr>
				<td><?= $row["Name"] ?></td>
				<td><?= $row["participant_age"] ?></td>				
			</tr>
			<?php
		}
	} else {
		# if the result set is empty print the following message
		echo "No participants";
	}
	?>
	</table>
<?php
}
?>

