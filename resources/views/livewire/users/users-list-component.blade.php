 <div class="grid grid-cols-12">
     <div class="col-span-12">
         <div class="card h-full p-0 rounded-xl border-0 overflow-hidden">
             <div
                 class="card-header border-b border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-700 py-4 px-6 flex items-center flex-wrap gap-3 justify-between">
                 <div class="flex items-center flex-wrap gap-3">

                     <div class="navbar-search">
                         <input type="text" wire:model.change="search" class="bg-white dark:bg-neutral-700 h-10 w-auto"
                             name="search" placeholder="Search">
                         <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                     </div>
                     <select wire:model.lazy="is_active"
                         class="form-select form-select-sm w-auto dark:bg-neutral-600 dark:text-white border-neutral-200 dark:border-neutral-500 rounded-lg">
                         <option value="all">Status</option>
                         <option value="1">Active</option>
                         <option value="0">Inactive</option>
                     </select>
                     <button wire:click="searchUser"
                         class="btn-icon bg-neutral-600 p-2 px-3  dark:text-white border-neutral-200 dark:border-neutral-500 rounded-lg ml-2">
                         <div wire:loading.remove wire:target="search,is_active">
                             <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                         </div>
                         <div wire:loading wire:target="search,is_active" class="">
                             <iconify-icon icon="line-md:loading-twotone-loop" class="icon animate-spin"></iconify-icon>
                         </div>
                     </button>
                 </div>
                 <a href="{{ route('addUser') }}"
                     class="btn btn-primary text-sm btn-sm px-3 py-3 rounded-lg flex items-center gap-2">
                     <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                     Add New User
                 </a>
             </div>
             <div class="card-body p-6">
                 <div class="table-responsive scroll-sm">
                     <table class="table bordered-table sm-table mb-0">
                         <thead>
                             <tr>
                                 <th scope="col">
                                     <div class="flex items-center gap-10">
                                         <div class="form-check style-check flex items-center">
                                             <input class="form-check-input rounded border input-form-dark"
                                                 type="checkbox" name="checkbox" id="selectAll">
                                         </div>
                                         S.L
                                     </div>
                                 </th>
                                 <th scope="col">Join Date</th>
                                 <th scope="col">Name</th>
                                 <th scope="col">Email</th>
                                 <th scope="col">Role</th>
                                 {{-- <th scope="col">Designation</th> --}}
                                 <th scope="col" class="text-center">Account Status</th>
                                 <th scope="col" class="text-center">Action</th>
                             </tr>
                         </thead>
                         <tbody>
                             @forelse ($users as $user)
                                 <tr>
                                     <td>
                                         <div class="flex items-center gap-10">
                                             <div class="form-check style-check flex items-center">
                                                 <input class="form-check-input rounded border border-neutral-400"
                                                     type="checkbox" name="checkbox" id="SL-1">
                                             </div>
                                             {{ $user->id }}
                                         </div>
                                     </td>
                                     <td>
                                         {{ $user->join_date }}
                                     </td>
                                     <td>
                                         <div class="flex items-center">
                                             <img src="{{ asset('assets/images/user-list/user-list1.png') }}"
                                                 alt=""
                                                 class="w-10 h-10 rounded-full shrink-0 me-2 overflow-hidden">
                                             <div class="grow">
                                                 <span
                                                     class="text-base mb-0 font-normal text-secondary-light">{{ $user->name }}</span>
                                             </div>
                                         </div>
                                     </td>
                                     <td><span
                                             class="text-base mb-0 font-normal text-secondary-light">{{ $user->email }}</span>
                                     </td>
                                     {{-- <td>HR</td> --}}
                                     <td>{{ $user->role }}</td>
                                     <td class="text-center">
                                         @if ($user->is_active == 1)
                                             <span
                                                 class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 border border-success-600 px-6 py-1.5 rounded font-medium text-sm">Active</span>
                                         @else
                                             <span
                                                 class="bg-neutral-200 dark:bg-neutral-600 text-neutral-600 border border-neutral-400 px-6 py-1.5 rounded font-medium text-sm">Inactive</span>
                                         @endif
                                     </td>
                                     <td class="text-center">
                                         <div class="flex items-center gap-3 justify-center">
                                             <a href="{{ route('viewUserProfile', ['id' => $user->id]) }}"
                                                 class="bg-info-100 dark:bg-info-600/25 hover:bg-info-200 text-info-600 dark:text-info-400 font-medium w-10 h-10 flex justify-center items-center rounded-full">
                                                 <iconify-icon icon="majesticons:eye-line"
                                                     class="icon text-xl"></iconify-icon>
                                             </a>
                                             <a href="{{ route('editUser', ['id' => $user->id]) }}"
                                                 class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 bg-hover-success-200 font-medium w-10 h-10 flex justify-center items-center rounded-full">
                                                 <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                             </a>
                                             <button type="button"
                                                 wire:click="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                                                 class="bg-danger-100 dark:bg-danger-600/25 hover:bg-danger-200 text-danger-600 dark:text-danger-500 font-medium w-10 h-10 flex justify-center items-center rounded-full">
                                                 <iconify-icon icon="fluent:delete-24-regular"
                                                     class="menu-icon"></iconify-icon>
                                             </button>
                                         </div>
                                     </td>
                                 </tr>

                                 @if ($showDeleteModal)
                                     <div class="modal-backdrop fade show"></div>
                                     <div class="modal fade show" tabindex="-1" role="dialog"
                                         style="display: block; padding-right: 17px;">
                                         <div class="modal-dialog">
                                             <div class="modal-content">
                                                 <div class="modal-header">
                                                     <h5 class="modal-title text-lg font-medium">Confirm Delete</h5>
                                                     <button type="button" class="btn-close"
                                                         wire:click="cancelDelete()"></button>
                                                 </div>
                                                 <div class="modal-body">
                                                     <p>Are you sure you want to delete <span
                                                             class="font-semibold">{{ $deleteUserName }}</span>?</p>
                                                     @if ($users->where('id', $deleteUserId)->first() && $users->where('id', $deleteUserId)->first()->role === 'super_admin')
                                                         <div
                                                             class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-3">
                                                             <strong>Warning!</strong> Super Admin users cannot be
                                                             deleted.
                                                         </div>
                                                     @endif
                                                 </div>
                                                 <div class="modal-footer">
                                                     <button type="button" class="btn btn-secondary"
                                                         wire:click="cancelDelete()">Cancel</button>
                                                     <button type="button" class="btn btn-danger"
                                                         wire:click="deleteUser()">Delete</button>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 @endif
                             @empty
                                 <tr>
                                     <td colspan="7" class="text-center py-8">
                                         <span class="text-secondary-light">No users found.</span>
                                     </td>
                                 </tr>
                             @endforelse

                         </tbody>
                     </table>
                 </div>

             </div>
         </div>
     </div>
 </div>
