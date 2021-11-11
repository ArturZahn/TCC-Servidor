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
- mudar imagem de cadastro
- aumentar tamanho do preco e mudar a posicao (telas: home, carrinho, detalhes da compra) `ok`
- mudar card do carrinho (e lugares onde a foto do produto nao é o foco)
- colocar pix como opcao de pagamento `ok`
- alterar selecao de endereco do pedido 
- cadastro de foto 
- pesquisa por produtor `ok`
- adicionar mais informacoes sobre o produtor `ok`
- trocar a ordem do card do produtor na tela do produto `ok`

outros:
- aplicativo entregador?



----------------------------------
- Correcão de erros:

Erro no cadastro de produto `ok`
Add tipo contagem na tela de detalhes do pedido, pagamentos do produtor `ok`
Formatação de dinheiro no pagamentos do produtor `ok`
Tirar o link no app do produtor 
Retirar a repetição "produtor" no app cliente 
add forma de pagamento nos detalhes do pagamento
falto o R$ na tela pagamentos_do_produtor
faltou os campos para cadastrar o endereco do produtor `ok` 

Colocar PIX como forma de pagamento `ok`
mudar logos `ok`


-----------------------------
sudo apt-get install -y php libapache2-mod-php php-common php-curl php-dev php-gd php-idn php-pear php-imagick php-imap php-json php-mcrypt php-memcache php-mhash php-ming php-mysql php-ps php-pspell php-recode php-snmp php-sqlite php-tidy php-xmlrpc php-xsl

original:
sudo apt-get install -y php5 libapache2-mod-php5 php5-common php5-curl php5-dev php5-gd php5-idn
php-pear php5-imagick php5-imap php5-json php5-mcrypt php5-memcache php5-mhash php5-ming
php5-mysql php5-ps php5-pspell php5-recode php5-snmp php5-sqlite php5-tidy php5-xmlrpc php5-xsl

sudo apt install php-pear php7.4-curl php7.4-dev php7.4-gd php7.4-mbstring php7.4-zip php7.4-mysql php7.4-xml