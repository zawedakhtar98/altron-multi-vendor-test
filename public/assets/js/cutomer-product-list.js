$(document).ready(function(){
    
    let is_login = $('#is_login').val() ? $('#is_login').val() : 0;
    $('.buy_now').on('click',function(){       
        if(is_login===0){
            Command: toastr["error"]("Session time out. Please Login!")            
            setTimeout(()=>{
                window.location.href=loginUrl;
            },3000);
        }        
    });    
    
    $(document).on('click','.add-to-cart-btn',function(e){
    e.preventDefault();
     let prod_id = $(this).data('prodid');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    $.ajax({
        url: baseUrl+'/cart/add/' + prod_id,
        type: 'POST',
        dataType: 'JSON', 
        success: function(response){
            if(response.status){
                $('#cart-count').text(response.count);
                Command: toastr["success"]("Item added to cart");  
            }
            else{
                Command: toastr["error"](response.message);
            }
        }
    });
});


})
