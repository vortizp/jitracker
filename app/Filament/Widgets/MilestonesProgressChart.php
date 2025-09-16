<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Milestone;
use App\Models\Student;

class MilestonesProgressChart extends ChartWidget
{
    protected ?string $heading = 'Milestones Progress Chart';

    protected function getData(): array
{
    $students = \App\Models\Student::all(); // or filter by group
    $milestones = \App\Models\Milestone::all();

    $datasets = [];

    foreach ($milestones as $milestone) {
        $progress = [];
        foreach ($students as $student) {
            $activities = $milestone->activities;
            $completed = $activities->filter(fn($a) => $a->students()->find($student->id)->pivot->completed)->count();
            $total = $activities->count();
            $progress[] = $total ? ($completed / $total * 100) : 0;
        }

        $datasets[] = [
            'label' => $milestone->name,
            'data' => $progress,
            'backgroundColor' => '#' . substr(md5($milestone->id), 0, 6), // unique color per milestone
        ];
    }

    return [
        'labels' => $students->pluck('nick_name')->toArray(),
        'datasets' => $datasets,
    ];
}

    protected function getType(): string
    {
        return 'bar';
    }

    public function getColumnSpan(): string|int
    {
        return 'full'; // full width
    }

    protected function getOptions(): array
{
    return [
        'indexAxis' => 'y', // makes the bars horizontal
        'scales' => [
            'x' => [
                'beginAtZero' => true,
                'max' => 100, // for percentages
            ],
            'y' => [
                'title' => [
                    'display' => true,
                    'text' => 'Students',
                ],
            ],
        ],
        'plugins' => [
            'legend' => [
                'position' => 'top',
            ],
        ],
    ];
}
}
