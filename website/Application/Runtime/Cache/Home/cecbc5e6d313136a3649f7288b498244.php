<?php if (!defined('THINK_PATH')) exit();?><form action="/index.php/Home/Base/uploadfile" enctype="multipart/form-data" method="post" >
<input type="text" name="name" />
<input type="file" name="photo" />
<input type="submit" value="submit" >
</form>
<form action="/index.php/Home/Base/insertplant" enctype="multipart/form-data" method="post" >
<input type="text" name="plantname" />
<input type="text" name="submittime" />
<input type="text" name="detail" />
<input type="text" name="picnames" />
<input type="submit" value="submit" >
</form>