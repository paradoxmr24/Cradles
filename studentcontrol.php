<?php
session_start();
require 'includes/connection.php';
$connect = connectdb($_SESSION['username']);
$query = "SELECT Id,Name,Subject,Class FROM exams";
$result = mysqli_query($connect,$query);
?>
<form method="post">
	<select name="e_id">
		<?php while($row = mysqli_fetch_assoc($result)) { ?>
			<option value="<?php echo $row['Id']; ?>"><?php echo $row['Id'] . '-' . $row['Name'] . '-' . $row['Class'] . '-' . $row['Subject']; ?></option>
		<?php } ?>
	</select>
	<button type="submit" name="submit">Submit</button>
</form>
<?php 
if(isset($_POST['submit'])) { ?>
<table>
	<tbody>
	<?php 
	$query = "SELECT * FROM marks WHERE Exam_id = '$_POST[e_id]'";
	$result = mysqli_query($connect,$query);
	while ($row = mysqli_fetch_assoc($result)) { ?>
	<tr>
		<td><?php echo $row['Student_id']; ?></td>
		<td>
			<form style="display:inline" method="post" action="functions/l-resetstudent.php">
				<input type="text" name="s_id" value="<?php echo $row['Student_id']; ?>" style="display: none;">
				<input type="text" name="e_id" value="<?php echo $_POST['e_id']; ?>" style="display: none;">
				<button type="submit">Reset Data</button>
			</form>
			<form style="display:inline" method="post" action="functions/l-checkquestions.php">
				<input type="text" name="s_id" value="<?php echo $row['Student_id']; ?>" style="display: none;">
				<input type="text" name="e_id" value="<?php echo $_POST['e_id']; ?>" style="display: none;">
				<button type="submit">Check Questions</button>
			</form>
		</td>
	</tr>
	
<?php } ?>
</tbody></table>
<?php } ?>