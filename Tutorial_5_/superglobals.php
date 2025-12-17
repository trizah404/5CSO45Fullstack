<?php 

?> 

<form method="POST" enctype="multipart/form-data">
	<h3> STUDENT REGISTRATION: </h3>
	Name: <input type="text" name="name" required> <br><br> 
	Age: <input type="number" name="age" required> <br><br> 
	Upload photo: <input type="file" name="image" required> <br><br> 
	<button type= "submit"> Submit </button> 
</form> 

<?php 

if ($_SERVER['REQUEST_METHOD']== "POST") { 

	echo "Name:" . $_POST['name']."<br>";
	echo "Age:"  .$_POST['age']. "<br>";
	echo "Uploaded Photo:" . $_FILES['image'] ['name']. "<br>";
	echo "Uploaded Photo:" . $_FILES['image'] ['name']. "<br>";
	echo "Uploaded Photo:" . $_FILES['image'] ['name']. "<br>";



	// code...
}
 ?>