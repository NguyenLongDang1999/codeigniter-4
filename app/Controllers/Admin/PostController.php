<?php
// Use Controller Folder Admin
namespace App\Controllers\Admin;
// Use BaseController
use App\Controllers\BaseController;
// Use Library Slug
use App\Libraries\Slug;
// Use Model
use App\Models\Mpost;
use App\Models\Mcatpost;

class postController extends BaseController
{
    public function __construct()
    {
        $this->mpost = new Mpost();
        $this->mcatpost = new Mcatpost();
        $this->slug = new Slug();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $data['list'] = $this->mpost->where('trash', 1)->orderBy('created_at', 'desc')->findAll();
        $data['mcatpost'] = $this->mcatpost;
        return view('backend/post/index', $data);
    }

    public function recycle()
    {
        $data['list'] = $this->mpost->where('trash', 0)->orderBy('created_at', 'desc')->findAll();
        $data['mcatpost'] = $this->mcatpost;
        return view('backend/post/recycle', $data);
    }

    public function add()
    {
        // Danh muc đa cấp
        $parentid = 0;
        $data['catalog_subcat'] = $this->mcatpost->where(['parentid' => $parentid, 'status' => 1])->orderBy('created_at', 'desc')->findAll();
        $data['mcatpost'] = $this->mcatpost;
        $data['validation'] = $this->validation;
        return view('backend/post/add', $data);
    }

    public function postAdd()
    {
        if (!$this->validate([
            'name' => [
                'rules' => 'required|max_length[255]|min_length[5]',
                'errors' => [
                    'required' => 'Tên tin tức không được bỏ trống.',
                    'max_length' => 'Tên tin tức không được vượt quá 255 ký tự.',
                    'min_length' => 'Tên tin tức không được dưới 5 ký tự.',
                ]
            ],
            'catpostid' => [
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
            return redirect()->route('postAdd')->withInput();
        }

        $upload_thumb = $this->request->getFile('thumb');
        // Nếu có lỗi trong lúc upload sẽ hiện ảnh defautl
        if ($upload_thumb->getError() == 4) {
            $thumb = 'default-image.jpg';
        } else {
            // Sinh ra tên ngẫu nhiên cho ảnh
            $thumb = $upload_thumb->getRandomName();
            // move tới file lưu ảnh
            $upload_thumb->move('uploads/post', $thumb);
        }

        // Lấy giá trị
        $name = $this->request->getVar('name');
        $meta_title = $this->request->getVar('meta_title');
        $meta_keyword = $this->request->getVar('meta_keyword');
        $meta_desc = $this->request->getVar('meta_desc');
        $slug = $this->slug->str_slug($name);
        $catpostid = $this->request->getVar('catpostid');
        $intro_desc = $this->request->getVar('intro_desc');
        $detail_desc = $this->request->getVar('detail_desc');

        $data = array(
            'name' => $name,
            'slug' => $slug,
            'catpostid' => $catpostid,
            'intro_desc' => $intro_desc,
            'detail_desc' => $detail_desc,
            'thumb' => $thumb,
            'status' => 1,
            'trash' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'meta_title' => $meta_title,
            'meta_keyword' => $meta_keyword,
            'meta_desc' => $meta_desc,
        );

        // Kiểm tra tên đã tồn tại chưa (Nên kiểm tra slug)
        if ($this->mpost->postCheckSlug($slug)) {
            $this->mpost->save($data); // save (insert update)
            session()->setFlashdata('success', 'Tin tức đã được thêm.');
        } else {
            session()->setFlashdata('error', 'Tin tức đã tồn tại. Vui lòng kiểm tra lại.');
        }
        return redirect()->route('postIndex');
    }

    public function edit($id)
    {
        
        $id = intval($id);
        $data['validation'] = $this->validation;
        // Danh muc đa cấp
        $parentid = 0;
        $data['catalog_subcat'] = $this->mcatpost->where(['parentid' => $parentid, 'status' => 1])->orderBy('created_at', 'desc')->findAll();
        $data['mcatpost'] = $this->mcatpost;
        $row = $this->mpost->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $data['row'] = $row;
        return view('backend/post/edit', $data);
    }

    public function postEdit($id)
    {
        $row = $this->mpost->find($id);
        if (!$this->validate([
            'name' => [
                'rules' => 'required|max_length[255]|min_length[5]',
                'errors' => [
                    'required' => 'Tên tin tức không được bỏ trống.',
                    'max_length' => 'Tên tin tức không được vượt quá 255 ký tự.',
                    'min_length' => 'Tên tin tức không được dưới 5 ký tự.',
                ]
            ],
            'catpostid' => [
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
            $upload_thumb->move('uploads/post', $thumb);
            // Sau khi sửa sẽ xoá ảnh cũ
            if ($row['thumb'] != 'default-image.jpg') {
                unlink('uploads/post/' . $this->request->getVar('checkImg'));
            }
        }

        // Lấy giá trị
        $name = $this->request->getVar('name');
        $meta_title = $this->request->getVar('meta_title');
        $meta_keyword = $this->request->getVar('meta_keyword');
        $meta_desc = $this->request->getVar('meta_desc');
        $slug = $this->slug->str_slug($name);
        $catpostid = $this->request->getVar('catpostid');
        $intro_desc = $this->request->getVar('intro_desc');
        $detail_desc = $this->request->getVar('detail_desc');

        $data = array(
            'id' => $row['id'],
            'name' => $name,
            'slug' => $slug,
            'catpostid' => $catpostid,
            'intro_desc' => $intro_desc,
            'detail_desc' => $detail_desc,
            'thumb' => $thumb,
            'updated_at' => date('Y-m-d H:i:s'),
            'meta_title' => $meta_title,
            'meta_keyword' => $meta_keyword,
            'meta_desc' => $meta_desc,
        );

        $this->mpost->save($data); // save (insert update)
        session()->setFlashdata('success', 'Tin tức đã được cập nhật.');
        return redirect()->route('postIndex');
    }

    public function status($id)
    {
        
        $id = intval($id);
        $row = $this->mpost->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $status = ($row['status'] == 1) ? 0 : 1;
        $data = array(
            'id' => $row['id'],
            'status' => $status
        );
        $this->mpost->save($data); // save (insert update)
        session()->setFlashdata('success', 'Trạng thái của Tin tức đã được cập nhật.');
        return redirect()->route('postIndex');
    }

    public function trash($id)
    {
        
        $id = intval($id);
        $row = $this->mpost->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $trash = ($row['trash'] == 1) ? 0 : 1;
        $data = array(
            'id' => $row['id'],
            'trash' => $trash
        );
        $this->mpost->save($data); // save (insert update)
        session()->setFlashdata('success', 'Đã đưa Tin tức "' . $row['name'] . '" vào thùng rác.');
        return redirect()->route('postIndex');
    }

    public function restore($id)
    {
        
        $id = intval($id);
        // Lấy về chi tiết thông tin
        $row = $this->mpost->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $trash = ($row['trash'] == 0) ? 1 : 0; // if rút gọn
        $data = array(
            'id' => $row['id'], // truyền id muốn cập nhật
            'trash' => $trash,
        );
        $this->mpost->save($data);
        session()->setFlashdata('success', 'Đã khôi phục thành công Tin tức "' . $row['name'] . '".');
        return redirect()->route('postRecycle');
    }

    public function delete($id)
    {
        
        $id = intval($id);
        // Lấy về chi tiết thông tin
        $row = $this->mpost->find($id);
        if(!$row) {
            return view('backend/error');
        }
        // xoá ảnh cũ
        if ($row['thumb'] != 'default-image.jpg') {
            unlink('uploads/post/' . $row['thumb']);
        }
        $this->mpost->delete($id);
        session()->setFlashdata('success', 'Đã xoá vĩnh viễn tin tức "' . $row['name'] . '".');
        return redirect()->route('postRecycle');
    }

    //--------------------------------------------------------------------

}
