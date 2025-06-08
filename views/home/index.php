<?php
// File: views/home/index.php
require_once 'views/layouts/header.php';
?>

<h1><?= isset($title) ? htmlspecialchars($title) : 'Welcome' ?></h1>

<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 10px; margin-bottom: 30px;">
    <h2 style="color: white; margin-bottom: 10px;"> Welcome to my MVC Framework!</h2>
    <p>This is a custom-built PHP MVC framework. Navigate through the menu to explore the features.</p>
</div>

<h2>👥 Recent Users</h2>
<?php if (!empty($users)): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td>
                        <span style="background: <?= $user['status'] === 'active' ? '#27ae60' : '#e74c3c' ?>; color: white; padding: 4px 8px; border-radius: 12px; font-size: 12px;">
                            <?= htmlspecialchars($user['status']) ?>
                        </span>
                    </td>
                    <td><?= isset($user['created_at']) ? date('M d, Y', strtotime($user['created_at'])) : 'N/A' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div style="margin-top: 20px;">
        <a href="/user" class="btn">View All Users</a>
        <a href="/user/create" class="btn">Add New User</a>
    </div>
<?php else: ?>
    <div class="empty-state">
        <h3>No Users Found</h3>
        <p>Get started by adding your first user!</p>
        <a href="/user/create" class="btn">Add First User</a>
    </div>
<?php endif; ?>

<?php require_once 'views/layouts/footer.php'; ?>
