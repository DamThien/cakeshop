<?php

namespace App\Http\Controllers;

use App\Models\bill_detail;
use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\slide;
use App\Models\product;
use App\Models\BillDetail;
use App\Models\bills;
use Illuminate\Support\Facades\Session;

use App\Models\customer;
use App\Models\comments;
use App\Models\type_products;
use App\Models\wishlists;

class PageController extends Controller
{
    //
    public function getIndex()
    {
        $slide = Slide::all();
        $new_product = product::where('new', 1)->paginate(8);
        $sanpham_khuyenmai = product::where('promotion_price', '<>', 0)->paginate(4);
        return view('page.trangchu', compact('slide', 'new_product', 'sanpham_khuyenmai'));
    }
    public function getLoaiSp($type)
    {
        $type_product = product::all();
        $sp_theoloai = product::where('id_type', $type)->get();
        $sp_khac = product::where('id_type', '<>', $type)->get();

        $loai = type_products::all();

        $loai_sp = type_products::where('id', $type)->first();
        return view('page.loai_sanpham', compact('sp_theoloai', 'type_product', 'sp_khac', 'loai', 'loai_sp'));
    }
    public function getChitiet(Request $request)
    {
        $sanpham = product::where('id', $request->id)->first();
        $splienquan = product::where('id', '<>', $sanpham->id, 'and', 'id_type', '=', $sanpham->id_type, )->paginate(3);
        $comments = comments::where('id_product', $request->id)->get();
        return view('page.chitiet_sanpham', compact('sanpham', 'splienquan', 'comments'));
    }

    public function getIndexAdmin()
    {
        $product = product::all();
        return view('pageadmin.admin')->with(['product' => $product, 'sumSold' => count(bill_detail::all())]);
    }
    public function getAdminAdd()
    {
        return view('pageadmin.formAdd');
    }

    public function postAdminAdd(Request $request)
    {
        $product = new product();

        if ($request->hasFile('inputImage')) {
            $file = $request->file('inputImage');
            $fileName = $file->getClientOriginalName();
            $file->move('source/image/product', $fileName);
            $product->image = $fileName;
        }

        $product->name = $request->inputName;
        $product->description = $request->inputDescription;
        $product->unit_price = $request->inputPrice;
        $product->promotion_price = $request->inputPromotionPrice;
        $product->unit = $request->inputUnit;
        $product->new = $request->inputNew;
        $product->id_type = $request->inputType;
        $product->save();
        return $this->getIndexAdmin();
    }

    public function getAdminEdit($id)
    {
        $product = product::find($id);
        return view('pageadmin.formEdit')->with('product', $product);
    }

    public function postAdminEdit(Request $request)
    {
        $id = $request->editId;
        $product = product::find($id);

        if ($request->hasFile('editImage')) {
            $file = $request->file('editImage');
            $fileName = $file->getClientOriginalName();
            $file->move('source/image/product', $fileName);
            $product->image = $fileName;
        }

        if ($request->file('editImage') != null) {
            $product->image = $fileName;
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
    public function postAdminDelete($id)
    {
        $product = product::find($id);
        $product->delete();
        return $this->getIndexAdmin();
    }
    public function getAddToCart(Request $req, $id)
    {
        if (Session::has('user')) {
            if (Product::find($id)) {
                $product = Product::find($id);
                $oldCart = Session('cart') ? Session::get('cart') : null;
                $cart = new Cart($oldCart);
                $cart->add($product, $id);
                $req->session()->put('cart', $cart);
                return redirect()->back();
            } else {
                return '<script>alert("Không tìm thấy sản phẩm này.");window.location.assign("/");</script>';
            }
        } else {
            return '<script>alert("Vui lòng đăng nhập để sử dụng chức năng này.");window.location.assign("/login");</script>';
        }
    }
    public function getDelItemCart($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        return redirect()->back();
    }
    public function getCheckout()
    {
        if (Session::has('cart')) {
            $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);
            return view('page.checkout')->with([
                'cart' => Session::get('cart'),
                'product_cart' => $cart->items,
                'totalPrice' => $cart->totalPrice,
                'totalQty' => $cart->totalQty
            ]);
            ;
        } else {
            return redirect('trangchu');
        }
    }

    public function postCheckout(Request $req)
    {
        $cart = Session::get('cart');
        $customer = new Customer;
        $customer->name = $req->full_name;
        $customer->gender = $req->gender;
        $customer->email = $req->email;
        $customer->address = $req->address;
        $customer->phone_number = $req->phone;

        if (isset($req->notes)) {
            $customer->note = $req->notes;
        } else {
            $customer->note = "Không có ghi chú gì";
        }

        $customer->save();

        $bill = new bills;
        $bill->id_customer = $customer->id;
        $bill->date_order = date('Y-m-d');
        $bill->total = $cart->totalPrice;
        $bill->payment = $req->payment_method;
        if (isset($req->notes)) {
            $bill->note = $req->notes;
        } else {
            $bill->note = "Không có ghi chú gì";
        }
        $bill->save();

        foreach ($cart->items as $key => $value) {
            $bill_detail = new bill_detail;
            $bill_detail->id_bill = $bill->id;
            $bill_detail->id_product = $key; //$value['item']['id'];																
            $bill_detail->quantity = $value['qty'];
            $bill_detail->unit_price = $value['price'] / $value['qty'];
            $bill_detail->save();
        }

        Session::forget('cart');
        $wishlists = wishlists::where('id_user', Session::get('user')->id)->get();
        if (isset($wishlists)) {
            foreach ($wishlists as $element) {
                $element->delete();
            }
        }
    }
}