<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

header('Content-type: image/png');
$username = $_POST['username'];
$date = $_POST['date'];
//$correct_answers = $_POST['correct_answers'];
//$answers = $_POST['answers'];
//$correct = $correct_answers . ' из ' . $answers;
// Создаем картинку и цвет шрифта
$img = imagecreatefromjpeg('img/picture.jpg');
$fontColor = imagecolorallocate($img, 035, 035, 035);
// Определяем положение имени пользователя (по центру)
$imageWidth = getimagesize('img/picture.jpg');
$imageWidth = $imageWidth[0];
$textPoints = imagettfbbox(300, 0, 'fonts/OpenSans.ttf', $username);
$textWidth = $textPoints[2] - $textPoints[0];
$x = ($imageWidth - $textWidth) / 2;
// Распологаем все данные на картинке
imagettftext($img, 300, 0, $x, 1000, $fontColor, 'fonts/OpenSans.ttf', $username);
imagettftext($img, 200, 0, 900, 1625, $fontColor, 'fonts/OpenSans.ttf', $test['name']);
imagettftext($img, 180, 0, 1600, 1976, $fontColor, 'fonts/OpenSans.ttf', $correct_answers);
imagettftext($img, 150, 0, 1600, 2325, $fontColor, 'fonts/OpenSans.ttf', $date);
imagepng($img);
imagedestroy($img);
?>
