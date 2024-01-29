<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Safexpress</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" sizes="16x16" href="http://safexpress.com.ph/favicon.ico">
    <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <!-- Include Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <style>
    /* Add custom CSS for random background color */
    .random-color-card {
      background-color: #f0f0f0; /* Default background color */
      transition: background-color 0.3s ease-in-out;
    }
  </style>
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Safexpress Logistics Inc. App List</h1>

        <div class="row">

       @foreach ($data as $item)


          <div class="col-md-6 col-lg-4 mb-4">
            <div class="card random-color-card">
              <div class="card-body">
                <h5 class="card-title">{{$item->app_name}}</h5>
                <p class="card-text">{{$item->description}}</p>
                <a href="{{$item->app_name}}" target="_bla" class="btn btn-primary">Open App</a>
              </div>
            </div>
          </div>
          @endforeach

        </div>
      </div>

      <!-- Include Bootstrap and jQuery scripts -->
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

      <script>
        // Function to generate a random color
        function getRandomColor() {
          const letters = '0123456789ABCDEF';
          let color = '#';
          for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
          }
          return color;
        }
 // Function to determine if a color is dark
 function isColorDark(hexColor) {
      // Convert hex to RGB
      const r = parseInt(hexColor.slice(1, 3), 16);
      const g = parseInt(hexColor.slice(3, 5), 16);
      const b = parseInt(hexColor.slice(5, 7), 16);

      // Calculate luminance
      const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;

      // Check if luminance is below a threshold (adjust as needed)
      return luminance <= 0.5;
    }

    // Apply random background color and font color to each card on page load
    document.addEventListener('DOMContentLoaded', function () {
      const cards = document.querySelectorAll('.random-color-card');
      cards.forEach(function (card) {
        const randomColor = getRandomColor();
        card.style.backgroundColor = randomColor;

        // Determine font color based on background color
        const fontColor = isColorDark(randomColor) ? 'white' : 'black';
        card.style.color = fontColor;
      });
    });
      </script>
</body>

</html>
