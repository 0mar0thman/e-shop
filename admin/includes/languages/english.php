<?php
// session_start();
function  lang($phrase)
{
    $admin = isset($_SESSION['original_username']) ? explode(' ', $_SESSION['original_username'])[0] : 'Guest';
    $lang = array(
        'HOME' => 'Home',
        'CATEGORIES' => 'Categories',
        'ITEM' => 'Items',
        'MEMBER' => 'Members',
        'COMMENT' => 'Comments',
        'STATISTICS' => 'Statistics',
        'LOGS' => 'Logs',
        'ADMIN' => $admin,
        'EDIT_PROFILE' => 'Edit Profile',
        'SETTINGS' => 'Settings',
        'LOGOUT' => 'Logout',
        'VIST_SHOP' => 'Vist Shop'
    );
    return $lang[$phrase];
}
