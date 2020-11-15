<?php
// Use Controller Folder Admin
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
// Use Model
use App\Models\Muser;
use App\Models\Mcontact;
use App\Models\Mproduct;
use App\Models\Morder;
use App\Models\Morderdetail;

class DashboardController extends BaseController
{
	public function __construct()
    {
		$this->muser = new Muser();
		$this->mcontact = new Mcontact();
		$this->mproduct = new Mproduct();
		$this->morderdetail = new Morderdetail();
		$this->morder = new Morder();
    }

	public function index()
	{
		$data['userCount'] = $this->muser->findAll();
		$data['contactCount'] = $this->mcontact->findAll();
		$data['productCount'] = $this->mproduct->findAll();
		$data['orderCount'] = $this->morder->findAll();

		$today = getdate(); // láy thời gian hiện tia
		$year = $today['year']; // Lấy năm hiện tại
		$data['year'] = $year;
		$day = $today['mday']; // ngày hiện tại
		$month = $today['mon']; // tháng hiện tại
		$list = $this->morder->where(['status' => 2, 'DAY(orderdate)' => $day, 'MONTH(orderdate)' => $month, 'YEAR(orderdate)' => $year])->findAll(); 
		$sum = 0; // tính tổng sl 
		// tính doanh thu ngày
		foreach ($list as $item) {
			$sum += $item['money'];
		}
		$data['getdate'] = $day . '/' . $month . '/' . $year;
		$data['total_day'] = $sum; 

		// tính đoanh thu tuần
		$sum_week = 0; // tính tổng sl 
		$week = date('W') - 1; // Bắt từ tuần 0 nên phải trừ 1
		$list_week = $this->morder->where(['status' => 2, 'WEEK(orderdate)' => $week, 'MONTH(orderdate)' => $month, 'YEAR(orderdate)' => $year])->findAll(); 
		// tính doanh thu tuần
		foreach ($list_week as $item) {
			$sum_week += $item['money'];
		}
		$data['getweek'] = 'Tuần thứ ' . $week . ' năm ' . $year;
		$data['total_week'] = $sum_week; 

		// tính torng odanh thu tháng
		$list_month = $this->morder->where(['status' => 2, 'MONTH(orderdate)' => $month, 'YEAR(orderdate)' => $year])->findAll(); 
		$sum_month = 0; // tính tổng sl 
		// tính doanh thu tháng
		foreach ($list_month as $item) {
			$sum_month += $item['money'];
		}
		$data['getmonth'] = $month . '/' . $year;
		$data['total_month'] = $sum_month; 

		// tính torng odanh thu nam
		$list_year = $this->morder->where(['status' => 2, 'YEAR(orderdate)' => $year])->findAll(); 
		$sum_year = 0; // tính tổng sl 
		// tính doanh thu tháng
		foreach ($list_year as $item) {
			$sum_year += $item['money'];
		}
		$data['getyear'] = $year;
		$data['total_year'] = $sum_year; 
		$data['morder'] = $this->morder;
		$data['morderdetail'] = $this->morderdetail;

		// đếm số đơn hàng chưa duyệt
		$data['status_0'] = $this->morder->where('status', 0)->findAll();
		// đếm số đơn hàng đã duyệt và đang giao hàng
		$data['status_1'] = $this->morder->where('status', 1)->findAll();
		// đếm số đơn hàng giao hàng thành công
		$data['status_2'] = $this->morder->where('status', 2)->findAll();
		// đếm số đơn hàng khách huỷ
		$data['status_3'] = $this->morder->where('status', 3)->findAll();
		// đếm số đơn hàng adim huỷ
		$data['status_4'] = $this->morder->where('status', 4)->findAll();
		return view('backend/dashboard/index', $data);
	}

	//--------------------------------------------------------------------

}
