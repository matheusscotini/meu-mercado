<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name'      => 'required|string|max:255',
            'delivery_date'      => 'required|date',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($data) {
            $productIds = collect($data['items'])->pluck('product_id')->all();
            $products = Product::whereIn('id', $productIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $total = 0;
            $errors = [];

            foreach ($data['items'] as $item) {
                $product = $products[$item['product_id']] ?? null;
                $qtyRequested = $item['quantity'];

                if (!$product) {
                    $errors[] = "Produto ID {$item['product_id']} não encontrado.";
                    continue;
                }

                if ($qtyRequested > $product->qty_stock) {
                    $errors[] = "Estoque insuficiente para {$product->name}. Solicitado {$qtyRequested}, disponível {$product->qty_stock}.";
                }
            }

            if (!empty($errors)) {
                return response()->json([
                    'message' => 'Estoque insuficiente para um ou mais produtos.',
                    'errors' => [
                        'items' => $errors,
                    ],
                ], 422);
            }

            // Passou na validação de estoque → cria pedido
            $order = Order::create([
                'customer_name' => $data['customer_name'],
                'delivery_date' => $data['delivery_date'],
                'total_amount'  => 0,
            ]);

            foreach ($data['items'] as $item) {
                $product = $products[$item['product_id']];
                $qty = $item['quantity'];
                $unitPrice = $product->price;
                $subtotal = $unitPrice * $qty;

                // Cria item
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $qty,
                    'unit_price' => $unitPrice,
                    'subtotal'   => $subtotal,
                ]);

                // Debita estoque
                $product->decrement('qty_stock', $qty);

                $total += $subtotal;
            }

            $order->update(['total_amount' => $total]);

            return response()->json([
                'message' => 'Pedido cadastrado com sucesso.',
                'order_id' => $order->id,
                'total_amount' => $total,
            ], 201);
        });
    }
}
