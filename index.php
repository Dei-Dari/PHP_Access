<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Получить содержимое страницы</title>
</head>
<body>
    <h1>Получить содержимое страницы</h1>
    <form action="process.php" method="post">
        <label for="url">URL сайта:</label>
        <input type="text" id="url" name="url" required>
        <button type="submit">Получить</button>
    </form>
</body>
</html>