<?php

namespace App\Controllers;
// Use BaseController
use App\Controllers\BaseController;
use App\Models\Mproduct;
use App\Models\Mcoupon;

class CartController extends BaseController
{
	public function __construct()
	{
		$this->mproduct = new Mproduct();
		$this->mcoupon = new Mcoupon();
	}

	public function index()
	{
		if (session()->has('cart')) {
			$cart = session()->get('cart');
			$data['cart'] = $cart;
		}

		if(session()->get('coupon')) {
			$couponId = session()->get('couponId');
			$get_used = $this->mcoupon->getUserUsed($couponId);
			// Tăng số lượng người sử dụng lên 1
			$data = array(
				'id' => $couponId,
				'user_used' => $get_used + 1,
			);
			$this->mcoupon->save($data);
		}

		// load view
		$data['mproduct'] = $this->mproduct;

		return view('frontend/cart/index', $data);
	}

	public function showTotal()
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
			}

			$show .= '<tr>
		<td>'. lang('App.frontend.cart.cartTotal') .' :</td>
		<td>' . $subTotal . ' VNĐ</td>
	</tr>
	<tr>
		<td>'. lang('App.frontend.cart.shipping') .' :</td>
		<td>50.000 VNĐ</td>
	</tr>';
	if(session()->has('coupon')) {
		$show .= '<tr>
		<td>'. lang('App.frontend.cart.coupon') .' :</td>
		<td>'.number_format($coupon, 0, ",", ".").' VNĐ</td>
	</tr>';
	} else {
		$show .= '<tr>
		<td>'. lang('App.frontend.cart.coupon') .' :</td>
		<td>0 VNĐ</td>
	</tr>';
	}
	$show .= ' <tr>
		<td>'. lang('App.frontend.cart.tax') .' : </td>
		<td>10%</td>
	</tr>
	<tr>
		<th>'. lang('App.frontend.cart.subTotal') .' :</th>
		<th>' . $subTotalTax . ' VNĐ</th>
	</tr>';
			echo $show;
		} else {
			$show = '';
			$show .= '<tr>
		<td>'. lang('App.frontend.cart.cartTotal') .' :</td>
		<td>0 VNĐ</td>
	</tr>
	<tr>
		<td>'. lang('App.frontend.cart.shipping') .' :</td>
		<td>0 VNĐ</td>
	</tr>
	<tr>
		<td>'. lang('App.frontend.cart.coupon') .' :</td>
		<td>0 VNĐ</td>
	</tr>
	<tr>
		<td>'. lang('App.frontend.cart.tax') .' : </td>
		<td>0%</td>
	</tr>
	<tr>
		<th>'. lang('App.frontend.cart.subTotal') .' :</th>
		<th>0 VNĐ</th>
	</tr>';
			echo $show;
		}
	}

	public function showCartQuantity()
	{
		if (session()->get('cart')) {
			$cart = session()->get('cart');
			$show = '';
			$quantity = count($cart);
			$total = 0;
			foreach ($cart as $key => $val) {
				$item = $this->mproduct->where(['status' => 1, 'trash' => 1])->find($key);
				$priceOne = $item['price'] - ($item['price'] * ($item['sale'] / 100));
				$price = $priceOne * $val;
				$total += $price;
				$changePrice = number_format($total, 0, ",", ".");
			}
			$show .= '<span class="text-capitalize"> ' . $quantity . ' '. lang('App.frontend.nav.item') .' </span> -
			' . $changePrice . ' VNĐ';
			echo $show;
		} else {
			$show = '';
			$show .= '<span class="text-capitalize"> 0 '. lang('App.frontend.nav.item') .'</span> - 0 VNĐ';
			echo $show;
		}
	}

	public function showCartData()
	{
		if (session()->get('cart')) {
			$cart = session()->get('cart');

			$show = '';
			foreach ($cart as $key => $val) {
				$item = $this->mproduct->where(['status' => 1, 'trash' => 1])->find($key);
				$priceOne = $item['price'] - ($item['price'] * ($item['sale'] / 100));
				$price = $priceOne * $val;
				$changePrice = number_format($price, 0, ",", ".");
				$show .= ' <tr>
				<td>
					<img src="' . base_url('uploads/product/' . $item['thumb']) . '" alt="' . $item['name'] . '" title="product-img" class="img-thumbnail" />
				</td>
				<td>
					<h5 class="mt-0 mb-1 text-truncate">
						<a href="' . base_url('san-pham/' . $item['slug']) . '" class="text-body text-capitalize">' . $item['name'] . '</a>
					</h5>
				</td>
				<td class="text-truncate">' . number_format($priceOne, 0, ",", ".") . ' VNĐ</td>
				<td>
					<div class="qtyField pr-3 d-flex justify-content-center">
						<a class="qtyBtn minus border-right-0" href="javascript:void(0);">
							<i class="fa fa-minus" aria-hidden="true"></i>
						</a>
						<input type="text" id="' . $item['id'] . '" name="quantity" value="' . $val . '" class="form-control border-radius-0 qty border-right-0 border-left-0 editQuantity" readonly="">
						<a class="qtyBtn plus border-left-0" href="javascript:void(0);">
							<i class="fa fa-plus" aria-hidden="true"></i>
						</a>
					</div>
				</td>
				<td class="text-truncate">' . $changePrice . ' VNĐ</td>
				<td>
					<a href="javascript:void(0);" class="action-icon text-danger delCart" id="' . $item['id'] . '">
						<i class="fa fa-trash" aria-hidden="true"></i></a>
				</td>
			</tr>
			';
			}
			echo $show;
		} else {
			$show = '';
			$show .= '
			<tr>
				<td colspan="6" class="text-danger text-center text-capitalize mt-2">Giỏ hàng trống</td>
			</tr>';
			echo $show;
		}
	}


	public function showCart()
	{
		if (session()->get('cart')) {
			$cart = session()->get('cart');

			$show = '';
			foreach ($cart as $key => $val) {
				$item = $this->mproduct->where(['status' => 1, 'trash' => 1])->find($key);
				$priceOne = $item['price'] - ($item['price'] * ($item['sale'] / 100));
				$price = $priceOne * $val;
				$changePrice = number_format($price, 0, ",", ".");
				$show .= ' <div class="row mt-2 d-flex align-items-center justify-content-center">
				<div class="col-3">
					<a href="' . base_url('san-pham/' . $item['slug']) . '" class="header__product-thumb">
						<img src="' . base_url('uploads/product/' . $item['thumb']) . '" class="img-fluid" alt="' . $item['name'] . '" />
					</a>
				</div>
	
				<div class="col-4">
					<p class="header__product-name text-capitalize">
					' . $item['name'] . '
					</p>
				</div>
	
				<div class="col-1">
					<div class="header__product-quantity">' . $val . '</div>
				</div>
	
				<div class="col-3">
					<div class="header__product-price"> ' . $changePrice . '</div>
				</div>

				<div class="col-1 p-0">
					<a href="javascript:void(0)" class="delCart" id="' . $item['id'] . '">
						<i class="fa fa-trash" aria-hidden="true"></i>
					</a>
				</div>
			</div>
			';
			}
			echo $show;
		} else {
			$show = '';
			$show .= ' <div class="row">
			<div class="col-12">
				<h2 class="text-danger text-center text-capitalize mt-2">Giỏ hàng trống</h2>
			</div>
		</div>';
			echo $show;
		}
	}

	public function add()
	{
		if ($this->request->isAJAX()) { // nếu yêu cầu xử lý ajax thì thực hiện
			// Lấy thuộc tính 
			$id = $this->request->getVar('id');
			// Kiểm tra giỏ hang
			if (session()->get('cart')) {
				$cart = session()->get('cart');
				// Nếu đã có sản phẩm đó trong giỏ thì sản phẩm đó sẽ tăng 1 đơn vi
				if (array_key_exists($id, $cart)) {
					$cart[$id]++;
				} else {
					$cart[$id] = 1; // Chưa có thì sẽ bắt đầu là 1
				}
			} else {
				$cart[$id] = 1;
			}
			session()->set('cart', $cart);
			echo json_encode($cart);
		}
	}

	public function edit()
	{
		// Lấy id
		$id = $this->request->getVar('id');
		// Kiểm tra giỏ hang
		if (session()->get('cart')) {
			$cart = session()->get('cart');
			if (array_key_exists($id, $cart)) {
				$cart[$id] = (int) ($this->request->getVar('sl'));
			}
		}
		session()->set('cart', $cart);
		echo json_encode($cart);
	}

	public function delete()
	{
		// Lấy id
		$id = $this->request->getVar('id');
		// Kiểm tra giỏ hang
		if (session()->get('cart')) {
			$cart = session()->get('cart');
			if ($cart[$id]) {
				unset($cart[$id]);
			}
		}
		session()->set('cart', $cart);
		session()->set('coupon');
		echo json_encode($cart);
	}

	public function coupon()
	{
		if ($this->request->isAJAX()) {
			$coupon = $this->request->getVar('coupon');
			$show = '';
			if (session()->has('coupon')) { // kiểm tra mã giảm giá này đax sử dụng hay chưa
				$show .= 'Mã giảm giá này đã được sử dụng qua rồi.';
			} else {
				// Nếu chưa nhập coupon mà apply thì báo lõi
				if (empty($coupon)) {
					$show .= 'Bạn chưa nhập mã giảm giá.';
				} else {
					// lấy toàn bộ thông tin trong bảng coupon để kiểm tra
					$couponGetAll = $this->mcoupon->where(['status' => 1, 'code' => $coupon])->findAll();
					if (empty($couponGetAll)) { // ko tồn tại báo lõi
						$show .= 'Mã giãm giá không tồn tại.';
					} else {
						// nếu coupopn có tồn tại trong csdl thì kiểm tra tiếp
						if (session()->get('cart')) {
							$cart = session()->get('cart');
							$show = '';
							$total = 0;
							foreach ($cart as $key => $val) {
								$item = $this->mproduct->where(['status' => 1, 'trash' => 1])->find($key);
								$priceOne = $item['price'] - ($item['price'] * ($item['sale'] / 100));
								$price = $priceOne * $val;
								$total += $price;
								$changePrice = $total + ($total * (10 / 100)) + 50000;
							}
						}
						foreach ($couponGetAll as $item) {
							$now = strtotime(date('Y-m-d H:i:s'));
							$getdate_coupon = strtotime($item['expiration_date']);
							// giới hạn nhậP - người đã nhập <= 0 thì mã không hoạt đọng
							if ($item['code_limit'] - $item['user_used'] == 0) {
								$show .= 'Mã giảm giá đã hết lượt sử dụng.';
								//NếU số tiền cho phép nhập không đủ thì báo lỗi
							} else if ($getdate_coupon <= $now) {
								$show .= 'Mã giảm giá này đã hết hạn từ ngày ' . $item['expiration_date'];
							} else if ($item['price_payment_limit'] >= $changePrice) {
								$show .= 'Mã giảm giá này chỉ áp dụng cho đơn hàng từ ' . number_format($item['price_payment_limit'], 0, ",", ".") . ' VNĐ trở lên.';
							} else {
								// nếu tất cả đieu kiện đều thảo mã
								$show .= '<script>toastr.options = {
								"closeButton": true,
								"debug": false,
								"newestOnTop": false,
								"progressBar": true,
								"positionClass": "toast-bottom-right",
								"preventDuplicates": false,
								"onclick": null,
								"showDuration": "300",
								"hideDuration": "1000",
								"timeOut": "5000",
								"extendedTimeOut": "1000",
								"showEasing": "swing",
								"hideEasing": "linear",
								"showMethod": "fadeIn",
								"hideMethod": "fadeOut"
							}
							toastr["success"]("Mã giám giá đang được kích hoạt");';

								// Đặt session để thực hiện giảm giá
								$arr = array(
									'coupon' => $item['price_discount'],
									'couponId' => $item['id']
								);
								session()->set($arr);
							}
						}
					}
				}
			}
			echo json_encode($show);
		}
	}
}
