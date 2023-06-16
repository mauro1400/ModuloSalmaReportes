<table>
    <thead>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <th>#</th>
            <th>Fecha de Entrega</th>
            <th>Nro Solicitud</th>
            <th>Solicitante </th>
            <th>Administrador</th>
            <th>Departamento</th>
            <th>Articulo</th>
            <th>Pedido</th>
            <th>Entregado</th>
            <th>Total Entregado</th>
            <th>Codigo</th>
            <th>Code</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($busqueda as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->fecha_entrega }}</td>
                <td>{{ $item->nro_solicitud }}</td>
                <td>{{ $item->solicitante }}</td>
                <td>{{ $item->administrador }}</td>
                <td>{{ $item->departamento }}</td>
                <td>{{ $item->articulo }}</td>
                <td>{{ $item->pedido }}</td>
                <td>{{ $item->entregado }}</td>
                <td>{{ $item->total_entregado }}</td>
                <td>{{ $item->codigo }}</td>
                <td>{{ $item->code }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
