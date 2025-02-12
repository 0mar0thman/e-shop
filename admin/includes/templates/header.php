<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= $css; ?>bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= $css; ?>jquery-ui.css">
    <link rel="stylesheet" href="<?= $css; ?>jquery.selectBoxIt.css">
    <link rel="stylesheet" href="<?= $css; ?>all.min.css">
    <link rel="stylesheet" href="<?= $css; ?>animate.min.css">
    <link rel="stylesheet" href="<?= $css; ?>aos.css">
    <link rel="stylesheet" href="<?= $css; ?>sweetalert2.min.css">
    <!-- Custom CSS -->

    <link rel="stylesheet" href="<?= $css; ?>global/global.css">
    <link rel="stylesheet" href="<?= $css; ?>components/navbar.css">
    <link rel="stylesheet" href="<?= $css; ?>pages/dashboard.css">
    <link rel="stylesheet" href="<?= $css; ?>components/cards.css">
    <link rel="stylesheet" href="<?= $css; ?>components/buttons.cs">
    <link rel="stylesheet" href="<?= $css; ?>responsive/responsive.css">
    <link rel="stylesheet" href="<?= $css; ?>components/tables.css">
    <link rel="stylesheet" href="<?= $css; ?>components/selectbox.css">
    <link rel="stylesheet" href="<?= $css; ?>components/stars.css">
    <link rel="stylesheet" href="<?= $css; ?>forms/forms.css">
    <link rel="stylesheet" href="<?= $css; ?>main_pages/items.css">
    <link rel="stylesheet" href="<?= $css; ?>main_pages/categorys.css">
    <link rel="stylesheet" href="<?= $css; ?>main_pages/members.css">

    <!-- SweetAlert2 CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"> -->

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Animate.css للحركات -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"> -->

    <!-- AOS للحركات عند التمرير -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"> -->

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
    <title><?php getTitle() ?></title>

    <style>
        @font-face {
            font-family: 'Cairo';
            src: url('style/static/Cairo-Regular.ttf') format('truetype');
            font-weight: 400;
        }

        @font-face {
            font-family: 'Cairo';
            src: url('style/static/Cairo-Regular.ttf') format('truetype');
            font-weight: 700;
        }

        body {
            /* font-family: 'Cairo', sans-serif; */
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #121212;
            color: #ffffff;
        }

        h1 {
            font-weight: 700;
        }

        p {
            font-weight: 400;
        }

        /* دعم Firefox */
        * {
            scrollbar-width: thin;
            /* عرض شريط التمرير */
            scrollbar-color: #555 #2c2c2c;
            /* لون شريط التمرير والخلفية */
        }

        /* تغيير لون شريط التمرير لأجهزة الويب */
        ::-webkit-scrollbar {
            width: 12px;
            /* عرض شريط التمرير */
        }

        ::-webkit-scrollbar-track {
            background: #2c2c2c;
            /* لون خلفية شريط التمرير */
            border-radius: 10px;
            /* حواف مستديرة */
        }

        ::-webkit-scrollbar-thumb {
            background: #555;
            /* لون شريط التمرير نفسه */
            border-radius: 10px;
            /* حواف مستديرة */
            border: 3px solid #2c2c2c;
            /* إطار حول شريط التمرير */
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #777;
            /* لون شريط التمرير عند التمرير فوقه */
        }
    </style>

</head>

<body></body>