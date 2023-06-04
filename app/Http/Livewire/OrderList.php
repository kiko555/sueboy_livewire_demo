<?php

namespace App\Http\Livewire;

use App\Models\Order;

use Livewire\Component;
use Livewire\WithPagination;

class OrderList extends Component
{
    use WithPagination;

    public $orders, $order_infos;

    public $action_add = false;
    public $action_edit = false;
    public $order_id, $order_detail_from_order_id;
    public $name, $total_price_origin, $total_price_after_discount, $total_quantity;

    protected $rules = [
        'name' => 'required',
        'total_price_origin' => 'required',
        'total_quantity' => 'required',
    ];

    public function refresh_orders()
    {
        $this->orders = Order::all();
    }

    public function mount()
    {
        $this->refresh_orders();
    }

    public function render()
    {
        return view('livewire.order-list');
    }

    public function add()
    {
        $this->name = '';
        $this->total_price_origin = null;
        $this->total_price_after_discount = null;
        $this->total_quantity = null;

        $this->action_add = true;
        $this->action_edit = false;
    }

    public function add_save()
    {
        $this->validate();

        try {
            Order::create([
                'name' => $this->name,
                'user_id' => auth()->id(),
                'total_price_origin' => $this->total_price_origin,
                'total_price_after_discount' => $this->total_price_after_discount,
                'total_quantity' => $this->total_quantity,
            ]);

            $this->refresh_orders();

            $this->action_add = false;

            session()->flash('success','新增成功！');
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
        }
    }

    public function edit($order_id)
    {
        $this->order_id = $order_id;

        try {
            $order = Order::find($order_id);

            if( !$order ) {
                session()->flash('error','訂單不存在！');
            } else {
                $this->name = $order->name;
                $this->total_price_origin = $order->total_price_origin;
                $this->total_price_after_discount = $order->total_price_after_discount;
                $this->total_quantity = $order->total_quantity;

                $this->action_add = false;
                $this->action_edit = true;
            }
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
        }
    }

    public function edit_save()
    {
        $this->validate();

        try {
            Order::Where('order_id', $this->order_id)->update([
                'name' => $this->name,
                'user_id' => auth()->id(),
                'total_price_origin' => $this->total_price_origin,
                'total_price_after_discount' => $this->total_price_after_discount,
                'total_quantity' => $this->total_quantity,
            ]);

            $this->refresh_orders();

            $this->action_edit = false;

            session()->flash('success','更新成功！');
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
        }

        $this->action_edit = false;
    }

    public function cancel()
    {
        $this->action_add = false;
        $this->action_edit = false;
    }

    public function delete($order_id)
    {
        try {
            Order::Where('order_id', $order_id)->delete();

            $this->refresh_orders();

            session()->flash('success','刪除成功！');
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
        }
    }

    public function get_order_detail($order_id)
    {
        $this->emit('triger_refresh_order_details', $order_id);
    }

    public function all_info($order_id)
    {
        $this->order_infos = Order::with('order_details')->where('order_id', $order_id)->get();
    }
}
