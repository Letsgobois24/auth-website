<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AjaxController extends BaseController
{
    protected $userModel;
    protected $roleModel;
    
    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
        $this->roleModel = new \App\Models\RoleModel();
    }

    public function search()
    {
        $keyword = $this->request->getVar('keyword');
        $maxRows = 2;

        $currentPage = $this->request->getVar('page_user') ?: 1;

        $data = [
            'roles' => $this->roleModel->findAll(),
            'users' => $this->userModel->getUsers($keyword, $maxRows),
            'maxRows' => $maxRows,
            'keyword' => ($keyword) ?: '',
            'pager' => $this->userModel->pager,
            'currentPage' => $currentPage
        ];
        return view('ajax/search', $data);
    }
}
