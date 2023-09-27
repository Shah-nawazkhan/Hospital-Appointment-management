<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Homecontroller extends Controller
{
    public function redirect()
    {
        if(Auth::id())
        {
            if(Auth::user()->usertype=='0'){
                $doctor = doctor::all();
                return view('user.home',compact('doctor'));
            }
            else 
            {
                return view('admin.home');
            }
        }
        else
        {
            return redirect()->back();
        }

    }
    public function index()
    {
        if(Auth::id()){
            return redirect('home');
        }
        else{

            $doctor = doctor::all();
            return view('user.home',compact('doctor'));
        }
    }
    public function appointment(Request $request)
    {
        
        $data = new appointment;
        $data->name=$request->name;
        $data->email=$request->email;
        $data->date=$request->date;
        $data->phone=$request->number;
        $data->message=$request->message;
        $data->doctor_id=$request->doctor;
        $data->status='In progress';
        // dd($data);
        if(Auth::id())
        {

            $data->user_id=Auth::user()->id;
        }

        $data->save();

        return redirect()->back()->with('message', 'Appointment request successful . we will contact with you soon');
    }
    public function myappointment()
    {
        if(Auth::id())
        {
            if(Auth::user()->usertype==0)
            {

                $userid = Auth::user()->id;
    
                $appoint = appointment::where('user_id',$userid)->get();
                foreach ($appoint as $key => $appointment) {
                    # code...
                    $appointment->doctor_id = Doctor::select('name')->where('id',$appointment->doctor_id )->first();

                }
                return view('user.my_appointment',compact('appoint'));
            }
            
        }
        else
        {
            return redirect()->back();
        }
    }
    public function cancel_appoint($id)
    {
        $data=appointment::find($id);
        $data->delete();

        return redirect()->back();
    }
}
