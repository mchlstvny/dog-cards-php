<?php
require 'dbconnect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Dog ID missing or invalid.");
}

$id = (int) $_GET['id'];

try {
    $stmt = $conn->prepare("SELECT * FROM dogs WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $dog = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$dog) {
        die("Dog not found.");
    }
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = $_POST['name'];
    $age   = $_POST['age'];
    $breed = $_POST['breed'];
    $color = $_POST['color'];
    $weight = $_POST['weight'];

    $image = $dog['image']; // keep old image by default
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target = "img/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    try {
        $stmt = $conn->prepare("UPDATE dogs 
                                SET name=:name, age=:age, breed=:breed, color=:color, weight=:weight, image=:image 
                                WHERE id=:id");
        $stmt->execute([
            ':name'  => $name,
            ':age'   => $age,
            ':breed' => $breed,
            ':color' => $color,
            ':weight'=> $weight,
            ':image' => $image,
            ':id'    => $id
        ]);
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Update failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Dog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-yellow-50 via-amber-100 to-orange-50 font-sans">
    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md border border-amber-200">
        <h1 class="text-3xl font-bold text-amber-700 mb-6 text-center">Edit Dog 🐾</h1>
        
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block text-left font-medium text-amber-900">Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($dog['name']); ?>" required
                    class="w-full px-4 py-2 border-2 border-amber-400 rounded-lg focus:ring-2 focus:ring-amber-600 focus:outline-none bg-amber-50">
            </div>
            
            <div>
                <label class="block text-left font-medium text-amber-900">Age</label>
                <input type="number" name="age" value="<?= htmlspecialchars($dog['age']); ?>" required
                    class="w-full px-4 py-2 border-2 border-amber-400 rounded-lg focus:ring-2 focus:ring-amber-600 focus:outline-none bg-amber-50">
            </div>

            <div>
                <label class="block text-left font-medium text-amber-900">Breed</label>
                <input type="text" name="breed" value="<?= htmlspecialchars($dog['breed']); ?>" required
                    class="w-full px-4 py-2 border-2 border-amber-400 rounded-lg focus:ring-2 focus:ring-amber-600 focus:outline-none bg-amber-50">
            </div>

            <div>
                <label class="block text-left font-medium text-amber-900">Color</label>
                <input type="text" name="color" value="<?= htmlspecialchars($dog['color']); ?>" required
                    class="w-full px-4 py-2 border-2 border-amber-400 rounded-lg focus:ring-2 focus:ring-amber-600 focus:outline-none bg-amber-50">
            </div>

            <div>
                <label class="block text-left font-medium text-amber-900">Weight</label>
                <input type="number" step="0.01" name="weight" value="<?= htmlspecialchars($dog['weight']); ?>" required
                    class="w-full px-4 py-2 border-2 border-amber-400 rounded-lg focus:ring-2 focus:ring-amber-600 focus:outline-none bg-amber-50">
            </div>

            <div>
                <label class="block text-left font-medium text-amber-900">Image</label>
                <input type="file" name="image"
                    class="w-full px-4 py-2 border-2 border-amber-400 rounded-lg focus:ring-2 focus:ring-amber-600 focus:outline-none bg-amber-50">
                <small class="text-gray-600 text-sm">Current image: <?= htmlspecialchars($dog['image']); ?></small>
            </div>

            <button type="submit"
                class="w-full py-3 rounded-lg font-bold text-white bg-gradient-to-r from-amber-600 to-yellow-700 hover:scale-105 transform transition">
                Save Changes
            </button>
        </form>

        <a href="index.php" 
            class="block mt-6 text-center text-amber-700 font-semibold hover:text-yellow-800 transition">
            Back to Home
        </a>
    </div>
</body>
</html>
