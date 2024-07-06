<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package as ModelsPackage;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class Package extends Controller
{
    public function index()
    {
        $packages = ModelsPackage::all();
        $data = [
            'nav' => 'Package',
            'packages' =>  $packages,
        ];

        return view('admin.package', $data);
    }

    public function getById(Request $request)
    {
        $data = ModelsPackage::find($request->id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        if ($request->profit < 0) {
            Alert::error('Sorry', 'min 1');
            return back();
        }

        $data = ModelsPackage::find($request->id);
        $data->price = $request->price;
        $data->hours = $request->hours;
        $data->total_profit = $request->profit;
        $data->stock = $request->stock;
        $data->static_stock = $request->stock;
        $data->save();

        Alert::success('Success', 'Success Update');
        return back();
    }
    public function add(Request $request)
    {
        if ($request->profit < 0) {
            Alert::error('Sorry', 'min 1');
            return back();
        }

        $data = new ModelsPackage();
        $data->price = $request->price;
        $data->hours = $request->hours;
        $data->total_profit = $request->profit;
        $data->stock = $request->stock;
        $data->static_stock = $request->stock;
        $data->save();

        Alert::success('Success', 'Success Add Data');
        return back();
    }

    public function delete(Request $request)
    {
        ModelsPackage::find($request->id)->delete();
        Alert::success('Success', 'Success Delete Data');
        return back();
    }

    public function resetStock(Request $request)
    {
        $data = ModelsPackage::all();
        foreach ($data as $item) {
            $item->stock = $item->static_stock;
            $item->save();
        }
        return response()->json(['count package' => $data->count()]);
    }
}
