# Convênia - Teste prático - DEV PHP PLENO

### Requisitos:
- PHP
- Banco de dados
- Laravel <3
- Testes

### Diferenciais
- Fila
- Cache

---

## Descrição do teste

Desenvolver uma API para cadastro de vendas para vendedores e calcular a comissão destas vendas (a comissão será de 8.5% sobre o valor da venda)

### Endpoints

Todos os retornos devem ser em formato json

> Criar vendedor

##### retorno
- Nome
- Email

---

> Listar todos os vendedores

##### retorno
- Nome
- Email
- Comissão

---

> Lançar nova venda para um vendedor

##### retorno
- Nome
- Email
- Valor da venda
- Comissão
- Data da venda

---

> Listar todas as vendas de um vendedor

##### retorno
- Nome
- Email
- Valor da venda
- Comissão
- Data da venda


Ao final de cada dia deve ser enviado um email com um relatório com a soma de todas as vendas efetuadas no dia.

---

> Não é necessário nenhuma forma de login/autenticação

**Não esqueça de testes unitários e/ou de integração**

### Forma de de entrega:

Crie um fork deste repositório e após finalizado nos envie por email


