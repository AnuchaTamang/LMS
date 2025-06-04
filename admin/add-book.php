<?php
session_start();
include('admin_session_check.php');
include('../connection.php');
$name = $_SESSION['name'];
$id = $_SESSION['id'];
if (empty($id)) {
    header("Location: index.php");
}
if (isset($_REQUEST['sbt-book-btn'])) {
    $book_name = trim($_POST['book_name']);
    $category_name = $_POST['category_name'];
    $isbn = $_POST['isbn'];
    $author_name = $_POST['author_name'];
    $publisher_name = $_POST['publisher_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $availability = $_POST['availability'];

    // similarity check
    $threshold = 80;
    $isDuplicate = false;
    $similarTitle = '';

    $fetch_books = mysqli_query($conn, "SELECT book_name FROM tbl_book");
    while ($row = mysqli_fetch_assoc($fetch_books)) {
        $existingTitle = $row['book_name'];
        similar_text(strtolower($book_name), strtolower($existingTitle), $percent);

        if ($percent >= $threshold) {
            $isDuplicate = true;
            $similarTitle = $existingTitle;
            break;
        }
    }

    if ($isDuplicate) {
        echo "<script>alert('Book NOT added. The title \"$book_name\" is $percent% similar to \"$similarTitle\".');</script>";
    } else {
        // Step 2: Insert book
        $insert_book = mysqli_query($conn, "INSERT INTO tbl_book 
            SET book_name='$book_name', category='$category_name', isbnno='$isbn', 
                author='$author_name', publisher='$publisher_name', price='$price', 
                quantity='$quantity', availability='$availability'");

        if ($insert_book) {
            echo "<script>alert('Book added successfully.');</script>";
        } else {
            echo "<script>alert('Failed to add book.');</script>";
        }
    }
}

?>
<?php include('include/header.php'); ?>
<div id="wrapper">
    <?php include('include/side-bar.php'); ?>

    <div id="content-wrapper">

        <div class="container-fluid">

            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Add Book</a>
                </li>

            </ol>

            <div class="card mb-3">

                <form method="post" class="form-valide">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="item">Book Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" name="book_name" id="book_name" class="form-control"
                                    placeholder="Enter Book Name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="leave-type">Category <span
                                    class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                <select class="form-control" id="category_name" name="category_name" required>
                                    <option value="">Select Category</option>
                                    <?php
                                    $fetch_category = mysqli_query($conn, "select * from tbl_category where status=1");
                                    while ($row = mysqli_fetch_array($fetch_category)) {
                                        ?>
                                        <option><?php echo $row['category_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="price">Book No <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" name="isbn" id="isbn" class="form-control"
                                    placeholder="Enter book number" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="price">Author <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" name="author_name" id="author_name" class="form-control"
                                    placeholder="Enter Author Name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="price">Publisher <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" name="publisher_name" id="publisher_name" class="form-control"
                                    placeholder="Enter Publisher Name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="price">Price <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" name="price" id="price" class="form-control"
                                    placeholder="Enter Price" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="price">Quantity <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" name="quantity" id="quantity" class="form-control"
                                    placeholder="Enter Quantity" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="status">Availability <span
                                    class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                <select class="form-control" id="availability" name="availability" required>
                                    <option value="">Select Status</option>
                                    <option value="1">Available</option>
                                    <option value="0">Not Available</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-8 ml-auto">
                                <button type="submit" name="sbt-book-btn" class="btn btn-primary">Submit</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>

    </div>

    <!-- <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  -->
    <?php include('include/footer.php'); ?>