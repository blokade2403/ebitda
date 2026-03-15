<script>
    $(document).ready(function() {
        $('#example2').DataTable({
            pageLength: 10,
            responsive: true,
            ordering: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            }
        });
    });
</script>

<script>
    document.querySelectorAll(".toggle-btn").forEach(btn => {

        btn.addEventListener("click", function() {

            let row = this.closest("tr");

            let childRows = document.querySelectorAll(
                `tr[data-parent="${row.dataset.id}"]`
            );

            childRows.forEach(r => {

                r.style.display =
                    r.style.display === "none" ? "" : "none";

            });

        });

    });
</script>

<script>
    document.querySelectorAll('.toggle').forEach(btn => {

        btn.addEventListener('click', function() {

            let id = this.dataset.id;

            document.querySelectorAll('tr[data-parent="' + id + '"]').forEach(row => {

                if (row.style.display === 'none') {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }

            });

        });

    });
</script>



<script>
    var ebitdaData = @json(isset($ebitdaBulanan) ? array_values($ebitdaBulanan) : []);

    var ctx2 = document.getElementById('ebitdaChart');

    if (ctx2) {

        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'EBITDA',
                    data: ebitdaData,
                    backgroundColor: '#0ab39c',
                    borderRadius: 6,
                    barThickness: 18
                }]
            },
            options: {

                indexAxis: 'y',

                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                },

                scales: {

                    x: {
                        grid: {
                            color: '#f1f1f1'
                        },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },

                    y: {
                        grid: {
                            display: false
                        }
                    }

                }

            }

        });

    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const categorySelect = document.getElementById("revenue_category_id");
        const serviceSelect = document.getElementById("service_id");

        const allServices = [...serviceSelect.options].map(option => ({
            value: option.value,
            label: option.text,
            category: option.dataset.category
        }));

        const serviceChoices = new Choices(serviceSelect, {
            searchEnabled: true,
            itemSelectText: ''
        });

        categorySelect.addEventListener("change", function() {

            let selectedCategory = this.value;

            let filtered = allServices.filter(service =>
                service.category === selectedCategory
            );

            serviceChoices.clearChoices();

            serviceChoices.setChoices(
                filtered.map(service => ({
                    value: service.value,
                    label: service.label
                })),
                'value',
                'label',
                true
            );

        });

    });
</script>


{{-- <script>
    document.addEventListener("DOMContentLoaded", function() {

        const ctx = document.getElementById('revenueChart');
        if (!ctx) return;

        const revenueData = @json($revenueChart ?? []);
        const expenseData = @json($expenseChart ?? []);
        const ebitdaData = @json($ebitdaChart ?? []);

        // const revenueData = @json($revenueChart);
        // const expenseData = @json($expenseChart);
        // const ebitdaData = @json($ebitdaChart);

        const existingChart = Chart.getChart(ctx);
        if (existingChart) existingChart.destroy();

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov',
                    'Des'
                ],
                datasets: [

                    {
                        label: 'Revenue',
                        data: revenueData,
                        borderColor: '#22c55e',
                        backgroundColor: 'rgba(34,197,94,0.15)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3
                    },

                    {
                        label: 'Expense',
                        data: expenseData,
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239,68,68,0.15)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3
                    },

                    {
                        label: 'EBITDA',
                        data: ebitdaData,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59,130,246,0.15)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3
                    }

                ]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    });
</script> --}}

</html>
