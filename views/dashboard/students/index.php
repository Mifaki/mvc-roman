<h2><?php echo $title ?></h2>

<div class="students-container">
    <div class="action-buttons">
        <a href="?c=dashboard&m=createStudent" class="btn-add">Add New Student</a>
    </div>

    <?php if (empty($students)): ?>
        <p>No students found in the database.</p>
    <?php else: ?>
        <table class="students-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>NIM</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['id']) ?></td>
                    <td><?php echo htmlspecialchars($student['name']) ?></td>
                    <td><?php echo htmlspecialchars($student['nim']) ?></td>
                    <td><?php echo htmlspecialchars($student['address']) ?></td>
                    <td class="action-links">
                        <a href="?c=dashboard&m=editStudent&id=<?php echo $student['id'] ?>">Edit</a> |
                        <a href="?c=dashboard&m=deleteStudent&id=<?php echo $student['id'] ?>" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>