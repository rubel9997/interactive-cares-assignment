<?php

use App\WEB\Controller\AdminDashboardController;
use App\WEB\Controller\TransactionController;

$user_id = $_GET['id'];
$transaction_list = (new TransactionController())->getTransactionList($user_id);
$customer = (new AdminDashboardController())->getCustomer($_GET['id']);


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

    <title>Transactions of <?php echo $customer['name'] ?? "Alex";?></title>
  </head>
  <body class="h-full">
    <div class="min-h-full">
      <div class="bg-sky-600 pb-32">
        <!-- Navigation -->
          <?php require_once "header.php" ?>

        <header class="py-10">
          <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">
              Transactions of <?php echo $customer['name'] ?? "Alex";?>
            </h1>
          </div>
        </header>
      </div>

      <main class="-mt-32">
        <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
          <div class="bg-white rounded-lg py-8">
            <!-- List of All The Transactions -->
            <div class="px-4 sm:px-6 lg:px-8">
              <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                  <p class="mt-2 text-sm text-gray-700">
                    List of transactions made by <?php echo $customer['name'] ?? "Alex";?>.
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
