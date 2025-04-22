document.addEventListener("DOMContentLoaded", function () {
    fetch(baseUrl + '/api/dados-fluxo-caixa')
        .then(response => response.json())
        .then(data => {
            var ctx_movimentacaoMensal = document.getElementById('movimentacaoMensal').getContext('2d');
            var myChart_movimentacaoMensal = new Chart(ctx_movimentacaoMensal, {
                type: 'bar',
                data: {
                    labels: Object.keys(data),
                    datasets: [{
                        label: 'Entradas',
                        data: Object.values(data).map(item => item.Entradas),
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Saídas',
                        data: Object.values(data).map(item => item.Saídas),
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Valores'
                            },
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);
                                }
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Mês e Ano'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Fluxo de caixa'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    var label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            })
        })
        .catch(error => console.error('Erro ao carregar dados do fluxo de caixa:', error));
});
