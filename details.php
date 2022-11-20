<?php
include('config/db_connect.php');

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($connection, $_GET['id']);
    $sql = "SELECT * FROM books WHERE id='$id'";
    $result = mysqli_query($connection, $sql);
    $book = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
}

include('config/db_disconnect.php');
?>


<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php') ?>
<section class="container-fluid text-center">
    <?php if ($book) :
        echo "<h4>" . htmlspecialchars($book['book_title']) . "</h4>";
        echo "<p>" . htmlspecialchars($book['book_author']) . "</p>";
        echo "<h4>" . htmlspecialchars(date($book['date_created'])) . "</h4>";
    endif ?>
</section>
<?php include('templates/footer.php') ?>

</html>