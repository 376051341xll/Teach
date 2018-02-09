<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script language="javascript" src="ckeditor/ckeditor.js"></script>
</head>
<body>
<form id="form1" name="form1" method="post" action="">
  <textarea name="content" id="content"></textarea>
  <script type="text/javascript">
 CKEDITOR.replace( 'content',
 {
 	filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
 	filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',
 	filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',
 	filebrowserUploadUrl : 
 	   'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
 	filebrowserImageUploadUrl : 
 	   'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
 	filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
 } 
 );
</script>
</form>
</body>
</html>
