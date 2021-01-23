<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="./css/alldivs.css">
  <title>PHP File Upload</title>
</head>


<html>  
<body> 
<div id="UgDiv" name="UgDiv" title="Div Element">  

	<div id="subDiv1"> 
		<?php
			echo nl2br("\r\n");
			$path = ".";
			$dh = opendir($path);
			$i=1;
			while (($file = readdir($dh)) !== false) {
				if($file != "." && $file != ".." && $file != "index.php" &&  $file != ".git"){
					echo "<a href='$path/$file'>$file</a><br /><br />";
					$i++;
				}
			}
			closedir($dh);
			echo nl2br("\r\n");
		?>	
        </div> 
        <br /> 

        <div id="subDiv2" name="subDiv2" title="Subdivision Div Element"> 
		<! ––
		Below PHP code shows the status of the file upload, and it’ll be set in a session variable 
       		by the upload.php script
        	––>

  		<?php
    			if (isset($_SESSION['message']) && $_SESSION['message']) {
      				printf('<b>%s</b>', $_SESSION['message']);
      				unset($_SESSION['message']);
   			 }
  		?>

		<! ––
		enctype = Type of encoding which should be used when the form is submitted , It can have one of 3 values:
		application/x-www-form-urlencoded: This is the default value when you don’t set the value of the enctype
                attribute explicitly. In this case, characters are encoded before it’s sent to the server. If you don’t 
                have the file field in your form, you should use this value for the enctype attribute.
		multipart/form-data: it allows you to upload files using the POST method. Also, it makes sure that the 
                characters are not encoded when the form is submitted.
                text/plain: This is generally not used. With this setting, the data is sent unencoded.
                input type="file" name="uploadedFile".which allows you to select a file from your computer.
                ––>

  		<form method="POST" action="./codes/upload.php" enctype="multipart/form-data">
    			<div class="upload-wrapper">
      				<span>Upload a File:</span>
      				<input type="file" name="uploadedFile" />
    			</div>
		        <input type="submit" name="uploadBtn" value="Upload" />
		 </form>

        </div> 
        <br />


        <div class="fixed" >
               <?php  include './codes/footer.php';?>     
        </div>
	<br />

</div>
</body>  
</html> 
