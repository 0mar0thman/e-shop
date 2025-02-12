<?php
// session_start();
function  lang($phrase)
{
    $admin = isset($_SESSION['UserName']) ? explode(' ', $_SESSION['UserName'])[0] : 'Guest';
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
        'PROFILE' => 'Profile',
        'LOGOUT' => 'Logout'
    );
    return $lang[$phrase];
}
