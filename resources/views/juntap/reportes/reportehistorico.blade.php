<style> 
    .bloque{
        font-size: 1rem;
        height: 3cm;
        text-align: center;
        display : flex;
        width   : auto;
    }
    .planilla{
        width  : auto;
        height : auto;
        border : 5px solid rgb(16, 101, 206);
        padding: 0.5cm 0.5cm;
        display: flex;
        flex-direction: column;
        justify-content: initial;
        font-family: 'Lato', sans-serif;
    }
    .logo{
        height: 75px;
    }
    .header{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .databloq{
        display: flex;
        flex-direction: column;
    }
    .databloq{
        font-size: 0.5rem;
    }
    .logocontainer{
        display: flex;
        justify-content: center;
    }
    .header .bloque{
        height: 3cm;
    }
    .bloqrow{
        display: flex;
        border: 3px solid black;
        flex-direction: column;
        justify-content: center;
        height: 120%;
    }
    .header div {
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .campo{
        display: flex;
        flex-direction: column;
        justify-content: center;
        border: px solid black;
        height: .7cm;
        font-size: .65rem;
    }
    .campor{
        display: flex;
        flex-direction: row;
        justify-content: center;
        border: 1px solid black;
        height: 1.2cm;
        font-size: .9rem;
    }
    .formbloq{
        text-align: center;
        display: flex;
        margin: 2px;
    }
    .titulo{
        width: auto;
        background-color: #BBBDC0;
        border: 0px solid black;
        text-align: center;
        font-size: .75rem;
        height: .5cm;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .checkox{
        width: 10px;
        height:10px;
        margin: 3px;
        border: 1px solid black;
        align-self: flex-end;
    }
    .check{
        display: flex;
        flex-direction: row;
        align-content: flex-start
    }
    .labelgrey{
        text-align: center;
    }
    .sign{
        border: 1px solid black;
        height: .7cm;
        font-size: .7rem;
        display: flex;
        flex-direction: row;
    }
    td {
    padding: 20px;
  }
  footer {
      background-color: #ffffff;
      color: #000000;
      padding: 10px;
      height: -30cm;
      text-align: center;
    }
</style>
<body>
<div class="planilla" id="content">
<table>
    <td>
            <div class="formbloq" style="aling-content:center">
                <img class="logo" src='template/assets/img/logo.png' alt="Logo Aviacion">
        </div>
    </td>
    <td>
        <div class="formbloq" style="text-align:center">
            <strong>
                <div> República Bolivariana de Venezuela </div>
                <div> Ministerio del Poder Popular para la Defensa </div>
                <div> Aviación Militar Bolivariana </div>
            </strong>
        </div>
    </td>
</table>

        <div class="titulo" style="text-align:center;font-size:1rem">
            Datos del Solicitante
        </div>

<div class="formbloq" >
    <table>
        <tr>
        <th>Nombre y Apellido</th>
        <th>Cedula de Identidad</th>
        <th>Cargo</th>
        <th>Unidad</th>
        </tr>

        <tr>
        <td>{{$datos->nombre1.' '.$datos->nombre2}}, {{$datos->apellido1.' '.$datos->apellido2}}</td>
        <td>{{$datos->cedula}}</td>
        <td>{{$datos->cargo}}</td>
        <td>{{$datos->ubicacion}}</td>
        </tr>
    </table>
</div>

        <div class="titulo" style="text-align:center;font-size:1rem">
            Historico de Ascensos
        </div>

    <div class="formbloq" >
        <table>
            <tr>
                <th>Grado</th>
                <th>Fecha de Ascenso</th>
                <th>Orden de Mérito</th>
                <th>Total de Orden de Mérito</th>
            </tr>
            @foreach($historico as $historico)
            <tr>
                <td>{{$historico->grado}}</td>
                <td>{{$historico->fecha_a}}</td>
                <td>{{$historico->orden_merito}}</td>
                <td>{{$historico->total_orden_merito}}</td>
            </tr>
            @endforeach
        </table>
    </div>
        <footer style="margin-top: 40%">
            <p>_______________________________________________</p>
            <p>Presidente de la Junta Permanente de Evaluación</p>
        </footer>
    </div>
    
</body>