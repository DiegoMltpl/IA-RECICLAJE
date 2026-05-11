<!DOCTYPE html>
<html>
<body>

<h2>Reporte de reciclaje</h2>

<p>Total: {{ $total }} kg</p>

<table border="1" width="100%">
<tr>
<th>Material</th>
<th>Peso</th>
<th>Fecha</th>
</tr>

@foreach($pesajes as $p)
<tr>
<td>{{ $p->material }}</td>
<td>{{ $p->peso }}</td>
<td>{{ $p->fecha }}</td>
</tr>
@endforeach

</table>

</body>
</html>