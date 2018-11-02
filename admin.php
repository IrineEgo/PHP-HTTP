<?php
    if (isset($_POST['upload'])) {
	    // Редирект на страницу с тестами через три секунды
	    header('refresh:3; url=list.php');
        if (!empty(glob('tests/*.json'))) {
            $allFiles = glob('tests/*.json');
        } 
		    else {
                $allFiles = [0];
            }

        $uploadfile = 'tests/' . basename($_FILES['testfile']['name']);
        // Проверка на ошибки
        if (pathinfo($_FILES['testfile']['name'], PATHINFO_EXTENSION) !== 'json') {
            $result = 'Необходим файл с расширением .json. Загрузите еще один файл!';
	    } 
	        else if (in_array($uploadfile, $allFiles, true)) {
                $result = 'Файл с таким именем уже существует!';	
            } 
	            else if (move_uploaded_file($_FILES['testfile']['tmp_name'], $uploadfile)) {
                    $result = 'Файл успешно загружен!';
                } 
	                else {
                        $result = 'Произошла ошибка!';
                    }
    }
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>Генератор тестов на PHP и JSON</title>
	<style type="text/css">
      a {
        color: navy;
        text-decoration: none;
      }	
      legend {
        font-weight: bold;
		margin: 20px 10px;
      }
	  fieldset {
	    margin: 40px auto 20px;
		width: 30%;
		background-color: whitesmoke;
	  }
    </style> 
  </head>
<body>
  <!-- Выводим информацию о файле и уведомление об успешной загрузке/ошибке -->
    <?php 
        if (isset($_POST['upload'])): 
	?>
        <a href="<?php $_SERVER['HTTP_REFERER'] ?>"><b>&laquo; НАЗАД</b></a><br>
            <?php 
		        $result; 
		    ?>	
			    <h1>Вы будете перенаправлены на страницу с тестами!</h1>
                    <?php endif; 
			        ?>

    <!-- До отправки/загрузки, выводим форму -->
    <?php if (!isset($_POST['create']) && !isset($_POST['upload'])): 
	?>                                                                                
        <form id="load-json" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Загрузите файл с тестом (в текстовом формате JSON)</legend>
                <input name="testfile" type="file" id="uploadfile" required>
                <input type="submit" id="submit-upload" name="upload" value="Загрузить">
            </fieldset>
        </form>
        <div>
            <fieldset>                                        
                <a href="list.php">ПОСМОТРЕТЬ ТЕСТЫ &raquo;</a>
            </fieldset>
        </div>
    <?php endif; 
	?>
  </body>
</html>
