<?php

namespace App\Http\Controllers;

use App\Models\bill_detail;
use App\Models\Product;
use App\Models\slide;
use App\Models\comments;
use App\Models\type_products;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    public function getIndex()
    {
        $slide = slide::all();
        $newProduct = Product::where('new', 1)->paginate(8);
        // sản phẩm khuyến mãi
        $topProduct = Product::where('promotion_price', '<>', 0)->paginate(4);
        return view('page.trangchu', compact('slide', 'newProduct', 'topProduct'));
    }

    public function getDetail(Request $request)
    {
        $sanpham = Product::where('id', $request->id)->first();
        $splienquan = Product::where('id', '<>', $sanpham->id, 'and', 'id_type', '=', $sanpham->id_type, )->paginate(3);
        $comments = comments::where('id_product', $request->id)->get();
        return view('page.chitiet_sanpham', compact('sanpham', 'splienquan', 'comments'));
    }

    public function getLoaiSp($type)
    {

        $type_product = type_products::all(); // show ra tên loại sp

        // lấy sp theo loại
        $sp_theoloai = Product::where('id_type', $type)->limit(3)->get();

        // Lay san pham hien thi Khac <> loai			
        $sp_khac = Product::where('id_type', '<>', $type)->paginate(3);

        // Lay san pham hien thi theoloai typeproduct  cho menu ben trai	
        // $loai = type_products::all();	

        // Lay ten Loai san pham moi khi chung ta chon danh muc loai san pham(phan menu ben trai)							
        $loai_sp = type_products::where('id', $type)->first();

        return view('page.loai_sanpham', compact('type_product', 'sp_theoloai', 'sp_khac', 'loai_sp'));
    }

    //Tạo Controller 	
    public function getIndexAdmin()
    {
        $products = Product::all();
        return view('pageadmin.admin')->with(['products' => $products, 'sumSold' => count(bill_detail::all())]);
    }

    //Tạo Controller để chạy View  giao diện thêm sản phẩm lên
    public function getAdminAdd()   
    {
        return view('pageadmin.formAdd');
    }

    //Tạo Controller postAdminAdd để thêm sản phẩm						
    public function postAdminAdd(Request $request)
    {
        $product = new Product();
        if ($request->hasFile('inputImage')) {
            $file = $request->file('inputImage');
            $fileName = $file->getClientOriginalName('inputImage');
            $file->move('source/image/product', $fileName);
        }
        $file_name = null;
        if ($request->file('inputImage') != null) {
            $file_name = $request->file('inputImage')->getClientOriginalName();
        }

        $product->name = $request->inputName;
        $product->image = $file_name;
        $product->description = $request->inputDescription;
        $product->unit_price = $request->inputPrice;
        $product->promotion_price = $request->inputPromotionPrice;
        $product->unit = $request->inputUnit;
        $product->new = $request->inputNew;
        $product->save();
        return $this->getIndexAdmin();
    }

    //Xây dựng Controller  để thực hiện Sữa giao diện cho trang sửa
    public function postAdminEdit(Request $request)
    {
       
        $id = $request->editId;
        $product = Product::find($id);
        if ($request->hasFile('editImage')) {
            $file = $request->file('editImage');
            $fileName = $file->getClientOriginalName('editImage');
            $file->move('source/image/product', $fileName);
        }

        if (!$product) {
            // Handle the case where the product is not found
            return redirect()->back()->with('error', 'Product not found.');
        }
        // $fileName = null;
        if ($request->file('editImage') != null) {
            $product ->image = $fileName;
        }

        $product->name = $request->editName;
        $product->description = $request->editDescription;
        $product->unit_price = $request->editPrice;
        $product->promotion_price = $request->editPromotionPrice;
        $product->unit = $request->editUnit;
        $product->new = $request->editNew;
        $product->id_type = $request->editType;
        $product->save();
        return $this->getIndexAdmin();
    }


    //Xây dựng Controller đẻ thực hiện Sữa giao diện cho trang sửa
    public function getAdminEdit($id)
    {
        $product = Product::find($id);
        return view('pageadmin.formEdit')->with('product', $product);
    }

        //Xây dựng Controller đẻ thực hiện Sữa giao diện cho trang sửa
        public function getAdminDelete($id)
        {
            $product = Product::find($id);
            $product->delete();
            return $this->getIndexAdmin();
        }



    // public function detChitiet(){
    //     return view('page.chitiet_sanpham');
    // }

    // public function getLienhe(){
    //     return view('page.lienhe');
    // }


    // public function getAbout(){
    //     return view('page.chitiet_sanpham');
    // }






}