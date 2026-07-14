<?php
use Illuminate\Support\Facades\Auth;

function thisUser(){
    $user = Auth::user();
    return !empty($user) ? $user : null;
}

function isAuthUser(){
    $user = thisUser();
    return !empty($user) ? true : false;
}

function isSuperAdmin(){
    $user = thisUser();
    return !empty($user) && $user['user_role_id'] == '019f4500-79ad-7075-8737-1c881b93367f' ? true : false;
}

function isAdmin(){
    $user = thisUser();
    return !empty($user) && $user['user_role_id'] == '019f4500-93c4-7386-9d2c-abbca3324a0a' ? true : false;
}

function isCoach(){
    $user = thisUser();
    return !empty($user) && $user['user_role_id'] == '019f4500-c2d9-7094-8fc8-1ced8e414519' ? true : false;
}

function isOnlySuperAdmin(){
    $user = thisUser();
    $adminUserRoleIds = ['019f4500-79ad-7075-8737-1c881b93367f'];
    return !empty($user) && in_array($user['user_role_id'], $adminUserRoleIds) ? true : false;
}

function isOnlyAdmins(){
    $user = thisUser();
    $adminUserRoleIds = ['019f4500-79ad-7075-8737-1c881b93367f', '019f4500-93c4-7386-9d2c-abbca3324a0a'];
    return !empty($user) && in_array($user['user_role_id'], $adminUserRoleIds) ? true : false;
}

function isAllUserRolesAllowed(){
    return true;
}

function parentRoute(){
    $route = 'admin';
    if (!empty(isCoach())){
        $route = 'coach';
    }
    return $route;
}

function generatePlayerID($id = 0){
    $newId = 0;
    if (!empty($id)) {
        $newId = STR_PAD($id, 6, 0, STR_PAD_LEFT);
    }

    $newId = str_split($newId, 3);
    $newId = implode('-', $newId);
    $newId = 'OCA-' . $newId;
    return $newId;
}

function priceWithCurrency($price){
    $price = str_replace(',', '', $price);
    $price = (float) $price;
    return defaultCurrency() . number_format($price, 2);
}

function priceWithoutCurrency($price){
    $price = str_replace(',', '', $price);
    $price = (float) $price;
    return number_format($price, 2);
}

function defaultCurrency(){
    return 'Rs. ';
}

function dateTimeFormat($date){
    return date('d-m-Y H:i A', strtotime($date));
}

function dateTimeFullFormat($date){
    return date('d-F-Y H:i A', strtotime($date));
}

function dateFormat($date){
    return date('d-F-Y', strtotime($date));
}

function batchNumberFormat($batchNumber, $length = 6){
    return str_pad($batchNumber, $length, '0', STR_PAD_LEFT);
}

function commonStatus($status){

    $out = [
        'text' => 'Inactive',
        'class' => 'bg-warning',
    ];

    if ($status == 1){
        $out = [
            'text' => 'Active',
            'class' => 'bg-success',
        ];
    }

    return $out;
}

function badgesDefaultBadges(){

    $out = [
        'Default Badges' => [
            'bg-primary' => 'Primary',
            'bg-secondary' => 'Secondary',
            'bg-success' => 'Success',
            'bg-info' => 'Info',
            'bg-warning' => 'Warning',
            'bg-danger' => 'Danger',
            'bg-dark' => 'Dark',
            'bg-light' => 'Light',
        ]
    ];

    return $out;
}

function badgesSoftBadges(){

    $out = [
        'Soft Badges' => [
            'badge-soft-primary' => 'Primary',
            'badge-soft-secondary' => 'Secondary',
            'badge-soft-success' => 'Success',
            'badge-soft-info' => 'Info',
            'badge-soft-warning' => 'Warning',
            'badge-soft-danger' => 'Danger',
            'badge-soft-dark' => 'Dark',
            'badge-soft-light' => 'Light',
        ]
    ];

    return $out;
}

function badgesOutlineBadges(){

    $out = [
        'Outline Badges' => [
            'badge-outline-primary' => 'Primary',
            'badge-outline-secondary' => 'Secondary',
            'badge-outline-success' => 'Success',
            'badge-outline-info' => 'Info',
            'badge-outline-warning' => 'Warning',
            'badge-outline-danger' => 'Danger',
            'badge-outline-dark' => 'Dark',
            'badge-outline-light' => 'Light',
        ]
    ];

    return $out;
}

function badgesRoundedPillBadges(){

    $out = [
        'Rounded Pill Badges' => [
            'rounded-pill bg-primary' => 'Primary',
            'rounded-pill bg-secondary' => 'Secondary',
            'rounded-pill bg-success' => 'Success',
            'rounded-pill bg-info' => 'Info',
            'rounded-pill bg-warning' => 'Warning',
            'rounded-pill bg-danger' => 'Danger',
            'rounded-pill bg-dark' => 'Dark',
            'rounded-pill bg-light' => 'Light',
        ]
    ];

    return $out;
}

function badgesRoundedPillBadgesWithSoftEffectBadges(){

    $out = [
        'Rounded Pill Badges with soft effect' => [
            'rounded-pill badge-soft-primary' => 'Primary',
            'rounded-pill badge-soft-secondary' => 'Secondary',
            'rounded-pill badge-soft-success' => 'Success',
            'rounded-pill badge-soft-info' => 'Info',
            'rounded-pill badge-soft-warning' => 'Warning',
            'rounded-pill badge-soft-danger' => 'Danger',
            'rounded-pill badge-soft-dark' => 'Dark',
            'rounded-pill badge-soft-light' => 'Light',
        ]
    ];

    return $out;
}

function badgesSoftBorderBadges(){

    $out = [
        'Soft Border Badges' => [
            'badge-border badge-soft-primary' => 'Primary',
            'badge-border badge-soft-secondary' => 'Secondary',
            'badge-border badge-soft-success' => 'Success',
            'badge-border badge-soft-info' => 'Info',
            'badge-border badge-soft-warning' => 'Warning',
            'badge-border badge-soft-danger' => 'Danger',
            'badge-border badge-soft-dark' => 'Dark',
            'badge-border badge-soft-light' => 'Light',
        ]
    ];

    return $out;
}

function badgesOutlinePillBadges(){

    $out = [
        'Outline Pill Badges' => [
            'rounded-pill badge-outline-primary' => 'Primary',
            'rounded-pill badge-outline-secondary' => 'Secondary',
            'rounded-pill badge-outline-success' => 'Success',
            'rounded-pill badge-outline-info' => 'Info',
            'rounded-pill badge-outline-warning' => 'Warning',
            'rounded-pill badge-outline-danger' => 'Danger',
            'rounded-pill badge-outline-dark' => 'Dark',
            'rounded-pill badge-outline-light' => 'Light',
        ]
    ];

    return $out;
}

function badgesLabelBadges(){

    $out = [
        'Label Badges' => [
            'badge-label bg-primary' => 'Primary',
            'badge-label bg-secondary' => 'Secondary',
            'badge-label bg-success' => 'Success',
            'badge-label bg-info' => 'Info',
            'badge-label bg-warning' => 'Warning',
            'badge-label bg-danger' => 'Danger',
            'badge-label bg-dark' => 'Dark',
            'badge-label bg-light' => 'Light',
        ]
    ];

    return $out;
}

function badgesGradientBadges(){

    $out = [
        'Gradient Badges' => [
            'badge-gradient-primary' => 'Primary',
            'badge-gradient-secondary' => 'Secondary',
            'badge-gradient-success' => 'Success',
            'badge-gradient-info' => 'Info',
            'badge-gradient-warning' => 'Warning',
            'badge-gradient-danger' => 'Danger',
            'badge-gradient-dark' => 'Dark',
            'badge-gradient-light' => 'Light',
        ]
    ];

    return $out;
}

function badgesAllBadges(){

    $out = badgesDefaultBadges();
    $out = array_merge($out, badgesSoftBadges());
    $out = array_merge($out, badgesOutlineBadges());
    $out = array_merge($out, badgesRoundedPillBadges());
    $out = array_merge($out, badgesRoundedPillBadgesWithSoftEffectBadges());
    $out = array_merge($out, badgesSoftBorderBadges());
    $out = array_merge($out, badgesOutlinePillBadges());
    $out = array_merge($out, badgesLabelBadges());
    $out = array_merge($out, badgesGradientBadges());

    return $out;
}

function strLimit($string, $length = 200){
    $out = [];
    if(strlen($string) <= $length) {
        $out = [
            'exceeded' => false,
            'string' => $string
        ];
    } else
    {
        $string = substr($string,0,$length) . '...';
        $out = [
            'exceeded' => true,
            'string' => $string
        ];
    }
    return $out;
}

function productImage($image, $folder = ''){

    $folder = !empty($folder) ? $folder . '/' : '';

    $newImage = asset('assets/common/images/uploads/' . $folder . $image);
    if (!empty($image) && !file_exists('assets/common/images/uploads/' . $folder . $image)) {
        $newImage = asset('assets/common/images/default-product.jpg');
    }
    return $newImage;
}

?>
