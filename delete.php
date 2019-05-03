<?php
	include_once("connection.php");

	if(isset($_GET['delete_id']))
	{

		//select image from db to delete
		$id=$_GET['delete_id']; //get delete_id and store in $id variable
		$sql="SELECT * FROM gambar WHERE id=:id";
		$select_stmt= $db->prepare($sql);
		$select_stmt->bindParam(':id', $id);
		$select_stmt->execute();
		$row=$select_stmt->fetch(PDO::FETCH_ASSOC);
		unlink("upload/".$row['image']); //unlink function permanently
		//delete an original record form db
		$sql="DELETE FROM gambar WHERE id=:id";
		$delete_stmt = $db->prepare($sql);
		$delete_stmt->bindParam(':id',$id);
		$delete_stmt->execute();

		header("Location:index.php");

	}
	?>