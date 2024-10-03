<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use App\Traits\AllFunction;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meta = [
            'title'=>'Customer',
            'keywords'=>'',
            'description'=>'',
        ];   
        
        //== get buckets ==
        $count1 = 1;
        $q = DB::table('customer');          
        $q->select('*');        
        $q->orderBy("name", "asc");         
        $customers  = $q->get()->toArray(); 
        $customers = json_decode(json_encode($customers), true);
        //p($buckets);
        
        $data = compact('meta','customers','count1');    
        //p($data);     
        return view('home')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $meta = [
            'title'=>'Add Customer',
            'keywords'=>'',
            'description'=>'',
        ];    
        $countries = Country::all()->toArray();

        $data = compact('meta','countries'); 
        return view('customers.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required', 
            'email' => 'required|unique:customer', 
            'phone' => 'required',    
            'profile_image' => 'required|mimes:png,jpeg,gif,webp|image|max:2048', // size : 1024*2 = 2048 = 2MB          
        ];
        $messages = [];
        $validation = Validator::make( 
            $request->toArray(), 
            $rules, 
            $messages
        );
        
        if($validation->fails()) {            
            return back()->withInput()->withErrors($validation->messages());            
        }
        else{

            //=== upload file
            $file = $request->file('profile_image');
            if($file){
                $array = [
                    'file'=>$file,
                    'destination_path'=>'uploads/customers',                    
                    'width'=>400,
                    'height'=>400,                  
                ];
                $profile_image = AllFunction::upload_image($array);
            }
            else{
                $profile_image = $request['profile_image'] ?? '';
            }

            // store
            $table = new Customer;
            $table->name       = $request['name'];
            $table->email      = $request['email'];  
            $table->phone      = $request['phone']; 
            $table->profile_image = $profile_image;               
            $table->country    = $request['country'] ?? '';   
            $table->gender     = $request['gender'] ?? 0; 
            $table->subscription  = json_encode($request['subscription'] ?? '');               
            $table->save();
            // redirect
            return redirect( route('customer.index') )->with('success','Customer created successfully');
        }        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Customer::find($id); 
        if(!$data){
            return redirect( route('customer.index') );
        }
        $data = $data->toArray();
        $data['subscription'] = json_decode($data['subscription']);
        //p($data);

        $meta = [
            'title'=>'Edit customer',
            'keywords'=>'',
            'description'=>'',
        ];     

        $countries = Country::all()->toArray();
        $data = compact('meta','data','id','countries');         
        return view('customers.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'name' => 'required',            
            'email'     => 'required|unique:customer,email,'.$id.',customer_id',  
            'phone' => 'required',  
            'profile_image' => 'required|mimes:png,jpeg,gif,webp|image|max:2048', // size : 1024*2 = 2048 = 2MB             
        ];
        $messages = [];
        $validation = Validator::make( 
            $request->toArray(), 
            $rules, 
            $messages
        );        
        if($validation->fails()) {            
            return back()->withInput()->withErrors($validation->messages());            
        }
        else{

            //=== upload file
            $file = $request->file('profile_image');
            if($file){
                $array = [
                    'file'=>$file,
                    'destination_path'=>'uploads/customers',                    
                    'width'=>400,
                    'height'=>400,                            
                ];
                $profile_image = AllFunction::upload_image($array);
            }
            else{
                $profile_image = $request['profile_image'] ?? '';
            }

            $table = Customer::find($id);
            $table->name       = $request['name'];
            $table->email      = $request['email'];  
            $table->phone      = $request['phone'];    
            $table->profile_image = $profile_image;               
            $table->country    = $request['country'] ?? '';   
            $table->gender     = $request['gender'] ?? 0; 
            $table->subscription  = json_encode($request['subscription'] ?? '');      
            $table->save();           
            return redirect( route('customer.index') )->with('success','Customer updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $table = Customer::find($id);
        $table->delete();       

        return json_encode(array(
            'status'=>'success',
            'message'=>'Customer deleted successfully'
        ));
        exit;       
    }
}
