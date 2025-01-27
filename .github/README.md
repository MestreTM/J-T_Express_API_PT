
# API para Rastreamento J&T Express

## Descrição
Este projeto é uma aplicação PHP que permite rastrear encomendas utilizando uma API local simples. A aplicação aceita um número de rastreio fornecido pelo usuário e retorna detalhes sobre o status de entrega da encomenda (o CPF é um numero fixo no proprio codigo, pelos testes não é necessário um numero de CPF válido).

## Estrutura do Projeto
- `index.php`: Página principal que recebe o número de rastreio e exibe os resultados.
- `api.php`: Script responsável por fazer a requisição à API externa e retornar os dados.

## Configuração
### Requisitos
- PHP 7.4 ou superior
- Extensão cURL habilitada
- Servidor web (Apache, Nginx, etc.)

### Instalação
1. Clone ou baixe o repositório.
2. Certifique-se de que o servidor web esteja configurado corretamente para servir os arquivos PHP.
3. Verifique se o `api.php` está no mesmo diretório que o `index.php`.

## Utilização
### Requisição via URL
você pode usar diretamente via URL e integrar em outras paginas que desejar
ex:

```
http://localhost/track/api.php?waybillNo=8880302187*****
```

### Interface do Usuário para testes
<img src="https://i.imgur.com/2HOePnP.png" alt="Interface" width="600">
1. Acesse a página `index.php` no navegador.
2. Insira o número de rastreio no campo de texto e clique em "Rastrear".
3. O sistema exibirá os detalhes do rastreamento ou mensagens de erro apropriadas.

### Mensagens de Erro
- **Código de rastreio inválido ou inexistente:** Quando a API não encontra resultados para o código fornecido.
- **Erro ao conectar-se à API:** Quando não é possível estabelecer uma conexão com a API.
- **api.php não encontrada:** Quando o arquivo `api.php` não está presente no servidor.

## Personalização
### Modificar Configurações Fixas
Os seguintes parâmetros podem ser ajustados no `api.php` para refletir suas necessidades:
- **CPF**: Atualize a constante `CPF` se necessário. Foi deixado um valor fixo pois nos testes a API ignora o número do CPF.
- **Idioma**: Certifique-se de que `langType` esteja definido como `PT` para resultados em português.

## API Externa
A aplicação se comunica com a seguinte API externa:
- **Endpoint**: `https://official.jtjms-br.com/official/logisticsTracking/v2/getDetailByWaybillNo`
- **Método**: POST
Esta API externa retorna qualquer requisição sem autenticação.

### Parâmetros
- `waybillNo`: Número de rastreio fornecido pelo usuário.
- `cpf`: CPF fixo definido no código.
- `langType`: Idioma (definido como `PT`).

### Cabeçalhos
- `Content-Type`: application/json
- `Accept-Language`: pt-BR,pt;q=0.9

## Segurança
Certifique-se de proteger seus scripts de alterações não autorizadas. Caso utilize em produção, considere implementar autenticação ou restrições de IP para evitar uso indevido.

## Suporte
Se encontrar problemas ou precisar de ajuda, sinta-se à vontade para abrir uma issue no repositório.
