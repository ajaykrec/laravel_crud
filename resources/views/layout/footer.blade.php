@php
//==
@endphp
</div>

<!-- Toasts -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
<div class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body"></div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>
</div>

<script src="{{ asset('/') }}assets/js/bootstrap.bundle.min.js"></script> 
<script src="{{ asset('/') }}assets/js/custom.js"></script> 

{{-- sweetalert2 File --}}  
<link rel="stylesheet" href="{{ asset('/') }}assets/sweetalert/sweetalert2.min.css"  media="all" />
<script type="text/javascript" src="{{ asset('/') }}assets/sweetalert/sweetalert2.min.js"></script>

<script>
 const showToaster = (obj)=>{    
    let status  = obj.status;
    let message = obj.message;
    if(status=='error'){
        $('.toast').addClass('bg-danger')
    }
    else if(status=='warning'){
        $('.toast').addClass('bg-warning')
    }    
    else if(status=='success'){
        $('.toast').addClass('bg-success')
    }
    else{
        $('.toast').addClass('bg-secondary')
    }    
    $('.toast-body').html(message)
    new bootstrap.Toast('.toast').show();
}
const hideToaster = (obj)=>{    
    new bootstrap.Toast('.toast').hide();    
}
@if(session()->has('error'))
    showToaster({'status':'error','message':"{{ session('error') }}"})
@endif
@if(session()->has('success'))
    showToaster({'status':'success','message':"{{ session('success') }}"})
@endif   
</script>
</body>
</html>