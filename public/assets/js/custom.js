/**** VALIDATION ****/
var email_regexp = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

var mobile_regexp = /^([0-9]{10})+$/;
var phone_regexp = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
var url_regexp = /\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i;
var dob_regexp = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
var password_regexp = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,}$/;

const validate = (obj)=>{
	var count = 0;
	Object.entries(obj).forEach(([key, val]) => {
		const type = val.type ?? ''	
		const funcName = 'validate_' + type    
		count = count + eval(`${funcName}(key,val)`);
	});	
	return count
}

const validate_name = (key,abj)=>{
	let i = 0;
	let title = abj.title ?? ''	
	let myInput = document.querySelector('input[name="'+key+'"]');
	let value = myInput.value
	if( !value ){
		$('input[name="'+key+'"]').addClass('error')
		$('#error-'+key).html(title+' is required')
		i = i + 1;
	}
	else{
		$('input[name="'+key+'"]').removeClass('error')
		$('#error-'+key).html('')
	}
	return i
}

const validate_number = (key,abj)=>{
	let i = 0;
	let title = abj.title ?? ''	
	let myInput = document.querySelector('input[name="'+key+'"]');
	let value = myInput.value
	if( !value ){
		$('input[name="'+key+'"]').addClass('error')
		$('#error-'+key).html(title+' is required')
		i = i + 1;
	}
	else{
		$('input[name="'+key+'"]').removeClass('error')
		$('#error-'+key).html('')
	}
	return i
}

const validate_email = (key,abj)=>{
	let i = 0;
	let title = abj.title ?? ''	
	let myInput = document.querySelector('input[name="'+key+'"]');
	let value = myInput.value	
	if( !value ){
		$('input[name="'+key+'"]').addClass('error')
		$('#error-'+key).html(title+' is required')
		i = i + 1;
	}
	else if( !value.match(email_regexp) ){
		$('input[name="'+key+'"]').addClass('error')
		$('#error-'+key).html('Invalid Email address')
		i = i + 1;
	}
	else{
		$('input[name="'+key+'"]').removeClass('error')
		$('#error-'+key).html('')
	}
	return i
}

const validate_phone = (key,abj)=>{
	let i = 0;
	let title = abj.title ?? ''	
	let myInput = document.querySelector('input[name="'+key+'"]');
	let value = myInput.value	
	if( !value ){
		$('input[name="'+key+'"]').addClass('error')
		$('#error-'+key).html(title+' is required')
		i = i + 1;
	}
	else if( !value.match(phone_regexp) ){
		$('input[name="'+key+'"]').addClass('error')
		$('#error-'+key).html('Invalid Phone Number')
		i = i + 1;
	}
	else{
		$('input[name="'+key+'"]').removeClass('error')
		$('#error-'+key).html('')
	}
	return i
}

const validate_password = (key,abj)=>{
	let i = 0;
	let title = abj.title ?? ''	
	let myInput = document.querySelector('input[name="'+key+'"]');
	let value = myInput.value
	if( !value ){
		$('input[name="'+key+'"]').addClass('error')
		$('#error-'+key).html(title+' is required')
		i = i + 1;
	}
	else if( value.length < 6 ){
		$('input[name="'+key+'"]').addClass('error')
		$('#error-'+key).html('The '+title+' field must be at least 6 characters.')
		i = i + 1;
	}
	else{
		$('input[name="'+key+'"]').removeClass('error')
		$('#error-'+key).html('')
	}
	return i
}

const validate_confirm_password = (key,abj)=>{
	let i = 0;
	let title = abj.title ?? ''	
	let match = abj.match ?? ''	
	let myInput = document.querySelector('input[name="'+key+'"]');
	let value = myInput.value
	if( !value ){
		$('input[name="'+key+'"]').addClass('error')
		$('#error-'+key).html(title+' is required')
		i = i + 1;
	}
	else if( $('input[name="'+match+'"]').val() != value ){
		$('input[name="'+key+'"]').addClass('error')
		$('#error-'+key).html(title+' mismatched')
		i = i + 1;
	}
	else{
		$('input[name="'+key+'"]').removeClass('error')
		$('#error-'+key).html('')
	}
	return i
}

/**** BUCKET ****/
const form_1 = document.getElementById('bucket-form')
const form_1_reqFields = { 
    name: { 'type': 'name', 'title': 'Name' }, 
    volume: { 'type': 'number', 'title': 'Volume' },    
}
Object.entries(form_1_reqFields).forEach(([key, val]) => {
    const type = val.type ?? ''	
    const funcName = 'validate_' + type    
    const myInput = document.querySelector('input[name="'+key+'"]');
    if(myInput){
        myInput.addEventListener("input", (e) => {  
            eval(`${funcName}(key,val)`);
        });
    }
    
});
if(form_1){
    form_1.addEventListener("submit", (e)=>{
        //e.preventDefault()  
        let error = validate(form_1_reqFields)  
        if(error > 0){
            e.preventDefault()   
            showToaster({'status':'error','message':'Please check required fields.'})    
        }  
        else{
            hideToaster()
        }  
    });
}

/**** BALL ****/
const form_2 = document.getElementById('ball-form')
const form_2_reqFields = { 
    name: { 'type': 'name', 'title': 'Name' }, 
    volume: { 'type': 'number', 'title': 'Volume' },    
}
Object.entries(form_2_reqFields).forEach(([key, val]) => {
    const type = val.type ?? ''	
    const funcName = 'validate_' + type    
    const myInput = document.querySelector('input[name="'+key+'"]');
    if(myInput){
        myInput.addEventListener("input", (e) => {  
            eval(`${funcName}(key,val)`);
        });
    }
    
});
if(form_2){
    form_2.addEventListener("submit", (e)=>{
        //e.preventDefault()  
        let error = validate(form_2_reqFields)  
        if(error > 0){
            e.preventDefault()   
            showToaster({'status':'error','message':'Please check required fields.'})    
        }  
        else{
            hideToaster()
        }  
    });
}





