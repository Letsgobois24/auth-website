<?php

namespace App\Controllers;

class Menu extends BaseController
{   
    protected $userModel;
    protected $menuModel;
    protected $submenuModel;
    
    public function __construct()
    {   
        $this->userModel = new \App\Models\UserModel();
        $this->menuModel = new \App\Models\MenuModel();
        $this->submenuModel = new \App\Models\SubMenuModel();
    }
    
    public function index($id='')
    {
        if($this->request->getMethod() == 'POST'){
            $rules['menu'] = 'required';
            $data['menu'] = $this->request->getVar('menu');
            
            if (! $this->validateData($data, $rules)) {
                self::flash('danger', $this->validator->getErrors()['menu']);
                return redirect()->back()->withInput();
            }
        
            if ($id){
                $data['id'] = $id;
                $lastMenu = $this->menuModel->getMenuById($id)['menu'];
                self::flash('success', 'Menu ' . $lastMenu . ' has been changed to '.$data['menu']);
            } else {
                self::flash('success', 'Menu added successfully');
            }
            $this->menuModel->save($data);
        
            return redirect()->back();
        }
        
        $data['user'] = $this->userModel->where('email', session()->get('email'))->first();
        $data['title'] = 'Menu Management';
        $menu = $this->userModel->getMenu(session()->get('role_id'));
        foreach ($menu as &$m) {
            $m['sub_menu'] = $this->userModel->getSubMenu($m['id']);
        }

        $data['menu'] = $menu;
        $data['all_menu'] = $this->menuModel->getAll('user_menu');
        return view('menu/index',$data);
    }
    
    public function deleteMenu($id){
        $menu = $this->menuModel->find($id);

        $this->menuModel->delete($id);
        self::flash('success', $menu['menu'] . ' menu has been deleted');

        return redirect()->back();
    }

    public function submenu($id='')
    {   
        if($this->request->getMethod() == 'POST'){
            $rules = [
                'title' => 'required',
                'menu_id' => 'required',
                'url' => 'required',
                'icon' => 'required',
            ];
            $data = [
                'title' => $this->request->getVar('title'),
                'menu_id' => $this->request->getVar('menu_id'),
                'url' => $this->request->getVar('url'),
                'icon' => $this->request->getVar('icon'),
                'is_active' => ($this->request->getVar('is_active') ?: 0 ) 
            ];

            if (! $this->validateData($data, $rules)) {
                self::flash('danger', array_values($this->validator->getErrors())[0]);
                return redirect()->back()->withInput();
            }
        
            if ($id){
                $data['id'] = $id;
                self::flash('success', 'Submenu has been edited succesfully');
            } else {
                self::flash('success', 'Submenu added successfully');
            }
            
            $this->submenuModel->save($data);
        
            return redirect()->back();

        }
        
        $data['user'] = $this->userModel->getUserByEmail(session()->get('email'));
        $data['title'] = 'Submenu Management';
        $menu = $this->userModel->getMenu(session()->get('role_id'));
        
        foreach ($menu as &$m) {
            $m['sub_menu'] = $this->userModel->getSubMenu($m['id']);
        }

        $data['menu'] = $menu;
        $data['all_submenu'] = $this->menuModel->getSubMenu();
        $data['all_menu'] = $this->menuModel->getAll('user_menu');
        return view('menu/submenu',$data);
    }

    public function deleteSubmenu($id)
    {
        $submenu = $this->submenuModel->find($id);
        $this->submenuModel->delete($id);
        self::flash('success', $submenu['title'] . ' submenu has been deleted');

        return redirect()->back();
    }
}