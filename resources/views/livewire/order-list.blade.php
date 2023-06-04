<div x-data="{}">
    <div>訂單</div>
    <button wire:click="add">新增</button>

    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="alert alert-danger" role="alert">
            {{ session()->get('error') }}
        </div>
    @endif

    @if ($action_add || $action_edit)
    <div class="ms-3 py-3">
        <div>
            名稱：<input wire:model="name" type="text">
            @error('name') <span class="error alert alert-danger">{{ $message }}</span> @enderror
        </div>

        <div>
            訂單原始總額：<input wire:model="total_price_origin" type="number" min="0">
            @error('total_price_origin') <span class="error alert alert-danger">{{ $message }}</span> @enderror
        </div>

        <div>
            訂單折扣後總額：<input wire:model="total_price_after_discount" type="number" min="0">
            @error('total_price_after_discount') <span class="error alert alert-danger">{{ $message }}</span> @enderror
        </div>

        <div>
            總數量：<input wire:model="total_quantity" type="number" min="0">
            @error('total_quantity') <span class="error alert alert-danger">{{ $message }}</span> @enderror
        </div>

        @if($action_add) <button wire:click="add_save">儲存</button> @endif
        @if($action_edit) <button wire:click="edit_save">儲存</button> @endif
        <button wire:click="cancel">取消</button>
    </div>
    @endif

    @if ($order_infos)
    <div class="border">
        @foreach ($order_infos as $order)
            訂單 {{ $order->order_id }} {{ $order->name }} {{ $order->total_price_origin }} {{ $order->total_price_after_discount }} {{ $order->total_quantity }} <br />

            <div class="ms-5">
            @foreach ($order->order_details as $order_detail)
                訂單明細 {{ $order_detail->order_detail_id }} {{ $order_detail->good_id }} {{ $order_detail->good_sell_price }} {{ $order_detail->discount }} {{ $order_detail->quantity }} {{ $order_detail->description }}  <br />

                <div class="ms-5">
                @foreach ($order_detail->goods as $good)
                    商品細節 {{ $good->good_id }}  顏色：{{ $good->color_id }}  尺吋：{{ $good->size_id }}  庫存編號：{{ $good->stock_id }}  商品名稱：{{ $good->good_name }}  <br />
                @endforeach
                </div>

            @endforeach
            </div>

        @endforeach
    </div>
    @endif

    @forelse ($orders as $index => $order)
        <div wire:key='"ordre_{{$order->order_id}}"' class="border">
            <a href="" @click.prevent="$wire.get_order_detail({{ $order->order_id }});">{{ $order->order_id }}</a>

            {{ $order->name }} 訂單原始總額：{{ $order->total_price_origin }} 訂單折扣後總額：{{ $order->total_price_after_discount }} 總數量：{{ $order->total_quantity }} 客戶：{{ $order->user_id }}

            <button wire:click="edit({{ $order->order_id }})">修改</button>
            <button wire:click="delete({{ $order->order_id }})">刪除</button>
            <button wire:click="all_info({{ $order->order_id }})">完整內容</button>
        </div>
    @empty
        <div><strong>沒有訂單</strong></div>
    @endforelse

    <div class="pt-3">
        @livewire('order-detail-list')
    </div>
</div>
