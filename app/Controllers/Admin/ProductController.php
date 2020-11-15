<?php
// Use Controller Folder Admin
namespace App\Controllers\Admin;
// Use BaseController
use App\Controllers\BaseController;
// Use Library Slug
use App\Libraries\Slug;
// Use Model
use App\Models\Mproduct;
use App\Models\Mbrand;
use App\Models\Mcatalog;

class ProductController extends BaseController
{
    public function __construct()
    {
        $this->mproduct = new Mproduct();
        $this->mbrand = new Mbrand();
        $this->mcatalog = new Mcatalog();
        $this->slug = new Slug();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $data['list'] = $this->mproduct->where('trash', 1)->orderBy('created_at', 'desc')->findAll();
        $data['mcatalog'] = $this->mcatalog;
        $data['mbrand'] = $this->mbrand;
        return view('backend/product/index', $data);
    }

    public function recycle()
    {
        $data['list'] = $this->mproduct->where('trash', 0)->orderBy('created_at', 'desc')->findAll();
        $data['mcatalog'] = $this->mcatalog;
        $data['mbrand'] = $this->mbrand;
        return view('backend/product/recycle', $data);
    }

    public function add()
    {
        // Danh muc đa cấp
        $parentid = 0;
        $data['catalog_subcat'] = $this->mcatalog->where(['parentid' => $parentid, 'status' => 1, 'trash' => 1])->orderBy('created_at', 'desc')->findAll();
        $data['mcatalog'] = $this->mcatalog;
        // Load thương hiệu qua view
        $data['list_brand'] = $this->mbrand->where('status', 1)->orderBy('created_at', 'desc')->findAll();
        $data['validation'] = $this->validation;
        return view('backend/product/add', $data);
    }

    public function postAdd()
    {
        if (!$this->validate([
            'name' => [
                'rules' => 'required|max_length[255]|min_length[5]',
                'errors' => [
                    'required' => 'Tên sản phẩm không được bỏ trống.',
                    'max_length' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
                    'min_length' => 'Tên sản phẩm không được dưới 5 ký tự.',
                ]
            ],
            'sku' => [
                'rules' => 'required|max_length[10]',
                'errors' => [
                    'required' => 'Mã sản phẩm không được bỏ trống.',
                    'max_length' => 'Mã sản phẩm không được vượt quá 10 ký tự.',
                ]
            ],
            'quantity' => [
                'rules' => 'required|is_numeric|integer|is_natural',
                'errors' => [
                    'required' => 'Số lượng không được bỏ trống.',
                    'is_numeric' => 'Số lượng phải là ký tự ký số.',
                    'integer' => 'Số lượng phải là số nguyên.',
                    'is_natural' => 'Số lượng phải là số dương.',
                ]
            ],
            'sale' => [
                'rules' => 'is_numeric|is_natural|less_than_equal_to[99]',
                'errors' => [
                    'is_numeric' => 'Số khuyến mãi phải là ký tự ký số.',
                    'is_natural' => 'Số khuyến mãi phải là số nguyên dương.',
                    'less_than_equal_to' => 'Số khuyến mãi phải nằm trong đoạn từ 0 - 99'
                ]
            ],
            'price' => [
                'rules' => 'required|is_numeric|integer|is_natural',
                'errors' => [
                    'required' => 'Giá bán không được bỏ trống.',
                    'is_numeric' => 'Giá bán phải là ký tự ký số.',
                    'integer' => 'Giá bán phải là số nguyên.',
                    'is_natural' => 'Giá bán phải là số dương.',
                ]
            ],
            'catid' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Danh mục không được bỏ trống.'
                ]
            ],
            'intro_desc' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Mô tả ngắn không được bỏ trống.',
                    'max_length' => 'Mô tả ngắn không được vượt quá 255 ký tự.',
                ]
            ],
            'detail_desc' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Mô tả chi tiết không được bỏ trống.',
                ]
            ],
            'meta_title' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Meta Title (SEO) không được bỏ trống.',
                    'max_length' => 'Meta Title (SEO) không được vượt quá 255 ký tự.',
                ]
            ],
            'meta_keyword' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Meta Keyword (SEO) không được bỏ trống.',
                    'max_length' => 'Meta Keyword (SEO) không được vượt quá 255 ký tự.',
                ]
            ],
            'meta_desc' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Meta Description (SEO) không được bỏ trống.',
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
            // Load validation
            return redirect()->route('productAdd')->withInput();
        }

        $upload_thumb = $this->request->getFile('thumb');
        // Nếu có lỗi trong lúc upload sẽ hiện ảnh defautl
        if ($upload_thumb->getError() == 4) {
            $thumb = 'default-image.jpg';
        } else {
            // Sinh ra tên ngẫu nhiên cho ảnh
            $thumb = $upload_thumb->getRandomName();
            // move tới file lưu ảnh
            $upload_thumb->move('uploads/product', $thumb);
        }

        // Upload nhiều ảnh
        $upload_multiple = $this->request->getFiles();
        $arr_upload = '';
        if($upload_multiple) {
            foreach($upload_multiple['images'] as $item)
            {   
                if($item->isValid() && ! $item->hasMoved()) {
                    $list = $item->getRandomName();
                    $item->move('uploads/product', $list);
                    $arr_upload .= $list . ',';
                }
            }
            $arr_upload = rtrim($arr_upload, ',');       
        }

        // Lấy giá trị
        $name = $this->request->getVar('name');
        $meta_title = $this->request->getVar('meta_title');
        $meta_keyword = $this->request->getVar('meta_keyword');
        $meta_desc = $this->request->getVar('meta_desc');
        $slug = $this->slug->str_slug($name);
        $catid = $this->request->getVar('catid');
        $brandid = $this->request->getVar('brandid');
        $sale = $this->request->getVar('sale');
        $sku = $this->request->getVar('sku');
        $price = $this->request->getVar('price');
        $quantity = $this->request->getVar('quantity');
        $intro_desc = $this->request->getVar('intro_desc');
        $detail_desc = $this->request->getVar('detail_desc');

        $data = array(
            'name' => $name,
            'slug' => $slug,
            'sku' => $sku,
            'quantity' => $quantity,
            'price' => $price,
            'sale' => $sale,
            'catid' => $catid,
            'brandid' => $brandid,
            'intro_desc' => $intro_desc,
            'detail_desc' => $detail_desc,
            'thumb' => $thumb,
            'thumb_list' => $arr_upload,
            'view' => 0,
            'number_buy' => 0,
            'featured' => 0,
            'status' => 1,
            'trash' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'meta_title' => $meta_title,
            'meta_keyword' => $meta_keyword,
            'meta_desc' => $meta_desc,
        );

        // Kiểm tra tên đã tồn tại chưa (Nên kiểm tra slug)
        if ($this->mproduct->productCheckSlug($slug)) {
            $this->mproduct->save($data); // save (insert update)
            session()->setFlashdata('success', 'Sản phẩm đã được thêm.');
        } else {
            session()->setFlashdata('error', 'Sản phẩm đã tồn tại. Vui lòng kiểm tra lại.');
        }
        return redirect()->route('productIndex');
    }

    public function edit($id)
    {
         // Lấy id trên đường dẫn url
        $id = intval($id);
        $data['validation'] = $this->validation;
        // Danh muc đa cấp
        $parentid = 0;
        $data['catalog_subcat'] = $this->mcatalog->where(['parentid' => $parentid, 'status' => 1, 'trash' => 1])->orderBy('created_at', 'desc')->findAll();
        $data['mcatalog'] = $this->mcatalog;
        // Load thương hiệu qua view
        $data['list_brand'] = $this->mbrand->where('status', 1)->orderBy('created_at', 'desc')->findAll();
        $row = $this->mproduct->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $data['row'] = $row;
        return view('backend/product/edit', $data);
    }

    public function postEdit($id)
    {
        $row = $this->mproduct->find($id);
        if (!$this->validate([
            'name' => [
                'rules' => 'required|max_length[255]|min_length[5]',
                'errors' => [
                    'required' => 'Tên sản phẩm không được bỏ trống.',
                    'max_length' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
                    'min_length' => 'Tên sản phẩm không được dưới 5 ký tự.',
                ]
            ],
            'sku' => [
                'rules' => 'required|max_length[10]',
                'errors' => [
                    'required' => 'Mã sản phẩm không được bỏ trống.',
                    'max_length' => 'Mã sản phẩm không được vượt quá 10 ký tự.',
                ]
            ],
            'quantity' => [
                'rules' => 'required|is_numeric|integer|is_natural',
                'errors' => [
                    'required' => 'Số lượng không được bỏ trống.',
                    'is_numeric' => 'Số lượng phải là ký tự ký số.',
                    'integer' => 'Số lượng phải là số nguyên.',
                    'is_natural' => 'Số lượng phải là số dương.',
                ]
            ],
            'sale' => [
                'rules' => 'is_numeric|is_natural|less_than_equal_to[99]',
                'errors' => [
                    'is_numeric' => 'Số khuyến mãi phải là ký tự ký số.',
                    'is_natural' => 'Số khuyến mãi phải là số nguyên dương.',
                    'less_than_equal_to' => 'Số khuyến mãi phải nằm trong đoạn từ 0 - 99'
                ]
            ],
            'price' => [
                'rules' => 'required|is_numeric|integer|is_natural',
                'errors' => [
                    'required' => 'Giá bán không được bỏ trống.',
                    'is_numeric' => 'Giá bán phải là ký tự ký số.',
                    'integer' => 'Giá bán phải là số nguyên.',
                    'is_natural' => 'Giá bán phải là số dương.',
                ]
            ],
            'catid' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Danh mục không được bỏ trống.'
                ]
            ],
            'intro_desc' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Mô tả ngắn không được bỏ trống.',
                    'max_length' => 'Mô tả ngắn không được vượt quá 255 ký tự.',
                ]
            ],
            'detail_desc' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Mô tả chi tiết không được bỏ trống.',
                ]
            ],
            'meta_title' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Meta Title (SEO) không được bỏ trống.',
                    'max_length' => 'Meta Title (SEO) không được vượt quá 255 ký tự.',
                ]
            ],
            'meta_keyword' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Meta Keyword (SEO) không được bỏ trống.',
                    'max_length' => 'Meta Keyword (SEO) không được vượt quá 255 ký tự.',
                ]
            ],
            'meta_desc' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Meta Description (SEO) không được bỏ trống.',
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
            // Load validation
            return redirect()->back()->withInput();
        }

        $upload_thumb = $this->request->getFile('thumb');
        // Kiểm tra ảnh cũ 
        if ($upload_thumb->getError() == 4) {
            $thumb = $this->request->getVar('checkImg');
        } else {
            // Sinh ra tên ngẫu nhiên cho ảnh
            $thumb = $upload_thumb->getRandomName();
            // move tới file lưu ảnh
            $upload_thumb->move('uploads/product', $thumb);
            // Sau khi sửa sẽ xoá ảnh cũ
            if ($row['thumb'] != 'default-image.jpg') {
                unlink('uploads/product/' . $this->request->getVar('checkImg'));
            }
        }

        // Lấy giá trị
        $name = $this->request->getVar('name');
        $meta_title = $this->request->getVar('meta_title');
        $meta_keyword = $this->request->getVar('meta_keyword');
        $meta_desc = $this->request->getVar('meta_desc');
        $slug = $this->slug->str_slug($name);
        $catid = $this->request->getVar('catid');
        $brandid = $this->request->getVar('brandid');
        $sale = $this->request->getVar('sale');
        $sku = $this->request->getVar('sku');
        $price = $this->request->getVar('price');
        $quantity = $this->request->getVar('quantity');
        $intro_desc = $this->request->getVar('intro_desc');
        $detail_desc = $this->request->getVar('detail_desc');

        $data = array(
            'id' => $row['id'],
            'name' => $name,
            'slug' => $slug,
            'sku' => $sku,
            'quantity' => $quantity,
            'price' => $price,
            'sale' => $sale,
            'catid' => $catid,
            'brandid' => $brandid,
            'intro_desc' => $intro_desc,
            'detail_desc' => $detail_desc,
            'thumb' => $thumb,
            'updated_at' => date('Y-m-d H:i:s'),
            'meta_title' => $meta_title,
            'meta_keyword' => $meta_keyword,
            'meta_desc' => $meta_desc,
        );

        // Upload nhiều ảnh
        $upload_multiple = $this->request->getFiles();
        $data['thumb_list'] = '';
        if($upload_multiple) {
            foreach($upload_multiple['photos'] as $item)
            {   
                if($item->isValid() && ! $item->hasMoved()) {
                    $list = $item->getRandomName();
                    $item->move('uploads/product', $list);
                    $data['thumb_list'] .= $list . ',';      
                } else {
                    $data['thumb_list'] .= $row['thumb_list'];                    
                }
            }
            $data['thumb_list'] = rtrim($data['thumb_list'], ',');       
        }


        $this->mproduct->save($data); // save (insert update)
        session()->setFlashdata('success', 'Sản phẩm đã được cập nhật.');
        return redirect()->route('productIndex');
    }

    public function status($id)
    {
         // Lấy id trên đường dẫn url
        $id = intval($id);
        $row = $this->mproduct->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $status = ($row['status'] == 1) ? 0 : 1;
        $data = array(
            'id' => $row['id'],
            'status' => $status
        );
        $this->mproduct->save($data); // save (insert update)
        session()->setFlashdata('success', 'Trạng thái của sản phẩm đã được cập nhật.');
        return redirect()->route('productIndex');
    }

    public function trash($id)
    {
         // Lấy id trên đường dẫn url
        $id = intval($id);
        $row = $this->mproduct->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $trash = ($row['trash'] == 1) ? 0 : 1;
        $data = array(
            'id' => $row['id'],
            'trash' => $trash
        );
        $this->mproduct->save($data); // save (insert update)
        session()->setFlashdata('success', 'Đã đưa sản phẩm "' . $row['name'] . '" vào thùng rác.');
        return redirect()->route('productIndex');
    }

    public function restore($id)
    {
         // Lấy id trên đường dẫn url
        $id = intval($id);
        // Lấy về chi tiết thông tin
        $row = $this->mproduct->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $trash = ($row['trash'] == 0) ? 1 : 0; // if rút gọn
        $data = array(
            'id' => $row['id'], // truyền id muốn cập nhật
            'trash' => $trash,
        );
        $this->mproduct->save($data);
        session()->setFlashdata('success', 'Đã khôi phục thành công sản phẩm "' . $row['name'] . '".');
        return redirect()->route('productRecycle');
    }

    public function featured($id)
    {
         // Lấy id trên đường dẫn url
        $id = intval($id);
        // Lấy về chi tiết thông tin
        $row = $this->mproduct->find($id);
        if(!$row) {
            return view('backend/error');
        }
        if($row['featured'] == 0) {
            $data = array(
                'id' => $row['id'], // truyền id muốn cập nhật
                'featured' => 1,
            );
            $this->mproduct->save($data);
            session()->setFlashdata('success', 'Sản phẩm "' . $row['name'] . '" đã được kích hoạt nổi bật.');
        } else if ($row['featured'] == 1) {
            $data = array(
                'id' => $row['id'], // truyền id muốn cập nhật
                'featured' => 0,
            );
            $this->mproduct->save($data);
            session()->setFlashdata('success', 'Sản phẩm "' . $row['name'] . '" đã được hủy kích hoạt nổi bật.');
        }
        return redirect()->route('productIndex');
    }


    public function delete($id)
    {
         // Lấy id trên đường dẫn url
        $id = intval($id);
        // Lấy về chi tiết thông tin
        $row = $this->mproduct->find($id);
        if(!$row) {
            return view('backend/error');
        }
        // xoá ảnh cũ
        if ($row['thumb'] != 'default-image.jpg') {
            unlink('uploads/product/' . $row['thumb']);
        }
        $thumb_list = explode(',', $row['thumb_list']);
        foreach($thumb_list as $img) {
            unlink('uploads/product/' . $img);
        }
        $this->mproduct->delete($id);
        session()->setFlashdata('success', 'Đã xoá vĩnh viễn sản phẩm "' . $row['name'] . '".');
        return redirect()->route('productRecycle');
    }

    //--------------------------------------------------------------------

}
