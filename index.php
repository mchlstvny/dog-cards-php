<?php
require 'dbconnect.php';

// dogs from database
try {
    $stmt = $conn->query("SELECT * FROM dogs");
    $dogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dog List</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-yellow-50 via-amber-100 to-orange-50 py-12 px-6 font-sans">

  <!-- Header + Add Button -->
  <div class="w-full max-w-7xl mx-auto flex justify-between items-center mb-10">
    <h1 class="text-4xl font-extrabold text-amber-700">🐾 Dog List</h1>
    <a href="upload.php" 
       class="flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-amber-600 to-yellow-700 text-white font-semibold rounded-full shadow-lg hover:scale-105 transform transition">
       <i data-feather="plus" class="w-5 h-5"></i>
    </a>
  </div>

  <!-- Dog Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 max-w-7xl mx-auto">
    <?php if ($dogs): ?>
      <?php foreach ($dogs as $dog): ?>
        <div class="bg-white rounded-2xl shadow-lg p-6 text-center border border-amber-200 hover:shadow-2xl transition transform hover:-translate-y-1">
          <!-- Dog Image -->
          <img src="img/<?php echo htmlspecialchars($dog['image']); ?>" 
               alt="<?php echo htmlspecialchars($dog['name']); ?>" 
               class="w-40 h-40 mx-auto object-cover rounded-full border-4 border-amber-400 shadow-md mb-4">
          
          <!-- Dog Info -->
          <h2 class="text-xl font-bold text-amber-800 mb-2"><?php echo htmlspecialchars($dog['name']); ?></h2>
          <p><span class="font-semibold text-amber-900">Age:</span> <?php echo htmlspecialchars($dog['age']); ?></p>
          <p><span class="font-semibold text-amber-900">Breed:</span> <?php echo htmlspecialchars($dog['breed']); ?></p>
          <p><span class="font-semibold text-amber-900">Color:</span> <?php echo htmlspecialchars($dog['color']); ?></p>
          <p><span class="font-semibold text-amber-900">Weight:</span> <?php echo htmlspecialchars($dog['weight']); ?> kg</p>
          
          <!-- Actions -->
          <div class="flex justify-center gap-4 mt-4">
            <a href="edit.php?id=<?php echo $dog['id']; ?>" 
               class="px-4 py-1 bg-yellow-200 hover:bg-yellow-400 text-amber-900 font-semibold rounded-lg shadow transition">
               Edit
            </a>
            <a href="delete.php?id=<?php echo $dog['id']; ?>" 
               onclick="openModal(this.href); return false;" 
               class="px-4 py-1 bg-red-200 hover:bg-red-300 text-red-800 font-semibold rounded-lg shadow transition">
               Delete
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-gray-700">No dogs found in the database.</p>
    <?php endif; ?>
  </div>

  <!-- Delete Confirmation Modal -->
  <div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl p-8 max-w-sm w-full text-center transform scale-95 opacity-0 transition-all duration-300" id="modalContent">
      <h2 class="text-xl font-bold text-amber-800 mb-4">Are you sure?</h2>
      <p class="text-gray-600 mb-6">This action cannot be undone. Do you really want to delete this dog?</p>
      <div class="flex justify-center gap-4">
        <button onclick="closeModal()" 
                class="px-5 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold">
          Cancel
        </button>
        <a id="confirmDeleteBtn" href="#" 
           class="px-5 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white font-semibold shadow">
          Yes, Delete
        </a>
      </div>
    </div>
  </div>

  <script>
    function openModal(deleteUrl) {
      document.getElementById("confirmDeleteBtn").setAttribute("href", deleteUrl);
      const modal = document.getElementById("confirmModal");
      const content = document.getElementById("modalContent");
      modal.classList.remove("hidden");
      setTimeout(() => {
        content.classList.remove("scale-95", "opacity-0");
        content.classList.add("scale-100", "opacity-100");
      }, 10);
    }

    function closeModal() {
      const modal = document.getElementById("confirmModal");
      const content = document.getElementById("modalContent");
      content.classList.remove("scale-100", "opacity-100");
      content.classList.add("scale-95", "opacity-0");
      setTimeout(() => {
        modal.classList.add("hidden");
      }, 200);
    }

    feather.replace();
  </script>
</body>
</html>
