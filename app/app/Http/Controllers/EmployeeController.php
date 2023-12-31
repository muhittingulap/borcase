<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Employee::with(["vehicle"]);

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
                'name' => 'required|min:3',
                'email' => 'required|email',
                'phone' => 'required|min:10',
            ]
        );

        if ($validator->fails()) {
            return $this->error('Warning', 401, [
                "errors" => $validator->errors()
            ]);
        }

        if (!Employee::where('email', $request->email)->exists()) {
            Employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
        } else {
            return $this->error('Warning', 401, [
                "errors" => [
                    "Çalışan maili zaten sistemde kayıtlı"
                ]
            ]);
        }

        return $this->success([]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Employee::where('id', $id)->get();
        return $this->success($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         // validation control
         $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:3',
                'email' => 'required|email',
                'phone' => 'required|min:10',
            ]
        );

        if ($validator->fails()) {
            return $this->error('Warning', 401, [
                "errors" => $validator->errors()
            ]);
        }

        if (!Employee::where([['name', $request->email], ['id', "!=", $id]])->exists()) {
            $up=[
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ];
            Employee::where('id', $id)->update($up);
        } else {
            return $this->error('Warning', 401, [
                "errors" => [
                    "Çalışan maili zaten sistemde kayıtlı"
                ]
            ]);
        }

        return $this->success([]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Employee::find($id)) {
            Employee::find($id)->delete();
        } else {
            return $this->error('Warning', 401, [
                "errors" => [
                    "Böyle bir çalışan kayıtlı değil"
                ]
            ]);
        }
        return $this->success([]);
    }
}
