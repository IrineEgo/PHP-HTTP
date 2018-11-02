<?php 
    $allTests = glob('tests/*.json');   
    if (!isset($_GET['number'])) {
        header('Location: list.php');
            exit;
    }
		
    if (!isset(glob('tests/*.json')[$_GET['number']])) {
	    http_response_code(404);
            echo 'Cтраница не найдена!';
                exit;
    } 
	
    $allTests = glob('tests/*.json');
    $number = $_GET['number'];
	$test = file_get_contents($allTests[$number]);
    $test = json_decode($test, true);
	
    //Проверка теста и вывод результата
    function checkTest($testFile)
    {
        foreach ($testFile as $key => $item) {
            if (!isset($_POST['answer' . $key])) {
                echo 'Должны быть решены все задания! ';
                exit;
            }
        }
        foreach ($testFile as $key => $item) {
            if ($item['correct_answer'] === $_POST['answer' . $key]) {
                $infoStyle = 'correct';
            } else {
                $infoStyle = 'incorrect';
        }
            echo '<div class=' . $infoStyle . '>' .
                'Вопрос: ' . $item['question'] . '<br>' .
                'Ваш ответ: ' . $item['answers'][$_POST['answer' . $key]] . '<br>' .
                'Правильный ответ: ' . $item['answers'][$item['correct_answer']] . '<br>' .
                '</div>' .
                '<hr>';
        }
    }
    //////////////////
    function answersCounter($testFile)
    {
        $i = 0;
        $questions = 0;
        foreach ($testFile as $key => $item) {
            $questions++;
            if ($item['correct_answer'] === $_POST['answer' . $key]) {
                $i++;
            }
        }
        return ['correct' => $i, 'total' => $questions];
    }
        if (isset($_POST['check-test'])) {
            $testname = basename($allTests[$number]);
            $username = str_replace(' ', '', $_POST['username']);
            $date = date("d-m-Y H:i");
            $correctAnswers = answersCounter($test)['correct'];
            $totalAnswers = answersCounter($test)['total'];
            $variables = [
                'testname' => $testname,
                'username' => $username,
                'date' => $date,
                'correctAnswers' => $correctAnswers,
                'totalAnswers' => $totalAnswers
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
	h1, h2 {
	  text-align: center;
	  color: navy;
	}
	a {
          color: navy;
          text-decoration: none;
        }
	.result {
	  margin: 40px auto 20px;
	  width: 40%;
        }
	.correct {
          background-color: palegreen;
          padding: 20px;
        }
        .incorrect {
          background-color: pink;
          padding: 20px;
        }
        #hidden-radio {
          position: absolute;
          left: 10%;
          top: 30%;
          opacity: 0;
        }	
      </style> 
  </head>
  <body>   
	<a href="<?php echo isset($_POST['check-test']) ? $_SERVER['HTTP_REFERER'] : 'list.php' ?>"><b>&laquo; НАЗАД</b></a><br>
    <div class="result">	
    <?php if (!isset($_POST['check-test'])): ?>
        <form method="POST">
            <h1><?php echo basename($allTests[$number]); ?></h1>
            <label>Введите ваше имя: <input type="text" name="username" required></label><br><br>
            <?php foreach ($test as $key => $item): ?>
                <fieldset>
                <div class="on-hidden-radio"></div>
                    <input type="radio" name="answer<?php echo $key ?>" id="hidden-radio" required>
                    <legend><?php echo $item['question'] ?></legend>
                    <label><input type="radio" name="answer<?php echo $key ?>" value="0"><?php echo $item['answers'][0] ?>
                    </label><br>
                    <label><input type="radio" name="answer<?php echo $key ?>" value="1"><?php echo $item['answers'][1] ?>
                    </label><br>
                    <label><input type="radio" name="answer<?php echo $key ?>" value="2"><?php echo $item['answers'][2] ?>
                    </label><br>
                    <label><input type="radio" name="answer<?php echo $key ?>" value="3"><?php echo $item['answers'][3] ?>
                    </label>
                </fieldset>
                <?php endforeach; ?>
                <br><input type="submit" name="check-test" value="Результат">
        </form>
    <?php endif; ?>
	
    <?php if (isset($_POST['check-test'])): ?>
    <div class="check-test">
        <?php checkTest($test) ?>
        <h4>Всего правильных ответов: <?php echo "$correctAnswers из $totalAnswers" ?></h4>
        <h2>Вы можете сгенерировать сертификат, <i><?php echo $username ?><i>  &darr; </h2>
        <form method="POST">
            <input type="submit" name="generate-picture" value="Сгенерировать">
            <?php foreach ($variables as $key => $variable): ?>
                <input type="hidden" value="<?php echo $variable ?>" name="<?php echo $key ?>">
            <?php endforeach; ?>
        </form>
      </div>
     <?php endif; ?>	
    </div>
  </body>
</html>


