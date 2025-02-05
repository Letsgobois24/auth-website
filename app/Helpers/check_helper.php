<?php 

use CodeIgniter\I18n\Time;

function check_access($role_id, $menu_id)
{
    $roleModel = new \App\Models\roleModel();
    $result =  $roleModel->getChecked($role_id, $menu_id);
    
    if ($result->get()->getNumRows() > 0) {
        return "checked='checked'";
    }
}

function time_parsing($time)
{
    return Time::parse($time)->humanize();
}

function selected_option($role, $user){
    if ($role == $user){
        return 'selected';
    }
}