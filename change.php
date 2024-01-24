<?php
$index_product = $_GET['index_data'];
echo ("$index_product");
include($_SERVER["DOCUMENT_ROOT"] . "/config/connection_to_db.php");
global $pdo;
// Prepare and execute the SELECT query
$stmt = $pdo->prepare("SELECT id, name, image, description FROM products WHERE id = $index_product");
$stmt->execute();

// Fetch all rows as an associative array
$result = $stmt->fetch();

if($_SERVER["REQUEST_METHOD"]=="POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];

    $image_name="";
    if(count(array_filter($_POST))!=count($_POST)){
        echo "Something is empty";
    }
    else{
        echo($_FILES["image"]);
        sleep(4);
        echo($result["image"]);
        sleep(4);
        if ($_FILES["image"]!=$result["image"]) {
            $image_name = uniqid() . ".jpg";
            $save_image = $_SERVER["DOCUMENT_ROOT"] . "/images/" . $image_name;
            move_uploaded_file($_FILES["image"]["tmp_name"], $save_image); //зберігаємо фото на сервер
        }
        else{
            $image_name=$result["image"];
        }
        include($_SERVER["DOCUMENT_ROOT"] . "/config/connection_to_db.php");
        global $pdo;
        $sql = "UPDATE products SET name = '$name', image = '$image_name', description = '$description' WHERE id = $index_product";

        $command = $pdo->prepare($sql);
        $command->execute();
        header("Location: /");
        exit;
    }


}

?>

<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Головна</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
<div class="container">

    <?php echo "<h1 class='text-center'>Редагувати</h1>" ?>

    <form class="offset-md-3 col-md-6" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Назва</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $result["name"]; ?>">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Фото</label>
            <div style="display: flex; flex-direction: row">
                <a id="imgBtn" onclick="imgBtnClick()"  style="margin-right: 3vw; width:100px; height:100px;"><img id="img_preview" src="/images/<?php echo $result["image"]; ?>" width="100px" height="100px"></a>
                <input type="file" class="form-control" id="imageInput" name="image" onchange="readURL(this)">
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Опис</label>
            <textarea class="form-control" rows="5" id="description" name="description" ><?php echo $result["description"]; ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Додати</button>
    </form>

</div>
<script src="/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img_preview').attr('src', e.target.result).width(100).height(100);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function imgBtnClick(){
        $('#imageInput').click();
    }

</script>
</body>
</html>