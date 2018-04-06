<!DOCTYPE html>
<html>
<head>
    <title>Прохождение теста</title>
</head>
<body>
<?php
	$tests_file = file_get_contents('tests.json');						
	$json = json_decode($tests_file, true); // из файла json получаем структуры php
	$test_num = $_GET['test'];
	if (empty($json[$test_num])) {
		header('HTTP/1.0 404 Not Found');
		echo '<p>Некорректное значение параметра test.<p>';
	} else {
		$test = $json[$test_num];
		echo "<h1>{$test['test_name']}</h1>";
		
		if (empty($_POST['a'])) {
			echo "<form method='post' action='test.php?test={$test_num}'>";
			echo "<p>Ваше имя:<br><input type='text' name='name' size=30></p>";
			
			foreach ($test['questions'] as $qi => $q) {
				echo "<div><p>{$q['q']}</p>";
				foreach ($q['answers'] as $ai => $a) {
					echo "<p><label for='a_{$qi}_{$ai}'>";
					echo "<input type='checkbox' name='a[$qi][$ai]' id='a_{$qi}_{$ai}'> {$a['a']}";
					echo "</label></p>";
				}
			}
			echo "<input type='submit' value='Отправить'>";
			echo "</form>";
		} else {
			$user_answers = $_POST['a'];
			$results = []; // [$qi => valid || not valid, ...]
			// echo "<pre>"; print_r($user_answers); echo "</pre>";
			
			// получить правильные варианты ответов
			$valid = function($item) { return $item['correct']; };
			
			foreach ($test['questions'] as $qi => $q) {
				$ans = array_filter($q['answers'], $valid);
				// echo "<p>"; var_dump($ans); echo "</p>";
				// index правильного варианта
				$valid_indices = array_keys($ans);
				if (empty($user_answers[$qi]))
					$user_indices = [];
				else
					$user_indices = array_keys($user_answers[$qi]);
				$intersect = array_intersect($valid_indices, $user_indices);
				
				$ci = count($intersect);
				$results[$qi] = ($ci == count($valid_indices) && $ci == count($user_indices));
			}
			
			$all_results = count($results);
			$valid = count(array_filter($results));
			$name = urlencode ($_POST['name']);
			echo "<p>Всего вопросов: ", $all_results, "</p>";
			echo "<p>Правильных ответов: ", $valid, "</p>";
			echo "<img src='png.php?name={$name}&all={$all_results}&valid={$valid}'>";
		}
	}
?>
</body>
</html>