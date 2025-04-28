<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']): ?>
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 py-6 flex flex-col">
            <div class="px-6 mb-8">
                <h2 class="text-2xl font-bold">Dashboard</h2>
            </div>
            <nav class="flex-1">
                <a href="/dashboard" class="flex items-center px-6 py-3 hover:bg-gray-700">
                    <i class="fas fa-home mr-3"></i>
                    Dashboard
                </a>
                <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
                <a href="/dashboard/users" class="flex items-center px-6 py-3 hover:bg-gray-700">
                    <i class="fas fa-users mr-3"></i>
                    Users
                </a>
                <a href="/dashboard/settings" class="flex items-center px-6 py-3 hover:bg-gray-700">
                    <i class="fas fa-cog mr-3"></i>
                    Settings
                </a>
                <?php endif; ?>
            </nav>
            <div class="px-6 py-4 border-t border-gray-700">
                <div class="flex items-center">
                    <i class="fas fa-user-circle text-2xl mr-3"></i>
                    <div>
                        <p class="font-medium"><?= $_SESSION['user']['name'] ?? 'User' ?></p>
                        <a href="/dashboard/logout" class="text-sm text-gray-400 hover:text-white">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Content -->
        <div class="flex-1">
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4">
                    <h1 class="text-2xl font-semibold text-gray-900"><?= $title ?? 'Dashboard' ?></h1>
                </div>
            </header>
            <main class="max-w-7xl mx-auto py-6 px-4">
    <?php else: ?>
    <main class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
    <?php endif; ?>
