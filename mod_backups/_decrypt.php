<?php
include("../login/valida.php");
include("../_funcoes.php");

if(isset($_POST["submit"])) {
    if(isset($_FILES["file"]["tmp_name"])){
        $content = decryptData(file_get_contents($_FILES["file"]["tmp_name"]),"controltextil123");
    }
}

?>


<!DOCTYPE html>
<html>
<body>

<form action="_decrypt.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="file" id="file">
    <input type="submit" value="Upload" name="submit">
</form>

</body>
</html>

