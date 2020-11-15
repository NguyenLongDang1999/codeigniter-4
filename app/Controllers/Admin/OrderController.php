<?php
// Use Controller Folder Admin
namespace App\Controllers\Admin;
// Use BaseController
use App\Controllers\BaseController;
// Use Model
use App\Models\Morder;
use App\Models\Morderdetail;
use App\Models\Mproduct;
use App\Models\Muser;
use App\Models\Mdistrict;
use App\Models\Mprovince;

class orderController extends BaseController
{
    public function __construct()
    {
        $this->morder = new Morder();
        $this->morderdetail = new Morderdetail();
        $this->mproduct = new Mproduct();
        $this->muser = new Muser();
        $this->mdistrict = new Mdistrict();
        $this->mprovince = new Mprovince();
    }

    public function index()
    {
        $data['list'] = $this->morder->where('trash', 1)->orderBy('orderdate', 'desc')->findAll();
        $data['muser'] = $this->muser;
        return view('backend/orders/index', $data);
    }

    public function saved()
    {
        $data['list'] = $this->morder->where('trash', 0)->orderBy('orderdate', 'desc')->findAll();
        $data['muser'] = $this->muser;
        return view('backend/orders/saved', $data);
    }

    public function status($id)
    {
         // Lấy id trên đường dẫn url
        $id = intval($id);
        $row = $this->morder->find($id); // lấy toàn bộ thôg tin đặt hàng
        if(!$row) {
            return view('backend/error');
        }
        if($row['status'] == 0) { // nếu status == 0 edit = 1
            $data = array(
                'id' => $row['id'],
                'status' => 1
            );
            $this->morder->save($data);
            session()->setFlashdata('success', 'Đơn hàng #' .$row['ordercode'] . ' đã duyệt và đang bắt đầu giao hàng.');
        } else if($row['status'] == 1) {
            $data = array(
                'id' => $row['id'],
                'status' => 2
            );
            $this->morder->save($data);

            // sau khi cập nhật đã giao hàng thanh toán
            // sản phẩm nào đã giao hàng sẽ bị trừ ra 
            $listOrder = $this->morderdetail->where(['orderid' => $id])->findAll();
            foreach ($listOrder as $item) {
                $qty = $item['qty']; // lấy số lượng sản phẩm khi thanh toán
                // Lấy số lượng number_buy + số lượng sản phẩm đơn hàng
                $number_buy = $this->mproduct->productUpdateNumberBuy($item['productid']); //truyền vào cột id sản phẩm
                $total = $qty + $number_buy;
                $data1 = array(
                    'id' => $item['productid'],
                    'number_buy' => $total,
                );
                $this->mproduct->save($data1);
            }
            session()->setFlashdata('success', 'Đơn hàng #' .$row['ordercode'] . ' đã giao hàng và thanh toán thành công.');
        }
        return redirect()->route('orderIndex');
    }

    public function detail($id)
    {
         // Lấy id trên đường dẫn url
        $row = $this->morder->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $data['province'] = $this->mprovince->provinceGetName($row['province']);
        $data['district'] = $this->mdistrict->districtGetName($row['district']);
        $data['listProduct'] = $this->morderdetail->where(['orderid' => $id])->findAll();
        $data['mproduct'] = $this->mproduct;
        $data['row'] = $row;
        $data['muser'] = $this->muser;
        return view('backend/orders/detail', $data);
    }

    public function cancel($id)
    {
         // Lấy id trên đường dẫn url
        $id = intval($id);
        $row = $this->morder->find($id);
        if(!$row) {
            return view('backend/error');
        }
        if($row['status'] == 0) { // nếu status == 0 edit = 1
            $data = array(
                'id' => $row['id'],
                'status' => 4
            );
            $this->morder->save($data);
            session()->setFlashdata('success', 'Đơn hàng #' .$row['ordercode'] . ' đã huỷ.');
        } else if($row['status'] == 1) {
            $data = array(
                'id' => $row['id'],
                'status' => 4
            );
            $this->morder->save($data);
            session()->setFlashdata('success', 'Đơn hàng #' .$row['ordercode'] . ' đã huỷ.');
        }
        return redirect()->route('orderIndex');  
    }

    public function saves($id)
    {
         // Lấy id trên đường dẫn url
        $id = intval($id);
        $row = $this->morder->find($id);
        if(!$row) {
            return view('backend/error');
        }
        if($row['trash'] == 1) { 
            $data = array(
                'id' => $row['id'],
                'trash' => 0
            );
            $this->morder->save($data);
            session()->setFlashdata('success', 'Đơn hàng #' .$row['ordercode'] . ' đã được lưu vào danh sách đã lưu thành công.');
        }
        return redirect()->route('orderIndex');
    }

    public function restore($id)
    {
         // Lấy id trên đường dẫn url
        $id = intval($id);
        $row = $this->morder->find($id);
        if(!$row) {
            return view('backend/error');
        }
        if($row['trash'] == 0) { 
            $data = array(
                'id' => $row['id'],
                'trash' => 1
            );
            $this->morder->save($data);
            session()->setFlashdata('success', 'Đơn hàng #' .$row['ordercode'] . ' đã được bỏ lưu ra khỏi danh sách đã lưu thành công.');
        }
        return redirect()->route('orderSaved');
    }

    public function delete($id)
    {
         // Lấy id trên đường dẫn url
        $id = intval($id);
        $row = $this->morder->find($id);
        if(!$row) {
            return view('backend/error');
        }

        $this->morder->delete($id);
        session()->setFlashdata('success', 'Đã xoá vĩnh viễn đơn hàng #"' . $row['ordercode'] . '".');
        return redirect()->route('orderSaved');
    }

    //--------------------------------------------------------------------

}
