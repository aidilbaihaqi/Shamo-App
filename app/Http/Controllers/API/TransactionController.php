<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function all(Request $request) {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $status = $request->input('status');

        if($id) {
            $transaction = Transaction::with(['items.product'])->find($id);
            if($transaction) {
                return ResponseFormatter::success(
                    $transaction, 
                    'Data transaksi berhasil diambil'
                );
            }else {
                return ResponseFormatter::error(
                    null, 
                    'Data transaksi tidak ada',
                    404
                );
            }

            $transaction = Transaction::with(['items.product'])->where('user_id', Auth::user()->id);

            if($status) {
                $transaction->where('status', $status);
            }

            return ResponseFormatter::success(
                $transaction->paginate($limit),
                'Data list transaki berhasil diambil'
            );
        }
    }

    public function checkout(Request $request) {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'exists:products,id',
            'total_price' => 'required|numeric',
            'shipping_price' => 'required|numeric',
            'status' => 'required|in:pending,success,failed,shipping,shipped'
        ]);

        $transaction = Transaction::create([
            'user_id' => Auth::user()->id,
            'address' => $request->address,
            'total_price' => $request->total_price,
            'shipping_price' => $request->shipping_price,
            'status' => $request->status
        ]);

        foreach ($request->items as $product) {
            TransactionItem::create([
                'user_id' => Auth::user()->id,
                'product_id' => $product['id'],
                'transaction_id' => $transaction->id,
                'quantity' => $product['quantity']
            ]);
        }

        return ResponseFormatter::success(
            $transaction->load('items.product'),
            'Transaksi berhasil'
        );
    }
}
