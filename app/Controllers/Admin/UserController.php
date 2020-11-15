<?php 
// Note: Load helper trong BaseController
// Controller nằm trong folder admin
namespace App\Controllers\Admin;
// Load BaseController
use App\Controllers\BaseController;
// Load model
use App\Models\Muser;

class UserController extends BaseController{

    // Phần sử dụng chung 
    public function __construct() {
        $this->muser = new Muser();
    }

    public function index()
    {
        $data['list'] = $this->muser->orderBy('created_at', 'desc')->findAll();
        return view('backend/user/index', $data);
    }

    public function detail($id)
    {
        $row = $this->muser->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $data['row'] = $this->muser->find($id);
        return view('backend/user/detail', $data);
    }

    public function status($id)
    {
         // Lấy id trên đường dẫn url
        $id = intval($id);
        $row = $this->muser->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $status = ($row['status'] == 1) ? 0 : 1;
        $data = array(
            'id' => $row['id'],
            'status' => $status
        );
        $this->muser->save($data); // save (insert update)
        session()->setFlashdata('success', 'Đã khóa tài khoản khách hàng ' . $row['fullname'] );
        return redirect()->route('userIndex');
    }

    public function delete($id) 
    {
        $row = $this->muser->find($id);
        if(!$row) {
            return view('backend/error');
        }
        // xoá ảnh cũ
        if ($row['thumb'] != 'default-image.jpg' && $row['thumb'] != '') {
            unlink('uploads/user/' . $row['thumb']);
        }
        $this->muser->delete($id);
        session()->setFlashdata('success', 'Đã xoá vĩnh viễn khách hàng ' .$row['fullname'] . ' .');
        return redirect()->route('userIndex');  
    }
}