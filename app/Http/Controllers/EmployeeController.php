<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    
    public function index()
    {
       $employees=Employee::all();
       return response(['employees'=>EmployeeResource::collection($employees),'message'=>'Successful'],200); 
    }

    
    public function store(Request $request)
    {
        $data=$request->all();
        $validator = Validator::make($data, [
            'name' => 'required|max:50',
            'age' => 'required|max:50',
            'position' => 'required|max:50',
            'salary' => 'required|max:50'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 
            'somethings wrong']);
        }

        $employee = Employee::create($data);

        return response([ 'employee' => new 
        EmployeeResource($employee), 
        'message' => 'Success'], 200);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return response([ 'employee' => new 
        EmployeeResource($employee), 'message' => 'Success'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $employee->update($request->all());

        return response([ 'employee' => new 
        EmployeeResource($employee), 'message' => 'Success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response(['message' => 'Employee deleted']);
    }
}
