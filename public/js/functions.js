function removeMascara(value) {
    return parseFloat(value.replace(/[^\d,]/g, '').replace(',', '.'));
}

// Função para calcular o mês anterior retorna o nome do mes simplificado e a competencia formatada em MM/AAAA
function competenciaAnterior(indice = 0) {
    var hoje = new Date();
    var mes = hoje.getMonth() - indice + 1; // Obtém o sexto mês anterior
    var ano = hoje.getFullYear(); // Obtém o ano atual

    // Ajusta o mês e o ano, se necessário
    if (mes <= 0) {
        mes += 12; // Adiciona 12 para voltar ao ano anterior
        ano--; // Ano anterior
    }

    return [obterNomeMes(mes), ("0" + mes).slice(-2) + '/' + ano];
}

// Função para obter o nome do mês a partir do número do mês
function obterNomeMes(numeroMes) {
    var nomesMeses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
    return nomesMeses[numeroMes - 1]; // Subtrai 1, pois os meses são indexados a partir de 0 no JavaScript
}

// Função para gerar cores dinâmicas com base no número de categorias
function gerarCores(numCategorias) {
    var cores = [];
    for (var i = 0; i < numCategorias; i++) {
        var r = Math.floor(Math.random() * 256);
        var g = Math.floor(Math.random() * 256);
        var b = Math.floor(Math.random() * 256);
        var cor = 'rgba(' + r + ',' + g + ',' + b + ', 0.5)';
        cores.push(cor);
    }
    return cores;
}

// Função para gerar cores de borda dinâmicas com base no número de categorias
function gerarCoresBorda(cores) {
    var coresBorda = [];
    cores.forEach(function(cor) {
        var rgba = cor.replace('0.5', '1');
        coresBorda.push(rgba);
    });
    return coresBorda;
}

// Função para verificar se é uma data válida
function isValidDate(dateString) {
    var date = new Date(dateString);
    // Verifica se a data é válida
    return !isNaN(date.getTime());
}

// formata a data dd/mm/AAAA
function formatDate(dateString) {
    const [year, month, day] = dateString.split('-');
    return new Date(year, month - 1, day).toLocaleDateString('pt-BR');
}