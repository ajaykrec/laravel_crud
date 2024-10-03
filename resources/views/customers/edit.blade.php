@extends('layout.main')

@section('page-content')
<div class="container">
<div class="row mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                <h5>Edit Customer</h5>                    
                </div>
                <div class="card-body">
                <form id="bucket-form" method="post" action="{{ route('customer.update',$id)}}" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" placeholder="" name="name" value="{{ old('name', $data['name']) }}"> 
                <span class="err" id="error-name">
                @error('name')
                {{$message}}
                @enderror 
                </span>                 
                </div> 

                <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" placeholder="" name="email" value="{{ old('email', $data['email']) }}"> 
                <span class="err" id="error-email">
                @error('email')
                {{$message}}
                @enderror 
                </span>                 
                </div> 

                <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" class="form-control" placeholder="" name="phone" value="{{ old('phone', $data['phone']) }}"> 
                <span class="err" id="error-phone">
                @error('phone')
                {{$message}}
                @enderror 
                </span>                 
                </div> 

                
                <div class="my-3">
                <label class="form-label">Profile image </label>
                <div id="imgdiv-outer">
                    @if($data['profile_image'])  
                        @php
                            $array = [
                                'table'=>'customer',
                                'table_id'=>'customer_id',
                                'table_id_value'=>$id ?? '',
                                'table_field'=>'profile_image',
                                'file_name'=>old('profile_image', $data['profile_image'] ?? ''),
                                'file_path'=>'uploads/customers',
                            ];
                            $json_string = json_encode($array);
                        @endphp
                        <div class="imgdiv">
                        <span title="Remove" class="delete_image" data-content="{{ $json_string }}">X</span>
                        <img src="{{ url('/storage/uploads/customers/'.$data['profile_image']) }}" class="img-thumb" width="100">                    
                        </div>      
                        <input type="hidden" name="profile_image" value="{{ old('profile_image', $data['profile_image'] ?? '') }}"> 
                               
                    @else
                        <input class="form-control" type="file" name="profile_image"> 
                        <span class="err" id="error-profile_image">
                        @error('profile_image')
                        {{$message}}
                        @enderror 
                        </span>               
                    @endif
                </div>                      
                </div>

                <div class="mb-3">
                <label class="form-label">Country</label>
                @php 
                $country = old('country', $data['country']);
                @endphp
                <select class="form-select" name="country"> 
                @if($countries)
                    @foreach($countries as $val)
                    <option value="{{ $val['name'] }}" {{ ($country==$val['name']) ? 'selected' : '' }}>{{ $val['name'] }}</option>
                    @endforeach
                @endif
                </select>
                <span class="err" id="error-country">
                @error('country')
                {{$message}}
                @enderror 
                </span>                 
                </div> 


                <div class="mb-3">
                <label class="form-label">Gender</label>
                @php 
                $gender = old('gender',$data['gender']);
                @endphp
                <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender-1" value="0" {{ ($gender=='0') ? 'checked' : '' }}>
                <label class="form-check-label" for="gender-1">
                Male
                </label>
                </div>
                <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender-2" value="1" {{ ($gender=='1') ? 'checked' : '' }}>
                <label class="form-check-label" for="gender-2">
                Female
                </label>
                </div>
                <span class="err" id="error-gender">
                @error('gender')
                {{$message}}
                @enderror 
                </span> 
                </div> 

                <div class="mb-3">
                <label class="form-label">Subscription</label>
                @php 
                $subscription = old('subscription[]',$data['subscription']) ?? [];
                @endphp
                <div class="form-check">
                <input class="form-check-input" type="checkbox" id="subscription-1" name="subscription[]" value="weekly" {{ (in_array('weekly',$subscription)) ? 'checked' : '' }}>
                <label class="form-check-label" for="subscription-1">
                weekly 
                </label>
                </div>

                <div class="form-check">
                <input class="form-check-input" type="checkbox" id="subscription-2" name="subscription[]" value="Monthly" {{ (in_array('Monthly',$subscription)) ? 'checked' : '' }}>
                <label class="form-check-label" for="subscription-2">
                Monthly 
                </label>
                </div>

                <div class="form-check">
                <input class="form-check-input" type="checkbox" id="subscription-2" name="subscription[]" value="Yearly" {{ (in_array('Yearly',$subscription)) ? 'checked' : '' }}>
                <label class="form-check-label" for="subscription-2">
                Yearly
                </label>
                </div>
              
                <span class="err" id="error-subscription">
                @error('subscription')
                {{$message}}
                @enderror 
                </span>                 
                </div> 
                
                <a href="{{ route('customer.index') }}" class="btn btn-secondary"><< Back</a>                    
                <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $('.delete_image').on('click', (e)=>{

        let json_string = e.target.getAttribute('data-content')    
        let obj = JSON.parse(json_string)
        console.log(obj);

        swal({		  
            title				: 'Are you sure?',
            text				: 'You want to delete this image',
            type				: 'warning',
            showCancelButton	: true,
            confirmButtonColor  : '#3085d6',
            cancelButtonColor	: '#d33',
            confirmButtonText	: 'Yes, delete it!',
            cancelButtonText	: 'No, cancel!',
            confirmButtonClass  : 'btn btn-success',
            cancelButtonClass	: 'btn btn-danger',
            buttonsStyling	    : false,
            closeOnConfirm	    : false	
        }).then(function () {

            $.ajax({
                type: "delete",
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                dataType: "json",
                url: "{{ route('delete.file') }}",   
                data: obj, 
                success: function(response){          
                    $('#imgdiv-outer').html(response.message)  
                    swal('Deleted!','Your file has been deleted.', 'success' )   
                }
            });  
        })	
    })
    </script>

@endsection


