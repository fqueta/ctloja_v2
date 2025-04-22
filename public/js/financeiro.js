function financeiro_create_receita_mensal(obj){
    var cmc = obj.getAttribute('campos-mensais'),cm=decodeArray(cmc);
    const d = {
        campos:cm,
        action:obj.getAttribute('action'),
        id_form:obj.getAttribute('id_form'),
        label:obj.getAttribute('label'),
    }

    renderForm(d,obj,function(res){
        if(res.mens){
            lib_formatMensagem('.mens',res.mens,res.color);
        }
        if(res.exec){
            var mod = '#modal-geral';
            $(mod).modal('hide');
            // lib_listDadosHtmlVinculo(res,obj.data('selector'),'cad');
            console.log(res);

        }
    });
}
function financeiro_carregarDadosDoServidor(tabela,campo_bus,routa) {
    if(typeof routa== 'undefined' ){
        routa = 'financeiro/receitas';
    }
    var campo_bus = campo_bus ? campo_bus : 'id';
    // if(typeof campo_bus== 'undefined' ){
    //     campo_bus = 'id';
    // }
    $.ajax({
        url: '/api/v1/'+routa,
        method: 'GET',
        success: function (res) {
            // console.log(dados);
            if(dados=res.dados_table){
                dados.forEach(function (item) {
                    var id = item[campo_bus].value;
                    const acoes = btns_acao(id);
                    const checkb = checkbox_tabela(id);
                    const data_row = [checkb,acoes];
                    if(Object.entries(item).length>0){
                        Object.entries(item).forEach(([key, v]) => {
                            if(v.active){
                                console.log(key);
                                // return
                                if(key==campo_bus){
                                    var d= encodeArray(item),inp_data = '<input type="hidden" id="tab_d_'+v.value+'" value="'+d+'" />';
                                    data_row.push(v.value+inp_data)
                                }else{
                                    data_row.push(v.value)
                                }
                                // console.log(v);
                            }
                        })
                    }
                    // var result = Object.keys(item).map((key) => [key, item[key]]);
                    // arri.push(result);
                    // // result.unshift(acoes,checkb);
                    // console.log(arri);
                    // let novaLinha = tabela.row.add([item.nome, item.idade, item.email, acoes]).draw(false);
                    let novaLinha = tabela.row.add(data_row).draw(false);
                    let node = novaLinha.node();
                    $(node).attr('data-id', id); // associa ID da base de dados
                    $(node).prependTo('#minhaTabela tbody');
                });
            }
            salvarTabelaNoSession(tabela);
        }
    });
}
function editar_linha_tabela(id){
    var d=document.getElementById('tab_d_'+id).value,arrd=decodeArray(d);
    console.log(arrd);

}
