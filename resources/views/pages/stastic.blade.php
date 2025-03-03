@extends('layouts.master')

@section('styles')
<link rel="stylesheet" href="{{ asset('style/add-expenses.css') }}">
<style>
    .chart-container {
        width: 100%;
        height: 400px;
        margin: 0 auto;
        padding: 12px;
        display: none; /* Ẩn tất cả chart ban đầu */
    }
    .chart-container.active {
        display: block; /* Hiện chart đang được chọn */
    }
    .tabs {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }
    .tab-button {
        padding: 10px 20px;
        margin: 5px;
        cursor: pointer;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 5px;
    }
    .tab-button.active {
        background-color: #0056b3;
    }
</style>
@endsection

@section('content')

<div class="chart-container active" id="chartContainer1">
    <canvas id="pieChart1"></canvas>
</div>
<div class="chart-container" id="chartContainer2">
    <canvas id="pieChart2"></canvas>
</div>
<div class="chart-container" id="chartContainer3">
    <canvas id="pieChart3"></canvas>
</div>


<div class="tabs">
    <button class="tab-button active" data-chart="pieChart1">Chart 1</button>
    <button class="tab-button" data-chart="pieChart2">Chart 2</button>
    <button class="tab-button" data-chart="pieChart3">Chart 3</button>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        function createPieChart(chartId, data) {
            const ctx = document.getElementById(chartId).getContext('2d');
            return new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Red', 'Blue', 'Yellow'],
                    datasets: [{
                        data: data,
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)'
                            ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)'
                            ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                font: { size: 14 },
                                padding: 20
                            }
                        }
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 1000
                    }
                }
            });
        }

        // Khởi tạo các biểu đồ
        createPieChart('pieChart1', [300, 50, 100]);
        createPieChart('pieChart2', [150, 200, 250]);
        createPieChart('pieChart3', [100, 150, 300]);

        // Xử lý sự kiện đổi biểu đồ
        const buttons = document.querySelectorAll('.tab-button');
        const charts = document.querySelectorAll('.chart-container');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                // Xóa class active khỏi tất cả nút và chart
                buttons.forEach(btn => btn.classList.remove('active'));
                charts.forEach(chart => chart.classList.remove('active'));

                // Thêm class active cho nút và chart được chọn
                this.classList.add('active');
                const chartId = this.getAttribute('data-chart');
                document.getElementById(`chartContainer${chartId.slice(-1)}`).classList.add('active');
            });
        });
    });
</script>
