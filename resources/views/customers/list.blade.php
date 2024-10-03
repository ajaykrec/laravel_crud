<div class="row mb-5">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between">
                    <h5>Customers</h5>
                    <div class="me-3"><a href="{{ route('customer.create') }}" class="btn btn-primary btn-sm">Add Customer</a></div>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Country</th>
                                <th scope="col">Gender</th>                                
                                <th scope="col">Subscription</th>
                                <th scope="col" width="12%">option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($customers)
                                @foreach($customers as $val)
                                <tr id="row-{{ $val['customer_id'] }}">
                                    <th scope="row">{{ $count1 }}</th>
                                    <td>{{ $val['name'] }}</td>
                                    <td>{{ $val['email'] }}</td>
                                    <td>{{ $val['phone'] }}</td>
                                    <td>{{ $val['country'] }}</td>
                                    <td>
                                    @if($val['gender']==0)
                                    Male
                                    @else
                                    Female
                                    @endif
                                    </td>
                                    <td>
                                    @php
                                    $subscription = $val['subscription'] ?? '';
                                    $subscriptionArr = json_decode($subscription);
                                    echo implode(',',$subscriptionArr);
                                    @endphp
                                    </td>
                                    <td>
                                        <button data-url="{{ route('customer.destroy',$val['customer_id']) }}" class="btn btn-sm btn-danger delete" data-id="{{ $val['customer_id'] }}">Delete</button>
                                        <a href="{{ route('customer.edit',$val['customer_id']) }}" class="btn btn-sm btn-success">Edit</a>
                                    </td>
                                </tr>
                                @php $count1++; @endphp
                                @endforeach
                            @else
                            <tr>
                            <td colspan="8">No Record Found.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
    $('.delete').on('click',(e)=>{
        let id = e.target.getAttribute('data-id');
        let url = e.target.getAttribute('data-url');
        $.ajax({
            type: "delete",
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            dataType: "json",
            url: url, 
            success: function(response){  
                $('#row-'+id).hide()                   
                showToaster({'status':'success','message':response.message})    
            }
        });  
    })
    </script>
