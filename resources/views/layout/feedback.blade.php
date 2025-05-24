

@if (session('error'))
    <div class="alert alert-danger bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 border-danger-100 px-6 py-[11px] mb-5 font-semibold text-lg rounded-lg "
        role="alert">
        <div class="flex items-start justify-between text-lg">
            <div class="flex items-start gap-2">
                <iconify-icon icon="mingcute:delete-2-line" class="icon text-xl mt-1.5 shrink-0"></iconify-icon>
                <div>
                    Oops!,
                    <p class="font-medium text-danger-600 text-sm mt-2">{{!! session('error') !!}}</p>
                </div>
            </div>
            <button class="remove-button text-danger-600 text-2xl line-height-1"> <iconify-icon
                    icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button>
        </div>
    </div>
@endif

@if ($errors->any())
<div class="alert alert-danger bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 border-danger-100 px-6 py-[11px] mb-3 font-semibold text-lg rounded-lg " role="alert">
    <div class="flex items-start justify-between text-lg">
        <div class="flex items-start gap-2">
            <iconify-icon icon="mingcute:delete-2-line" class="icon text-xl mt-1.5 shrink-0"></iconify-icon>
            <div>
            Oops!    
            <ul>
                @foreach ($errors->all() as $error)
                <li class="font-medium text-danger-200 text-sm mt-2">{{ $error }}</li>
            @endforeach
               </ul>
            </div>
        </div>
        <button class="remove-button text-danger-600 text-2xl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button>
    </div>
</div>
@endif

@if (session('success'))


<div class="alert alert-success bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 border-success-100 px-6 py-[11px] mb-2.5 font-semibold text-lg rounded-lg flex items-center justify-between " role="alert">
  <div class="flex items-center gap-2">
      <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
     {{ session('success') }}
  </div>
  <button class="remove-button text-success-600 text-2xl line-height-1 "> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button>
</div>
@endif
