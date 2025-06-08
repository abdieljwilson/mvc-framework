<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'MVC Framework' ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        nav { background: #333; padding: 10px; margin-bottom: 20px; }
        nav a { color: white; text-decoration: none; margin-right: 15px; }
        nav a:hover { text-decoration: underline; }
        .container { max-width: 800px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 8px 16px; background: #007cba; color: white; text-decoration: none; border-radius: 4px; }
        .btn:hover { background: #005a87; }
        form { margin: 20px 0; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0; box-sizing: border-box; }
    </style>
</head>
<body>
    <nav>
        <a href="/">Home</a>
        <a href="/home/about">About</a>
        <a href="/user">Users</a>
        <a href="/user/create">Add User</a>
    </nav>
    <div class="container">

<?php
// File: views/layouts/footer.php
?>
    </div>
</body>
</html>
