@extends('layouts.admin')
@section('title', 'carender')

@section('content')

<table class="table table-bordered">
    <thead>
        <tr>
            @foreach (['日', '月', '火', '水', '木', '金', '土'] as $dayOfWeek)
            <th>{{ $dayOfWeek }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($dates as $date)
        @if ($date->dayOfWeek == 0)
        <tr>
            @endif
            <td @if ($date->month != $currentMonth)
                class="bg-secondary"
                @endif
                >
                {{ $date->day }}
            </td>
            @if ($date->dayOfWeek == 6)
        </tr>
        @endif
        @endforeach
    </tbody>
</table>
