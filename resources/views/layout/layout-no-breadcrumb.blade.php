

<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">

<x-head />


<body class="dark:bg-neutral-800 bg-neutral-100 dark:text-white">

    <!-- ..::  header area start ::.. -->
    <x-sidebar />
    <!-- ..::  header area end ::.. -->

    <main class="dashboard-main">

        <!-- ..::  navbar start ::.. -->
        <x-navbar />
        <!-- ..::  navbar end ::.. -->
        <div class="dashboard-main-body">

            <!-- ..::  header area end ::.. -->

            @yield('content')
        
        </div>
        
        <!-- ..::  footer  start ::.. -->
        <x-footer />
        <!-- ..::  footer area end ::.. -->


    </main>

    <!-- ..::  scripts  start ::.. -->
    <x-script  script='{!! isset($script) ? $script : "" !!}' />

    @livewireScripts

    <!-- ..::  scripts  end ::.. -->
</body>

</html>