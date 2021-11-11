`Funcionalidades do sistema`
  - login para o sistema
├─ login `ok`

- Produtos
├─ tabela dos produtos
│   ⤷ campos: produtor, preco, qtd estoque
├─ formulario editar/cadastrar produtos

- Crud produtor
├─ tabela produtos
├─ formulario editar/cadastrar produtos
│   ⤷ link para produtos do produtor

- Pagamentos
├─ tebela produtores que precisam ser pagos
│   ⤷ descricao: ver para quais produtores a pooperativa ta devendo
│   ⤷ tabela: produtor, status, quanto ta devendo, botoes pagar produtor e ver todos os pagamentos
├─ pagar produtor
│   ⤷ tela para pagar o produtor
│   ⤷ tabela: mostra por quais itens o pagamento ta sendo feito
│   ⤷ botao para pagar
├─ ver todos os pagamentos do produtor
│   ⤷ tabela: data, valor, botao detalhes do pagamento
├─ ver detalhes do pagamento
│   ⤷ tabela: valor total, itens (qtd, valor do item)

- Tela pedidos realizados (que foram entregues e que ainda falta entregar)
├─ tabela dos pedidos
│   ⤷ campos: status, cod pedido, cliente, valor total, data, qtd itens, botao ver mais
│   ⤷ filtro: por status, cliente
├─ detelhe do pedido
    ⤷dados: cod pedido, cliente, valor total, status, data, qtd itens, tabela com itens do pedido,
│   ⤷ ver e atualizar dados
│   ⤷ cancelar compra



---------------------------------------------------------------------------------
Funções secundarias
- aba geral / home (produtos vendidos na semana, lucro da semana, etc)
- pagamento dos funcionários (?)



---------------------------------------------------------------------------------

Coisas para fazer:
- logo coopaf `ok`
- documentacao 
- fazer telas (design)
- slide apresentacao `ok`
- roteiro apresentacao `ok`

Coisas no projeto:
- design tela login `Ok`
- design tela tabela dos produtos
- design tela formulario editar/cadastrar produtos
- design tela tabela produtos
- design tela formulario editar/cadastrar produtos
- design tela tebela produtores que precisam ser pagos
- design tela pagar produtor
- design tela ver todos os pagamentos do produtor
- design tela ver detalhes do pagamento
- design tela tabela dos pedidos `Ok`
- design tela detelhe do pedido

- backend tela login `Ok`   

- backend tela tabela dos produtos
- backend tela formulario editar/cadastrar produtos
- backend tela tabela produtos
- backend tela formulario editar/cadastrar produtos
- backend tela tebela produtores que precisam ser pagos
- backend tela pagar produtor
- backend tela ver todos os pagamentos do produtor
- backend tela ver detalhes do pagamento
- backend tela tabela dos pedidos `Ok`
- backend tela detelhe do pedido

---------------------------------
Coisas secundárias:

Para mudar no aplicativo mobile:
- simplificar texto da index `ok`
- aumentar tamanho do preco e mudar a posicao (telas: home, carrinho, detalhes da compra) `ok`
- colocar pix como opcao de pagamento `ok`
- pesquisa por produtor `ok`
- adicionar mais informacoes sobre o produtor `ok`
- trocar a ordem do card do produtor na tela do produto `ok`

- mudar card do carrinho (e lugares onde a foto do produto nao é o foco)
- alterar selecao de endereco do pedido 
- mudar imagem de cadastro
- cadastro de foto 
- imagem da home do site
- criar os dados do blog

outros:
- aplicativo entregador?

----------------------------------
- Correcão de erros:

Erro no cadastro de produto `ok`
Add tipo contagem na tela de detalhes do pedido, pagamentos do produtor `ok`
Formatação de dinheiro no pagamentos do produtor `ok`
add forma de pagamento nos detalhes do pagamento `ok`
falto o R$ na tela pagamentos_do_produtor `ok`
faltou os campos para cadastrar o endereco do produtor `ok` 
Colocar PIX como forma de pagamento `ok`
mudar logos `ok`

Tirar o link no app do produtor 
Retirar a repetição "produtor" no app cliente 