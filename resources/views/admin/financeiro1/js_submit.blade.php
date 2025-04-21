@php
    $config = isset($form['config']) ? $form['config'] : [];
    $compleUrl = isset($config['compleUrl']) ? $config['compleUrl'] : '';

@endphp
<script>
    var tabela;
    var linhaEditando = null;
    var id_form = '#{{$config['frm_id']}}';
    $(document).ready(function () {
      // Inicializa a tabela (vazia no início)
      tabela = $('#lista-tabela').DataTable({
        // ordering: false,
        "paging":   false,
        stateSave: true,
                language: {
                    url: '/DataTables/datatable-pt-br.json'
                },
        order:[2,'desc']
      });

      // Carrega dados do servidor
      financeiro_carregarDadosDoServidor(tabela,'id');

      $(id_form+' [type="submit"]').on('click', function (e) {
        // e.preventDefault();
        const nome = $('#nome').val();
        // const idade = $('#idade').val();
        // const email = $('#email').val();
        const acoes = gerarBotoesAcao();

        //if (nome && idade && email) {
          if (linhaEditando !== null) {
            // Atualizar (aqui você pode fazer um PUT via AJAX)
            const row = linhaEditando;
            const id = $(row.node()).data('id');

            // $.ajax({
            //   url: '/api/pessoas/' + id, // ajustar a rota do backend
            //   method: 'PUT',
            //   data: { nome, idade, email },
            //   success: function () {
            //     row.data([nome, idade, email, acoes]).draw(false);
            //     linhaEditando = null;
            //     $('#adicionarLinha').text('Adicionar');
            //     $('#nome, #idade, #email').val('');
            //   }
            // });
          } else {
            // Adicionar novo (POST via AJAX)
            // $.ajax({
            //   url: '/api/pessoas',
            //   method: 'POST',
            //   data: { nome, idade, email },
            //   success: function (res) {
            //     let novaLinha = tabela.row.add([nome, idade, email, acoes]).draw(false);
            //     let node = novaLinha.node();
            //     $(node).attr('data-id', res.id); // opcional: usar ID do banco
            //     $(node).prependTo('#minhaTabela tbody');

            //     $('#nome, #idade, #email').val('');
            //   }
            // });
            $(id_form).validate({
                submitHandler: function(form) {
                    submitFormulario($(id_form),function(res){

                        let btn_press = $('#btn-press-salv').html();
                        lib_formatMensagem('.mens',res.mens,res.color);
                        if(res.exec){
                        }
                        // console.log(res,btn_press);
                        // if(btn_press=='sair'){
                        //     if(pop){
                        //             window.opener.popupCallback_vinculo(res); //Call callback function
                        //             window.close(); // Close the current popup
                        //             return;
                        //     }
                        //     var redirect = $('[btn-volter="true"]').attr('redirect');

                        //     if(redirect){
                        //         if(pop){
                        //             window.opener.popupCallback(function(){
                        //                 alert('pop some data '+redirect);
                        //             }); //Call callback function
                        //             window.close(); // Close the current popup
                        //             return;
                        //         }else{
                        //             window.location = redirect;
                        //         }
                        //     }else if(res.return){
                        //         if(pop){
                        //             window.opener.popupCallback(function(){
                        //                 alert('pop some data '+res.return);
                        //             }); //Call callback function
                        //             window.close(); // Close the current popup
                        //             return;
                        //         }else{
                        //             window.location = res.return;
                        //         }
                        //     }
                        // }else if(btn_press=='permanecer'){
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
                                    // console.log(data_row);
                                    // alert('j');

                                    // row.data([nome, idade, email, acoes]).draw(false);
                                    // row.data(data_row).draw(false);
                                    // log(res);
                                    let novaLinha = tabela.row.add(data_row).draw(false);
                                    let node = novaLinha.node();
                                    $(node).attr('data-id', id); // opcional: usar ID do banco
                                    $(node).prependTo('#lista-tabela tbody');

                                    // $('#nome, #idade, #email').val('');;
                                    limparCamposObrigatorios(id_form);
                                }
                            }
                            // dps_salvar_lancemento(res,tabela);
                            // if(res.redirect){
                            //     window.location = res.redirect;
                            // }
                        // }
                        // if(res.errors){
                        //     alert('erros');
                        //     console.log(res.errors);
                        // }
                    },function(res){
                        lib_funError(res);
                    },'&'+$('#files').serialize());

                }
            });
          }
        // } else {
        //   alert('Preencha todos os campos.');
        // }


      });

      $('#limparTabela').on('click', function () {
        tabela.clear().draw();
      });

      $('#minhaTabela tbody').on('click', '.btn-excluir', function () {
        const tr = $(this).closest('tr');
        const row = tabela.row(tr);
        const id = $(tr).data('id');

        $.ajax({
          url: '/api/pessoas/' + id,
          method: 'DELETE',
          success: function () {
            row.remove().draw();
          }
        });
      });

      $('#minhaTabela tbody').on('click', '.btn-editar', function () {
        const tr = $(this).closest('tr');
        const row = tabela.row(tr);
        const dados = row.data();

        $('#nome').val(dados[0]);
        $('#idade').val(dados[1]);
        $('#email').val(dados[2]);

        linhaEditando = row;
        $('#adicionarLinha').text('Atualizar');
      });
    });

    function gerarBotoesAcao() {
      return `
      <div class="col-12 d-flex">
        <button class="btn btn-outline-primary btn-editar">✏️ Editar</button>
        <button class="btn btn-outline-danger btn-excluir">🗑️ Excluir</button>
      </div>
      `;
    }
    function btns_acao(id){
        return `
            <div class="col-12 d-flex">
                <button type="button" onclick="editar_linha_tabela('`+id+`')" title="Editar" class="btn btn-sm btn-outline-secondary mr-1">
                    <i class="fa fa-pen"></i>
                </button>                                                                                                <button type="button" onclick="excluir_linha_tabela('`+id+`')" data-del="true" data-id="1" name="button" title="Excluir" class="btn btn-outline-danger">
                    <i class="fa fa-times"></i>
                </button>
            </div>
                `;
    }
    function checkbox_tabela(id){
        return `<td>
                    <input type="checkbox" class="checkbox" onclick="color_select1_0(this.checked,this.value);" value="`+id+`" name="check_`+id+`" id="check_`+id+`">
                </td>`;
    }
</script>
