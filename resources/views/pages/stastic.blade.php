
@extends('layouts.master')

@section('styles')
<link rel="stylesheet" href="{{asset('style/add-expenses.css')}}">
@endsection

@section('content')
<div style="width: 100%; margin: 0 auto; padding-top: 50px; border-bottom: 1px solid #FFF">
    <canvas id="pieChart"></canvas>
</div>
<div>
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Red', 'Blue', 'Yellow'],
                datasets: [{
                    data: [300, 50, 100],
                    backgroundColor: ['#FF5733', '#33A1FF', '#FFEB33'],
                    borderColor: ['#FF5733', '#33A1FF', '#FFEB33'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                position: 'bottom',
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom', // Đặt chú thích ở dưới biểu đồ
                        labels: {
                            font: {
                                size: 14 // Kích thước chữ trong chú thích
                            },
                            padding: 20 // Khoảng cách giữa chú thích và biểu đồ
                        }
                    }
                },
                animation: {
                    animateRotate: true, // Hiệu ứng xoay khi xuất hiện
                    animateScale: true,  // Hiệu ứng phóng to khi xuất hiện
                    duration: 1000,      // Thời gian chạy animation (ms)
                }
            }
        });
    });
</script>
