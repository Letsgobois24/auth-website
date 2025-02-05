<?php

namespace App\Models;

use CodeIgniter\Commands\Utilities\Publish;
use CodeIgniter\Model;
use Kint\Value\FunctionValue;

class SubMenuModel extends Model
{
    protected $table = 'user_sub_menu';
    protected $allowedFields = ['title','menu_id', 'url', 'icon', 'is_active'];

    public function getSubmenuById($id)
    {
        return $this->select('title')
                    ->where('id',$id)
                    ->first();
    }

}

