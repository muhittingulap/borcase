<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Vehicle::with(["user"]);

        $data = $query->paginate(50);

        return $this->success($data);
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
        // validation control
        $validator = Validator::make(
            $request->all(),
            [
                'plate' => 'required|min:3',
                'model' => 'required',
                'brand' => 'required',
            ]
        );

        if ($validator->fails()) {
            return $this->error('Warning', 401, [
                "errors" => $validator->errors()
            ]);
        }

        if (!Vehicle::where('plate', $request->plate)->exists()) {
            Vehicle::create([
                'plate' => $request->plate,
                'model' => $request->model,
                'brand' => $request->brand,
            ]);
        } else {
            return $this->error('Warning', 401, [
                "errors" => [
                    "Araç plakası zaten sistemde kayıtlı"
                ]
            ]);
        }

        return $this->success([]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Vehicle::where('id', $id)->get();
        return $this->success($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validation control
        $validator = Validator::make(
            $request->all(),
            [
                'plate' => 'required|min:3',
                'model' => 'required',
                'brand' => 'required',
            ]
        );

        if ($validator->fails()) {
            return $this->error('Warning', 401, [
                "errors" => $validator->errors()
            ]);
        }


        if (!Vehicle::where([['plate', $request->plate], ['id', "!=", $id]])->exists()) {
            $up = [
                'plate' => $request->plate,
                'model' => $request->model,
                'brand' => $request->brand,
            ];
            Vehicle::where('id', $id)->update($up);
        } else {
            return $this->error('Warning', 401, [
                "errors" => [
                    "Araç plakası zaten sistemde kayıtlı"
                ]
            ]);
        }

        return $this->success([]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Vehicle::find($id)) {
            Vehicle::find($id)->delete();
        } else {
            return $this->error('Warning', 401, [
                "errors" => [
                    "Böyle bir araç sistemde kayıtlı değil"
                ]
            ]);
        }
     
        return $this->success([]);
    }
}
