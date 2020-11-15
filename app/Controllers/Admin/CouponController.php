<?php
// Use Controller Folder Admin
namespace App\Controllers\Admin;
// Use BaseController
use App\Controllers\BaseController;
// Use Model
use App\Models\Mcoupon;

class CouponController extends BaseController
{
    public function __construct()
    {
        $this->mcoupon = new Mcoupon();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $data['list'] = $this->mcoupon->orderBy('created_at', 'desc')->findAll();
        return view('backend/coupon/index', $data);
    }

    public function add()
    {
        $data['validation'] = $this->validation;
        return view('backend/coupon/add', $data);
    }

    public function postAdd()
    {
        if (!$this->validate([
            'code' => [
                'rules' => 'required|max_length[30]|min_length[3]|is_unique[tbl_coupon.code]',
                'errors' => [
                    'required' => 'Mã code không được bỏ trống.',
                    'max_length' => 'Mã code không được vượt quá 30 ký tự.',
                    'min_length' => 'Mã code không được dưới 3 ký tự.',
                    'is_unique' => 'Mã code này đã tồn tại.'
                ]
            ],
            'price_discount' => [
                'rules' => 'required|is_numeric|integer|is_natural',
                'errors' => [
                    'required' => 'Số tiền giảm giá không được bỏ trống.',
                    'is_numeric' => 'Số tiền giảm giá phải là ký tự ký số.',
                    'integer' => 'Số tiền giảm giá phải là số nguyên.',
                    'is_natural' => 'Số tiền giảm giá phải là số dương.',
                ]
            ],
            'code_limit' => [
                'rules' => 'required|is_numeric|integer|is_natural',
                'errors' => [
                    'required' => 'Giới hạn nhập không được bỏ trống.',
                    'is_numeric' => 'Giới hạn nhập phải là ký tự ký số.',
                    'integer' => 'Giới hạn nhập phải là số nguyên.',
                    'is_natural' => 'Giới hạn nhập phải là số dương.',
                ]
            ],
            'expiration_date' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Ngày hết hạn không được bỏ trống.',
                ]
            ],
            'price_payment_limit' => [
                'rules' => 'required|is_numeric|integer|is_natural',
                'errors' => [
                    'required' => 'Số tiền được nhập code không được bỏ trống.',
                    'is_numeric' => 'Số tiền được nhập code phải là ký tự ký số.',
                    'integer' => 'Số tiền được nhập code phải là số nguyên.',
                    'is_natural' => 'Số tiền được nhập code phải là số dương.',
                ]
            ],
            'code_description' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Mô tả code không được bỏ trống.',
                ]
            ]
        ])) {
            // Load validation
            return redirect()->route('couponAdd')->withInput();
        }

        // Lấy giá trị
        $code = $this->request->getVar('code');
        $price_discount = $this->request->getVar('price_discount');
        $code_limit = $this->request->getVar('code_limit');
        $expiration_date = $this->request->getVar('expiration_date');
        $price_payment_limit = $this->request->getVar('price_payment_limit');
        $code_description = $this->request->getVar('code_description');

        $data = array(
            'code' => $code,
            'price_discount' => $price_discount,
            'code_limit' => $code_limit,
            'user_used' => 0,
            'expiration_date' => $expiration_date,
            'price_payment_limit' => $price_payment_limit,
            'code_description' => $code_description,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        );

        $this->mcoupon->save($data); // save (insert update)
        session()->setFlashdata('success', 'Coupon đã được thêm.');
        return redirect()->route('couponIndex');
    }

    public function edit($id)
    {
        
        $id = intval($id);
        $row = $this->mcoupon->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $data['row'] = $row;
        $data['validation'] = $this->validation;    
        return view('backend/coupon/edit', $data);
    }

    public function postEdit($id)
    {
        $row = $this->mcoupon->find($id);
        if (!$this->validate([
            'code' => [
                'rules' => 'required|max_length[30]|min_length[3]',
                'errors' => [
                    'required' => 'Mã code không được bỏ trống.',
                    'max_length' => 'Mã code không được vượt quá 30 ký tự.',
                    'min_length' => 'Mã code không được dưới 3 ký tự.',
                ]
            ],
            'price_discount' => [
                'rules' => 'required|is_numeric|integer|is_natural',
                'errors' => [
                    'required' => 'Số tiền giảm giá không được bỏ trống.',
                    'is_numeric' => 'Số tiền giảm giá phải là ký tự ký số.',
                    'integer' => 'Số tiền giảm giá phải là số nguyên.',
                    'is_natural' => 'Số tiền giảm giá phải là số dương.',
                ]
            ],
            'code_limit' => [
                'rules' => 'required|is_numeric|integer|is_natural',
                'errors' => [
                    'required' => 'Giới hạn nhập không được bỏ trống.',
                    'is_numeric' => 'Giới hạn nhập phải là ký tự ký số.',
                    'integer' => 'Giới hạn nhập phải là số nguyên.',
                    'is_natural' => 'Giới hạn nhập phải là số dương.',
                ]
            ],
            'expiration_date' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Ngày hết hạn không được bỏ trống.',
                ]
            ],
            'price_payment_limit' => [
                'rules' => 'required|is_numeric|integer|is_natural',
                'errors' => [
                    'required' => 'Số tiền được nhập code không được bỏ trống.',
                    'is_numeric' => 'Số tiền được nhập code phải là ký tự ký số.',
                    'integer' => 'Số tiền được nhập code phải là số nguyên.',
                    'is_natural' => 'Số tiền được nhập code phải là số dương.',
                ]
            ],
            'code_description' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Mô tả code không được bỏ trống.',
                ]
            ]
        ])) {
            // Load validation
            return redirect()->back()->withInput();
        }

        // Lấy giá trị
        $code = $this->request->getVar('code');
        $price_discount = $this->request->getVar('price_discount');
        $code_limit = $this->request->getVar('code_limit');
        $expiration_date = $this->request->getVar('expiration_date');
        $price_payment_limit = $this->request->getVar('price_payment_limit');
        $code_description = $this->request->getVar('code_description');

        $data = array(
            'id' => $row['id'],
            'code' => $code,
            'price_discount' => $price_discount,
            'code_limit' => $code_limit,
            'expiration_date' => $expiration_date,
            'price_payment_limit' => $price_payment_limit,
            'code_description' => $code_description,
        );

        $this->mcoupon->save($data); // save (insert update)
        session()->setFlashdata('success', 'Coupon đã được cập nhật.');
        return redirect()->route('couponIndex');
    }

    public function status($id)
    {
        
        $id = intval($id);
        $row = $this->mcoupon->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $status = ($row['status'] == 1) ? 0 : 1;
        $data = array(
            'id' => $row['id'],
            'status' => $status
        );
        $this->mcoupon->save($data); // save (insert update)
        session()->setFlashdata('success', 'Trạng thái của coupon đã được cập nhật.');
        return redirect()->route('couponIndex');
    }

    public function delete($id)
    {
        
        $id = intval($id);
        // Lấy về chi tiết thông tin
        $row = $this->mcoupon->find($id);
        if(!$row) {
            return view('backend/error');
        }
    
        $this->mcoupon->delete($id);
        session()->setFlashdata('success', 'Đã xoá vĩnh viễn coupon "' . $row['code'] . '".');
        return redirect()->route('couponIndex');
    }

    //--------------------------------------------------------------------

}
