<!DOCTYPE html>
<html>
<head>
    <title>Тест</title>
</head>
<body>
<h1>Тесты</h1>
<?php
	$tests_file = file_get_contents('tests.json');
	$json = json_decode($tests_file, true); // из файла json получаем структуры php
	foreach ($json as $index => $test) {
		echo "<p><a href='test.php?test={$index}'>{$test['test_name']}</a></p>";
	}
?>
</body>
</html>