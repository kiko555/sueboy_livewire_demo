<?php

namespace App\Http\Livewire;

use App\Models\OrderDetail;
use Livewire\Component;

class OrderDetailList extends Component
{
    public $order_details=[];

    public $action_add = false;
    public $action_edit = false;
    public $order_detail_id;
    public $order_id, $good_id, $good_sell_price, $discount, $quantity, $description;

    protected $rules = [
        'good_id' => 'required',
        'good_sell_price' => 'required',
        'quantity' => 'required',
    ];

    protected $listeners = ['triger_refresh_order_details' => 'refresh_order_details'];

    public function refresh_order_details($order_id=null)
    {
        $this->order_id = $order_id;

        if( $order_id)
        {
            $this->order_details = OrderDetail::Where('order_id', $order_id)->get();
        }
    }

    public function mount()
    {
        $this->refresh_order_details();
    }

    public function render()
    {
        return view('livewire.order-detail-list');
    }

    public function add()
    {
        $this->good_id = null;
        $this->good_sell_price = null;
        $this->discount = null;
        $this->quantity = null;
        $this->description = null;

        $this->action_add = true;
        $this->action_edit = false;
    }

    public function add_save()
    {
        $this->validate();

        try {
            OrderDetail::create([
                'order_id' => $this->order_id,
                'good_id' => $this->good_id,
                'good_sell_price' => $this->good_sell_price,
                'discount' => $this->discount,
                'quantity' => $this->quantity,
                'description' => $this->description,
            ]);

            $this->refresh_order_details($this->order_id);

            $this->action_add = false;

            session()->flash('success','新增成功！');
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
        }
    }

    public function edit($order_detail_id)
    {
        $this->order_detail_id = $order_detail_id;

        try {
            $order_detail = OrderDetail::find($order_detail_id);

            if( !$order_detail ) {
                session()->flash('error','訂單明細不存在！');
            } else {
                $this->good_id = $order_detail->good_id;
                $this->good_sell_price = $order_detail->good_sell_price;
                $this->discount = $order_detail->discount;
                $this->quantity = $order_detail->quantity;
                $this->description = $order_detail->description;

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
            OrderDetail::Where('order_detail_id', $this->order_detail_id)->update([
                'good_id' => $this->good_id,
                'good_sell_price' => $this->good_sell_price,
                'discount' => $this->discount,
                'quantity' => $this->quantity,
                'description' => $this->description,
            ]);

            $this->refresh_order_details($this->order_id);

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

    public function delete($order_detail_id)
    {
        try {
            OrderDetail::Where('order_detail_id', $order_detail_id)->delete();

            $this->refresh_orders();

            session()->flash('success','刪除成功！');
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
        }
    }
}
