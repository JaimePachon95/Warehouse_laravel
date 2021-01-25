<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\Warehousedescription;
use Doctrine\Inflector\Rules\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouses = Warehouse::latest()->get();

        return view('warehouses.index',[
            'warehouses' =>$warehouses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $modelWarehouse = new Warehouse();
            $modelWarehouse->name=$request->name;
            $modelWarehouse->headquarters_number=$request->headquartersNumber;
            $modelWarehouse->save();

            foreach($request->descriptions as $description){
                $this->storeDescription(
                    $modelWarehouse['id'],
                    $description['phone'],
                    $description['city'],
                    $description['address']
                );
            }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                        'message' => $e->getMessage(),
                        'status' => 'fail'], 400);
        }

        return response()->json(true, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function show(Warehouse $warehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function edit(Warehouse $warehouse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $modelWarehouse= new Warehouse();
        $Warehousefind=$modelWarehouse->where(['id' =>$request->id])->get();
        $warehouse = Warehouse::find($Warehousefind[0]['id']);
        $warehouse->name=$request->name;
        $warehouse->headquarters_number=$request->headquartersNumber;
        $warehouse->save();
        return response()->json(true, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $modelWarehouse= new Warehouse();
        $Warehousefind=$modelWarehouse->where(['id' =>$request->id])->get();
        $warehouse = Warehouse::find($Warehousefind[0]['id']);
        $warehouse->delete();
        return response()->json(true, 200);
    }


    private function storeDescription( $Warehouse_id, $phone, $city, $address){
        $modelWarehousedescription = new Warehousedescription();
        $modelWarehousedescription->warehouse_id=$Warehouse_id;
        $modelWarehousedescription->phone=$phone;
        $modelWarehousedescription->city=$city;
        $modelWarehousedescription->address=$address;
        $modelWarehousedescription->save();
    }
}
