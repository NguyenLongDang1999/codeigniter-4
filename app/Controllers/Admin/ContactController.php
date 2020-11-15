<?php 
// Note: Load helper trong BaseController
// Controller nằm trong folder admin
namespace App\Controllers\Admin;
// Load BaseController
use App\Controllers\BaseController;
// Load model
use App\Models\Mcontact;
use App\Models\Morder;

class ContactController extends BaseController{

    // Phần sử dụng chung 
    public function __construct() {
        $this->mcontact = new Mcontact();
        $data['morder'] = new Morder();
        $this->email = \Config\Services::email();
    }

    public function index()
    {
        $data['list'] = $this->mcontact->orderBy('created_at', 'desc')->findAll();
        return view('backend/contact/index', $data);
    }

    public function detail($id)
    {
        $data['validation'] = \Config\Services::validation();
        $row = $this->mcontact->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $data['row'] = $this->mcontact->find($id);
        return view('backend/contact/detail', $data);
    }

    public function postDetail($id) 
    {
        $row = $this->mcontact->find($id);
        if(!$this->validate([
            'reply' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Trả lời câu hỏi không được bỏ trống.',
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }

        $this->email->setFrom('emarketstore2020@gmail.com', 'TopDeal Store');
        $this->email->setTo($row['email']); // Gửi đến mail vừa đăng ký
        $subject= 'TopDeal Store - Trả lời liên hệ của khách hàng';
        $this->email->setSubject($subject); 
        $reply = $this->request->getVar('reply');
        $message = 'Chào '.$row['fullname'] .'. <br><br> Cảm ơn bạn phản hồi ý kiến về cửa hàng. <br><br> Câu hỏi của bạn: '.$row['body'].'.  <br><br> Nội dung trả lời cửa hàng: '.$reply.'.';
        $this->email->setMessage($message);
        $this->email->send();
        if (!$this->email->send())
        {
            $this->email->printDebugger(['headers']);
        }
        session()->setFlashdata('success', 'Liên hệ của khách hàng ' .$row['fullname'] . ' vừa được gửi đi.');
        return redirect()->back();
    }

    public function delete($id) 
    {
        $row = $this->mcontact->find($id);
        $this->mcontact->delete($id);
        session()->setFlashdata('success', 'Đã xoá vĩnh viễn liên hệ của khách hàng ' .$row['fullname'] . ' .');
        return redirect()->route('contactIndexBE');  
    }
}