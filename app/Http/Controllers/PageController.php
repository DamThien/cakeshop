<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Comment;
use App\Models\TypeProduct;
use App\Models\BillDetail;
class PageController extends Controller
{
    //
    public function getIndex(){

        $slide = Slide::all();
        $new_product = Product::where('new',1)->paginate(8);
        $spkhuyenmai = Product::where('promotion_price', '<>', 0)->paginate(4);		

        return View('page.trangchu',compact('slide','new_product','spkhuyenmai'));
    }
    public function getDetail(Request $request)
    {
        $sanpham = Product::where('id', $request->id)->first();
        $splienquan = Product::where('id', '<>', $sanpham->id, 'and', 'id_type', '=', $sanpham->id_type)->paginate(3);
        $comments =    Comment::where('id_product', $request->id)->get();
        return view('page.chitiet_sanpham', compact('sanpham', 'splienquan', 'comments'));
    }
    public function getLoaiSp($type)
    {
        $type_product = TypeProduct::all(); //Show ra tên loại sản phẩm
        $sp_theoloai = Product::where('id_type', $type)->get();
        $sp_khac = Product::where('id_type', '<>', $type)->paginate(3);
        return view('page.loai_sanpham', compact('sp_theoloai', 'type_product', 'sp_khac'));
    }
    public function getIndexAdmin()
    {
        $Product = Product::all();
        return view('pageadmin.admin')->with([
            'Product' => $Product,
            'sumSold' => count(BillDetail::all())
        ]);
    }
    public function getAdminAdd()
    {
        return view('pageadmin.admin-add-form');
    }
    public function postAdminAdd(Request $request)
    {
        $product = new Product();

        if ($request->hasFile('inputImage')) {
            $file = $request->file('inputImage');
            $fileName = $file->getClientOriginalName('inputImage');
            $file->move('source/image/product', $fileName);
            $product->image = $fileName;
        }

        $product->name = $request->inputName;
        $product->description = $request->inputDescription; // Sửa đúng tên trường ở đây
        $product->unit_price = $request->inputunitPrice;
        $product->promotion_price = $request->inputPromotionPrice;
        $product->unit = $request->inputunit;
        $product->new = $request->inputNew;
        $product->id_type = $request->inputType;

        $product->save();

        return $this->getIndexAdmin();
    }


    public function getAdminEdit($id)
    {
        $product = Product::find($id);
        return view('pageadmin.admin-edit-form')->with('product', $product);
    }

    public function postAdminEdit(Request $request)
    {
        $id = $request->editId;
        $product = Product::find($id);
        if ($request->hasFile('editImage')) {
            $file = $request->file('editImage');
            $fileName = $file->getClientOriginalName('editImage');
            $file->move('source/image/product', $fileName);
            $product->image = $fileName;
        }

        $product->name = $request->editName;
        $product->description = $request->editDescription;
        $product->unit_price = $request->editunitPrice;
        $product->promotion_price = $request->editPromotionPrice;
        $product->unit = $request->inputeditunit;
        $product->new = $request->editNew;
        $product->id_type = $request->editType;

        $product->save();

        return $this->getIndexAdmin();
    }

    // public function postAdminDelete($id){
    //     $product = Product::find($id);
    //     $product->detele();
    //     return $this->getIndexAdmin();
    // }
    public function  postAdminDelete($id)
    {
        $product = Product::find($id);
        $product->delete();
        return $this->getIndexAdmin();
    }
}
