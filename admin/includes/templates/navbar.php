<!-- Navigation Menu Starts Here -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="dashboard.php"><?= lang('HOME_ADMIN'); ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><?= lang('CATEGORIES'); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><?= lang('ITEMS'); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="members.php?do=manage"><?= lang('MEMBERS'); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><?= lang('COMMENTS'); ?></a>
            </li>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><?= lang('STATISTICS'); ?></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= $_SESSION['Username']; ?> 
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Settings</a>
                    <a class="dropdown-item" href="members.php?do=edit&userid=<?= $_SESSION['UserID']; ?>">Edit Profile</a> 
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<!-- Navigation Menu Ends Here -->