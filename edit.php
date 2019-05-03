<?php
require_once("connection.php");

if(isset($_GET['update_id']))
{
	try
	{
		$id=$_GET['update_id'];
		$sql="SELECT * FROM gambar WHERE id =:id";
		$select_stmt=$db->prepare($sql);
		$select_stmt->bindParam(':id', $id);
		$select_stmt->execute();
		$row = $select_stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}
?>
<!DOCTYPE html>
<html>
<head><title>File Update</title></head>
<body>
<div align="center">
	<form method="post" enctype="multipart/form-data" action="">
		<fieldset style="width:100px; border-color: #66CDAA; border-radius: 25px;">
			<legend style="color: #66CDAA; font-weight:bold; text-align: right; border: 1px solid yellow;">Edit file image</legend>
				<table align="center" width="90">
					<tr>
						<td width="50">Name</td>
						<td><input type="text" name="txt_name" value="<?php echo $row['name']; ?>" /></td>
					</tr>
					<tr>
						<td>File</td>
						<td><input type="file" name="txt_file"  value="<?php echo $row['image']; ?>"/></td>
					</tr>
					<tr>
						<td></td>
						<td><img src="upload/<?php echo $row['image']; ?>" height="100" width="100"/></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" name="btn_update" value="Update"></td>
					</tr>
				</table>
			</fieldset>
		</form>
	</div>
</body>
</html>

<?php
if(isset($_POST['btn_update']))
{
	try
	{
		$name = $_POST['txt_name']; //textbox name txt_name
		$image_file = $_FILES["txt_file"]["name"];
		$type = $_FILES["txt_file"]["type"];
		$size = $_FILES["txt_file"]["size"];
		$temp = $_FILES["txt_file"]["tmp_name"];

		$path = "upload/".$image_file;

		$directory="upload/";

		if($image_file)
		if($type=="image/jpg" || $type=='image/jpeg' || $type=='image/png' || $type=='image/gif')
		{
			if(!file_exists($path)) //cek file not exist in your upload folder
			{
				if($size < 5000000) //cek file size 5mb
				{
					unlink($directory.$row['image']);
					//moved upload file directory to your upload folder
					move_uploaded_file($temp, "upload/".$image_file);
				}
				else
				{
					//error message file size not large
					$errorMsg="Your file to large please upload 5mb size";
				}
			}
			else
			{
				//error message file not exist your upload folder path
				$errorMsg="File already exists check upload folder";
			}
		}
		else
		{
			//error message file extension
			$errorMsg="Upload JPG, JPEG, PNG, GIF File formate check file extension";
		}
		else
		{
			//if you not select new image then use previous image
			$image_file=$row['image'];
		}
		if(!isset($errorMsg))
		{
			$update_stmt=$db->prepare('UPDATE gambar SET name=:name_up, image=:file_up WHERE id=:id');
			$update_stmt->bindParam(':name_up', $name);
			$update_stmt->bindParam(':file_up', $image_file);
			$update_stmt->bindParam(':id', $id);


			if($update_stmt->execute())
			{
				echo "<scipt>alert('file Update succesfully');</script>";
				header("Location:index.php");
			}
			else
			{
				echo "<script>alert('File Update failed');</script>";
			}
		}
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}
?>