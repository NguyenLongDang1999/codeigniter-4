<?php 
// Controller nằm trong folder admin
namespace App\Controllers\Admin;
// Load BaseController
use App\Controllers\BaseController;
// Load model
use App\Models\Madmin;

class LoginController extends BaseController{

    // Phần sử dụng chung 
    public function __construct() {
        $this->madmin = new Madmin();
    }

    public function index()
    {
        return view('backend/login/index');
    }

    public function login()
    {
        $username = $this->request->getVar('username');
        $password = md5($this->request->getVar('password')); // dạng mã hoá md5
        $remember = $this->request->getVar('remember');
        // Nếu trùng khớp trả về dashboard sai thì báo lõi
        if($this->madmin->checkLogin($username, $password)) {
            $row = $this->madmin->checkLogin($username, $password); // Lấy thôgn tin admin
            $arr = [
                // admin_login trùng với session bên filter
                'adminLogin' => true,
                'fullname' => $row['fullname'],
                'thumb' => $row['thumb']
            ];
            session()->set($arr); 
            // if($remember != NULL) {
            //     session()->setTempdata('username', $username, (86400 * 30));
            //     session()->setTempdata('password', $password, (86400 * 30));
            // }
            return redirect()->route('dashboardIndex');    
        } else {
            session()->setFlashdata('error', 'Username hoặc password không trùng khớp. Vui lòng kiểm tra lại.');
            return redirect()->route('loginIndex');
        }
    }

    public function logout()
    {
        $arr = ['adminLogin', 'fullname', 'thumb'];
        session()->remove($arr);
        return redirect()->route('loginIndex');
    }

}