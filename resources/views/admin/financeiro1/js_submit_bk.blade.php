@php
    $config = isset($form['config']) ? $form['config'] : [];
    $compleUrl = isset($config['compleUrl']) ? $config['compleUrl'] : '';

@endphp
<script>
    var tabela;
    var linhaEditando = null;

    function dps_salvar_lancemento(res,tabela){
        try {
            if(c=res.campos){
                var id = res.idCad ? res.idCad : null;
                if(id){
                    const data_row = [checkbox_tabela(id),btns_acao(id)];

                    if(Object.entries(c).length>0){
                        Object.entries(c).forEach(([key, v]) => {
                            if(v.active){
                                data_row.push(v.value)
                                console.log(v);
                            }
                        })
                    }
                    console.log(data_row);
                    tabela.row(linhaEditando).data(data_row).draw(false);
                    let ultimaLinha = tabela.row(tabela.rows().count() - 1);
                    let dadosUltima = ultimaLinha.data();
                    ultimaLinha.remove(); // remove do final

                    tabela.row.add(dadosUltima).draw(false); // adiciona novamente

                    // Move para o topo
                    let node = tabela.row(tabela.rows().count() - 1).node();
                    $(node).prependTo('#DataTables_Table_0 tbody');
                }
                // c.forEach(el => {
                //     console.log(el.active)
                // });
            }
        } catch (error) {
            console.log(error);

        }

    }
    function btns_acao(id){
        return `<button type="button" onclick="editar_linha_tabela('`+id+`')" title="Editar" class="btn btn-sm btn-outline-secondary mr-1">
                    <i class="fa fa-pen"></i>
                </button>                                                                                                <button type="button" onclick="excluir_linha_tabela('`+id+`')" data-del="true" data-id="1" name="button" title="Excluir" class="btn btn-outline-danger">
                    <i class="fa fa-times"></i>
                </button>`;
    }
    function checkbox_tabela(id){
        return `<td>
                    <input type="checkbox" class="checkbox" onclick="color_select1_0(this.checked,this.value);" value="`+id+`" name="check_`+id+`" id="check_`+id+`">
                </td>`;
    }
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
    $(function(){
        tabela = $('#lista-tabela').DataTable({
                "paging":   false,
                stateSave: true,
                language: {
                    url: '/DataTables/datatable-pt-br.json'
                },
                order:[]
        });
        // salvarTabelaNoSession(tabela);
        $("#{{$config['frm_id']}}").validate({
            submitHandler: function(form) {
                submitFormulario($("#{{$config['frm_id']}}"),function(res){

                    let btn_press = $('#btn-press-salv').html();
                    lib_formatMensagem('.mens',res.mens,res.color);
                    if(res.exec){
                    }
                    console.log(res,btn_press);
                    if(btn_press=='sair'){
                        if(pop){
                                window.opener.popupCallback_vinculo(res); //Call callback function
                                window.close(); // Close the current popup
                                return;
                        }
                        var redirect = $('[btn-volter="true"]').attr('redirect');

                        if(redirect){
                            if(pop){
                                window.opener.popupCallback(function(){
                                    alert('pop some data '+redirect);
                                }); //Call callback function
                                window.close(); // Close the current popup
                                return;
                            }else{
                                window.location = redirect;
                            }
                        }else if(res.return){
                            if(pop){
                                window.opener.popupCallback(function(){
                                    alert('pop some data '+res.return);
                                }); //Call callback function
                                window.close(); // Close the current popup
                                return;
                            }else{
                                window.location = res.return;
                            }
                        }
                    }else if(btn_press=='permanecer'){
                        dps_salvar_lancemento(res,tabela);
                        // if(res.redirect){
                        //     window.location = res.redirect;
                        // }
                    }
                    if(res.errors){
                        alert('erros');
                        console.log(res.errors);
                    }
                },function(res){
                    lib_funError(res);
                },'&'+$('#files').serialize());
                /*
                $(form).submit(function(e){
                    e.preventDefault();

                });
                */

            }
        });
        function btnPres(obj){
            $('#btn-press-salv').remove();
            var btn = '<span id="btn-press-salv" class="d-none">'+obj.attr('btn')+'</span>';
            $(btn).insertAfter(obj);
        }
        $('[type="submit"]').on('click',function(e){
            btnPres($(this));
        });
    });
</script>
