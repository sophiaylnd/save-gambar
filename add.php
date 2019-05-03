<?php
require_once("connection.php");

if(isset($_POST['btn_insert']))
{
	try
	{
		$name = $_POST['txt_name']; //textbox name txt_name
		$image_file = $_FILES["txt_file"]["name"];
		$type = $_FILES["txt_file"]["type"];
		$size = $_FILES["txt_file"]["size"];
		$temp = $_FILES["txt_file"]["tmp_name"];

		$path="upload/".$image_file; //set upload folder path

		if(empty($name))
		{
			$errorMsg = "Please enter name";
		}
		else if(empty($image_file))
		{
			$errorMsg = "Please Select Image";
		}
		else if($type=="image/jpg" || $type=='image/jpeg' || $type=='image/png' || $type=='image/gif')
		{
			if(!file_exists($path)) //cek file not exist in your upload folder
			{
				if($size < 5000000) //cek file size 5mb
				{
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
		if(!isset($errorMsg))
		{
			$sql = "INSERT INTO gambar(name,image) VALUES(:fname, :fimage)";
			$insert_stmt=$db->prepare($sql);
			$insert_stmt->bindParam(':fname', $name);
			$insert_stmt->bindParam(':fimage', $image_file); //bind all parameter

			if($insert_stmt->execute())
			{
				echo "<scipt>alert('file upload succesfully')</script>";
				header("Location:index.php");
			}
			else
			{
				echo "<script>alert('File upload failed')</script>";
			}
		}
		else
		{
			echo "<script>alert('".$errorMsg."')</script>";
		}
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}
?>
<!DOCTYPE html>
<html>
<head><title>Add File Image</title></head>
<body>
	<div align="center">
		<form method="post" enctype="multipart/form-data" action="">
			<!-- Gunakan Multipart jika pada file terdapat file upload-->
			<fieldset style="width: 75px; border-color: #66CDAA; border-radius: 25px;">
				<legend style="color: #66CDAA; font-weight: bold; text-align: right; border: 1px solid yellow;">Insert file image</legend>
				<table align="center">
					<tr>
						<td>Name</td>
						<td><input type="text" name="txt_name"/></td>
					</tr>
					<tr>
						<td>File</td>
						<td><input type="file" name="txt_file"/></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" name="btn_insert" value="Insert"></td>
					</tr>
				</table>
			</fieldset>
		</form>
	</div>
</body>
</html>