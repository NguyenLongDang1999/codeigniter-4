<?php

namespace App\Controllers;
// Use BaseController
use App\Controllers\BaseController;
use App\Models\Muser;

class LoginController extends BaseController
{
    public function __construct()
    {
        $this->muser = new Muser();
        $this->validation = \Config\Services::validation();
    }

    public function postRegister()
    {
        if ($this->request->isAJAX()) {
            $fullname = $this->request->getVar('fullname');
            $email = $this->request->getVar('email');
            $phone = $this->request->getVar('phone');
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');

            if (!$this->validate([
                'fullname' => [
                    'rules' => 'required|max_length[255]|min_length[3]',
                    'errors' => [
                        'required' => lang('App.frontend.login.validate.fullname.required'),
                        'max_length' => lang('App.frontend.login.validate.fullname.max'),
                        'min_length' => lang('App.frontend.login.validate.fullname.min')
                    ]
                ],
                'email' => [
                    'rules' => 'required|max_length[255]|valid_emails|is_unique[tbl_user.email]',
                    'errors' => [
                        'required' => lang('App.frontend.login.validate.email.required'),
                        'max_length' => lang('App.frontend.login.validate.email.max'),
                        'valid_emails' => lang('App.frontend.login.validate.email.valid'),
                        'is_unique' => lang('App.frontend.login.validate.email.unique')
                    ]
                ],
                'phone' => [
                    'rules' => 'required|max_length[10]|is_numeric|is_natural',
                    'errors' => [
                        'required' => lang('App.frontend.login.validate.phone.required'),
                        'max_length' => lang('App.frontend.login.validate.phone.max'),
                        'is_numeric' => lang('App.frontend.login.validate.phone.numeric'),
                        'is_natural' => lang('App.frontend.login.validate.phone.natural'),
                    ]
                ],
                'username' => [
                    'rules' => 'required|regex_match[/^[A-Za-z0-9_\.]{3,32}$/]|is_unique[tbl_user.username]',
                    'errors' => [
                        'required' => lang('App.frontend.login.validate.username.required'),
                        'regex_match' => lang('App.frontend.login.validate.username.regex'),
                        'is_unique' => lang('App.frontend.login.validate.username.unique')
                    ]
                ],
                'password' => [
                    'rules' => 'required|regex_match[/^([a-zA-Z]){1}([\w_\.!@#$%^&*()]+){3,32}$/]',
                    'errors' => [
                        'required' => lang('App.frontend.login.validate.password.required'),
                        'regex_match' => lang('App.frontend.login.validate.password.regex')
                    ]
                ]
            ])) {
                $msg = [
                    'error' => [
                        'fullname' => $this->validation->getError('fullname'),
                        'email' => $this->validation->getError('email'),
                        'phone' => $this->validation->getError('phone'),
                        'username' => $this->validation->getError('username'),
                        'password' => $this->validation->getError('password'),
                    ]
                ];
            } else {

                $data = array(
                    'username' => $username,
                    'password' => md5($password),
                    'fullname' => $fullname,
                    'email' => $email,
                    'phone' => $phone,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                );

                $this->muser->save($data);

                $msg = [
                    'success' => 'Đăng ký thành công. Bây giờ bạn có thể đăng nhập.'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function postLogin()
    {
        if ($this->request->isAJAX()) {
            $username = $this->request->getVar('loginUsername');
            $password = md5($this->request->getVar('loginPassword'));

            if (!$this->validate([
                'loginUsername' => [
                    'rules' => 'required|regex_match[/^[A-Za-z0-9_\.]{3,32}$/]',
                    'errors' => [
                        'required' => lang('App.frontend.login.validate.username.required'),
                        'regex_match' => lang('App.frontend.login.validate.username.regex'),
                    ]
                ],
                'loginPassword' => [
                    'rules' => 'required|regex_match[/^([a-zA-Z]){1}([\w_\.!@#$%^&*()]+){3,32}$/]',
                    'errors' => [
                        'required' => lang('App.frontend.login.validate.password.required'),
                        'regex_match' => lang('App.frontend.login.validate.password.regex')
                    ]
                ]
            ])) {
                $msg = [
                    'error' => [
                        'loginUsername' => $this->validation->getError('loginUsername'),
                        'loginPassword' => $this->validation->getError('loginPassword'),
                    ]
                ];
            } else {
                if ($this->muser->checkLogin($username, $password)) {
                    $row = $this->muser->checkLogin($username, $password);
                    if ($row['status'] == 1) {
                        // Nếu trạng thái == 1 sẽ thực hiện == 0 sẽ bị khoá tài khoản
                        // Sau khi kiểm tra xong thì lưu mảng sesion
                        $arr = [
                            // admin_login trùng với session bên filter
                            'userAll' => $row,
                            'userFullname' => $row['fullname'], // Hiển thị họ tên
                            'userPhone' => $row['phone'], // Hiển thị sdt
                            'userThumb' => $row['thumb'], // HIển thị hình ảnh
                            'userId' => $row['id'], // Lấy id để truy vân
                            'userEmail' => $row['email'],
                        ];
                        session()->set($arr);

                        $msg = [
                            'success' => 'Đăng nhập thành công.'
                        ];
                    } else {
                        $msg = [
                            'danger' => 'Tài khoản này hiện đang bị khóa. Vui lòng liên hệ với cửa hàng để được khắc phục.'
                        ];
                    }
                    // end status
                } else {
                    $msg = [
                        'danger' => 'Tài khoản hoặc mật khẩu không trùng khớp. Vui lòng thử lại.'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }

    public function showLogin()
    {
        $show = '';
        if (session()->has('userAll')) {
            $show .= '<div class="login__icon" data-container="body" data-toggle="popover" data-placement="left">
            <i class="fa fa-user-o" aria-hidden="true"></i>
        </div>';
        } else {
            $show .= '<div class="login__icon" data-toggle="modal" data-target="#userLogin">
            <i class="fa fa-user-o" aria-hidden="true"></i>
        </div>';
        }

        echo $show;
    }

    public function postLogout()
    {
        $arr = array('userAll', 'userFullname', 'userThumb', 'userId', 'userEmail');
        session()->remove($arr);
        $msg = [
            'success' => 'Đăng xuất thành công.'
        ];
        echo json_encode($msg);
    }
}
