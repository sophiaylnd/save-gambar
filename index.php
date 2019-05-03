<?php
	include_once("connection.php");
	//query sql
	$sql = "SELECT * FROM gambar";
?>
<!DOCTYPE html>
<html>
<head>
<title> File Image Upload Sophia </title></head>
<body>
	<table width="55%" align="center" cellspacing="0">
		<caption><font size="6" color="#191970"><strong>Image File Upload</strong></font></caption>
		<thead>
			<tr height="55" valign="bottom">
				<td colspan="4" align="left"><a href="add.php">
					<img src="images/add.png" width="32" height="32" title="Add Image"></a></td>
			</tr>
			<tr bgcolor="#66CDAA" padding="0" height="35">
				<th>NAME</th>
				<th>FILE</th>
				<th colspan="2">UPDATE</th>
			</tr>
			<thead>
				<tbody>
					<?php
					$select_stmt=$db->prepare($sql);
					$select_stmt->execute();
					while($row=$select_stmt->fetch(PDO::FETCH_ASSOC))
					{
						echo "<tr>";
						echo "<td align='center' style='border-bottom: 1pt solid black;'>".$row['name']."</td>";
						echo "<td align='center' style='border-bottom: 1pt solid black;'><img src='upload/".$row['image']."' width='70' height='60'></td>";
						echo "<td width='50' align='center' style='border-bottom: 1pt solid black;'><a href='edit.php?update_id=".$row['id']."'><img src='images/edit.png' width='20' height='20'></a></td>";
						echo "<td width='50' align='center' style='border-bottom: 1pt solid black;'><a href='delete.php?delete_id=".$row['id']."' onClick=\"return confirm('Are You Sure Want To Delete?')\">
						<img src='images/delete.png' width='20' height='20'></a></td>";
					echo "</tr>";

					}

					?>
				</tbody>
				</table>
</body>

</html>