<?php

namespace App\Controllers;
// Use BaseController
use App\Controllers\BaseController;
use App\Models\Mproduct;
use App\Models\Mslider;
use App\Models\Mcatalog;
use App\Models\Mbrand;
use App\Models\Mpost;
use App\Models\Mreview;

class HomeController extends BaseController
{
    public function __construct()
    {
        $this->mproduct = new Mproduct();
        $this->mslider = new Mslider();
        $this->mcatalog = new Mcatalog();
        $this->mbrand = new Mbrand();
        $this->mpost = new Mpost();
    }

    public function index()
    {
        $data['mcatalog'] = $this->mcatalog;
        $data['mproduct'] = $this->mproduct;
        $data['mreview'] = new Mreview();
        // Slider
        $data['listSlider'] = $this->mslider->where(['status' => 1])->orderBy('created_at', 'desc')->findAll(10);
        // Product
        $data['listProductNew'] = $this->mproduct->where(['status' => 1, 'trash' => 1, 'featured' => 0])->orderBy('created_at', 'desc')->findAll(10);
        $data['listProductFeatured'] = $this->mproduct->where(['status' => 1, 'trash' => 1, 'featured' => 1])->orderBy('created_at', 'desc')->findAll(10);
        $data['listProductMostView'] = $this->mproduct->where(['status' => 1, 'trash' => 1])->orderBy('view', 'desc')->findAll(10);
        // Product By Cat
        $data['listProductByCat'] = $this->mcatalog->where(['status' => 1, 'trash' => 1, 'parentid' => 0])->findAll(5);
        // Post
        $data['listPost'] = $this->mpost->where(['status' => 1, 'trash' => 1])->orderBy('created_at', 'desc')->findAll(4);
        return view('frontend/home/index', $data);
    }

    public function modal()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            if (isset($id) && !empty($id)) {
                $listProductModal = $this->mproduct->where(['status' => 1, 'trash' => 1, 'id' => $id])->findAll();
                $modal = '';
                foreach ($listProductModal as $item) {
                    $catalogGetName = $this->mcatalog->catalogGetName($item['catid'])['name'];
                    $brandGetName = $this->mbrand->brandGetName($item['brandid']);

                    $modal .= '<div class="row">
                    <div class="col-lg-4">
                      <div class="slider slider-for">';
                    $modal .= '<div>
                            <img src="' . base_url('uploads/product/' . $item['thumb']) . '" class="img-fluid w-100" alt="' . $item['name'] . '" />
                          </div>';
                    $thumbList = explode(',', $item['thumb_list']);
                    foreach ($thumbList as $img) {
                        $modal .= '<div>
                            <img src="' . base_url('uploads/product/' . $img) . '" class="img-fluid w-100" alt="' . $item['name'] . '" />
                          </div>';
                    }

                    $modal .= '</div>
                      <div class="slider slider-nav mt-2">';
                    $modal .= '<div>
                            <img src="' . base_url('uploads/product/' . $item['thumb']) . '" class="img-fluid w-100" alt="' . $item['name'] . '" />
                          </div>';
                    $thumbList = explode(',', $item['thumb_list']);
                    foreach ($thumbList as $img) {
                        $modal .= '<div>
                            <img src="' . base_url('uploads/product/' . $img) . '" class="img-fluid w-100" alt="' . $item['name'] . '" />
                          </div>';
                    }
                    $modal .= '
                      </div>
                    </div>
        
                    <div class="col-lg-8">
                      <div class="product__modal-name">
                        <a href="' . base_url('san-pham/' . $item['slug']) . '">
                          <h2>
                            ' . $item['name'] . '
                          </h2>
                        </a>
                      </div>
        
                      <div class="product__modal-review d-flex border-bottom pb-3">
                        <div class="text-warning">
                          <i class="fa fa-star-o" aria-hidden="true"></i>
                          <i class="fa fa-star-o" aria-hidden="true"></i>
                          <i class="fa fa-star-o" aria-hidden="true"></i>
                          <i class="fa fa-star-o" aria-hidden="true"></i>
                          <i class="fa fa-star-o" aria-hidden="true"></i>
                        </div>
        
                        <div class="review ml-3">
                          (Chưa có đánh giá nào cho sản phẩm này)
                        </div>
                      </div>
        
                      <div class="product__modal-price">';
                    if ($item['sale'] > 0) {
                      $modal .= '
                    <div class="price-buy"> ' . number_format($item['price'] - ($item['price'] * ($item['sale'] / 100)), 0, ",", ".") . ' VNĐ</div>
                    <div class="price-root">' . number_format($item['price'], 0, ',', '.') . ' VNĐ</div>';
                    } else {
                      $modal .= '
                      <div class="price-buy"> ' . number_format($item['price'], 0, ',', '.') . ' VNĐ</div>
                      <div class="price-root" style="opacity: 0">' . number_format($item['price'], 0, ',', '.') . ' VNĐ</div>';
                    }
        
                      $modal .='</div>
        
                      <div class="product__modal-info">
                        <ul class="m-0 list-unstyled">
                        <li class="text-capitalize">
                             Lượt xem:
                            <strong class="text-uppercase">' . $item['view'] . '</strong>
                          </li>
                          <li class="text-capitalize">
                            Mã sản phẩm:
                            <strong class="text-uppercase">' . $item['sku'] . '</strong>
                          </li>
                          <li class="text-capitalize">
                            Danh mục:
                            <strong class="text-capitalize">' . $catalogGetName . '</strong>
                          </li>';
                          if(isset($brandGetName)) {
                            $modal .= '<li class="text-capitalize">
                              Thương hiệu:
                              <strong class="text-capitalize">' . $brandGetName['name'] . '</strong>
                            </li>';
                            }        

                        $modal .='</ul>
                      </div>
        
                      <div class="product__modal-btn">
                        <a href="javascript:void(0)" class="product__modal-link addToCart" data-id="'. $item['id'] .'"><i class="fa fa-shopping-basket pr-2" aria-hidden="true"></i>Thêm vào giỏ hàng</a>
                        <a href="javascript:void(0)" class="product__modal-link"><i class="fa fa-heart-o pr-2" aria-hidden="true"></i>Yêu
                          thích</a>
                      </div>
                    </div>
                  </div>';
                    echo $modal;
                }
            }
        }
    }
}
