<?php

include 'views/layouts/header.php';
?>

<h1>Add New User</h1>

<?php if (isset($error)): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST">
    <div>
        <label>Name:</label>
        <input type="text" name="name" required>
    </div>
    <div>
        <label>Email:</label>
        <input type="email" name="email" required>
    </div>
    <div>
        <button type="submit" class="btn">Create User</button>
        <a href="/user">Cancel</a>
    </div>
</form>

<?php include 'views/layouts/footer.php'; ?>
