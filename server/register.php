<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../vendor/autoload.php';
require_once '../constants.php';

use App\Models\Student;
use Illuminate\Support\Collection;

$student_model = new Student();
$error = null;

if (array_key_exists("register", $_POST)) {
    $input = Collection::make($_POST);
    $inserted  = $student_model->insert($input->except('register')->all());

    if ($inserted) {
        header('Location: ' . $_SERVER['PHP_SELF']);
    }
    $error = "Could not insert student record.";
}

// Fetch all student records
$students = $student_model->get_all_students();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - SOAP Web Services Demo</title>

    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tailwindcss/ui@latest/dist/tailwind-ui.min.css">
</head>

<body class="bg-gray-100">
    <div class="px-4 py-5 sm:px-6 grid grid-rows-2 lg:grid-cols-12 gap-4 w-full">
        <!-- FORM -->
        <div class="lg:col-span-6 xl:col-span-5">
            <div class=" bg-white overflow-hidden shadow rounded-lg">
                <div class="border-b border-gray-200 px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Student Registration</h3>
                </div>
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                    <div class="px-4 py-5 sm:p-6 bg-white">
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
                            <div class="col-span-6">
                                <label for="student_name" class="block text-sm font-medium leading-5 text-gray-700">Name</label>
                                <input id="student_name" name="name" type="text" class="mt-1 form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="email_address" class="block text-sm font-medium leading-5 text-gray-700">Email address</label>
                                <input id="email_address" name="email" type="email" required class="mt-1 form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="phone_number" class="block text-sm font-medium leading-5 text-gray-700">Phone Number</label>
                                <input id="phone_number" name="phone_number" type="text" required class="mt-1 form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="address" class="block text-sm font-medium leading-5 text-gray-700">Address</label>
                                <input id="address" name="address" type="text" required class="mt-1 form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="entry_points" class="block text-sm font-medium leading-5 text-gray-700">Entry Points</label>
                                <input id="entry_points" name="entry_points" type="number" min="1" class="mt-1 form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6 flex justify-end">
                        <input type="hidden" name="register">
                        <button type="submit" class="py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-500 focus:outline-none focus:shadow-outline-blue active:bg-indigo-600 transition duration-150 ease-in-out">
                            Register Student
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END FORM -->

        <!-- TABLE -->
        <div class="lg:col-span-6 xl:col-span-7 bg-white overflow-hidden shadow rounded-lg">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            Admission No.
                                        </th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            Email
                                        </th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            Phone Number
                                        </th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            Address
                                        </th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            Entry Points
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php foreach ($students as $student) : ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                                <?= $student['id'] ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                                <?= $student['name'] ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                                <?= $student['email'] ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                                <?= $student['phone_number'] ?>
                                            </td>
                                            <td class="px-6 py-4 text-sm leading-5 text-gray-900">
                                                <?= $student['address'] ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                                <?= $student['entry_points'] ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END TABLE -->
    </div>
</body>

</html>