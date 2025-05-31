<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permit Application</title>
    <link rel="stylesheet" href="{{url('CSS/appy.css')}}">
    @yield('styles')
</head>
<body>
    <div class="container">
        <!-- Navigation Bar -->
        

        <!-- Main Content -->
        <div class="cont">
        @yield('content') <!-- This is where the content of the individual views will go -->
        </div>
    </div>

    <!-- Include JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')

</body>
</html>

