<?php

use function Livewire\Volt\form;
use function Livewire\Volt\mount;
use function Livewire\Volt\with;

use function Livewire\Volt\state;

use App\Livewire\App\Links\Analytics\Index\Filters;
use Illuminate\Support\Facades\DB;
use App\Livewire\App\Links\Analytics\Index\Range;

state(['dataset' => [], 'shortLink' => fn () => $shortLink]);

state('filters')->reactive();

$fillDataset = function () {
    $increment = match ($this->filters->range) {
        Range::Today => DB::raw("strftime('%H', created_at) as increment"),
        Range::Year => DB::raw("strftime('%Y', created_at) || '-' || strftime('%m', created_at) as increment"),
        default => DB::raw("DATE(created_at) as increment"),
    };

    $results = $this->shortLink->clickEvents()
        ->select($increment, DB::raw('COUNT(*) as total'))
        ->tap(function ($query) {
            $this->filters->apply($query);
        })
        ->groupBy('increment')
        ->get();

    $this->dataset['values'] = $results->pluck('total')->toArray();
    $this->dataset['labels'] = $results->pluck('increment')->toArray();
};

mount(function () {
    $this->filters->init($this->shortLink);
});

with(function () {
    $this->fillDataset();

    return [];
});

?>

<div>
    <div
        x-data="chart"
        wire:ignore
        wire:loading.class="opacity-50"
        class="relative h-[5rem] sm:h-[10rem] w-full overflow-hidden"
    >
        <canvas class="w-full"></canvas>
    </div>
</div>

@assets
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endassets

@script
<script>
    // @todo: fix this...
    Alpine.data('chart', Alpine.skipDuringClone(() => {
        let chart

        return {
            init() {
                chart = this.initChart(this.$wire.dataset)

                this.$wire.$watch('dataset', () => {
                    this.updateChart(chart, this.$wire.dataset)
                })
            },

            destroy() {
                chart.destroy()
            },

            updateChart(chart, dataset)
            {
                let { labels, values } = dataset

                chart.data.labels = labels
                chart.data.datasets[0].data = values
                chart.update()
            },

            initChart(dataset) {
                let el = this.$wire.$el.querySelector('canvas')

                let { labels, values } = dataset

                return new Chart(el, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            tension: 0.1,
                            label: 'Clics',
                            data: values,
                            fill: {
                                target: 'origin',
                                above: '#1d4fd810',
                            },
                            pointStyle: 'circle',
                            pointRadius: 0,
                            pointBackgroundColor: '#5ba5e1',
                            pointBorderColor: '#5ba5e1',
                            pointHoverRadius: 4,
                            borderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                displayColors: false,
                            },
                        },
                        hover: {
                            mode: 'index',
                            intersect: false
                        },
                        layout: {
                            padding: {
                                left: 0,
                                right: 0,
                            },
                        },
                        scales: {
                            x: {
                                display: false,
                                border: { dash: [5, 5] },
                                ticks: {
                                    callback: function(val, index, values) {
                                        let label = this.getLabelForValue(val)

                                        return index === 0 || index === values.length - 1 ? '' : label;
                                    }
                                },
                                grid: {
                                    border: {
                                        display: false
                                    },
                                },
                            },
                            y: {
                                display: false,
                                border: { display: false },
                                beginAtZero: true,
                                grid: { display: false },
                                ticks: {
                                    display: false
                                },
                            },
                        },
                    },
                })
            },
        }
    }))
</script>
@endscript
