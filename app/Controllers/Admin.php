<?php

namespace App\Controllers;

class Admin extends BaseController
{   
    protected $userModel;
    protected $menuModel;
    protected $roleModel;
    protected $dataUser;
    protected $menu;
    
    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();   
        $this->menuModel = new \App\Models\MenuModel();
        $this->dataUser = $this->userModel->where('email', session()->get('email'))->first();
        $this->roleModel = new \App\Models\RoleModel();

        $menu = $this->userModel->getMenu(session()->get('role_id'));
        foreach ($menu as &$m) {
            $m['sub_menu'] = $this->userModel->getSubMenu($m['id']);
        }
        $this->menu = $menu;

    }
    
    public function index()
    {
        $data['user'] = $this->dataUser;
        $data['title'] = 'Dashboard';

        $data['menu'] = $this->menu;
        return view('admin/index',$data);
    }

    public function role($id='')
    {   
        if ($this->request->getMethod() == 'POST'){
            $rules['role'] = 'required';
            $getData['role'] = $this->request->getVar('role');
            $getData['id'] = $id;
        
            if (! $this->validateData($getData, $rules)) {
                self::flash('danger', $this->validator->getErrors()['role']);
                return redirect()->back();
            }

            if ($id){
                $lastRole = $this->roleModel->getRole($id)['role'];
                self::flash('success', $lastRole . ' role has been changed to '.$getData['role']);
            } else {
                self::flash('success', $getData['role'] . ' role has been added');
            }

            $this->roleModel->save($getData);
            return redirect()->back();
        }
        
        $data['user'] = $this->dataUser;
        $data['title'] = 'Role';
        
        $menu = $this->userModel->getMenu(session()->get('role_id'));
        foreach ($menu as &$m) {
            $m['sub_menu'] = $this->userModel->getSubMenu($m['id']);
        }
        
        $data['roles'] = $this->menuModel->getAll('user_role');
        $data['menu'] = $menu;
        return view('admin/role',$data);
    }

    public function deleteRole($id)
    {
        $role = $this->roleModel->find($id);

        $this->roleModel->delete($id);
        self::flash('success', $role['role'] . ' role has been deleted');

        return redirect()->back();

    }

    public function roleaccess($role_id)
    {
        $data['user'] = $this->dataUser;
        $data['title'] = 'Roleaccess';
        
        
        $data['role'] = $this->roleModel->getRole($role_id);

        $data['menu'] = $this->menu;
        $data['all_menu'] = $this->menuModel->getAll('user_menu');
        return view('admin/roleaccess',$data);
    }

    public function changeAccess()
    {
        $menu_id = $this->request->getVar('menuId');
        $role_id = $this->request->getVar('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->roleModel->getChecked($role_id, $menu_id)->get();

        $userAccessModel = new \App\Models\UserAccessModel();
        
        if ($result->getNumRows() < 1){
            $userAccessModel->insert($data);
        } else {
            $userAccessModel->where($data)->delete();
        }

        self::flash('warning', 'Access has been changed.');
        
    }
    
    public function userManagement()
    {
        $keyword = $this->request->getVar('keyword');
        $maxRows = $this->request->getVar('maxRows'); // Ensure this matches the AJAX request
        
        $maxRows = ($maxRows) ?: 2;

        $currentPage = $this->request->getVar('page_user') ?: 1;

        $data = [
            'title' => 'User',
            'menu' => $this->menu,
            'user' => $this->dataUser,
            'roles' => $this->roleModel->findAll(),
            'users' => $this->userModel->getUsers($keyword, $maxRows),
            'maxRows' => $maxRows,
            'keyword' => ($keyword) ?: '',
            'pager' => $this->userModel->pager,
            'currentPage' => $currentPage
        ];
        return view('admin/usermanagement', $data);
    }
    
    public function changeActivation()
    {
        $id = $this->request->getVar('id');
        $checked = $this->request->getVar('checked');

        $data = [
            'id' => $id,
            'is_active' => ($checked == 'true') ? 1 : 0
        ];

        $this->userModel->save($data);

        self::flash('warning', 'User activation has been changed');
    }
    
    public function changeRole()
    {
        $data = [
            'id' => $this->request->getVar('id'),
            'role_id' => $this->request->getVar('role_id')
        ];
        
        $this->userModel->save($data);
        
        self::flash('warning', 'User activation has been changed');
    }

    public function coba (){
        $keyword = $this->request->getPost('keyword');
        $maxRows = $this->request->getPost('max-rows');
        $kata = $this->request->getPost('asu');

        d($kata);
        d($keyword);
        d($maxRows);
    }
}