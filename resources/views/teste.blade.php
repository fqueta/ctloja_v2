@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Pagina de teste</h1>
@stop

@section('content')
<div class="content">
    <h2>Cadastro de Pessoas</h2>

    <input type="text" id="nome" placeholder="Nome">
    <input type="number" id="idade" placeholder="Idade">
    <input type="email" id="email" placeholder="Email">
    <button id="adicionarLinha">Adicionar</button>
    <button id="limparTabela">Limpar Tabela</button>

    <hr>

    <table id="minhaTabela" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Idade</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

</div>
@stop

@section('css')
    <link rel="stylesheet" href=" {{url('/')}}/css/lib.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        input, button {
            margin: 5px;
        }
        td button {
            margin-right: 5px;
        }
    </style>
@stop

@section('js')
    {{-- <script>
        import SirTrevor from "sir-trevor";

        const editor = new SirTrevor.Editor({
        el: document.querySelector(".js-st-instance"),
        defaultType: "Text",
        iconUrl: "build/sir-trevor-icons.svg"
        });
    </script> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" /> --}}
    <script src=" {{url('/')}}/js/lib.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        var tabela;
        var linhaEditando = null;

        $(document).ready(function () {
            tabela = $('#minhaTabela').DataTable();

            restaurarTabelaDoSession();

            $('#adicionarLinha').on('click', function () {
                const nome = $('#nome').val();
                const idade = $('#idade').val();
                const email = $('#email').val();

                if (nome && idade && email) {
                    const acoes = gerarBotoesAcao();

                    if (linhaEditando !== null) {
                        // Atualiza a linha existente
                        tabela.row(linhaEditando).data([nome, idade, email, acoes]).draw(false);
                        linhaEditando = null;
                        $('#adicionarLinha').text('Adicionar');
                    } else {
                        // Adiciona nova linha
                        // tabela.row.add([nome, idade, email, acoes]).draw(false);
                        tabela.row.add([nome, idade, email, acoes]).draw(false);

                        let ultimaLinha = tabela.row(tabela.rows().count() - 1);
                        let dadosUltima = ultimaLinha.data();
                        ultimaLinha.remove(); // remove do final

                        tabela.row.add(dadosUltima).draw(false); // adiciona novamente

                        // Move para o topo
                        let node = tabela.row(tabela.rows().count() - 1).node();
                        $(node).prependTo('#minhaTabela tbody');

                    }

                    salvarTabelaNoSession();
                    $('#nome, #idade, #email').val('');
                } else {
                    alert('Preencha todos os campos.');
                }
            });

            $('#limparTabela').on('click', function () {
                tabela.clear().draw();
                sessionStorage.removeItem('dadosTabela');
            });

            // Ações dinâmicas (editar/excluir)
            $('#minhaTabela tbody').on('click', '.btn-excluir', function () {
                const row = tabela.row($(this).parents('tr'));
                row.remove().draw();
                salvarTabelaNoSession();
            });

            $('#minhaTabela tbody').on('click', '.btn-editar', function () {
                const tr = $(this).closest('tr');

                const row = tabela.row(tr);
                const dados = row.data();
                console.log(tr);

                $('#nome').val(dados[0]);
                $('#idade').val(dados[1]);
                $('#email').val(dados[2]);

                linhaEditando = row;
                $('#adicionarLinha').text('Atualizar');
            });
        });

        function gerarBotoesAcao() {
            return `
                <button class="btn-editar">✏️ Editar</button>
                <button class="btn-excluir">🗑️ Excluir</button>
            `;
        }

        function salvarTabelaNoSession() {
            const dados = tabela.rows().data().toArray();
            sessionStorage.setItem('dadosTabela', JSON.stringify(dados));
        }

        function restaurarTabelaDoSession() {
            const dadosSalvos = sessionStorage.getItem('dadosTabela');
            if (dadosSalvos) {
                const dados = JSON.parse(dadosSalvos);
                console.log(dados);

                dados.forEach(function (linha) {
                    // Substitui ações por novos botões
                    linha[3] = gerarBotoesAcao();
                    tabela.row.add(linha);
                });
                tabela.draw();
            }
        }
    </script>

@stop
