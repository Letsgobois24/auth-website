<?php

namespace App\Models;

use CodeIgniter\Model;

class UserAccessModel extends Model
{
    protected $table = 'user_access_menu';
    protected $allowedFields = ['role_id', 'menu_id'];
}