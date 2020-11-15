<?php

namespace App\Controllers;
// Use BaseController
use App\Controllers\BaseController;
use App\Models\Mcontact;

class ContactController extends BaseController
{
    public function __construct()
    {
        $this->mcontact = new Mcontact();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        
        return view('frontend/contact/index');
    }

    public function postContact()
    {
        if($this->request->isAJAX())
        {
            $fullname = $this->request->getVar('fullname');
            $email = $this->request->getVar('email');
            $phone = $this->request->getVar('phone');
            $body = $this->request->getVar('body');

            if(!$this->validate([
                'fullname' => [
                    'rules' => 'required|max_length[255]',
                    'errors' => [
                        'required' => 'Họ và tên không được bỏ trống.',
                        'max_length' => 'Họ và tên không được vượt quá 255 ký tự.'
                    ]
                ],
                'email' => [
                    'rules' => 'required|max_length[255]|valid_emails',
                    'errors' => [
                        'required' => 'Email không được bỏ trống.',
                        'max_length' => 'Email không được vượt quá 255 ký tự.',
                        'valid_emails' => 'Email không đúng định dạng. Vui lòng kiểm tra lại.'
                    ]
                ],
                'phone' => [
                    'rules' => 'required|max_length[10]|is_numeric|is_natural',
                    'errors' => [
                        'required' => 'Số điện thoại không được bỏ trống.',
                        'max_length' => 'Số điện thoại không được vượt quá 10 ký tự.',
                        'is_numeric' => 'Số điện thoại phải là ký tự ký số.',
                        'is_natural' => 'Số điện thoại phải là số nguyên dương.',           
                    ]
                ],
                'body' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nội dung liên hệ không được bỏ trống.',     
                    ]
                ]
            ])) {
                $msg = [
                    'error' => [
                        'fullname' => $this->validation->getError('fullname'),
                        'email' => $this->validation->getError('email'),
                        'phone' => $this->validation->getError('phone'),
                        'body' => $this->validation->getError('body')
                    ]
                ];
            } else {
                $data = array(
                    'fullname' => $fullname,
                    'email' => $email,
                    'phone' => $phone,
                    'body' => $body,
                    'created_at' => date('Y-m-d H:i:s'),
                );

                $this->mcontact->save($data);

                $msg = [
                    'success' => 'Liên hệ của bạn đã được gửi. Chúng tôi sẽ phản hồi với bạn sớm nhất.'
                ];
            }
            echo json_encode($msg);
        }
    }
}
