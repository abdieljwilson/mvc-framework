<?php
// File: views/users/index.php
include 'views/layouts/header.php';
?>

<h1>Users</h1>
<a href="/user/create" class="btn">Add New User</a>

<?php if (!empty($users)): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td>
                        <a href="/user/show/<?= $user['id'] ?>">View</a> |
                        <a href="/user/edit/<?= $user['id'] ?>">Edit</a> |
                        <a href="/user/delete/<?= $user['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No users found.</p>
<?php endif; ?>

<?php include 'views/layouts/footer.php'; ?>
