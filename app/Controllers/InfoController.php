<?php

namespace App\Controllers;
// Use BaseController
use App\Controllers\BaseController;
use App\Models\Mproduct;
use App\Models\Mdistrict;
use App\Models\Morder;
use App\Models\Morderdetail;
use App\Models\Mprovince;
use App\Models\Muser;

class InfoController extends BaseController
{
    public function __construct()
    {
        $this->mproduct = new Mproduct();
        $this->morder = new Morder();
		$this->morderdetail = new Morderdetail();
        $this->mdistrict = new Mdistrict();
        $this->mprovince = new Mprovince();
        $this->muser = new Muser();
        $this->validation = \Config\Services::validation();
        $this->email = \Config\Services::email(); //s ử dụng email
    }

    public function index()
    {
        // ko đăng nhập bij đảy ra
        if(session()->get('userAll')) {
            $data['row'] = session()->get('userAll');       
            $userId = session()->get('userId');
        } else {
            return redirect()->route('productIndexFE'); 
        }

        // lấy danh sách đơn hàng chưa duyệt
		$data['listOrderNotSuccess'] = $this->morder->where(['status' => 0, 'userid' => $userId])->orderBy('orderdate', 'desc')->findAll();
		// lấy danh sách đơn hàng đã duyệt
		$data['listOrderSuccess'] = $this->morder->where(['status !=' => 0, 'userid' => $userId])->orderBy('orderdate', 'desc')->findAll();

        return view('frontend/info/index', $data);
    }

    public function edit($id)
    {
        // không đăng nhập bị đẩy qua đăng nhập
        if(!session()->has('userAll')) {
            return redirect()->route('productIndexFE'); 
        }
        $row = $this->muser->find($id);

        if(!$row) {
            return view('backend/error');
        }

        $data['row'] = $row;
        $data['validation'] = $this->validation;    
        return view('frontend/info/edit', $data);
    }

    public function postEdit($id)
    {
        $row = $this->muser->find($id);

        if(!$row) {
            return view('backend/error');
        }

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
                'rules' => 'required|max_length[255]|valid_emails',
                'errors' => [
                    'required' => lang('App.frontend.login.validate.email.required'),
                    'max_length' => lang('App.frontend.login.validate.email.max'),
                    'valid_emails' => lang('App.frontend.login.validate.email.valid'),
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
            'address' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Địa chỉ sinh sống không được bỏ trống.'
                ]
            ],
            'thumb' => [
                'rules' => 'max_size[thumb,1024]|is_image[thumb]|mime_in[thumb,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'max_size' => 'Ảnh không phù hợp với kích thước.',
                    'is_image' => 'Tệp bạn upload không phải là hình ảnh.',
                    'mime_in' => 'Tệp bạn upload không phải là hình ảnh.'
                ]
            ]
        ])) {
            return redirect()->back()->withInput();
        }

        $fullname = $this->request->getVar('fullname');
        $email = $this->request->getVar('email');
        $phone = $this->request->getVar('phone');
        $address = $this->request->getVar('address');
        $upload_thumb = $this->request->getFile('thumb');
        // Kiểm tra ảnh cũ 
        if ($upload_thumb->getError() == 4) {
            $thumb = $this->request->getVar('checkImg');
        } else {
            // Sinh ra tên ngẫu nhiên cho ảnh
            $thumb = $upload_thumb->getRandomName();
            // move tới file lưu ảnh
            $upload_thumb->move('uploads/user', $thumb);
            // Sau khi sửa sẽ xoá ảnh cũ
            if ($row['thumb'] != 'default-image.jpg' && $row['thumb'] != '') {
                unlink('uploads/user/' . $this->request->getVar('checkImg'));
            }
        }

        $data = array(
            'id' => $row['id'],
            'fullname' => $fullname,
            'email' => $email,
            'phone' => $phone,
            'thumb' => $thumb,
            'address' => $address,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        $this->muser->save($data);
        session()->setFlashdata('success', 'Thông tin cá nhân của bạn đã được cập nhật.');
        return redirect()->back()->withInput();
    }

    public function resetPassword($id)
    {
        // không đăng nhập bị đẩy qua đăng nhập
        if(!session()->has('userAll')) {
            return redirect()->route('productIndexFE'); 
        }
        $row = $this->muser->find($id);

        if(!$row) {
            return view('backend/error');
        }

        $data['row'] = $row;
        $data['validation'] = $this->validation;    
        return view('frontend/info/resetPassword', $data);
    }

    public function postResetPassword($id)
    {
        // không đăng nhập bị đẩy qua đăng nhập
        if(!session()->has('userAll')) {
            return redirect()->route('productIndexFE'); 
        } else {
            $row = $this->muser->find($id);
        }

        if(!$this->validate([
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Mật khẩu cũ không được bỏ trống.',
                ]
			],
			'passwordNew' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Mật khẩu mới không được bỏ trống.',
                ]
			],
			'rePasswordNew' => [
                'rules' => 'matches[passwordNew]',
                'errors' => [
                    'matches' => 'Xác nhận mật khẩu không trùng khớp.',
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }
        
        $password = md5($this->request->getVar('password'));
        $passwordNew = md5($this->request->getVar('passwordNew'));

        // Neu mat khau cu khong trung khop thi bao loi
        if($password != $row['password']) {
            session()->setFlashdata('error', 'Mật khẩu cũ không trùng khớp vui lòng thử lại.');
        } else {
            $data = array(
                'id' => $row['id'],
                'password' => $passwordNew,
            );

            $this->muser->save($data);
            session()->setFlashdata('success', 'Mât khẩu của bạn đã được cập nhật thành công.');
        }
        return redirect()->back();
    }

    public function forgotPassword()
    {
        $data['validation'] = $this->validation;    
        return view('frontend/info/forgot', $data);
    }

    public function getForgotPassword($id)
    {
        $data['validation'] = $this->validation;    
        $data['row'] = $this->muser->find($id);
        return view('frontend/info/getForgot', $data);
    }

    public function getPostForgotPassword($id)
    {
        $row = $this->muser->find($id);

        if(!$this->validate([
			'passwordNew' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Mật khẩu mới không được bỏ trống.',
                ]
			],
			'rePasswordNew' => [
                'rules' => 'matches[passwordNew]',
                'errors' => [
                    'matches' => 'Xác nhận mật khẩu không trùng khớp.',
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }

        $passwordNew = md5($this->request->getVar('passwordNew'));
        $data = array(
            'id' => $row['id'],
            'password' => $passwordNew
        );
        $this->muser->save($data);
        session()->setFlashdata('success', 'Mật khẩu đã được cập nhật. Bạn có thể đăng nhập');
        return redirect()->back();
    }

    public function postForgotPassword()
    {
        if(!$this->validate([
            'email' => [
                'rules' => 'required|max_length[255]|valid_emails',
                'errors' => [
                    'required' => lang('App.frontend.login.validate.email.required'),
                    'max_length' => lang('App.frontend.login.validate.email.max'),
                    'valid_emails' => lang('App.frontend.login.validate.email.valid'),
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        } 

        $email = $this->request->getVar('email');
        $row = $this->muser->userGetEmail($email);
        if(isset($row)) {
            $this->email->setFrom('emarketstore2020@gmail.com', 'TopDeal Store');
            $this->email->setTo($email); // Gửi đến mail vừa đăng ký
            $subject= 'TopDeal Store - Lấy lại mật khẩu';
            $this->email->setSubject($subject); 
            $message = 'Chào bạn,<br><br>Vui lòng nhấp vào link dưới đây để lấy lại mật khẩu<br><br>
            <a href=' . base_url(route_to('infoGetForgotPassword', $row['id'])) . '>' . base_url(route_to('infoGetForgotPassword', $row['id'])) . '</a><br><br>Cảm ơn.';
            $this->email->setMessage($message);
            $this->email->send();
            if (!$this->email->send())
            {
                $this->email->printDebugger(['headers']);
            }
            session()->setFlashdata('success', 'Vui lòng kiểm tra Email để lấy lại mật khẩu.');
        } else {
            session()->setFlashdata('error', 'Email này không phải là thành viên trong cửa hàng. Bạn vui lòng lấy Email dùng để đăng ký để lấy lại mật khẩu.');
        }
        return redirect()->back();
    }

    public function detail($id)
	{
		// không đăng nhập bị đẩy qua đăng nhập
        if(!session()->has('userAll')) {
            return redirect()->route('productIndexFE'); 
        }
		
        $row = $this->morder->find($id);

        if(!$row) {
            return view('backend/error');
        }

        $data['row'] = $row;
        $data['province'] = $this->mprovince->provinceGetName($row['province']);
        $data['district'] = $this->mdistrict->districtGetName($row['district']);
        $data['listOrder'] = $this->morderdetail->where(['orderid' => $id])->findAll();
        $data['mproduct'] = $this->mproduct;
        $data['user'] = $this->muser->orderGetUserid($row['userid']);
		return view('frontend/info/detail', $data);
	}	

    public function delete($id)
    {
        // không đăng nhập bị đẩy qua đăng nhập
        if(!session()->has('userAll')) {
            return redirect()->route('productIndexFE'); 
        }
        $row = $this->morder->find($id);

        if(!$row) {
            return view('backend/error');
        }

        $data = array(
            'id' => $row['id'],
            'status' => 3,
        );

        $this->morder->save($data);
        return redirect()->route('infoIndex');  
    }

    public function checkout()
    {
        // ko đăng nhập bij đảy ra
        if(!session()->get('userAll')) {
            return redirect()->route('productIndexFE');
        } else {
            $data['row'] = session()->get('userAll');
        }
        
        // giỏ hàng ko có sản phẩm bị đẩy ra 
        if(!session()->get('cart')) {
            return redirect()->route('productIndexFE');
        }

        // load view
        $data['provinceAll'] = $this->mprovince->findAll();
        $data['validation'] = $this->validation;
        return view('frontend/info/checkout', $data);
    }

    public function postCheckout()
    {
        if (!$this->validate([
            'address' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Địa chỉ nhận hàng không được bỏ trống.',
                ]
            ],
            'provinceid' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tỉnh/Thành phố không được bỏ trống.',
                ]
            ],
            'district' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Quận/Huyện không được bỏ trống.',
                ]
            ],
        ])) {
            // Load validation
            return redirect()->route('checkoutIndex')->withInput();
        }

        // lấy giỏ hàng 
        if (session()->get('cart')) {
            $cart = session()->get('cart');
            $total = 0;
            foreach ($cart as $key => $val) {
                $item = $this->mproduct->where(['status' => 1, 'trash' => 1])->find($key);
                $priceOne = $item['price'] - ($item['price'] * ($item['sale'] / 100));
                $price = $priceOne * $val;
                $total += $price;
                if (session()->has('coupon')) {
                    $coupon = session()->get('coupon');
                    $changePrice = ($total + ($total * (10 / 100)) + 50000) - $coupon;
                } else {
                    $coupon = 0;
                    $changePrice = $total + ($total * (10 / 100)) + 50000;
                }
            }
        }

        if(session()->get('userAll')) {
            $userId = session()->get('userId');
        }
        
		$getData = array(
			'ordercode' => random_string('alnum', 5), // sử dụng helper text để mã hoá
            'userid' => $userId,
            'orderdate' => date('Y-m-d H:i:s'),
            'money' => $changePrice,
            'coupon' => $coupon,
            'price_ship' => 50000,
            'address' => $this->request->getVar('address'),
            'province' => $this->request->getVar('provinceid'),
            'district' => $this->request->getVar('district'),
            'status' => 0,
            'trash' => 1
        );
        
        $this->morder->save($getData); // tiến hành thêm vao bảng order
        // thêm vào chi tiết hoá dơn
		$orderGetid = $this->morder->orderUserid($userId); // lấy về id orderid
        $orderid = $orderGetid['id'];
        // lấy giỏ hàng 
		if(session()->has('cart')) {
			$cart = session()->get('cart');
			foreach ($cart as $key => $val) {
                $item = $this->mproduct->where(['status' => 1, 'trash' => 1])->find($key);
                $priceOne = $item['price'] - ($item['price'] * ($item['sale'] / 100));
                $getData = array(
                    'orderid' => $orderid,
                    'productid' => $key,
                    'qty' => $val,
                    'price' => $priceOne,
                    'trash' => 1,
                    'status' => 1
                );
                $this->morderdetail->save($getData);
			}
        }
        $arr = ['cart', 'coupon', 'couponId'];
        session()->remove($arr);
        return redirect()->route('checkoutThanks'); 
    }

    public function thanks()
    {
        // ko đăng nhập bij đảy ra
        if(!session()->get('userAll')) {
            return redirect()->route('productIndexFE');
        } else {
            $data['row'] = session()->get('userAll');
            $userId = session()->get('userId');
            $userEmail = session()->get('userEmail');
            $listOrder = $this->morder->orderUserid($userId);
            $data['listOrder'] = $listOrder;
            $data['listProduct'] = $this->morderdetail->orderdetailProductid($listOrder['id']);

            // tiến hành gửi đơ n hàng về mail
			$this->email->setFrom('emarketstore2020@gmail.com', 'TopDeal Store');
			$this->email->setTo($userEmail); // Gửi đến mail
			$subject= 'TopDeal Store - Thông tin thanh toán đơn hàng';
			$this->email->setSubject($subject); 
			$message = view('layout/frontend/email', $data);
			$this->email->setMessage($message);
			$this->email->send();
			if (!$this->email->send())
			{
				$this->email->printDebugger(['headers']);
			}
        }
        return view('backend/thanks');
    }

    public function district()
    {
        if($this->request->isAJAX()) {
            // <option value=""></option>
            $provinceid = $this->request->getVar('provinceid');
            $show = '';
            $listDistrict = $this->mdistrict->where('provinceid', $provinceid)->findAll();
            foreach ($listDistrict as $item) {
                $show .= '<option value="'.$item['id'].'">'.$item['name'].'</option>';
            }
            echo $show;
        }
    }

    public function showOrder()
    {
        if (session()->get('cart')) {
            $cart = session()->get('cart');

            $show = '';
            $total = 0;
            foreach ($cart as $key => $val) {
                $item = $this->mproduct->where(['status' => 1, 'trash' => 1])->find($key);
                $priceOne = $item['price'] - ($item['price'] * ($item['sale'] / 100));
                $price = $priceOne * $val;
                $total += $price;
                if(session()->has('coupon')) {
					$coupon = session()->get('coupon');
					$changePrice = ($total + ($total * (10 / 100)) + 50000) - $coupon;
				} else {
					$changePrice = $total + ($total * (10 / 100)) + 50000;
				}
				$subTotal = number_format($total, 0, ",", ".");
                $subTotalTax = number_format($changePrice, 0, ",", ".");
                
                $show .= '<tr>
                <td style="width: 80px;">
                    <img src="'.base_url('uploads/product/'.$item['thumb']).'" alt="'.$item['name'].'" title="product-img" class="rounded" height="48">
                </td>
                <td>
                    <a href="'.base_url('san-pham/'.$item['slug']).'" class="text-body font-weight-semibold" style="display: -webkit-box;
                    -webkit-box-orient: vertical;
                    -webkit-line-clamp: 2;
                    width: 150px;
                    height: 50px;
                    overflow: hidden;">'.$item['name'].'</a>
                    <small class="d-block">'.$val.' x '.number_format($priceOne, 0, ",", ".").' VNĐ</small>
                </td>

                <td class="text-right">
                    '.number_format($price, 0, ",", ".").' VNĐ
                </td>
            </tr>';
            }

            $show .= '<tr class="text-right">
            <td colspan="2">
                <h6 class="m-0 text-capitalize">Tổng cộng:</h6>
            </td>
            <td class="text-right">
            ' . $subTotal . ' VNĐ
            </td>
        </tr>
        <tr class="text-right">
            <td colspan="2">
                <h6 class="m-0 text-capitalize">Phí vận chuyển:</h6>
            </td>
            <td class="text-right">
                '.number_format(50000, 0, ",", ".").' VNĐ
            </td>
        </tr>';
        if(session()->has('coupon')) {
            $show .= '<tr class="text-right">
            <td colspan="2">
                <h6 class="m-0 text-capitalize">Mã giảm giá:</h6>
            </td>
            <td class="text-right">
                '.number_format($coupon, 0, ",", ".").' VNĐ
            </td>
        </tr>';
        } else {
            $show .= '<tr class="text-right">
            <td colspan="2">
                <h6 class="m-0 text-capitalize">Mã giảm giá:</h6>
            </td>
            <td class="text-right">
                0 VNĐ
            </td>
        </tr>';
        }
        $show .= '
        <tr class="text-right">
            <td colspan="2">
                <h5 class="m-0 text-capitalize">Thuế:</h5>
            </td>
            <td class="text-right font-weight-semibold">
                10%
            </td>
        </tr>
        <tr class="text-right">
            <td colspan="2">
                <h5 class="m-0 text-capitalize">Thành tiền:</h5>
            </td>
            <td class="text-right font-weight-semibold">
                '.$subTotalTax.' VNĐ
            </td>
        </tr>';

            echo $show;
        }
    }
}
