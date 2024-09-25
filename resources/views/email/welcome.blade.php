<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to {{ config('app.name') }} Community</title>
    <style>
      body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
      }
      .container {
        max-width: 500px;
        padding: 15px;
        margin: 0 auto;
      }
      .btn {
        background-color: #3498db;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h1>Welcome to {{ config('app.name') }} Community</h1>
      <p>Thank you for signing up! We hope you enjoy exploring this community.</p>
      <p>
        <a href="{{ route('dashboard') }}" class="btn">Go Home</a>
      </p>
    </div>
  </body>
</html>
