<?php
$servername = "localhost";
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "eco_store";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for adding products
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    $sql = "INSERT INTO products (title, description, price, image) VALUES ('$title', '$description', '$price', '$image')";
    $conn->query($sql);
}

// Handle product deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM products WHERE id=$id";
    $conn->query($sql);
}

// Fetch products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Admin Panel</h1>

    <h2>Add Product</h2>
    <form method="POST" action="admin.php">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" name="price" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="image">Image URL</label>
            <input type="text" class="form-control" name="image" required>
        </div>
        <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
    </form>

    <h2 class="mt-5">Products</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td>$<?php echo $row['price']; ?></td>
                    <td><img src="<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>" style="width: 50px;"></td>
                    <td><a href="admin.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php
$conn->close();
?>
