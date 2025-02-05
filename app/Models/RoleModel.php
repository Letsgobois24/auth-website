<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'user_role';
    protected $allowedFields = ['role'];

    public function getRole($id)
    {
        return $this->where('id', $id)->first();
    }

    public function getChecked($role_id,$menu_id)
    {
        return $this->db->table('user_access_menu')
                    ->where('role_id', $role_id)
                    ->where('menu_id', $menu_id);
    }

    public function getRoleAccess($url) {
        $url = explode('/', $url)[1];

        return $this->db->table('user_access_menu')
                        ->select('role_id, menu')
                        ->join('user_menu', 'user_access_menu.menu_id = user_menu.id')
                        ->where('role_id', session()->get('role_id'))
                        ->like('menu', '%' . $url)
                        ->get()
                        ->getFirstRow();
    }
}