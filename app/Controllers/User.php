<?php

namespace App\Controllers;

class User extends BaseController
{
    protected $userModel;
    protected $roleModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
        $this->roleModel = new \App\Models\roleModel();
    }

    public function index()
    {
        $role_id = session()->get('role_id');
        $menu = $this->userModel->getMenu($role_id);
        foreach ($menu as &$m) {
            $m['sub_menu'] = $this->userModel->getSubMenu($m['id']);
        }

        $data = [
            'title' => 'My Profile',
            'user' => $this->userModel->where('email', session()->get('email'))->first(),
            'menu' => $menu,
            'role' => $this->roleModel->getRole($role_id)['role']
        ];

        return view('user/index', $data);
    }
    
    public function edit()
    {
        if ($this->request->getMethod() == 'PUT') {
            $rules = [
                'name' => 'required',
                'image' => 'is_image[image]|max_size[image,2048]'
            ];
            $data = [
                'name' => $this->request->getVar('name'),
                'image' => $this->request->getVar('image'),
            ];
    
            if (! $this->validateData($data, $rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
            $email = $this->request->getVar('email');

            $newImage = $this->request->getFile('image');
            $lastImage = $this->request->getVar('last-image');


            if ($newImage->getError() == 4) {
                unset($data['image']);
            } else {
                $imageName = $newImage->getRandomName();
                $newImage->move('img/photos', $imageName);
                if ($lastImage != 'default.png') {
                    unlink(FCPATH . 'img/photos/' . $lastImage);
                }

                $data['image'] = $imageName;
            }
            
            $this->userModel->where('email',$email)->set($data)->update();
    
            self::flash('success', 'Profile updated successfully');
            return redirect()->to('/user');

        }
        
        $data['user'] = $this->userModel->where('email', session()->get('email'))->first();
        $data['title'] = 'Edit Profile';
        $menu = $this->userModel->getMenu(session()->get('role_id'));
        foreach ($menu as &$m) {
            $m['sub_menu'] = $this->userModel->getSubMenu($m['id']);
        }
        
        $data['menu'] = $menu;
        return view('user/edit', $data);
    }

    public function changePassword()
    {
        $data['user'] = $this->userModel->where('email', session()->get('email'))->first();
        
        if($this->request->getMethod() == 'PUT'){
            $rules = [
                'currentPassword' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Password is required'
                    ]
                ],
                'newPassword1' => [
                    'rules' => 'required|min_length[4]',
                    'errors' => [
                        'required' => 'Password is required',
                        'min_length' => 'Password must be at least 4 characters',
                    ]
                ],
                'newPassword2' => [
                    'rules' => 'required|matches[newPassword1]',
                    'errors' => [
                        'required' => 'Password is required',
                        'matches' => 'Password does not match'
                    ]
                ]
            ];

            $getData = [
                'currentPassword' => $this->request->getVar('currentPassword'),
                'newPassword1' => $this->request->getVar('newPassword1'),
                'newPassword2' => $this->request->getVar('newPassword2')
            ];
    
            if (! $this->validateData($getData, $rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
            
            if (!password_verify($getData['currentPassword'], $data['user']['password'])){
                self::flash('danger', 'Password is incorrect.');
                return redirect()->back();
            }

            $hash_password = password_hash($getData['newPassword1'], PASSWORD_DEFAULT);

            $this->userModel->where('email',$data['user']['email'])->set(['password' => $hash_password])->update();

            self::flash('success', 'Password has been changed.');
        }        
        
        $data['title'] = 'Change Password';
        $menu = $this->userModel->getMenu(session()->get('role_id'));
        foreach ($menu as &$m) {
            $m['sub_menu'] = $this->userModel->getSubMenu($m['id']);
        }

        $data['menu'] = $menu;
        return view('user/changepassword', $data);
    }
}
