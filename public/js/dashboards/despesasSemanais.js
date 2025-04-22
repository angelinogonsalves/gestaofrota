// Função para converter número da semana em data
function obterIntervaloDataDaSemana(numeroSemana, ano) {
    var primeiroDiaDoAno = new Date(ano, 0, 1);
    var dias = (numeroSemana - 1) * 7;
    var dataInicio = new Date(ano, 0, 1 + dias);
    var dataFim = new Date(ano, 0, 7 + dias);

    var opcoes = { day: 'numeric', month: 'short' };

    return `${dataInicio.toLocaleDateString('pt-BR', opcoes)} - ${dataFim.toLocaleDateString('pt-BR', opcoes)}`;
}

document.addEventListener("DOMContentLoaded", function() {
    fetch(baseUrl + '/api/dados-despesas-semanais')
        .then(response => response.json())
        .then(data => {
            var numerosSemana = Object.keys(data);
            var rotulosSemana = numerosSemana.map(numeroSemana => {
                var ano = parseInt(numeroSemana.slice(0, 4));
                var semana = parseInt(numeroSemana.slice(4));
                return obterIntervaloDataDaSemana(semana, ano);
            });

            var ctx_despesasSemanais = document.getElementById('despesasSemanais').getContext('2d');
            var myChart_despesasSemanais = new Chart(ctx_despesasSemanais, {
                type: 'line',
                data: {
                    labels: rotulosSemana,
                    datasets: [{
                        label: 'Despesas Semanais',
                        data: Object.values(data),
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Despesas Semanais',
                        },
                        legend: {
                            display: false
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
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Semana'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Valor'
                            },
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);
                                }
                            }
                        }
                    }
                }
            })
        })
        .catch(error => console.error('Erro ao carregar dados do despesas semanais:', error));
});
