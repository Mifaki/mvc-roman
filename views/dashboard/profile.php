<h2><?= $title ?></h2>

<div class="profile-container">
    <h3>User Profile</h3>
    
    <div class="profile-info">
        <p><strong>Username:</strong> <?= htmlspecialchars($username) ?></p>
        <p><strong>User ID:</strong> <?= htmlspecialchars($user_id) ?></p>
    </div>
    
    <div class="profile-actions">
        <p>You can update your profile settings from here.</p>
        <!-- Additional profile functionality can be added here -->
    </div>
</div>