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
        $keyword = $this->request->getVar('keyword') ?: '';
        $maxRows = $this->request->getVar('maxrows') ?: 2;
        $pager = $this->request->getVar('page_user') ?: 1;

        $users = $this->userModel->getUsers($keyword, $maxRows, $pager);

        $data = [
                'roles' => $this->roleModel->findAll(),
                'users' => $users,
                'pager' => $this->userModel->pager->links('user', 'user_pagination'),
                'currentPage' => $pager,
                'maxRows' => $maxRows
            ];

        if($this->request->isAJAX()){
            return $this->response->setJSON($data);
        }

        $data['title'] = 'User';
        $data['menu'] = $this->menu;
        $data['users'] = $users;
        $data['user'] = $this->dataUser;

        return view('admin/usermanagement', $data);
    }
    
    public function changeUserData()
    {
        $id =  $this->request->getVar('id');
        
        $this->userModel->save($this->request->getVar());

        $data = $this->userModel->select('updated_at')->find($id);
        $data['updated_at'] = time_parsing($data['updated_at']);
        return $this->response->setJSON($data);
    }

}