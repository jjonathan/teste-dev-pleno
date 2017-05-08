<!DOCTYPE html>
<html>
<head>
    <title>teste-dev-pleno</title>

    <style type="text/css">
        th, td{
            text-align: center;
            padding: 10px 15px;
        }
        td:nth-child(3){
            text-align: left!important;
        }
    </style>

</head>
<body>
    <h1>teste-dev-pleno</h1>
    <p>
        API desenvolvida com a finalidade de atender os requisitos para o teste de dev pleno
    </p>
    <p>
        <h3>Abaixo segue a lista de rotas para acesso a API, tais como seus métodos, parâmetros e descrição:</h3>
    </p>
    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Rota</th>
                <th>Método</th>
                <th>Parâmetros</th>
                <th>Descrição</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><a href="vendedor/novo">vendedor/novo</a></td>
                <td>POST</td>
                <td>
                    <strong>nome</strong>:  (string) Nome do vendedor
                    <br>
                    <strong>email</strong>: (string) Email do vendedor
                </td>
                <td>
                    Faz o cadastro de novos vendedores
                </td>
            </tr>
            <tr>
                <td><a href="vendedor/lista">vendedor/lista</a></td>
                <td>GET</td>
                <td>
                    <strong>NENHUM</strong>
                </td>
                <td>
                    Lista todos os vendedores
                </td>
            </tr>
            <tr>
                <td><a href="venda/nova">venda/nova</a></td>
                <td>POST</td>
                <td>
                    <strong>vendedor_id</strong>: (integer) Id do vendedor
                    <br>
                    <strong>valor_venda</strong>: (float)   Valor da venda do vendedor
                </td>
                <td>
                    Lança uma nova venda para o vendedor
                </td>
            </tr>
            <tr>
                <td><a href="venda/lista">venda/lista</a></td>
                <td>GET</td>
                <td>
                    <strong>vendedor_id</strong>: (integer) Id do vendedor
                </td>
                <td>
                    Lista as vendas do vendedor e soma total da sua comissão
                </td>
            </tr>
        </tbody>
    </table>
    <p>
        Para o envio de e-mail foi seguido a documentação do Laravel para <a href="https://laravel.com/docs/5.4/scheduling" target="_blank">Agendamento de tarefa</a>, ou seja, é rodado o commando <code>php artisan email:comissao</code> todo dia as 23:59:00
    </p>
</body>
</html>