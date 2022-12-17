<?php

namespace App\Http\Controllers\Front;

use App\Services\Order\OrderServiceInterface;
use App\Services\OrderDetail\OrderDetailService;
use App\Services\OrderDetail\OrderDetailServiceInterface;
use App\Utilities\Constant;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    private $orderService;
    private $orderDetailService;
    public function __construct(OrderServiceInterface $orderService ,
                                OrderDetailServiceInterface $orderDetailService)
    {
        $this->orderService= $orderService;
        $this->orderDetailService = $orderDetailService;
    }

    public function index(){

        $carts = Cart::content();
        $total = Cart::total();
        $subtotal = Cart::subtotal();
        return view('front.checkout.index',compact('carts','total','subtotal'));
    }
    public function addOrder(Request $request) {
        //01. thêm đơn hàng
            $data=$request->all();
            $data['status']=Constant::order_status_ReceiveOrders;
            $order= $this->orderService->create($data);
        //02. thêm chi tiết đơn hàng
            $carts =Cart::content();
            foreach ($carts as $cart) {
                $data = [
                    'order_id'=>$order->id,
                    'product_id'=>$cart->id,
                    'qty'=>$cart->qty,
                    'amount'=>$cart->price,
                    'total'=>$cart->qty * $cart->price,
                ];

                $this->orderDetailService->create($data);
            }
        //03.Xóa giỏ hàng
            Cart::destroy();
        //04. Trả về kq thông báo
        return "Success! You will pay on delivery . Please check later ! Thanks ! ";

    }
}
