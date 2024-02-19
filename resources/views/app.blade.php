<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Safexpress</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Include Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        /* Add custom CSS for card background color */
        .card {
            background-color: #3367D6;
            color: white; /* Set font color to white */
        }
        .card-img-overlay {
            position: relative;
        }
        .warehouse-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Safexpress Logistics Inc. App List</h1>

        <div class="row">
            <!-- Example card with warehouse image -->
            @foreach ($data as $item)


            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">{{$item->app_name}}</h5>
                  <p class="card-text">{{$item->description}}</p>
                  <a href="/app/{{$item->app_code}}" target="_bla" class="btn btn-primary">Open App</a>
                </div>
              </div>
            </div>
            @endforeach
        

            <!-- Iterate over data and generate cards dynamically -->
            <!-- Replace this with your foreach loop -->
        </div>
    </div>

    <!-- Include Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
