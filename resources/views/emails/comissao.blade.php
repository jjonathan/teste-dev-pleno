<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1>{{ $nome }}</h1>
	<h2>Valor total de comissão: R$ {{ number_format($valor_comissao, 2, ',', '.') }}</h2>
	<div>
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Valor</th>
				</tr>
			</thead>
			<tbody>
				@forelse($vendas as $venda)
					<tr>
						<td>{{ $venda->id }}</td>
						<td>R$ {{ number_format($venda->valor_venda, 2, ',', '.') }}</td>
					</tr>
				@empty
					<tr>
						<td colspan="2" style="text-align: center;">Sem vendas</td>
					</tr>
				@endforelse
			</tbody>
		</table>
	</div>
</body>
</html>