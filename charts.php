<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Charts - Windmill Dashboard</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./assets/css/tailwind.output.css" /><link rel="stylesheet" href="./assets/css/corescustomizadas.css" />
    <script
      src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
      defer
    ></script>
    <script src="./assets/js/init-alpine.js"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css"
    />
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
      defer
    ></script>
    <script src="./assets/js/charts-lines.js" defer></script>
    <script src="./assets/js/charts-pie.js" defer></script>
    <script src="./assets/js/charts-bars.js" defer></script>
  </head>
  <body>
    <div
      class="flex h-screen bg-gray-50 dark:bg-gray-900"
      :class="{ 'overflow-hidden': isSideMenuOpen}"
    >
    
    <?php
      include("./sidebar.php");
    ?>
      <div class="flex flex-col flex-1">
        <header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
          <div
            class="container flex items-center justify-between h-full px-6 mx-auto text-verdecoopaf-600 dark:text-verdecoopaf-300"
          >
            <!-- Mobile hamburger -->
            <button
              class="p-1 -ml-1 mr-5 rounded-md md:hidden focus:outline-none focus:shadow-outline-verdecoopaf"
              @click="toggleSideMenu"
              aria-label="Menu"
            >
              <svg
                class="w-6 h-6"
                aria-hidden="true"
                fill="currentColor"
                viewBox="0 0 20 20"
              >
                <path
                  fill-rule="evenodd"
                  d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </button>
            <!-- Search input -->
            <div class="flex justify-center flex-1 lg:mr-32">
              <div
                class="relative w-full max-w-xl mr-6 focus-within:text-verdecoopaf-500"
              >
                <div class="absolute inset-y-0 flex items-center pl-2">
                  <svg
                    class="w-4 h-4"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </div>
                <input
                  class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-verdecoopaf-300 focus:outline-none focus:shadow-outline-verdecoopaf form-input"
                  type="text"
                  placeholder="Search for projects"
                  aria-label="Search"
                />
              </div>
            </div>
            <?php include("headeroptions.php")?>
          </div>
        </header>
        <main class="h-full pb-16 overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Charts
            </h2>
            <!-- CTA -->
            <a
              class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-verdecoopaf-100 bg-verdecoopaf-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-verdecoopaf"
              href="https://github.com/estevanmaito/windmill-dashboard"
            >
              <div class="flex items-center">
                <svg
                  class="w-5 h-5 mr-2"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                >
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                  ></path>
                </svg>
                <span>Star this project on GitHub</span>
              </div>
              <span>View more &RightArrow;</span>
            </a>

            <p class="mb-8 text-gray-600 dark:text-gray-400">
              Charts are provided by
              <a
                class="text-verdecoopaf-600 dark:text-verdecoopaf-400 hover:underline"
                href="https://www.chartjs.org/"
              >
                Chart.js
              </a>
              . Note that the default legends are disabled and you should
              provide a description for your charts in HTML. See source code for
              examples.
            </p>

            <div class="grid gap-6 mb-8 md:grid-cols-2">
              <!-- Doughnut/Pie chart -->
              <div
                class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                  Doughnut/Pie
                </h4>
                <canvas id="pie"></canvas>
                <div
                  class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400"
                >
                  <!-- Chart legend -->
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-blue-600 rounded-full"
                    ></span>
                    <span>Shirts</span>
                  </div>
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-teal-500 rounded-full"
                    ></span>
                    <span>Shoes</span>
                  </div>
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"
                    ></span>
                    <span>Bags</span>
                  </div>
                </div>
              </div>
              <!-- Lines chart -->
              <div
                class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                  Lines
                </h4>
                <canvas id="line"></canvas>
                <div
                  class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400"
                >
                  <!-- Chart legend -->
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-teal-500 rounded-full"
                    ></span>
                    <span>Organic</span>
                  </div>
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"
                    ></span>
                    <span>Paid</span>
                  </div>
                </div>
              </div>
              <!-- Bars chart -->
              <div
                class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                  Bars
                </h4>
                <canvas id="bars"></canvas>
                <div
                  class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400"
                >
                  <!-- Chart legend -->
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-teal-500 rounded-full"
                    ></span>
                    <span>Shoes</span>
                  </div>
                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"
                    ></span>
                    <span>Bags</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </body>
</html>
