<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Main</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
<div class="container">
<?php
    $path = $_SERVER["DOCUMENT_ROOT"];
    include($path."/_index_header.php");
    include($path."/config/connection_to_db.php");

global $pdo;
// Prepare and execute the SELECT query
$stmt = $pdo->prepare('SELECT id, name, image, description FROM products');
$stmt->execute();

// Fetch all rows as an associative array
$result = $stmt->fetchAll();

?>


</div>
    <?php echo "<h1 class='text-center'>Товари</h1>"?>
<a href="/create.php" class="btn btn-success">Додати</a>
<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Фото</th>
        <th scope="col">Назва</th>
        <th scope="col">Опис</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($result as $item) {
        ?>
        <tr>
            <th scope="row"><?php echo $item["id"]; ?></th>
            <td>
                <img src="/images/<?php echo $item["image"]; ?>" alt="Клавіатура" width="100" height="100">
            </td>
            <td><?php echo $item["name"]; ?></td>
            <td><?php echo $item["description"]; ?></td>
            <td>
                <a href="#" class="btn btn-info">Редагувати</a>
                <a href="#" class="btn btn-danger">Видалить</a>
            </td>
        </tr>

        <?php
    }
    ?>
    </tbody>
</table>

<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
