<?php

session_start();

require_once 'includes/connection.php';

require_once 'includes/format.php';


//resetData('575992','aditi');
function getQuery($table) {

    $query = "SELECT * FROM $table";

      $and = false;

      foreach($_POST as $a => $a_value) {

        if($a_value != '') {

          if($and) {

            $query .= ' && ';

          } else {

            $query .= ' WHERE ';

          }

          $query .= "$a = '$a_value' ";

          $and = true;

        }

    }

    $query .= ' ORDER BY Time DESC LIMIT 50';

    return $query;

}

$connect = connectdb($_SESSION['username']);

$t = date('Y-m-d H:i:s');

$query = getQuery('log');

$result = mysqli_query($connect,$query);



?>
<html>
<head>
  <title>Log</title>
</head>
<body>
<form method="post">

      <input type="text" name="Name" placeholder="Name">

      <input type="number" name="Class" placeholder="Class">

      <input type="number" name="Exam" placeholder="Exam">

      <input type="text" name="Subject" placeholder="Subject">

      <input type="text" name="Type" placeholder="Type">

      <button type="submit" name="submit">Log</button>

</form>
<button onclick="location.reload();">Reload</button>

<table>

    <tbody>

        <?php

        while($row = mysqli_fetch_assoc($result)) { 

            $t = explode(' ',$row['Time']);
            if($row['Seen'] == 0) { ?>
            	<tr style="font-weight: bold;">
        	<?php } else { ?>
            	<tr>
<?php } ?>
                <td scope="row"><?php echo getFormattedDate($t[0]); ?></td>

                <td><?php echo getFormattedTime($t[1],true); ?></td>

                <td><?php echo $row['Name']; ?></td>

                <td><?php echo $row['Class']; ?></td>

                <td><?php echo $row['Exam']; ?></td>

                <td><?php echo $row['Subject']; ?></td>

                <td><?php echo $row['Type']; ?></td>

                <td><?php echo $row['Message']; ?></td>
            </tr>
            <?php if(!$row['Seen']) { 
            	$query = "UPDATE log SET Seen = '1' WHERE Name='$row[Name]' && Class='$row[Class]' && Exam = '$row[Exam]' && Subject = '$row[Subject]' && Type = '$row[Type]' && Message = '$row[Message]' && Time = '$row[Time]'";
            	mysqli_query($connect,$query);
            	?>
        	<?php } } ?>

    </tbody>

</table>
</body>
</html>