<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 1. Base Frameworks and Libraries -->
    <link rel="stylesheet" href="<?= $css; ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?= $css; ?>jquery-ui.css">
    <link rel="stylesheet" href="<?= $css; ?>jquery.selectBoxIt.css">
    <link rel="stylesheet" href="<?= $css; ?>sweetalert2.min.css">
    <link rel="stylesheet" href="<?= $css; ?>aos.css">
    <link rel="stylesheet" href="<?= $css; ?>animate.min.css">
    <link rel="stylesheet" href="<?= $css; ?>all.min.css">
    
    <link rel="stylesheet" href="<?= $css; ?>backend.css">

    <title><?php displayPageTitle() ?></title>
</head>

<body>

<style>
    .profile-card {
            background: linear-gradient(135deg,rgb(25, 25, 25) 0%,rgb(69, 69, 69) 100%);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .profile-img {
            width: 150px;
            height: 150px;
            border: 5px solid white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .stats-box {
            background: rgba(0, 0, 0, 0.9);
            border-radius: 10px;
            transition: transform 0.3s ease;
        }
        .stats-box:hover {
            transform: translateY(-5px);
        }
        .edit-btn {
            position: absolute;
            top: 20px;
            left: 20px;
        }
        .social-icon {
            width: 40px;
            height: 40px;
            transition: all 0.3s ease;
        }
        .social-icon:hover {
            transform: scale(1.2);
        }
</style>