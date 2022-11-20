<?php
include('config/db_connect.php');

if (isset($_POST['delete'])) {
    $id_to_delete = mysqli_real_escape_string($connection, $_POST['delete']);
    echo $id_to_delete;
    $sql = "DELETE FROM books WHERE id='$id_to_delete'";
    if (mysqli_query($connection, $sql)) {
        header('Location: index.php'); // change the page to the index
    } else {
        echo 'Query error:' . mysqli_error(($connection));
    }
}
// write query for all books
$sql = 'SELECT * FROM books ORDER BY date_created';
// make query & get results
$result = mysqli_query($connection, $sql);
//fetch the resulting rows as an array
$books = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);
include('config/db_disconnect.php');
?>

<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php') ?>
<div class="container-fluid">
    <h4 class="text-center text-important">Books</h4>
    <div class="card-group justify-content-around">
        <div class="row">
            <?php
            foreach ($books as $book) : ?>
                <div class="col d-flex">
                    <div class="card d-flex align-items-center" style="width: 18rem">
                        <img class="card-img-top" src=<?php echo "./covers/" . $book['filename']; ?> alt="Book cover" style="width:100%; height:250px; object-fit: cover">
                        <div class="card-body d-flex flex-column text-center justify-content-between">
                            <h6 class="card-title"><?php echo htmlspecialchars($book['book_title']); ?></h6>
                            <p class="card-text"><?php echo htmlspecialchars($book['book_author']); ?></p>
                            <div class="card-footer secondary-card align-self-end">
                                <div class="d-flex justify-content-between align-items-center">
                                    <form action="" method="post"><button type="submit" class="btn btn-default" value="<?php echo $book['id']; ?>" name="delete">Remove book</button></form>
                                    <a href="details.php?id=<?php echo $book['id']; ?> class=" brand-text">More info...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="row">
    <p class="mx-auto mt-4 emphasis"><?php echo "There are " . count($books) . " books in the database" ?></p>
</div>
</div>
<?php include('templates/footer.php') ?>

</html>