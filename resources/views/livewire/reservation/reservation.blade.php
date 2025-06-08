  <div>
      <div class="grid grid-cols-12">
          <div class="col-span-12">
              <div class="card border-0 overflow-hidden">
                  <div class="card-header">
                      <h6 class="card-title mb-0 text-lg">Reservation Table Datatables</h6>
                  </div>

                  {{-- <form method="POST" action="{{ route('printExpenses') }}" target="_blank">
                    @csrf
                    <button type="submit" class="btn btn-primary mb-3">Print Selected</button>

                    <form method="POST" action="{{ route('importExpenses') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" accept=".csv,.xlsx" required>
                        <button type="submit" class="btn btn-info mb-3">Import</button>
                    </form>
                    <form method="POST" action="{{ route('exportExpenses') }}">
                    @csrf
                    <input type="hidden" name="selected" id="export-selected">
                    <button type="submit" class="btn btn-success mb-3">Export Selected</button>
                </form> --}}

                  <div class="card-body">
                      @include('layout.feedback')

                      <div class="flex space-x-2">
                          <a href="{{ route('reservations.create') }}"
                              class="btn bg-primary-600 hover:bg-primary-700 text-white rounded-lg px-5 py-[11px] mb-5">New
                              Reservation</a>
                          <a href="{{ route('tables') }}"
                              class="btn bg-primary-600 hover:bg-primary-700 text-white rounded-lg px-5 py-[11px] mb-5">Look
                              Dining Tables</a>
                      </div>
                      <table id="selection-table"
                          class="border border-neutral-200 dark:border-neutral-600 rounded-lg border-separate	">
                          <thead>
                              <tr>
                                  <th scope="col" class="text-neutral-800 dark:text-white">
                                      <div class="form-check style-check flex items-center">
                                          <input class="form-check-input" id="select-all" type="checkbox">

                                          <label class="ms-2 form-check-label" for="serial">
                                              S.L
                                          </label>
                                      </div>
                                  </th>
                                  <th scope="col" class="text-neutral-800 dark:text-white">
                                      <div class="flex items-center gap-2">
                                          Contact Name
                                          <svg class="w-4 h-4 ms-1" aria-hidden="true"
                                              xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                              fill="none" viewBox="0 0 24 24">
                                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                          </svg>
                                      </div>
                                  </th>
                                  <th scope="col" class="text-neutral-800 dark:text-white">
                                      <div class="flex items-center gap-2">
                                          Reserved at
                                          <svg class="w-4 h-4 ms-1" aria-hidden="true"
                                              xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                              fill="none" viewBox="0 0 24 24">
                                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                          </svg>
                                      </div>
                                  </th>
                                  <th scope="col" class="text-neutral-800 dark:text-white">
                                      <div class="flex items-center gap-2">
                                        Reservation End Time
                                          <svg class="w-4 h-4 ms-1" aria-hidden="true"
                                              xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                              fill="none" viewBox="0 0 24 24">
                                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                          </svg>
                                      </div>
                                  </th>
                                  <th scope="col" class="text-neutral-800 dark:text-white">
                                      <div class="flex items-center gap-2">
                                          Status
                                          <svg class="w-4 h-4 ms-1" aria-hidden="true"
                                              xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                              fill="none" viewBox="0 0 24 24">
                                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                          </svg>
                                      </div>
                                  </th>

                                  <th scope="col" class="text-neutral-800 dark:text-white">
                                      <div class="flex items-center gap-2">
                                          Guest Count
                                          <svg class="w-4 h-4 ms-1" aria-hidden="true"
                                              xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                              fill="none" viewBox="0 0 24 24">
                                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                          </svg>
                                      </div>
                                  </th>

                                  <th scope="col" class="text-neutral-800 dark:text-white">
                                      <div class="flex items-center gap-2">
                                          Created By
                                          <svg class="w-4 h-4 ms-1" aria-hidden="true"
                                              xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                              fill="none" viewBox="0 0 24 24">
                                              <path stroke="currentColor" stroke-linecap="round"
                                                  stroke-linejoin="round" stroke-width="2"
                                                  d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                          </svg>
                                      </div>
                                  </th>

                                  <th scope="col" class="text-neutral-800 dark:text-white">
                                      <div class="flex items-center gap-2">
                                          Action
                                      </div>
                                  </th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($reservations as $reservation)
                                  <tr>
                                      <td>
                                          <div class="form-check style-check flex items-center">
                                              <input type="checkbox" name="selected[]" value="{{ $reservation->id }}"
                                                  class="form-check-input">
                                              <label class="ms-2 form-check-label">
                                                  {{ $reservation->id }}
                                              </label>
                                          </div>
                                      </td>
                                      <td>
                                          <h6 class="text-base mb-0 font-bold grow">
                                              {{ optional($reservation->reservationContact)->name }}</h6>
                                      </td>
                                      <td>
                                          <h6 class="text-base mb-0 font-bold grow">
                                              {{ $reservation->reservation_datetime }}</h6>
                                      </td>
                                      <td>
                                          <div class="">
                                              @if ($reservation->completed_reservation_time)
                                                  <h6 class="text-base mb-0 font-bold grow">
                                                      {{ $reservation->completed_reservation_time }}</h6>
                                              @else
                                                  <span
                                                      class="mb-0 grow px-8 py-1.5 rounded-full font-medium text-base bg-warning-100 dark:bg-warning-600/25 text-warning-600 dark:text-warning-400">
                                                      Pending
                                                  </span>
                                              @endif


                                          </div>
                                      </td>
                                      <td>

                                          <div>
                                              <span
                                                  class="mb-0 grow px-8 py-1.5 rounded-full font-medium text-base
                                                    @if ($reservation->status == 'available') bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400
                                                    @elseif($reservation->status == 'occupied')
                                                        bg-warning-100 dark:bg-warning-600/25 text-warning-600 dark:text-warning-400
                                                    @elseif($reservation->status == 'reserved')
                                                        bg-info-100 dark:bg-info-600/25 text-info-600 dark:text-info-400
                                                    @elseif($reservation->status == 'out_of_service')
                                                        bg-danger-600 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400
                                                    @elseif($reservation->status == 'cancelled')
                                                        bg-danger-600 dark:bg-danger-600/25 text-white dark:text-danger-400
                                                          @elseif($reservation->status == 'completed')
                                                        bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 @endif ">
                                                  {{ $reservation->status }}
                                              </span>
                                          </div>

                                      </td>
                                      <td>
                                          <div class="items-center w-48">
                                              <p class="text-base mb-0 font-medium grow">
                                                  {{ $reservation->guest_count }}
                                              </p>
                                          </div>
                                      </td>
                                      <td>
                                          <div class="items-center w-48">
                                              <p class="text-base mb-0 font-medium grow">{{ $reservation->user->name }}
                                              </p>
                                          </div>


                                      </td>
                                      <td class="">
                                          <a href="{{ url("/reservations/edit/$reservation->id") }}"
                                              class="w-8 h-8 bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 rounded-full inline-flex items-center justify-center">
                                              <iconify-icon icon="lucide:edit"></iconify-icon>
                                        </a>
                                        @if(auth()->user()->role == ('admin') || auth()->user()->role == ('super_admin'))
                                            <a data-modal-target="delete-modal-{{ $reservation->id }}"
                                                data-modal-toggle="delete-modal-{{ $reservation->id }}"
                                                class="w-8 h-8 bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 rounded-full inline-flex items-center justify-center">
                                                <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                            </a>
                                        @endif  </td>
                                  </tr>
                              @endforeach

                          </tbody>
                      </table>
                  </div>
                  </form>
              </div>
          </div>
      </div>


      @foreach ($reservations as $reservation)
          <x-confirm-delete-modal :modalId="'delete-modal-' . $reservation->id" :route="route('reservations.destroy', $reservation->id)" />
      @endforeach
  </div>
