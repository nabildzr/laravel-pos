<div>
    <div class="card-body p-6">
        <div class="flex items-center flex-wrap gap-2 justify-between">
            <h6 class="mb-2 font-bold text-lg">Revenue Report</h6>
            <div>
                <select wire:model.live="period" class="form-select form-select-sm w-auto bg-white dark:bg-neutral-700 border text-secondary-light">
                    <option value="yearly">Yearly</option>
                    <option value="monthly">Monthly</option>
                    <option value="weekly">Weekly</option>
                    <option value="daily">Today</option>
                </select>
            </div>
        </div>
        <ul class="flex flex-wrap items-center mt-4 gap-3">
            <li class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-sm bg-primary-600"></span>
                <span class="text-secondary-light text-sm font-semibold">
                    Earning:
                    <span class="text-neutral-600 dark:text-neutral-200 font-bold">Rp {{ number_format($totalEarning, 0, '.', '.') }}</span>
                </span>
            </li>
            <li class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-sm bg-warning-600"></span>
                <span class="text-secondary-light text-sm font-semibold">
                    Expense:
                    <span class="text-neutral-600 dark:text-neutral-200 font-bold">Rp {{ number_format($totalExpense, 0, '.', '.') }}</span>
                </span>
            </li>
        </ul>
        <div class="mt-[60px]">
            <div wire:ignore id="paymentStatusChart"></div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', function() {
            const options = {
                series: [{
                    name: 'Net Profit',
                    data: @js($profitData)
                }],
                colors: ['#487FFF', '#FF9F29'],
                chart: {
                    type: 'bar',
                    height: 250,
                    toolbar: {
                        show: false
                    },
                },
                grid: {
                    show: true,
                    borderColor: "#D1D5DB",
                    strokeDashArray: 4,
                    position: "back",
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        columnWidth: 10,
                    },
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ["transparent"],
                },
                xaxis: {
                    categories: [
                        "Jan",
                        "Feb",
                        "Mar",
                        "Apr",
                        "May",
                        "Jun",
                        "Jul",
                        "Aug",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dec",
                    ],
                },
                yaxis: {
                    categories: [
                        "0",
                        "5000",
                        "10,000",
                        "20,000",
                        "30,000",
                        "50,000",
                        "60,000",
                        "60,000",
                        "70,000",
                        "80,000",
                        "90,000",
                        "100,000",
                    ],
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    opacity: 1,
                    width: 18,
                },
            };

            const chart = new ApexCharts(document.querySelector("#paymentStatusChart"), options);
            chart.render();

            // Listen untuk event refreshChart dari Livewire
            Livewire.on('refreshChart', (data) => {
                chart.updateSeries([{
                    name: 'Net Profit',
                    data: data
                }]);
            });
        });
    </script>
</div>
