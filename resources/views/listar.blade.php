<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta content="IE=Edge" http-equiv="X-UA-Compatible">
  <meta name="description" content="A new Flutter project.">

  <!-- iOS meta tags & icons -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-title" content="Comércios em Pirapora">
  <link rel="apple-touch-icon" href="icons/Icon-192.png">

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/png" href="favicon.png" />

  <title>Comércios em Pirapora</title>
  <link rel="manifest" href="manifest.json">
</head>

<body>
  <!-- This script installs service_worker.js to provide PWA functionality to
       application. For more information, see:
       https://developers.google.com/web/fundamentals/primers/service-workers -->
  <script>
    if ('serviceWorker' in navigator) {
      window.addEventListener('load', function () {
        navigator.serviceWorker.register('flutter_service_worker.js?v=3577036945');
      });
    }
  </script>
  <script src="main.dart.js" type="application/javascript"></script>
</body>

</html>