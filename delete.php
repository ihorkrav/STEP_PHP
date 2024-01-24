
<?php
include($_SERVER["DOCUMENT_ROOT"]."/config/connection_to_db.php");
$delete_id = $_GET['delete_id'];
if ($delete_id!=0) {
    echo("<script>console.log('$delete_id')</script>");
    global $pdo;
// SQL query to delete the element from the database
    $sql = "DELETE FROM products WHERE id = $delete_id";
    $command=$pdo->prepare($sql);
    $command->execute();
    header("Location: /");
    exit;
}
else{
    echo("<script>console.log('fail')</script>");
}
?>
