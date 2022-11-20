<?php
include('config/db_connect.php');

$author = $title = '';
$errors = array('title' => '', 'author' => '');
if (isset($_POST['submit'])) {
    if (empty($_POST['title'])) {
        $errors['title'] =  "A title is required<br>";
    } else {
        $title = htmlspecialchars($_POST['title']);
    }
    if (empty($_POST['author'])) {
        $errors['author'] =  "An author is required<br>";
    } else {
        $author = htmlspecialchars($_POST['author']);
    }

    $filename = $_FILES["cover"]["name"];
    $tempname = $_FILES["cover"]["tmp_name"];
    $folder = "./covers/" . $filename;

    if (move_uploaded_file($tempname, $folder)) {
        echo "<h3>  Image uploaded successfully!</h3>";
    } else {
        echo "<h3>  Failed to upload image!</h3>";
    }

    if (array_filter($errors)) {
        echo 'errors in the form';
    } else {
        // form is valid, send the data to the database
        $author = mysqli_real_escape_string($connection, $_POST['author']);
        $title = mysqli_real_escape_string($connection, $_POST['title']);

        $sql = "INSERT INTO books (book_title, book_author, filename) VALUES('$title', '$author', '$filename')";
        if (mysqli_query($connection, $sql)) {
            header('Location: index.php'); // change the page to the index
        } else {
            echo "Query error: " . mysqli_error($connection);
        }
    }


}
include('config/db_disconnect.php');
?>

<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php'); ?>
<section class="container-fluid bg-light container-sm">
    <form class="bg-white p-4" action="" method="post" enctype="multipart/form-data" >
        <h4 class="text-center bg-light shadow-lg mb-5 p-3 rounded-lg border border-bottom-0">Add a book<h4>
                <div class="form-group">
                    <label class="mr-sm-2">Book title: </label>
                    <input class="form-control mb-2 mr-sm-2" type="text" name="title" value="<?php echo $title ?>">
                    <div class="text-danger d-block small">
                        <?php
                        echo $errors['title'];
                        ?>
                    </div>
                </div>
                <div class="form-froup">
                    <label class="mr-sm-2">Author of the book: </label>
                    <input class="form-control mb-2 mr-sm-2" type="text" name="author" value="<?php echo $author ?>">
                    <div class="text-danger d-block small">
                        <?php
                        echo $errors['author'];
                        ?>
                    </div>
                <div class="form-group">
                <label class="mr-sm-2">Book cover: </label>
                    <input class="form-control mb-2 mr-sm-2" type="file" name="cover" value=" " accept="image/*" id="cover">
                    <div class="text-danger d-block small">
                    </div>
                </div>
                </div>
                <div class="col text-center">
                    <button type="submit" name='submit' value="submit" class="btn btn-primary">Submit</button>
                </div>
    </form>
</section>
<?php include('templates/footer.php'); ?>