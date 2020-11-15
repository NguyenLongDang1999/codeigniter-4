<?php
// Sử dụng controlelr
namespace App\Controllers;
// Sử dụng BaseControlelr
use App\Controllers\BaseController;
// Load model
use App\Models\Mproduct;
use App\Models\Mcatalog;

class SearchController extends BaseController
{
    // Phần sử dụng chcung
    public function __construct()
    {
        $this->mproduct = new Mproduct();
        $this->mcatalog = new Mcatalog();
    }

    public function index()
    {
        $data['mcatalog'] = $this->mcatalog;
        // ajAx fILTER
        $filterSearch = $this->request->getVar('filterSearch'); // lấy giá trị
        $select = '';
        if (isset($filterSearch)) {
            // value option phải = tên csdl 
            $where = $this->request->getVar('filterSearch'); // lấy giá trị
            $result = explode('-', $where); // tách nó ra
            $value = $result[0];
            $order = $result[1];
            $getData = array(
                '0' => $value,
                '1' => $order
            );
            session()->set('productFilterSearch', $getData);
        } else {
            if (session()->get('productFilterSearch')) {
                $getData = session()->get('productFilterSearch');
                $value = $getData[0];
                $order = $getData[1];
                // hiển thị các otpion khi lọc
                $option = $value . '-' . $order;
                if ($option == 'created_at-desc') {
                    $select .= ' <option value="created_at-desc" selected>Mặc định</option>';
                } else {
                    $select .= ' <option value="created_at-desc">Mặc định</option>';
                }

                if ($option == 'created_at-asc') {
                    $select .= '  <option value="created_at-asc" selected>Sản phẩm cũ nhất</option>';
                } else {
                    $select .= '  <option value="created_at-asc">Sản phẩm cũ nhất</option>';
                }

                if ($option == 'name-asc') {
                    $select .= '<option value="name-asc" selected>Tên (A - Z)</option>';
                } else {
                    $select .= '  <option value="name-asc">Tên (A - Z)</option>';
                }

                if ($option == 'name-desc') {
                    $select .= '<option value="name-desc" selected>Tên (Z - A)</option>';
                } else {
                    $select .= '  <option value="name-desc">Tên (Z - A)</option>';
                }

                if ($option == 'price-asc') {
                    $select .= '<option value="price-asc" selected>Giá (Thấp -> Cao)</option>';
                } else {
                    $select .= '  <option value="price-asc">Giá (Thấp -> Cao)</option>';
                }

                if ($option == 'price-desc') {
                    $select .= '<option value="price-desc" selected>Giá (Cao -> Thấp)</option>';
                } else {
                    $select .= '  <option value="price-desc">Giá (Cao -> Thấp)</option>';
                }

                if ($option == 'view-desc') {
                    $select .= '<option value="view-desc" selected>Lượt xem (Cao -> Thấp)</option>';
                } else {
                    $select .= '  <option value="view-desc">Lượt xem (Cao -> Thấp)</option>';
                }

                if ($option == 'view-asc') {
                    $select .= '<option value="view-asc" selected>Lượt xem (Thấp -> Cao)</option>';
                } else {
                    $select .= '  <option value="view-asc">Lượt xem (Thấp -> Cao)</option>';
                }
            } else {
                $value = 'created_at';
                $order = 'desc';

                $select .= '<option value="created_at-desc" selected>Mặc định</option>
                <option value="created_at-asc">Sản phẩm cũ nhất</option>
                <option value="name-asc">Tên (A - Z)</option>
                <option value="name-desc">Tên (Z - A)</option>
                <option value="price-asc">Giá (Thấp -> Cao)</option>
                <option value="price-desc">Giá (Cao -> Thấp)</option>
                <option value="view-asc">Lượt xem (Thấp -> Cao)</option>
                <option value="view-desc">Lượt xem (Cao -> Thấp)</option>';
            }
            $data['select'] = $select;
        }
        $data['listProductNew'] = $this->mproduct->where(['status' => 1, 'trash' => 1])->orderBy('created_at', 'desc')->findAll(8);
        // lấY dữ liệu seach
        $keyword = $this->request->getVar('search');
        $data['keyword'] = $keyword;
        if ($keyword) {
            $data['productSearch'] = $this->mproduct->productSearch($keyword, $value, $order);
            $data['pager'] = $this->mproduct->pager;

            if (isset($filterSearch)) {
                $result = view('frontend/search/indexFilter', $data);
                echo json_encode($result);
            } else {
                return view('frontend/search/index', $data);
            }
        } else {
            return redirect()->route('productIndexFE');
        }
    }

    public function autocomplete()
    {
        $term = $this->request->getVar('term');

        if (isset($term)) {
            $result = $this->mproduct->where(['status' => 1, 'trash' => 1])->like('name', $term)->orderBy('created_at', 'desc')->findAll();
            if (count($result)) {
                foreach ($result as $row) {
                    $arr_result[] = $row['name'];
                }
                echo json_encode($arr_result);
            }
        }
    }

    //--------------------------------------------------------------------

}
