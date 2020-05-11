<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

  <!-- Fontawesome CDN File-->
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

  <!-- Admin Panel CSS File-->
  <link rel="stylesheet" type="text/css" href="<?= $css; ?>frontend.css">

  <title><?= getTitle(); ?></title>
</head>

<body>
  <!-- Header Ends -->

  <div class="upper-navbar">
    <div class="container">
      <div class="row">
        <?php
        if (isset($_SESSION['user'])) {
        ?>
          <img src="layout/images/tandra.jpg" class="img-fluid user-img" alt="User Profile Picture">

          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $sessionedUser; ?></button>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="profile.php">My Profile</a>
              <a class="dropdown-item" href="addnewitem.php">New Items</a>
              <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
          </div>

        <?php
        } else {
        ?>
          <a href="login.php">
            <span class="">Login | Signup</span>
          </a>
        <?php
        }
        ?>
      </div>
    </div>
  </div>


  <!-- Navigation Menu Starts Here -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php"><?= lang('HOME_ADMIN'); ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <?php
          $allCats = getAllFrom("*", "categories", "WHERE Cat_parent = 0", "","Cat_id","ASC");

          foreach ($allCats as $cat) {
            echo 
            "<li class='nav-class'>
              <a href='categories.php?pageid={$cat['Cat_id']}'>
                  {$cat['Cat_name']}
              </a>
            </li>";
          }

        ?>
      </ul>
    </div>
  </nav>
  <!-- Navigation Menu Ends Here -->