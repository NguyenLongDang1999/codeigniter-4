<?php

namespace App\Controllers;
// Use BaseController
use App\Controllers\BaseController;
use App\Models\Mproduct;
use App\Models\Mbrand;
use App\Models\Mcatalog;
use App\Models\Mreview;
use App\Models\Muser;

class ProductController extends BaseController
{
    public function __construct()
    {
        $this->mproduct = new Mproduct();
        $this->mbrand = new Mbrand();
        $this->muser = new Muser();
        $this->mcatalog = new Mcatalog();
        $this->mreview = new Mreview();
    }

    public function index()
    {
        $data['mcatalog'] = $this->mcatalog;
        $data['mreview'] = $this->mreview;
        // ajAx fILTER
        $filter = $this->request->getVar('filter'); // lấy giá trị
        $select = '';
        if (isset($filter)) {
            // value option phải = tên csdl 
            $where = $this->request->getVar('filter'); // lấy giá trị
            $result = explode('-', $where); // tách nó ra
            $value = $result[0];
            $order = $result[1];
            $getData = array(
                '0' => $value,
                '1' => $order
            );
            session()->set('productFilterIndex', $getData);
        } else {
            if (session()->get('productFilterIndex')) {
                $getData = session()->get('productFilterIndex');
                $value = $getData[0];
                $order = $getData[1];
                // hiển thị các otpion khi lọc
                $option = $value . '-' . $order;
                if ($option == 'created_at-desc') {
                    $select .= ' <option value="created_at-desc" selected>'.lang('App.frontend.pageProduct.selectDefault').'</option>';
                } else {
                    $select .= ' <option value="created_at-desc">'.lang('App.frontend.pageProduct.selectDefault').'</option>';
                }

                if ($option == 'created_at-asc') {
                    $select .= '  <option value="created_at-asc" selected>'.lang('App.frontend.pageProduct.selectOld').'</option>';
                } else {
                    $select .= '  <option value="created_at-asc">'.lang('App.frontend.pageProduct.selectOld').'</option>';
                }

                if ($option == 'name-asc') {
                    $select .= '<option value="name-asc" selected>'.lang('App.frontend.pageProduct.selectName1').'</option>';
                } else {
                    $select .= '  <option value="name-asc">'.lang('App.frontend.pageProduct.selectName1').'</option>';
                }

                if ($option == 'name-desc') {
                    $select .= '<option value="name-desc" selected>'.lang('App.frontend.pageProduct.selectName2').'</option>';
                } else {
                    $select .= '  <option value="name-desc">'.lang('App.frontend.pageProduct.selectName2').'</option>';
                }

                if ($option == 'price-asc') {
                    $select .= '<option value="price-asc" selected>'.lang('App.frontend.pageProduct.selectPrice1').'</option>';
                } else {
                    $select .= '  <option value="price-asc">'.lang('App.frontend.pageProduct.selectPrice1').'</option>';
                }

                if ($option == 'price-desc') {
                    $select .= '<option value="price-desc" selected>'.lang('App.frontend.pageProduct.selectPrice2').'</option>';
                } else {
                    $select .= '  <option value="price-desc">'.lang('App.frontend.pageProduct.selectPrice2').'</option>';
                }

                if ($option == 'view-desc') {
                    $select .= '<option value="view-desc" selected>'.lang('App.frontend.pageProduct.selectView1').'</option>';
                } else {
                    $select .= '  <option value="view-desc">'.lang('App.frontend.pageProduct.selectView1').'</option>';
                }

                if ($option == 'view-asc') {
                    $select .= '<option value="view-asc" selected>'.lang('App.frontend.pageProduct.selectView2').'</option>';
                } else {
                    $select .= '  <option value="view-asc">'.lang('App.frontend.pageProduct.selectView2').'</option>';
                }
            } else {
                $value = 'created_at';
                $order = 'desc';

                $select .= '<option value="created_at-desc" selected>'.lang('App.frontend.pageProduct.selectDefault').'</option>
                <option value="created_at-asc">'.lang('App.frontend.pageProduct.selectOld').'</option>
                <option value="name-asc">'.lang('App.frontend.pageProduct.selectName1').'</option>
                <option value="name-desc">'.lang('App.frontend.pageProduct.selectName2').'</option>
                <option value="price-asc">'.lang('App.frontend.pageProduct.selectPrice1').'</option>
                <option value="price-desc">'.lang('App.frontend.pageProduct.selectPrice2').'</option>
                <option value="view-asc">'.lang('App.frontend.pageProduct.selectView1').'</option>
                <option value="view-desc">'.lang('App.frontend.pageProduct.selectView2').'</option>';
            }
            $data['select'] = $select;
        }
        // load view
        $data['listProductNew'] = $this->mproduct->where(['status' => 1, 'trash' => 1])->orderBy('created_at', 'desc')->findAll(8);
        $data['listCatalogChild'] = $this->mcatalog->where(['status' => 1, 'trash' => 1, 'parentid' => 0])->orderBy('created_at', 'desc')->findAll();
        $data['listProductAll'] = $this->mproduct->where(['status' => 1, 'trash' => 1])->orderBy($value, $order)->paginate(12);
        $data['pager'] = $this->mproduct->pager;
        if (isset($filter)) {
            $result = view('frontend/product/indexFilter', $data);
            echo json_encode($result);
        } else {
            return view('frontend/product/index', $data);
        }
    }

    public function catalog()
    {
        $data['mcatalog'] = $this->mcatalog;
        $data['mreview'] = $this->mreview;
        // lấy thông tin qua url
        $slug = $this->request->uri->getSegment(2);
        $row = $this->mcatalog->catalogDetail($slug);
        // Xuất Breadcrumb
        $parent = $this->mcatalog->catalogGetName($row['id']);
        if (isset($parent['parentid'])) {
            $child = $this->mcatalog->catalogGetName($parent['parentid']);
            $data['child'] = $child;

            if (isset($child['parentid'])) {
                $parentChild = $this->mcatalog->catalogGetName($child['parentid']);
                $data['parentChild'] = $parentChild;
            }
        }
        // Hiển thị danh mục con
        $data['childCatalog'] = $this->mcatalog->catalogSubCatalog($row['id']);
        // Lấy id hiển thị sản phẩm theo danh mục
        $listCat = $this->mcatalog->where(['status' => 1, 'trash' => 1, 'parentid' => $row['id']])->findAll();
        $listCatid[] = $row['id'];
        foreach ($listCat as $item) {
            $listCatid[] = $item['id'];
            $listCat = $this->mcatalog->where(['status' => 1, 'trash' => 1, 'parentid' => $item['id']])->findAll();
            foreach ($listCat as $item1) {
                $listCatid[] = $item1['id'];
            }
        }

        // ajAx fILTER
        $filterCat = $this->request->getVar('filterCat'); // lấy giá trị
        $select = '';
        if (isset($filterCat)) {
            // value option phải = tên csdl 
            $where = $this->request->getVar('filterCat'); // lấy giá trị
            $result = explode('-', $where); // tách nó ra
            $value = $result[0];
            $order = $result[1];
            $getData = array(
                '0' => $value,
                '1' => $order
            );
            session()->set('productFilterCat', $getData);
        } else {
            if (session()->get('productFilterCat')) {
                $getData = session()->get('productFilterCat');
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

        $data['productShowByCat'] = $this->mproduct->productShowByCat($listCatid, $value, $order);
        // load view
        $data['listProductNew'] = $this->mproduct->where(['status' => 1, 'trash' => 1])->orderBy('created_at', 'desc')->findAll(8);
        $data['row'] = $row;
        $data['pager'] = $this->mproduct->pager;
        $data['parent'] = $parent;
        if (isset($filterCat)) {
            $result = view('frontend/product/indexFilterCat', $data);
            echo json_encode($result);
        } else {
            return view('frontend/product/catalog', $data);
        }
    }

    public function detail()
    {
        $data['mcatalog'] = $this->mcatalog;
        $slug = $this->request->uri->getSegment(2);
        $row = $this->mproduct->productDetail($slug);
        if (!$row) {
            return view('backend/error');
        }
        $data['listProductNew'] = $this->mproduct->where(['status' => 1, 'trash' => 1])->orderBy('created_at', 'desc')->findAll(8);
        $data['row'] = $row;
        // Xuất Breadcrumb
        $child = $this->mcatalog->catalogGetName($row['catid']);
        $parentChild = $this->mcatalog->catalogGetName($child['parentid']);
        $parent = $this->mcatalog->catalogGetName($parentChild['parentid']);
        // Xuất tên danh mục và thương hiệu
        $data['brandName'] = $this->mbrand->brandGetName($row['brandid']);
        $data['catalogName'] = $this->mcatalog->catalogGetName($row['catid']);
        // Sản phâmr cungf danh mục
        $data['listProductRelated'] = $this->mproduct->where(['status' => 1, 'trash' => 1, 'catid' => $row['catid'], 'id !=' => $row['id']])->orderBy('created_at', 'desc')->findAll(10);
        // Cập nhật lượt xem khi đến trang chi tiét
        $view = $row['view'] + 1;
        $getData = array(
            'id' => $row['id'],
            'view' => $view
        );
        $this->mproduct->save($getData);

        // LOad view
        $data['parentChild'] = $parentChild;
        $data['parent'] = $parent;
        $data['list_review'] = $this->mreview->where('productid', $row['id'])->orderBy('created_at', 'desc')->findAll();
        $data['mreview'] = $this->mreview;
        return view('frontend/product/detail', $data);
    }

    public function comment()
    {
        if($this->request->isAJAX()) { 	
            $productid = $this->request->getVar('productid');
            $rate = $this->request->getVar('rate');
            $select = $this->request->getVar('select');

            if(session()->get('userAll')) {
                $user_id = session()->get('userId');// lấy id yser
            }

            $data = array(
                'productid' => $productid,
                'userid' => $user_id,
                'total' =>  $select,
                'body' => $rate,
                'created_at' => date('Y-m-d H:i:s'),
            );
            
            if(!empty($rate) && !empty($select)) {
                $this->mreview->save($data);
            }
        }       
    }

    public function showComment($id) 
    {
        // hiển thị comment
        $list_review = $this->mreview->where('productid', $id)->orderBy('created_at', 'desc')->findAll();
        $review = '';
        if(count($list_review) > 0) {
        foreach($list_review as $item) {
            $get_user = $this->muser->orderGetUserid($item['userid']);
            $review .= '<div class="spr-review">
            <div class="spr-review-header d-flex justify-content-between px-2">
                <div>
                    <span
                    class="product-review spr-starratings spr-review-header-starratings text-warning">
                    <span class="reviewLink"> ';
                    for($i = 1; $i <= 5; $i++) { // chạy 5 sao
                        if($i <= $item['total']) {
                            $review .= '<i class="fa fa-star"></i>';
                        } else {
                            $review .= '<i class="fa fa-star-o"></i>';
                        }
                    }
            $review .= '</span>
                </span>
                    <h3 class="spr-review-header-title">'. $get_user['fullname'] .'</h3>
                    <span class="spr-review-header-byline">'. $item['created_at'] .'</span>
                </div>
                <div class="w-25"> ';
                    if(!empty($get_user['thumb'])) {
                        $review .= '<img class="img-fluid rounded-circle" src="'.base_url('uploads/user/'.$get_user['thumb']).'" />';
                    } else {
                        $review .= '<img class="img-fluid rounded-circle" src="'.base_url('uploads/default-image.jpg').'" />';
                    }
                $review .= '</div>
            </div>
            <div class="spr-review-content px-2">
                <p class="spr-review-content-body">'. $item['body'] .'.</p>
            </div>
        </div>';
        }
        } else {
            $review .= 'Chưa có đánh giá cho sản phẩm.';
        }
        
        echo $review;
    }


    public function showProductFilter()
    {
        if($this->request->isAJAX()) {
            $price1 = $this->request->getVar('price1');
            $price2 = $this->request->getVar('price2');
            $listProduct = $this->mproduct->where(['status' => 1, 'trash' => 1, 'price >=' => $price1, 'price <=' => $price2])->orderBy('created_at', 'desc')->findAll();
            $show = '';
            if(count($listProduct)) {
                $show .= '<div class="product product__th">
                <div class="row">';
                    foreach ($listProduct as $item) { 
                        $show .= '<div class="col-md-4 col-6">
                            <div class="product__container mt-4">
                                <div class="product__container-thumb">
                                    <a href="'. base_url('san-pham/' . $item['slug']) .'">
                                        <img src=" '. base_url('uploads/product/' . $item['thumb']) .'" class="img-fluid" alt="'. $item['name'] .'" />
                                    </a>
            
                                    <ul class="product__container-hover">
                                        <li class="product__hover-item">
                                            <a href="javascript:void(0)" id="'. $item['id'] .'" class="product__hover-link product__hover-quickview" data-toggle="modal" data-target="#dataModal">
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li class="product__hover-item">
                                            <a href="" class="product__hover-link">
                                                <i class="fa fa-heart-o" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li class="product__hover-item">
                                            <a href="javascript:void(0)" class="product__hover-link addToCart" data-id=" '. $item['id'] .' ">
                                                <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
            
                                <div class="product__container-info">
                                    <div class="product__container-name">
                                        <a href=" '. base_url('san-pham/' . $item['slug']) .'" class="product__container-link">
                                            <h2>
                                                 '. $item['name'] .'
                                            </h2>
                                        </a>
                                    </div>
            
                                    <div class="product__container-view mt-2 text-muted">
                                        Lượt xem: '. $item['view'] .'
                                    </div>
                                    
                                    <div class="product__contaier-start mt-2">
                                <div class="text-warning">';
                                 
                        $sum = 0;
                        $list_review1 = $this->mreview->where('productid', $item['id'])->orderBy('created_at', 'desc')->findAll();
                        foreach ($list_review1 as $rows) {
                            $sum+= $rows['total'];
                        }
                        $count = count($list_review1);
                        for ($i = 1; $i <= 5; $i++) { 
                            if(!empty($sum) && !empty($count)) {
                                if($i <= floor($sum/$count)) {
                                    $show .= '<i class="fa fa-star"></i>';
                                } else if(($i) == floor($sum/$count)) {
                                    $show .= '<i class="fa fa-star-o"></i>';    
                                } else {
                                    $show .= '<i class="fa fa-star-o"></i>';
                                }
                            } else {
                                $show .= '<i class="fa fa-star-o"></i>';
                            }
                        }
                        
                        $show .= '</div>
                            </div>
                                    ';
            
                                    if($item['sale'] > 0) {
                                        $show .= '<div class="product__container-price d-flex justify-content-between align-items-center">
                                        <div class="product-price">
                                            <div class="price-buy"> ' . number_format($item['price'] - ($item['price'] * ($item['sale'] / 100)), 0, ",", ".") . '  VNĐ</div>
                                            <div class="price-root"> ' . number_format($item['price'], 0, ',', '.') . '  VNĐ</div>
                                        </div>
                                        <div class="price-sale">- '. $item['sale'] .' %</div>
                                        </div>';
                                    } else {
                                        $show .= '<div class="product__container-price d-flex justify-content-between align-items-center">
                                        <div class="product-price">
                                            <div class="price-buy"> ' . number_format($item['price'], 0, ',', '.') . '  VNĐ</div>
                                            <div class="price-root" style="opacity: 0"> ' . number_format($item['price'], 0, ',', '.') . '  VNĐ</div>
                                        </div>
                                        
                                        </div>';
                                    }
                                    
                                $show .= '</div>
                            </div>
                        </div>';
                    } 
                $show .= '</div>
            </div>
            
            <div class="product__list" style="display: none"> ';
    foreach ($listProduct as $item) { 
        $show .= ' <div class="row">
            <div class="col-4">
                <a href=" '. base_url('san-pham/' . $item['slug']) .' ">
                    <img src=" '. base_url('uploads/product/' . $item['thumb']) .'" class="img-fluid" alt="'. $item['name'] .'" />
                </a>
            </div>
            <div class="col-8">
                <div class="product__list-name">
                    <a href="'. base_url('san-pham/' . $item['slug']) .'">
                        <h2>
                             '. $item['name'] .' 
                        </h2>
                    </a>
                </div>

                <div class="product__container-view mt-2 text-muted">
                    Lượt xem:  '. $item['view'] .'
                </div>

                <div class="product__container-view mt-2 text-muted">
                     '. $item['intro_desc'] .'
                </div>

                <div class="product__list-price d-flex justify-content-between align-items-center">';
                if($item['sale'] > 0) {
                    $show .= '
                    <div class="price">
                        <div class="price-buy"> ' . number_format($item['price'] - ($item['price'] * ($item['sale'] / 100)), 0, ",", ".") . '  VNĐ</div>
                        <div class="price-root"> ' . number_format($item['price'], 0, ',', '.') . '  VNĐ</div>
                    </div>
                    <div class="sale">- '. $item['sale'] .' %</div>'
                    ;
                } else {
                    $show .= '
                    <div class="price">
                        <div class="price-buy"> ' . number_format($item['price'], 0, ',', '.') . '  VNĐ</div>
                        <div class="price-root" style="opacity: 0"> ' . number_format($item['price'], 0, ',', '.') . '  VNĐ</div>
                    </div>
                    
                    ';
                }
                    
                $show .= '</div>

                <div class="product__list-btn mt-3">
                    <a href="javascript:void(0)" class="product__list-link mb-1 addToCart" data-id=" '. $item['id'] .'"><i class="fa fa-shopping-basket pr-2" aria-hidden="true"></i>Thêm vào giỏ hàng</a>
                    <a href="javascript:void(0)" class="product__list-link mb-1"><i class="fa fa-heart-o pr-2" aria-hidden="true"></i>Yêu
                        thích</a>
                    <a href="javascript:void(0)" id="'. $item['id'] .' " class="product__list-link product__hover-quickview" data-toggle="modal" data-target="#dataModal"><i class="fa fa-search pr-2" aria-hidden="true"></i>Xem nhanh</a>
                </div>
            </div>
        </div>';
    } 

    $show .= '</div>
            ';
            } else {
                $show .= '<div class="text-center">
                <h2 class="text-capitalize text-danger d-inline-block mt-5 ">Không có sản phẩm nào ở mức giá hiện tại. Vui lòng quay lại sau.</h2>
            </div>';
            }
                
           
            echo $show;
        }
    }
}
