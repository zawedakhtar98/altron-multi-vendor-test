@extends('layout.app')
@section('title', 'Product')
@section('main')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('custom-css')
  <style>
    .product-card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: transform 0.2s;
        background: #fff;
    }
    .product-card:hover {
        transform: translateY(-5px);
    }
    .product-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }
    .product-price {
        font-size: 1.2rem;
        color: #28a745;
        font-weight: bold;
    }
    .btn-buy {
        background-color: #ff5722;
        border: none;
    }
    .btn-buy:hover {
        background-color: #e64a19;
    }
  </style>
@endsection

<div class="container py-5">
    <h2 class="mb-4 text-center">Our Products</h2>
    <div id="product-container">
        @include('customer.ajax.product-list', ['product' => $product])
    </div>
    <div class="row g-4">
        <div class="col-md-12 col-sm-12">
            <div id="loading" style="display: none;text-align:center;margin:20px;">
                <b>Loading...</b>
            </div>
        </div>
        <input type="hidden" id="next-page" value="{{ $product->nextPageUrl()}}">
        <input type="hidden" id="is_login" value="{{Auth::id()}}">
        {{-- {{$product->links()}} --}}
    </div>
</div>
@endsection

@section('javascript')
    <script src="{{asset('assets/js/cutomer-product-list.js')}}"></script>    

    <script>
        var baseUrl = "{{ url('/') }}";       // Base URL
        var loginUrl = "{{ route('login') }}"; // Named route
    </script>

    <script>
        $(document).ready(function(){

        var loading = false;

        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                
                if(loading) return;
                
                var nextPage = $('#next-page').val();
                if(nextPage) {
                    loading = true;
                    $('#loading').show();

                    $.get(nextPage, function(data){
                        $('#product-container').append(data);
                        $('#loading').hide();

                        // Update next page URL or remove if no more pages
                        var newPage = nextPage.replace(/page=\d+/, function(match){
                            return 'page=' + (parseInt(match.split('=')[1]) + 1);
                        });
                        
                        // Laravel pagination handles it automatically
                        var lastPage = {{ $product->lastPage() }};
                        var currentPage = parseInt(newPage.match(/page=(\d+)/)[1]);
                        if(currentPage > lastPage){
                            $('#next-page').val('');
                        } else {
                            $('#next-page').val(newPage);
                        }

                        loading = false;
                    });
                }
            }
        });

    });
    </script>

@endsection