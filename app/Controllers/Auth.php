<?php

namespace App\Controllers;

class Auth extends BaseController
{
    protected $userModel;
    protected $userTokenModel;

    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
        $this->userTokenModel =  new \App\Models\UserTokenModel();
    }
    
    public function index()
    {   
        if($this->request->getMethod() == 'POST'){
            $rules = [
                'email' => 'required|valid_email',
                'password' => 'required'
            ];
            $data = [
                'email' => $this->request->getVar('email'),
                'password' => $this->request->getVar('password')
            ];
        
            if (! $this->validateData($data, $rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
            
            $user = $this->userModel->getUserByEmail($data['email']);
        
            if($user){
                if($user['is_active'] == 1) {
                    if(password_verify($data['password'], $user['password'] )){
                        $data = [
                            'email' => $user['email'],
                            'role_id' => $user['role_id']
                        ];
                        session()->set($data);
        
                        if($user['role_id'] == 1) {
                            return redirect()->to('/admin');
                        } else {
                            return redirect()->to('/user');
                        }
        
                    } else {
                        self::flash('danger', 'Email or Password is incorrect!');
                    }
                } else{
                    self::flash('danger', 'This email is not active!');
                }
            } else{
                self::flash('danger', 'You are not registered yet!');
            }
            return redirect()->back()->withInput();
        }
    
        $data['title'] = 'Login Page';
        
        return view('/auth/login', $data);
    }
    
    public function registration()
    {
        if (session()->has('role_id')) {
            return redirect()->to('user');
        }

        if($this->request->getMethod() == 'POST'){
            $rules = [
                'name' => 'required',
                'email' => 'required|valid_email|is_unique[user.email]',
                'password1' => [
                    'rules' => 'required|min_length[4]',
                    'errors' => [
                        'required' => 'Password is required',
                        'min_length' => 'Password must be at least 4 characters',
                    ]
                ],
                'password2' => [
                    'rules' => 'required|matches[password1]',
                    'errors' => [
                        'required' => 'Password is required',
                        'matches' => 'Password does not match'
                    ]
                ]
            ];
            
            $email = $this->request->getVar('email');
            $user = [
                'name' => $this->request->getVar('name'),
                'email' => $email,
                'password1' => $this->request->getVar('password1'),
                'password2' => $this->request->getVar('password2')
            ];
        
            if (!$this->validateData($user, $rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        
            $user['image'] = 'default.png';
            $user['password'] = password_hash($user['password1'], PASSWORD_DEFAULT);
            unset($user['password1']);
            unset($user['password2']);
            $user['role_id'] = 2;
            $user['is_active'] = 0;
            
            self::flash('success', 'Please activate your account, first.');
            
            // Siapkan Token
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token
            ];

            $this->userModel->save($user);
            $this->userTokenModel->save($user_token);
            
            $this->_sendEmail($token, 'verify');

            return redirect()->to('/');
        }

        $user = [
            'title' => 'Registration Page',
        ];
        
        return view('auth/registration',$user);
    }

    private function _sendEmail($token, $type)
    {
        $email = $this->request->getVar('email');
        
        $emailService = \Config\Services::email();
        $emailService->setTo($email);

        if ($type == 'verify') {
            $emailService->setSubject('Account Verification');
            $emailService->setMessage('Click this link to verify your account : 
                <br>
                <a href="' . base_url() .'verify?email='.$email.'&token='.urlencode($token).'">Activate</a>
                ');
            } else if ($type == 'forgot'){
            $emailService->setSubject('Reset Password');
            $emailService->setMessage('
                Click this link to change your password: 
                <br>
                <a href="' . base_url() .'resetpassword?email='.$email.'&token='.urlencode($token).'">Reset Password</a>
                ');

        }

        if($emailService->send()) {
            return true;
        } else {
            return $emailService->printDebugger();
            die;
        }

    }
    
    public function verify()
    {
        $email = $this->request->getVar('email');
        $token = $this->request->getVar('token');
        $user = $this->userModel->getUserByEmail($email);

        if ($user) {
            $user_token = $this->userTokenModel->getChecked($email, $token);
            if($user_token) {
                $created_at = strtotime($user_token['created_at']);
                $time_diff = time() - $created_at;

                if ($time_diff <= 1200) {
                    $this->userModel->where('email',$email)->set(['is_active' => 1])->update();
                    self::flash('success', $email . ' has been activated. Please Login');
                } else {
                    $this->userModel->where('email',$email)->delete();
                    self::flash('danger', 'Account Activation Failed! Token Expired.');
                }
                $this->userTokenModel->where('email',$email)->delete();

            } else {
                self::flash('danger', 'Account Activation Failed! Wrong Token.');
            }
        } else {
            self::flash('danger', 'Account Activation Failed! Wrong Email.');
        }
        return redirect()->to('/');
    }

    public function forgotPassword()
    {
        if($this->request->getMethod() == 'POST'){
            $email = $this->request->getVar('email');
            $rules = [
                'email' => 'required|valid_email'
            ];
            $data = [
                'email' => $email
            ];
        
            if (! $this->validateData($data, $rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $user = $this->userModel
                    ->where(['email' => $email, 'is_active' => 1])
                    ->first();

            if($user) {
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token
                ];
                
                $this->userTokenModel->save($user_token);
                $this->_sendEmail($token, 'forgot');

                self::flash('info', "Please check your email to reset your password.");  

            } else {
                self::flash('danger', "Email isn't register or activated yet.");  
            }

            return redirect()->back()->withInput();
        }

        $data['title'] = 'Forgot Password';
        
        return view('/auth/forgot-password', $data);
    }

    public function resetPassword()
    {
        $email = $this->request->getVar('email');
        $token = $this->request->getVar('token');

        $user = $this->userModel->getUserByEmail($email);
        
        if($user) {
            $user_token = $this->userTokenModel->getChecked($email, $token);
            if($user_token) {
                $created_at = strtotime($user_token['created_at']);
                $time_diff = time() - $created_at;

                if ($time_diff <= 1200) {
                    session()->set('change-password', $email);
                    return $this->changePassword();
                } else {
                    self::flash('danger', 'Reset Password Failed! Token Expired.');
                }
                $this->userTokenModel->where('email',$email)->delete();

            } else {
                self::flash('danger', 'Reset Password Failed! Token Invalid' );
            }
        } else {
            self::flash('danger', 'Reset Password Failed! Wrong Email' );
        }
        return redirect()->to('/');
    }

    public function changePassword(){
        $email = session('change-password');
        if(!$email){
            return redirect()->to('/');
        }
        
        if($this->request->getMethod() == 'POST'){
            $rules = [
                'password1' => [
                    'rules' => 'required|min_length[4]',
                    'errors' => [
                        'required' => 'Password is required',
                        'min_length' => 'Password must be at least 4 characters',
                    ]
                ],
                'password2' => [
                    'rules' => 'required|matches[password1]',
                    'errors' => [
                        'required' => 'Password is required',
                        'matches' => 'Password does not match'
                    ]
                ]
            ];

            $getData = [
                'password1' => $this->request->getVar('password1'),
                'password2' => $this->request->getVar('password2')
            ];
    
            if (! $this->validateData($getData, $rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $password = password_hash($getData['password1'], PASSWORD_DEFAULT);
            
            $this->userModel->where('email',$email)->set(['password' => $password])->update();
            
            session()->remove('change-password');

            self::flash('success', 'Password has been changed! Please Login');

            return redirect()->to('/');
        }


        $data['title'] = 'Change Password';

        return view('/auth/change-password', $data);
    }

    public function logout()
    {
        session()->remove('email');
        session()->remove('role_id');
        self::flash('success', 'You have been logged out successfully.');
        return redirect()->to('/');
    }
}
