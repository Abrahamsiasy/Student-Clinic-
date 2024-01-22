<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-center">

    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-success" role="alert">
                <h5 class="card-title">Are you sure to  close <u>{{ $student->fullName }}</u>'s last case?</h5>
                <hr>
                <p class="card-text">
                    There is an existing opened case associated with the given ID. Are you sure you want to close?
                </p>
                <div class="d-flex justify-content-center">
                    
              

                    <form id="update-status-form" action="{{ route('update.status') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="id" value=" {{ $student->id }}"> <!-- Pass the ID of the record you want to update -->
                    </form>

                    <a href="{{ route('home') }}" class="btn btn-danger mx-2">Cancel</a>
                    <a href="{{ route('update.status') }}" class="btn btn-success mx-2" onclick="event.preventDefault(); document.getElementById('update-status-form').submit();">
                        Yes, Proceed
                    </a>
                </div>
            </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>





