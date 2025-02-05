<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'user_menu';
    protected $allowedFields = ['menu'];

    public function getMenuById($id)
    {
        return $this->where('id',$id)->first();
    }
    
    public function getAll($table, $columns=['*'])
    {
        $str = implode(',',$columns);
        return $this->db->table($table)
					->select($str)
                    ->get()
                    ->getResultArray();
    }
    
    public function getSubMenu(){
        return $this->db->table('user_menu')
                    ->select('*')
                    ->join('user_sub_menu', 'user_sub_menu.menu_id = user_menu.id')
                    ->get()
                    ->getResultArray();
    }
}