<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Futuristic Disk Usage Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: radial-gradient(circle, rgba(0, 0, 0, 0.95) 0%, rgba(10, 10, 30, 1) 100%);
            color: #e0e0e0;
            font-family: 'Orbitron', sans-serif;
            overflow-x: hidden;
        }

        .container {
            position: relative;
            z-index: 1;
        }

        .card {
            background: rgba(25, 25, 45, 0.9);
            border-radius: 1.5rem;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(20px);
        }

        .card:hover {
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.8);
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid #444;
            background: rgba(40, 40, 60, 0.8);
            border-radius: 1.5rem 1.5rem 0 0;
        }

        .card-body {
            padding: 2rem;
        }

        .table-header {
            background: rgba(30, 30, 50, 0.9);
            color: #e0e0e0;
        }

        .table-row {
            background: rgba(20, 20, 40, 0.9);
            transition: background 0.3s ease;
        }

        .table-row:hover {
            background: rgba(30, 30, 50, 0.8);
        }

        .chart-container {
            background: rgba(30, 30, 50, 0.9);
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
        }

        .button {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            border: none;
            color: #ffffff;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
            font-size: 1rem;
            font-weight: bold;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
        }

        .button:hover {
            background: linear-gradient(135deg, #2a5298, #1e3c72);
            transform: scale(1.05);
        }

        .glow {
            text-shadow: 0 0 20px rgba(0, 255, 255, 0.8), 0 0 30px rgba(0, 255, 255, 0.6), 0 0 40px rgba(0, 255, 255, 0.4);
        }

        .neon-text {
            color: #00ffff;
            text-shadow: 0 0 20px #00ffff, 0 0 30px #00ffff;
        }
    </style>
</head>

<body class="p-8">
    <div class="container mx-auto max-w-6xl relative">
        <!-- Header -->
        <header class="mb-12 text-center">
            <h1 class="text-6xl font-extrabold mb-4 glow">Futuristic Disk Usage Dashboard</h1>
            <p class="text-xl">Monitor and manage disk usage with a high-tech interface.</p>
        </header>

        <!-- Disk Usage Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            <!-- Project Size Card -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-3xl font-semibold neon-text">Project Size</h2>
                </div>
                <div class="card-body text-center">
                    <p class="text-5xl font-bold text-blue-300">{{ $totalSize }}</p>
                </div>
            </div>

            <!-- Server Disk Space Card -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-3xl font-semibold neon-text">Server Disk Space</h2>
                </div>
                <div class="card-body">
                    <p class="text-lg mb-2">Total: <span
                            class="font-semibold text-blue-300">{{ $totalDiskSpace }}</span></p>
                    <p class="text-lg mb-2">Free: <span class="font-semibold text-blue-300">{{ $freeDiskSpace }}</span>
                    </p>
                    <p class="text-lg mb-2">Used: <span class="font-semibold text-blue-300">{{ $usedDiskSpace }}</span>
                    </p>
                </div>
            </div>

            <!-- Disk Usage Chart Card -->
            <div class="card chart-container">
                <h2 class="text-3xl font-semibold neon-text mb-4">Disk Usage Chart</h2>
                <canvas id="diskUsageChart"></canvas>
            </div>
        </div>

        <!-- Directory Details Card -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-3xl font-semibold neon-text">Directory Details</h2>
            </div>
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-800 rounded-lg">
                        <thead class="table-header text-left text-gray-200">
                            <tr>
                                <th class="px-4 py-2 border-b">Name</th>
                                <th class="px-4 py-2 border-b">Size</th>
                                <th class="px-4 py-2 border-b">Type</th>
                                <th class="px-4 py-2 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($directoryDetails as $detail)
                                <tr class="table-row">
                                    <td class="px-4 py-2">{{ $detail['name'] }}</td>
                                    <td class="px-4 py-2">{{ $detail['size'] }}</td>
                                    <td class="px-4 py-2">{{ $detail['type'] }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <form id="form-{{ $loop->index }}" method="POST"
                                            action="{{ route('delete.old.files') }}">
                                            @csrf
                                            <input type="hidden" name="file" value="{{ $detail['name'] }}">
                                            <button type="submit" class="button">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Confirmation Modal -->
        <div id="confirmationModal"
            class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75 hidden z-50">
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg text-center max-w-sm w-full">
                <h2 class="text-2xl font-bold text-cyan-400 mb-4">Confirm Deletion</h2>
                <p class="text-gray-300 mb-6">Are you sure you want to delete this file or directory?</p>
                <div class="flex justify-center space-x-4">
                    <button id="confirmYes" class="button bg-green-500 hover:bg-green-600">Yes, Delete</button>
                    <button id="confirmNo" class="button bg-red-500 hover:bg-red-600">Cancel</button>
                </div>
            </div>
        </div>

    </div>

    <script>
        var freeDiskSpaceGB = {{ $freeDiskSpaceBytes / 1024 ** 3 }};
        var usedDiskSpaceGB = {{ $usedDiskSpaceBytes / 1024 ** 3 }};
        var usedProjectDiskSpaceGB = {{ $usedProjectDiskSpaceBytes / 1024 ** 3 }};

        var ctx = document.getElementById('diskUsageChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Free Space', 'Used Space', 'Project Space'],
                datasets: [{
                    label: 'Disk Usage',
                    data: [freeDiskSpaceGB, usedDiskSpaceGB, usedProjectDiskSpaceGB],
                    backgroundColor: ['#00ffff', '#ff6f61', '#ffeb3b'],
                    borderColor: '#1e293b',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: '#e0e0e0'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw.toFixed(2) + ' GB';
                            }
                        }
                    }
                }
            }
        });

        function showConfirmationModal(formId) {
            document.getElementById('confirmationModal').classList.remove('hidden');
            document.getElementById('confirmYes').setAttribute('data-form-id', formId);
        }

        function confirmDeletion(formId) {
            var form = document.getElementById('form-' + formId);
            if (form) {
                // Proceed with the deletion
                form.submit();
            }
        }

        document.querySelectorAll('form button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default form submission
                var formId = this.closest('form').id.split('-')
                    .pop(); // Get the form id from the button's closest form
                showConfirmationModal(formId);
            });
        });

        document.getElementById('confirmYes').addEventListener('click', function() {
            var formId = this.getAttribute('data-form-id');
            confirmDeletion(formId);
            document.getElementById('confirmationModal').classList.add('hidden');
        });

        document.getElementById('confirmNo').addEventListener('click', function() {
            document.getElementById('confirmationModal').classList.add('hidden');
        });
    </script>
</body>

</html>
