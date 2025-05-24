<div id="{{ $modalId }}" tabindex="-1" aria-hidden="true"
    class="hidden  overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-dark-2">
            <form action="{{ $route }}" method="POST">
                @csrf
                @method('PUT')
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Confirm
                        Add Stock to <b>{{ $product->name }}</b> Product</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="{{ $modalId }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5 space-y-2">
                    <p class="text-lg text-gray-700 dark:text-gray-300">
                        Stock
                    </p>
                    <input type="number" name="stock" id="stock" min="1" required
                        class="block w-full px-4 pb-2 border border-gray-300 rounded-lg focus:ring focus:ring-primary-200 focus:border-primary-500 dark:bg-dark-1 dark:border-gray-600 dark:text-white"
                        placeholder="Enter stock quantity">
                </div>
                <div class="flex items-center gap-4 p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" data-modal-hide="{{ $modalId }}"
                        class="border border-danger-600   hover:bg-red- bg-hover-danger-200 text-danger-600 text-base px-[50px] py-[11px] rounded-lg"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit"
                        class="btn bg-primary-600 hover:bg-primary-700 text-white text-base rounded-lg px-[25px] py-3"
                        id="closeModal">
                        Add
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



{{-- trigger --}}
{{-- 
  <a data-modal-target="delete-modal-{{ $product->id }}"
                                            data-modal-toggle="delete-modal-{{ $product->id }}"
                                            class="w-8 h-8 bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 rounded-full inline-flex items-center justify-center">
                                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                        </a>
--}}

{{-- call modal --}}
{{-- 
                                <x-confirm-delete-modal :modalId="'delete-modal-' . $product->id" :route="route('actionDeleteProduct', $product->id)" />
--}}
