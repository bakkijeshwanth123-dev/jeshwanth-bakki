<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$file = 'projects.json';
$projects = json_decode(file_get_contents($file), true);

if (isset($_POST['add'])) {
    $new_project = [
        'name' => $_POST['name'],
        'image' => $_POST['image'],
        'tech' => explode(',', $_POST['tech']),
        'description' => $_POST['description'],
        'live' => $_POST['live'],
        'github' => $_POST['github']
    ];
    $projects[] = $new_project;
    file_put_contents($file, json_encode($projects, JSON_PRETTY_PRINT));
}

if (isset($_GET['delete'])) {
    $index = $_GET['delete'];
    array_splice($projects, $index, 1);
    file_put_contents($file, json_encode($projects, JSON_PRETTY_PRINT));
    header("Location: admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container { padding: 4rem 10%; }
        .form-card { margin-bottom: 3rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 2rem; }
        th, td { padding: 1rem; border-bottom: 1px solid var(--border); text-align: left; }
    </style>
</head>
<body class="dark-theme">
    <nav>
        <a href="index.html" class="logo">BJ.</a>
        <a href="logout.php" class="btn btn-outline">Logout</a>
    </nav>

    <div class="admin-container">
        <h2 class="section-title">Manage Projects</h2>
        
        <div class="glass-card form-card">
            <h3>Add New Project</h3>
            <form method="POST" class="contact-form" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1.5rem;">
                <input type="text" name="name" placeholder="Project Name" required>
                <input type="text" name="image" placeholder="Image URL (or placeholder)" required>
                <input type="text" name="tech" placeholder="Technologies (comma separated)" required>
                <input type="text" name="live" placeholder="Live Demo URL">
                <input type="text" name="github" placeholder="GitHub URL">
                <textarea name="description" placeholder="Short Description" style="grid-column: span 2;" required></textarea>
                <button type="submit" name="add" class="btn btn-primary" style="grid-column: span 2;">Add Project</button>
            </form>
        </div>

        <div class="glass-card">
            <h3>Existing Projects</h3>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Tech</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $index => $p): ?>
                    <tr>
                        <td><?php echo $p['name']; ?></td>
                        <td><?php echo implode(', ', $p['tech']); ?></td>
                        <td>
                            <a href="?delete=<?php echo $index; ?>" style="color: var(--accent);" onclick="return confirm('Delete this project?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
