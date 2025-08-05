<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{asset('assets/css/admin.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    @yield('custom-css')
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center">Seller Panel</h4>
        <a href="{{route('seller.dashboard')}}"><i class="fas fa-home"></i> Dashboard</a> 
        <a href="{{route('seller.product.list')}}"><i class="fas fa-box"></i> Products List</a> 
        <a href="{{route('logout')}}"><i class="fas fa-cogs"></i> Logout</a>
    </div>