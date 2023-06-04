<div>
    @if($order_id )
        <div>訂單編號：{{ $order_id }}</div>

        <button wire:click="add">新增訂單明細</button>

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
                商品編號<input wire:model="good_id" type="text">
                @error('good_id') <span class="error alert alert-danger">{{ $message }}</span> @enderror
            </div>

            <div>
                商品售價：<input wire:model="good_sell_price" type="number" min="0">
                @error('good_sell_price') <span class="error alert alert-danger">{{ $message }}</span> @enderror
            </div>

            <div>
                折扣：<input wire:model="discount" type="number" min="0">
                @error('discount') <span class="error alert alert-danger">{{ $message }}</span> @enderror
            </div>

            <div>
                數量：<input wire:model="quantity" type="number" min="0">
                @error('quantity') <span class="error alert alert-danger">{{ $message }}</span> @enderror
            </div>

            <div>
                描述<textarea wire:model="description"></textarea>
            </div>

            @if($action_add) <button wire:click="add_save">儲存</button> @endif
            @if($action_edit) <button wire:click="edit_save">儲存</button> @endif
            <button wire:click="cancel">取消</button>
        </div>
        @endif
    @endif

    @forelse ($order_details as $index => $order_detail)
        <div wire:key='"order_detail_{{$order_detail->order_detail_id}}"' class="px-1 border">
            訂單明細編號：{{ $order_detail->order_detail_id }} 商品編號：{{ $order_detail->good_id }} 商品售價：{{ $order_detail->good_sell_price }} 折扣：{{ $order_detail->discount }} 數量：{{ $order_detail->quantity }} 描述：{{ $order_detail->description }}

            <button wire:click="edit({{$order_detail->order_detail_id}})">修改</button>
            <button wire:click="delete({{$order_detail->order_detail_id}})">刪除</button>
        </div>
        <div class="pb-2 ps-5">
            @forelse ($order_detail->goods as $good)
                商品細節 {{ $good->good_id }}  顏色：{{ $good->color_id }}  尺吋：{{ $good->size_id }}  庫存編號：{{ $good->stock_id }}  商品名稱：{{ $good->good_name }}
            @empty
            @endforelse
        </div>
    @empty
        <div><strong>沒有訂單明細</strong></div>
    @endforelse
</div>
