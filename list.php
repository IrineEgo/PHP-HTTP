<?php
    $allFiles = glob('tests/*.json');
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>Список тестов</title>
  </head>
  <body>
    <a href="admin.php"><div>&laquo; НАЗАД</div></a>
    <hr>
    <h2>Список тестов:</h2>
    <?php if (!empty($allFiles)): 
	?>
        <?php foreach ($allFiles as $file): 
		?>
            <?php
                $file_data = json_decode(file_get_contents($file));
            ?>
            <div>
                <h3><?=$file_data->name?></h3>
                <a href="test.php?number=<?php echo array_search($file, $allFiles); ?>">ПРОЙТИ ТЕСТ &raquo;</a>
            </div>
            <hr>
        <?php endforeach; 
		?>
        <?php endif; 
		?>
    <?php if (empty($allFiles)) echo 'Нет ни одного теста!';
	?>	
  </body>
</html>
