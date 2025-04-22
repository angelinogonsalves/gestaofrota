/// <reference path="../functions.js" />

document.addEventListener("DOMContentLoaded", function () {
    fetch(baseUrl + '/api/dados-distribuicao-contas')
        .then(response => response.json())
        .then(data => {
            var numCategorias = Object.keys(data).length;
            var cores = gerarCores(numCategorias);
            var coresBorda = gerarCoresBorda(cores);

            var ctx_distribuicaoContas = document.getElementById('distribuicaoContas').getContext('2d');
            var myChart_distribuicaoContas = new Chart(ctx_distribuicaoContas, {
                type: 'pie',
                data: {
                    labels: Object.keys(data),
                    datasets: [
                        {
                            label: 'Percentual %',
                            data: Object.values(data),
                            backgroundColor: cores,
                            borderColor: coresBorda,
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        },
                        title: {
                            display: true,
                            text: 'Percentual do Valor de Contas Pagas por Motivo'
                        }
                    }
                }
            })
        })
        .catch(error => console.error('Erro ao carregar dados da distribuição de contas:', error));
});
