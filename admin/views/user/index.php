<h1><?= htmlspecialchars($title) ?></h1>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Address</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Phone</th>
            <th>DOB</th>
            <th>Username</th>
            <th>Role</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['MaND']) ?></td>
                <td><?= htmlspecialchars($user['TenND']) ?></td>
                <td><?= htmlspecialchars($user['DcND']) ?></td>
                <td><?= htmlspecialchars($user['EmailND']) ?></td>
                <td><?= $user['GioiTinhND'] == 1 ? 'Male' : 'Female' ?></td>
                <td><?= htmlspecialchars($user['SDT']) ?></td>
                <td><?= htmlspecialchars($user['NgSinhND']) ?></td>
                <td><?= htmlspecialchars($user['TenTK']) ?></td>
                <td>
                    <?= ($user['LoaiTK'] == 1) ? 'Admin' : (($user['LoaiTK'] == 2) ? 'Editor' : 'User') ?>
                </td>
                <td>
                    <?= ($user['TinhTrang'] == 1) ? 'Active' : 'Disabled' ?>
                </td>
                <td>
                    <a href="?page=user&action=view&id=<?= $user['MaND'] ?>">View</a>
                    <a href="?page=user&action=edit&id=<?= $user['MaND'] ?>">Edit</a>
                    <a href="?page=user&action=delete&id=<?= $user['MaND'] ?>" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>