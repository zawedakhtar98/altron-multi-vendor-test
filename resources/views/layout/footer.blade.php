<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery Validation Plugin -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    IsCartValueAvail();
    function IsCartValueAvail(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token()}}'
            }
        })
        $.ajax({
            url: '{{url("cart/count")}}',
            type: 'GET',
            dataType: 'JSON', 
            success: function(response){
                if(response.count>0){
                    $('#cart-count').text(response.count);
                }
            }
        });
    }
</script>

@yield('javascript')
</body>
</html>
