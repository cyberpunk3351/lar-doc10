<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request, ApiResponse $response)
    {
        $limit = $request->get('limit');
        if (!isset($limit)) $limit = 20;
        $orders = Order::with('equipments', 'employes')->paginate($limit);
        if (count($orders) > 0) {
            $response->setStatus('OK');
            $response->setMessage('Данные успешно загружины');
            $response->setData(['orders' => $orders]);
        }
        return $response->asJson();
    }

    public function store(Request $request, ApiResponse $response)
    {
        $order = new Order;
        $order->fill($request->order)->save();
        $response->setStatus('OK');
        $response->setMessage('Запись создана');
        $response->setData(['order' => $order]);
        return $response->asJson();
    }

    public function show($id, ApiResponse $response)
    {
        $order = Order::find($id);
        if (isset($order)) {
            $response->setStatus('OK');
            $response->setMessage('Запись с таким id обнаружена');
            $response->setData(['$order' => $order]);
        } else {
            $response->setMessage('Запись с таким id не обнаружена');
        }
        return $response->asJson();
    }

    public function update(Request $request, ApiResponse $response)
    {
        $order = Order::find($request->get('id'));
        if ($order !== null) {
            $order->update($request->order);
            $response->setStatus('OK');
            $response->setMessage('Запись с таким id обновлена');
            $response->setData(['order' => $order]);
        } else {
            $response->setMessage('Запись с таким id не обнаружена');
        }
        return $response->asJson();
    }

    public function destroy($id, ApiResponse $response)
    {
        $order = Order::find($id);
        if ($order !== null) {
            $order->delete();
            $response->setStatus('OK');
            $response->setMessage('Запись с таким id удалена');
            $response->setData(['$order' => $order]);
        } else {
            $response->setMessage('Запись с таким id не обнаружена');
        }
        return $response->asJson();
    }
}
