<?php

function lang($phrase)
{
    static $lang = array(
        //navbar for arabic
        'HOME' => 'الرئيسية',
        'CATEGORIES' => 'فئات',
        'ITEM' => 'عناصر',
        'MEMBER' => 'اعضاء',
        'STATISTICS' => 'إحصائيات',
        'LOGS' => 'تسجيلات',
        'ADMIN' => 'مسؤول',
        'EDIT_PROFILE' => 'تعديل الحساب',
        'SETTINGS' => 'اعدادات',
        'LOGOUT' => 'تسجيل الخروج'

    );
    return $lang[$phrase];
}
