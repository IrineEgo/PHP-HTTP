<?php
    $allFiles = glob('tests/*.json');
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>Список тестов</title>
    <style type="text/css">
      h1 {
        text-align: center;
      }	  
      a {
        color: navy;
        text-decoration: none;
       }
       .file-block {
	  margin: 40px auto 20px;
	  width: 40%;
	  border-bottom: 1px solid navy;
        }
      </style> 	
  </head>
  <body>
    <a href="admin.php"><b>&laquo; НАЗАД</b></a><br><br>

    <h1>Список тестов:</h1>
    <?php if (!empty($allFiles)): ?>
        <?php foreach ($allFiles as $file): ?>
            <div class="file-block">
                <h3><?php echo str_replace('tests/', '', $file); ?></h3>
                <a href="test.php?number=<?php echo array_search($file, $allFiles); ?>">ПРОЙТИ ТЕСТ &raquo;</a><br><br>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>
    <?php if (empty($allFiles)) echo 'Нет ни одного теста!';?>	
  </body>
</html>
