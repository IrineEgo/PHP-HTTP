<?php 
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

    $allTests = glob('tests/*.json');   
    if (isset($_GET['number']) === false || $_GET['number'] == '' || $_GET['number'] > count($allTests)-1) {
        header('Location: list.php');
        exit;
    }
		
    // Если не существует теста с номером из get-запроса, то выдавать 404 ошибку
    if (empty(glob('tests/*.json')[$_GET['number']])) {
	    http_response_code(404);
        echo 'Cтраница не найдена!';
        exit;
        //header($_SERVER['SERVER_PROTOCOL'] . '404 Not Found');
        //exit;
    } 
	
    // Получаем файл с номером из GET-запроса
    $allTests = glob('tests/*.json');
    $number = $_GET['number'];
	$test = file_get_contents($allTests[$number]);
    $test = json_decode($test, true);
    
    /////////////////////   
    $answers = []; 
    if(isset($_POST['answers']))
        $answers = $_POST['answers'];
   
    $correct_answers = 0;
	
    if (isset($_POST['check-test'])) {
        $username = str_replace(' ', '', $_POST['username']);
        $date = date("d-m-Y H:i");
		//$correct_answers = answersCounter($test)['correct'];
        $variables = [
            'username' => $username,
            'date' => $date,
			//'$correct_answers' => $correct_answers

        ];
    }
	
    if (isset($_POST['generate-picture'])) {
        include_once 'create-picture.php';
    }    
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>ТЕСТ</title>
    <style type="text/css">
        .green { color:green; }
        .red { color:red; }
    </style>
  </head>
  <body>   
	<a href="<?php echo isset($_POST['check-test']) ? $_SERVER['HTTP_REFERER'] : 'list.php' ?>"><div>&laquo; НАЗАД</div></a><br>
	
        <?php if(count($answers) < 3):?>
            Должны быть решены все задания!            
        <?php endif?>    
    
        <form method="POST">           
            <h1><?php echo $test['name'] ?></h1>
			    <label>Введите ваше имя: <input type="text" name="username" required></label><br><br>
            <?php foreach($test['questions'] as $qkey => $item):  ?>          
            <fieldset>
                <legend><?php echo $item['question'] ?></legend>              
                <?php foreach($item['answers'] as $value => $answer): ?>
                    <label>
                        <input type="radio" name="answers[<?=$qkey?>]" value="<?=$value?>" required <?php if(isset($answers[$qkey]) && $value == $answers[$qkey]):?> checked <?php endif;?>>
                        <?php echo $answer ?>
                    </label><br>              
                <?php endforeach; ?>

                <?php if(isset($answers[$qkey])): ?>
                <?php if($item['correct_answer'] == $answers[$qkey]) $correct_answers++; ?>    
                
                <p class="<?php if($item['correct_answer'] == $answers[$qkey]):?>green<?php else:?>red<?php endif?>">
                    Правильный ответ: <i><?=$item['answers'][$item['correct_answer']]?></i>
                </p>
                
                <?php endif?>  
				
            </fieldset>
            
            <?php endforeach; ?>
            <br>
            <br>
            <input type="submit" name="check-test" value="Результат">
        </form>
    

    <!-- Проверка результатов теста -->
    <div>
        <?php if (isset($_POST['check-test'])): ?>
        <br><h4>Всего правильных ответов: <?=$correct_answers?></h4>
		<h2>Вы можете сгенерировать сертификат, <?php echo $username ?>  &darr; </h2>
        <form method="POST">
            <input type="submit" name="generate-picture" value="Сгенерировать">
            <?php foreach ($variables as $key => $variable): ?>
                <input type="hidden" value="<?php echo $variable ?>" name="<?php echo $key ?>">
            <?php endforeach; ?>
        </form>
        <?php endif;?>
    </div>
	<br><br>
  </body>
</html>
