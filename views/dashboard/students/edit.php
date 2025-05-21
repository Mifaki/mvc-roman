<h2><?= $title ?></h2>

<div class="student-form-container">
    <?php if (isset($error)): ?>
    <div class="error-message">
        <?= htmlspecialchars($error) ?>
    </div>
    <?php endif; ?>

    <form action="?c=dashboard&m=updateStudent" method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($student->id) ?>">
        
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($student->name) ?>" required>
        </div>

        <div class="form-group">
            <label for="nim">NIM:</label>
            <input type="text" id="nim" name="nim" value="<?= htmlspecialchars($student->nim) ?>" required>
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <textarea id="address" name="address" rows="3" required><?= htmlspecialchars($student->address) ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit">Update</button>
            <a href="?c=dashboard&m=getAllStudents" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>