<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

use nusoap_client;

$client = new nusoap_client("http://localhost:8080/?wsdl");

$student = null;
$error = null;

if (array_key_exists("search", $_POST)) {
  $response = $client->call("get_student_by_admission", ["admission_number" => $_POST['admission_number']]);

  // Check for errors
  if (array_key_exists("faultstring", $response)) {
    $error = $response["faultstring"];
  } else {
    $student = $response;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Query - SOAP Web Services Demo (Client)</title>

  <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tailwindcss/ui@latest/dist/tailwind-ui.min.css">
</head>

<body class="min-h-screen bg-gray-100 text-gray-900">
  <div class="px-4 py-5 sm:px-6 flex justify-center">
    <div class="w-full md:max-w-6xl bg-white overflow-hidden shadow rounded-lg">
      <div class="border-b border-gray-200 px-4 py-5 sm:px-6">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Student Search</h3>
      </div>
      <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
        <div class="w-3/4 px-4 py-5 sm:p-6 bg-white">
          <!-- Notification area -->
          <?php if (!empty($error)) : ?>
            <div class="mb-5">
              <p class="text-red-600">
                <strong>Error!</strong> <?= $error ?>
              </p>
            </div>
          <?php endif; ?>
          <!-- END Notification area -->
          <div class="grid grid-cols-6 gap-6">
            <div class="col-span-4">
              <label for="admission_number" class="block text-sm font-medium leading-5 text-gray-700">Admission Number</label>
              <input id="admission_number" name="admission_number" type="text" class="mt-1 form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
            </div>
            <div class="col-span-2 flex items-end">
              <input type="hidden" name="search">
              <button type="submit" class="py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-500 focus:outline-none focus:shadow-outline-blue active:bg-indigo-600 transition duration-150 ease-in-out">
                Search
              </button>
            </div>
          </div>
        </div>
      </form>

      <?php if ($student) : ?>
        <div class="px-4 py-5 sm:p-6 w-5/6">
          <div class="border rounded">
            <div class="border-b border-gray-200 px-4 py-5 sm:px-6">
              <h3 class="text-2xl font-bold leading-6 text-gray-900">Results</h3>
            </div>
            <div class="text-lg pt-5 px-4 py-5">
              <p><span>Admission Number: </span><strong><?= $student["id"] ?></strong></p>
              <p><span>Name: </span><strong><?= $student["name"] ?></strong></p>
              <p><span>Email: </span><strong><?= $student["email"] ?></strong></p>
              <p><span>Phone Number: </span><strong><?= $student["phone_number"] ?></strong></p>
              <p><span>Address: </span><strong><?= $student["address"] ?></strong></p>
              <p><span>Entry Points: </span><strong><?= $student["entry_points"] ?></strong></p>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>

</html>