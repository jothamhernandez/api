@extends('layouts.app')

@section('content')
<div class="border-bottom mb-3 pt-3 pb-2">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <h1 class="h2">{{ $event->name }}</h1>
    </div>
    <span class="h6">{{ $event->getFormattedDate() }}</span>
</div>

<div class="mb-3 pt-3 pb-2">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <h2 class="h4">Room Capacity</h2>
    </div>
</div>

<canvas id="myChart" width="400" height="150"></canvas>
<script src="{{ asset('js/Chart.bundle.min.js') }}"></script>
<script>
    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                @foreach ($event->getSessions() as $session)
                '{{ $session->title }}',
                @endforeach
            ],
            datasets: [{
                label: 'Attendees',
                data: [
                    @foreach ($event->getSessions() as $session)
                    {{ $session->getNumAttendees() }},
                    @endforeach
                ],
                backgroundColor: [
                    @foreach ($event->getSessions() as $session)
                        @if ($session->getNumAttendees() <= $session->room->capacity)
                            'rgba(139,195,74,0.5)',
                        @else
                            'rgba(244,67,54,0.5)',
                        @endif
                    @endforeach
                ],
            },{
                label: 'Capacity',
                data: [
                    @foreach ($event->getSessions() as $session)
                    {{ $session->room->capacity }},
                    @endforeach
                ],
                backgroundColor: [
                    'rgba(33,150,243,0.5)',
                    'rgba(33,150,243,0.5)',
                    'rgba(33,150,243,0.5)',
                    'rgba(33,150,243,0.5)',
                    'rgba(33,150,243,0.5)',
                    'rgba(33,150,243,0.5)',
                    'rgba(33,150,243,0.5)',
                    'rgba(33,150,243,0.5)',
                    'rgba(33,150,243,0.5)',
                    'rgba(33,150,243,0.5)',
                    'rgba(33,150,243,0.5)',
                    'rgba(33,150,243,0.5)',
                ],
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    },
                    gridLines: {
                        display: false,
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Capacity',
                        fontSize: 16,
                        padding: 15,
                    }
                }],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Sessions',
                        fontSize: 16,
                    },
                    barPercentage: 0.7,
                    gridLines: {
                        lineWidth: 3,
                    }
                }]
            },
            legend: {
                position: 'right',
                labels: {
                    fontSize: 16
                },
            },
        }
    });
</script>

@endsection
