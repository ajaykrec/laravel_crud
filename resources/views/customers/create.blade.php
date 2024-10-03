@extends('layout.main')

@section('page-content')
<div class="container">
<div class="row mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                <h5>Add Customer</h5>                    
                </div>
                <div class="card-body">
                <form id="bucket-form" method="post" action="{{ route('customer.store')}}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" placeholder="" name="name" value="{{ old('name') }}"> 
                <span class="err" id="error-name">
                @error('name')
                {{$message}}
                @enderror 
                </span>                 
                </div> 

                <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" placeholder="" name="email" value="{{ old('email') }}"> 
                <span class="err" id="error-email">
                @error('email')
                {{$message}}
                @enderror 
                </span>                 
                </div> 

                <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" class="form-control" placeholder="" name="phone" value="{{ old('phone') }}"> 
                <span class="err" id="error-phone">
                @error('phone')
                {{$message}}
                @enderror 
                </span>                 
                </div> 

                <div class="my-3">
                <label class="form-label">Profile Image</label>
                <div id="imgdiv-outer"> 
                <input class="form-control" type="file" name="profile_image"> 
                <span class="err" id="error-profile_image">
                @error('profile_image')
                {{$message}}
                @enderror 
                </span>                               
                </div>
                </div>

                <div class="mb-3">
                <label class="form-label">Country</label>
                @php 
                $country = old('country');
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
                $gender = old('gender');
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
                $subscription = old('subscription[]') ?? [];
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
@endsection


