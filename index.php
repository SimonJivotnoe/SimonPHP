<?php
$dir    = '/OpenServer/domains/php1/';

if($_FILES["filename"]["size"] > 1024*3*1024)
   {
     echo ("Размер файла превышает три мегабайта");
     exit;
   }
   // Проверяем загружен ли файл
   if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
   {
     // Если файл загружен успешно, перемещаем его
     // из временной директории в конечную
     move_uploaded_file($_FILES["filename"]["tmp_name"], "/OpenServer/domains/php1/".$_FILES["filename"]["name"]);
   } else {
      //echo("Ошибка загрузки файла");
   }


if (!empty($_GET['delete']))
{
	if(file_exists($_GET['delete']))
	{
		unlink ($dir.$_GET['delete']);
		echo "file ".$_GET['delete']." was deleted";
	}
	else
	{
		echo "file ".$_GET['delete']." was deleted";
	}
}

$files1 = scandir($dir);

function whatSize($files)
{	
	if (filesize($files)<1024)
	{
		$b = filesize($files)."b";
	}
	elseif(filesize($files)>1024 && filesize($files)<1048576)
	{
		$b = round(filesize($files)/1024, 2) ."kb";
	}
	else
	{
		$b = round(filesize($files)/1048576, 2) ."Mb";
	}
	
	return $b;
}
if (!empty($files1))
{	
	array_shift($files1);
	array_shift($files1);
	$result = "<table border='1'><th>name</th><th>size</th><th>action</th>";
	foreach ($files1 as $files)
	{
		$result .= "<tr><td>$files</td><td>".whatSize($files)."</td><td><a href='index.php?delete=$files'>delete</a></td></tr>";
	}
	$result .= "</table>";
}
//<h2><p><b> Форма для загрузки файлов </b></p></h2>
$result .= '<h2><p><b></b></p></h2>
      <form action="index.php" method="post" enctype="multipart/form-data">
      <input type="file" name="filename"><br> 
      <input type="submit" value="Загрузить"><br>
      </form>';

print_r($result);



