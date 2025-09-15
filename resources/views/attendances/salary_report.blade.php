@extends('dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Báo cáo lương nhân viên</h5>
                    <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('attendances.salary_report') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="month">Tháng</label>
                                    <select name="month" id="month" class="form-control">
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="year">Năm</label>
                                    <select name="year" id="year" class="form-control">
                                        @php
                                            $currentYear = date('Y');
                                            $startYear = $currentYear - 5;
                                            $endYear = $currentYear + 1;
                                        @endphp
                                        @for ($i = $startYear; $i <= $endYear; $i++)
                                            <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary mt-4">Lọc</button>
                                <a href="#" onclick="window.print()" class="btn btn-success mt-4">In báo cáo</a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-light">
                                    <th>ID</th>
                                    <th>Nhân viên</th>
                                    <th>Vị trí</th>
                                    <th>Lương theo giờ</th>
                                    <th>Tổng số giờ làm</th>
                                    <th>Tổng lương</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($salaryReports as $report)
                                    <tr>
                                        <td>{{ $report->id }}</td>
                                        <td>{{ $report->full_name }}</td>
                                        <td>{{ $report->position }}</td>
                                        <td>{{ number_format($report->hourly_rate) }} VNĐ</td>
                                        <td>{{ $report->total_hours }}</td>
                                        <td>{{ number_format($report->total_salary) }} VNĐ</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Không có dữ liệu lương trong tháng này</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="bg-light font-weight-bold">
                                    <td colspan="4" class="text-right">Tổng cộng:</td>
                                    <td>{{ $salaryReports->sum('total_hours') }}</td>
                                    <td>{{ number_format($salaryReports->sum('total_salary')) }} VNĐ</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .btn, form, .card-header {
            display: none !important;
        }
        .card {
            border: none !important;
        }
        .card-body {
            padding: 0 !important;
        }
        body {
            margin: 1cm;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    }
</style>
@endsection 