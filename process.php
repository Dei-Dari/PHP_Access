<?php
//https://www.php.net/manual/ru/function.filter-input.php
//https://www.php.net/manual/ru/function.filter-var.php
//https://www.php.net/manual/ru/filter.constants.php#constant.filter-sanitize-url
//https://www.php.net/manual/ru/filter.constants.php#constant.filter-validate-url
//https://www.php.net/manual/ru/function.file-get-contents.php
//https://www.php.net/manual/ru/domdocument.loadhtml.php
//https://www.php.net/manual/ru/domdocument.savehtml.php
//https://www.php.net/manual/ru/function.strip-tags.php
//https://www.php.net/manual/ru/function.uniqid.php
//URL: http://example.com

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);    //получение url из формы с фильтрацией

    // проверка на соотвествие стандарта url
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        $htmlContent = @file_get_contents($url);

        if ($htmlContent != false) {
            $dom = new DOMDocument();
            @$dom->loadHTML($htmlContent);  //загрузка HTML из строки
            $body = $dom->getElementsByTagName('body')->item(0);

            if ($body) {
                $textContent = $dom->saveHTML($body);
                $textContent = strip_tags($textContent);    //удаление тегов html

                $datadir = __DIR__ . '/data/';
                if (!$datadir)
                    echo 'Отсутствует папка для сохранения файлов';

                $filename = $datadir . uniqid() . '.txt';    //файл с уникальным именем (на основе времени)

                if (file_put_contents($filename, $textContent) !== false) {
                    echo "Содержимое успешно сохранено в файл: $filename<br>";
                } else {
                    echo "Ошибка при записи файла: $filename<br>";
                    echo "Error: " . error_get_last()['message'] . "<br>";
                }

            } else {
                echo "Тег <body> на странице не найден.";
            }
        } else {
            echo "Не удалось получить содержимое страницы.<br>";
            if (isset($http_response_header)) {
                echo "HTTP Response Headers:<br>";
                foreach ($http_response_header as $header) {
                    echo $header . "<br>";
                }
            }
        }
    } else {
        echo "Неверный URL.";
    }
}

//Ссылка на главную страницу
echo "<br><a href='index.php'>Вернуться на главную страницу</a>";
?>