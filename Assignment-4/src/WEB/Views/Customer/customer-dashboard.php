<?php

use App\WEB\Controller\TransactionController;
use App\WEB\Session;

$user_id = Session::get('user_id');
$balance = (new TransactionController())->getBalance($user_id);
$transaction_list = (new TransactionController())->getTransactionList($user_id);

?>

<!DOCTYPE html>
<html
    class="h-full bg-gray-100"
    lang="en">
<head>
    <meta charset="UTF-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0" />

    <!-- Tailwindcss CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AlpineJS CDN -->
    <script
        defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Inter Font -->
    <link
        rel="preconnect"
        href="https://fonts.googleapis.com" />
    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <style>
        * {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont,
            'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans',
            'Helvetica Neue', sans-serif;
        }
    </style>

    <title>Dashboard</title>
</head>
<body class="h-full">
<div class="min-h-full">
    <div class="bg-emerald-600 pb-32">
        <!-- Navigation -->
        <?php require_once "header.php" ?>
        <header class="py-10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-white">
                    Howdy, <?= \App\WEB\Session::get('name')?> 👋
                </h1>
            </div>
        </header>
    </div>

    <main class="-mt-32">
        <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg p-2">

                <?php
                if(\App\WEB\Session::get('success_message')){
                    ?>
                    <div class="flex items-center bg-green-100 border-l-4 border-green-500 py-2 px-3 my-2 mx-2 rounded-md shadow-md">
                        <div class="text-green-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <?= \App\WEB\Session::get('success_message'); ?>
                            <?php  unset($_SESSION['success_message']); ?>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <?php
                if(\App\WEB\Session::get('error_message')){
                    ?>
                    <div class="flex items-center bg-red-100 border-l-4 border-red-500 py-2 px-3 my-2 mx-2 rounded-md shadow-md">
                        <div class="text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <?= \App\WEB\Session::get('error_message'); ?>
                            <?php  unset($_SESSION['error_message']); ?>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <!-- Current Balance Stat -->
                <dl
                    class="mx-auto grid grid-cols-1 gap-px sm:grid-cols-2 lg:grid-cols-4">
                    <div
                        class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 bg-white px-4 py-10 sm:px-6 xl:px-8">
                        <dt class="text-sm font-medium leading-6 text-gray-500">
                            Current Balance
                        </dt>
                        <dd
                            class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">
                            $<?= isset($balance) ? number_format($balance):'0.0'?>
                        </dd>
                    </div>
                </dl>

                <!-- List of All The Transactions -->
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <p class="mt-2 text-sm text-gray-700">
                                Here's a list of all your transactions which inlcuded
                                receiver's name, email, amount and date.
                            </p>
                        </div>
                    </div>
                    <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div
                                class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                    <tr>
                                        <th scope="col"
                                                class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                            Sender Name
                                        </th>
                                        <th scope="col"
                                                class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                           Sender Email
                                        </th>
                                        <th scope="col"
                                            class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                            Receiver Name
                                        </th>
                                        <th scope="col"
                                            class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                            Receiver Email
                                        </th>
                                        <th
                                            scope="col"
                                            class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Amount
                                        </th>
                                        <th
                                                scope="col"
                                                class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Transaction Type
                                        </th>
                                        <th
                                            scope="col"
                                            class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Date
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    <?php
                                    foreach ($transaction_list as $key=>$value){

                                    ?>
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-800 sm:pl-0">
                                                <?= isset($value['sender_name']) ? $value['sender_name']:''?>
                                            </td>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">
                                                <?= isset($value['sender_email']) ? $value['sender_email']:''?>
                                            </td>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-800 sm:pl-0">
                                                <?= isset($value['receiver_name']) ? $value['receiver_name']:''?>
                                            </td>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">
                                                <?= isset($value['receiver_email']) ? $value['receiver_email']:''?>
                                            </td>

                                            <?php
                                            if($value['transaction_type'] == \App\Common\TransactionType::DEPOSIT || $value['transaction_type'] == \App\Common\TransactionType::RECEIVE){
                                                 ?>
                                                    <td class="whitespace-nowrap px-2 py-4 text-sm font-medium text-emerald-600"> <?= isset($value['amount']) ?  '+$ '.number_format($value['amount']):'' ?> </td>
                                                <?php
                                            }elseif($value['transaction_type'] == \App\Common\TransactionType::WITHDRAW || $value['transaction_type'] == \App\Common\TransactionType::TRANSFER){
                                                  ?>
                                                     <td class="whitespace-nowrap px-2 py-4 text-sm font-medium text-red-600">  <?= isset($value['amount']) ?  '-$ '.number_format($value['amount']):'' ?> </td>
                                                <?php
                                            }
                                            ?>
                                            <td class="whitespace-nowrap px-2 py-4 text-sm text-gray-500">
                                                <?= isset($value['transaction_type']) ? ucfirst($value['transaction_type']):''?>
                                            </td>
                                            <td class="whitespace-nowrap px-2 py-4 text-sm text-gray-500">
                                                <?= isset($value['transaction_date']) ? date('d M Y, h:i A', strtotime($value['transaction_date'])) :''?>
                                            </td>
                                        </tr>

                                    <?php
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>
