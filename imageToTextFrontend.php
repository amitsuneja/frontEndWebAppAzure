<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
   <style>
       body{
           background-color: #fafafa;
       }
       #imgText{
            white-space: pre-wrap;
            height: 50vh;
            overflow: scroll;
            background: #fff;
       }
   </style>
</head>
<body>
    <div class="container p-4">
        <form action="" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <div class="row">
                    <label for="">Select Image:</label>
                    <input type="file" name="file" id="file" class="form-control" required accept="image/*">
                    <button type="button" class="btn btn-primary" onclick="fetchTextFromImg()">Upload</button>
                </div>
              </div>
        </form>

        <hr>
        <div class="result p-4" id="result" style="display: none;">
              <div class="alert alert-success">Result</div>
              <div id="imgText" class="p-4 mt-2" style="white-space: pre-wrap;"></div>
        </div>
    </div>
</body>
<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>

  <script>
   function fetchTextFromImg(){
       let inputImg = $("#file")[0].files[0];
       console.log(inputImg);
       let fd = new FormData();
       fd.append("file",inputImg);
      let url ="https://amitsunejafuncapp.azurewebsites.net/api/HttpOcrFunc?code=JVSLx7s7la2ULBg6Qfa4/S7j22mTLjk6HEY2uwaa8OZZqbciOV3zFw==";
       $.ajax({
           url,
           type:'POST',
           data:fd,
           contentType: false,
           processData: false,
           success:(response)=>{
               $("#result").css("display","block");
               $("#imgText").text(response);
               console.log(response);
           }
       })

       
   } 

  </script>
        <div class="fixed" >
               <?php  include './codes/footer.php';?>
        </div>

</html>
