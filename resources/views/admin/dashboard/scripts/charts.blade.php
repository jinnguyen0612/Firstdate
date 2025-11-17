<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    profileStatistics = {!! json_encode($profileStatistics) !!};
    
    window.addEventListener('DOMContentLoaded', () => {
        // Followers Chart
        const followersOptions = {
            series: [{
                data: profileStatistics
            }],
            chart: {
                height: 140,
                type: 'area',
                fontFamily: 'Nunito, sans-serif',
                sparkline: {
                    enabled: true
                }
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            colors: ['#4361ee'],
            grid: {
                padding: {
                    top: 5
                }
            },
            yaxis: {
                show: false
            },
            tooltip: {
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: () => ''
                    }
                }
            }
        };

        const referralOptions = {
            series: [{
                data: [54, 34]
            }],
            chart: {
                height: 140,
                type: 'area',
                fontFamily: 'Nunito, sans-serif',
                sparkline: {
                    enabled: true
                }
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            colors: ['#e7515a'],
            grid: {
                padding: {
                    top: 5
                }
            },
            yaxis: {
                show: false
            },
            tooltip: {
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: () => ''
                    }
                }
            }
        };

        // Render charts
        const followersEl = document.querySelector("#followers-chart");
        if (followersEl) {
            const followersChart = new ApexCharts(followersEl, followersOptions);
            followersChart.render();
        }

        const referralEl = document.querySelector("#referral-chart");
        if (referralEl) {
            const referralChart = new ApexCharts(referralEl, referralOptions);
            referralChart.render();
        }
    });
</script>