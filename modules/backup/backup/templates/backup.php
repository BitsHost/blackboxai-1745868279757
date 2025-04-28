<?php include __DIR__ . '/layout/header.php'; ?>

<div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Backup Management</h2>
            <form action="/backup/create" method="POST" class="inline">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-plus mr-2"></i>Create New Backup
                </button>
            </form>
        </div>

        <?php if (empty($backups)): ?>
            <div class="text-center py-8">
                <i class="fas fa-archive text-gray-400 text-5xl mb-4"></i>
                <p class="text-gray-500">No backups available. Create your first backup using the button above.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Filename
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Created At
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($backups as $backup): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <i class="fas fa-file-archive text-gray-400 mr-2"></i>
                                        <?= htmlspecialchars($backup['filename']) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">
                                        <?= htmlspecialchars($backup['created_at']) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="/backup/download/<?= $backup['id'] ?>" class="text-blue-600 hover:text-blue-900 mr-4">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                    <a href="/backup/delete/<?= $backup['id'] ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this backup?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>
