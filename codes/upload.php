<?php
session_start();
 
$message = ''; 

// we've checked whether it’s a valid POST request in the first place
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload')
{
//After validating the POST request, we check that the file upload was successful.
  if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
  {
    /*
In PHP, when a file is uploaded, the $_FILES superglobal variable is populated with all the information about the uploadedfile. It’s initialized as an array and may contain the following information for successful file upload.

tmp_name: The temporary path where the file is uploaded is stored in this variable.
name: The actual name of the file is stored in this variable.
size: Indicates the size of the uploaded file in bytes.
type: Contains the mime type of the uploaded file.
error: If there’s an error during file upload, this variable is populated with the appropriate error message. In the case of successful file upload, it contains 0, which you can compare by using the UPLOAD_ERR_OK constant.
    */
 
    // If the file upload is successful, we initialize a few variables with information about the uploaded file.
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileSize = $_FILES['uploadedFile']['size'];
    $fileType = $_FILES['uploadedFile']['type'];
    $fileNameCmps = explode(".", $fileName); // creating array variable $fileNameCmps [0]=firstname [1]=extension
    $fileExtension = strtolower(end($fileNameCmps)); // strtolower : convert to lowercase
                                                     // end move to last item of array
 
    // md5 - Calculate the MD5 hash of the string
    // The time() function returns the current time in the number of seconds since the Unix Epoch (January 1 1970 00:00:00 GMT).
    // . used to combine strings 
    // $fileExtension contains extension in lowercase from above code
    $dated = date('m-d-Y---h-i-s-a',time());
    //$newFileName = $fileName . $dated . '.' . $fileExtension;
    $newFileName = $fileNameCmps[0] .  '.' . $dated . '.' . $fileExtension;


 
    // check if file has one of the following extensions
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');
  
     //in_array — Checks if a value exists in an array .Return True or False. checking extension in array.
    if (in_array($fileExtension, $allowedfileExtensions))
    {  // in_array returns true 

      
      // directory in which the uploaded file will be moved
      $uploadFileDir = './uploaded_files/';
      $dest_path = $uploadFileDir . $newFileName; // using . to combine strings
 
      if(move_uploaded_file($fileTmpPath, $dest_path)) 
      {
        // if move_uploaded_file returns True
        $message ='File is successfully uploaded.';
      }
      else
      {
        // if move_uploaded_file returns  False
        $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
      }
    }
    else
    {
      // in_array returns false
      $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
    }
  }
  else
  {
    // if file upload is not successful
    $message = 'There is some error in the file upload. Please check the following error.<br>';
    $message .= 'Error:' . $_FILES['uploadedFile']['error'];
  }
}
$_SESSION['message'] = $message;
header("Location: index.php");
