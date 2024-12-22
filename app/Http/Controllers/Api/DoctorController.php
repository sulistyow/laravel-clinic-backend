<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    //
    public function index()
    {
        $doctors = User::where('role', 'doctor')->get()->with('clinic', 'specialization')->get();
        return response()->json([
            'status' => 'success',
            'data' => $doctors,
        ], 201);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'emaill' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required',
            'clinic_id' => 'required',
            'specialist_id' => 'required',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $doctor = User::create($data);
        // upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '' . $image->getClientOriginalExtension();
            $filePath = $image->storeAs('doctor', $image_name, 'public');
            $doctor->image = '/storage/' . $filePath;
            $doctor->save();
        }

        return response()->json([
            'status' => 'success',
            'data' => $doctor,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required',
            'role' => 'required',
            'clinic_id' => 'required',
            'specialist_id' => 'required',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $doctor = User::find($id);
        $doctor->update($data);
        // upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '' . $image->getClientOriginalExtension();
            $filePath = $image->storeAs('doctor', $image_name, 'public');
            $doctor->image = '/storage/' . $filePath;
            $doctor->save();
        }

        return response()->json([
            'status' => 'success',
            'data' => $doctor,
        ], 200);
    }

    public function destroy($id)
    {
        $doctor = User::find($id);
        $doctor->delete();
        return response()->json([
            'status' => 'success',
            'data' => 'Doctor deleted',
        ], 200);
    }

    public function getDoctorActive()
    {
        $doctors = User::where('role', 'doctor')->where('status', 'active')->get()->with('clinic', 'specialization')->get();
        return response()->json([
            'status' => 'success',
            'data' => $doctors,
        ], 200);
    }

    public function searchDoctor(Request $request)
    {
        $doctors = User::where('role', 'doctor')
            ->where('name', 'like', '%' . $request->search . '%')
            ->where('specialist_id', $request->specialist_id)
            ->get()->with('clinic', 'specialization')->get();

        return response()->json([
            'status' => 'success',
            'data' => $doctors,
        ], 200);
    }

    // get doctor by id
    public function getDoctorById($id)
    {
        $doctor = User::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $doctor,
        ], 200);
    }

    // get doctor by clinic id
    public function getDoctorByClinicId($id)
    {
        $doctors = User::where('role', 'doctor')->where('clinic_id', $id)->get()->with('clinic', 'specialization')->get();
        return response()->json([
            'status' => 'success',
            'data' => $doctors,
        ], 200);
    }

    // get doctor by specialist
    public function getDoctorBySpecialist($id)
    {
        $doctors = User::where('role', 'doctor')->where('specialist_id', $id)->get()->with('clinic', 'specialization')->get();
        return response()->json([
            'status' => 'success',
            'data' => $doctors,
        ], 200);
    }

}
