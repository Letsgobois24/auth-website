<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $useTimestamps = true;
    protected $allowedFields = ['name','email','image','password', 'role_id','is_active'];

    public function getMenu($role_id){
        return $this->db->table('user_menu')
					->select('user_menu.id, menu')
					->join('user_access_menu', 'user_menu.id = user_access_menu.menu_id')
					->where('user_access_menu.role_id', $role_id)
					->orderBy('user_access_menu.menu_id', 'ASC')
                    ->get()
                    ->getResultArray();
    }

    public function getSubMenu($menu_id){
        return $this->db->table('user_menu')
					->join('user_sub_menu', 'user_menu.id = user_sub_menu.menu_id')
					->where('user_sub_menu.menu_id', $menu_id)
					->where('user_sub_menu.is_active', 1)
                    ->get()
                    ->getResultArray();
    }

    public function getUserByEmail($email) {
        return $this->where('email', $email)
                    ->first();
    }

    public function getUsers($keyword='')
    {
        $joinTable = $this->db->table('user_role')
                            ->select('user.id, name, email, image, role, role_id, is_active, created_at, updated_at')
                            ->join('user', 'user_role.id=user.role_id');
        if ($keyword){
            $joinTable = $joinTable
                        ->like('name', "%$keyword%")
                        ->orLike('email', "%$keyword%");
        }
        return $joinTable->get()->getResultArray();
    }
}