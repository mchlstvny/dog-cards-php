<?php
require 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = $_POST['name'];
    $age   = $_POST['age'];
    $breed = $_POST['breed'];
    $color = $_POST['color'];
    $weight = $_POST['weight'];

    $image = $_FILES['image']['name'];
    $target = "img/" . basename($image);

    try {
        $stmt = $conn->prepare("INSERT INTO dogs (name, age, breed, color, weight, image) 
                                VALUES (:name, :age, :breed, :color, :weight, :image)");
        $stmt->execute([
            ':name'  => $name,
            ':age'   => $age,
            ':breed' => $breed,
            ':color' => $color,
            ':weight' => $weight,
            ':image' => $image
        ]);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            header("Location: index.php"); // redirect after success
            exit; 
        } else {
            echo "Dog saved, but failed to upload image.";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Dog</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-amber-50 via-orange-100 to-yellow-50 min-h-screen flex items-center justify-center p-6">

  <div class="bg-white shadow-lg rounded-2xl p-8 max-w-lg w-full border border-amber-200">
    <h1 class="text-3xl font-bold text-amber-900 mb-6 text-center">Add a New Dog</h1>

    <form method="POST" enctype="multipart/form-data" class="space-y-5">
      <div>
        <label class="block text-amber-800 font-medium mb-1">Name</label>
        <input type="text" name="name" required 
          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 focus:outline-none border-amber-300">
      </div>

      <div>
        <label class="block text-amber-800 font-medium mb-1">Age</label>
        <input type="number" name="age" required 
          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 focus:outline-none border-amber-300">
      </div>

      <div>
        <label class="block text-amber-800 font-medium mb-1">Breed</label>
        <input type="text" name="breed" required 
          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 focus:outline-none border-amber-300">
      </div>

      <div>
        <label class="block text-amber-800 font-medium mb-1">Color</label>
        <input type="text" name="color" required 
          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 focus:outline-none border-amber-300">
      </div>

      <div>
        <label class="block text-amber-800 font-medium mb-1">Weight (kg)</label>
        <input type="number" step="0.01" name="weight" required 
          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 focus:outline-none border-amber-300">
      </div>

      <div>
        <label class="block text-amber-800 font-medium mb-1">Image</label>
        <input type="file" name="image" required 
          class="w-full px-4 py-2 border rounded-lg focus:outline-none border-amber-300 bg-amber-50">
      </div>

      <button type="submit" 
        class="w-full bg-amber-600 hover:bg-amber-700 text-white font-semibold py-3 rounded-lg transition">
        Add Dog
      </button>
    </form>

    <div class="mt-6 text-center">
      <a href="index.php" class="block mt-6 text-center text-amber-700 font-semibold hover:text-yellow-800 transition">
        Back to Dog List</a>
    </div>
  </div>

</body>
</html>