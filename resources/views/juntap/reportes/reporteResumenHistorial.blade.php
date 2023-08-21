<style> 
    .bloque{
        display : table;
        border  : 0px solid black;
        width   : 100%;
    }
    .planilla{
        width  : 216mm;
        height : 279mm;
        border : 2px solid black;
        padding: 2.5cm 2cm;
        display: flex;
        flex-direction: column;
        justify-content: initial;
        font-family: 'Lato', sans-serif;
    }
    .logo{
        margin: 15px;
        height: 60px;
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
        flex-direction: columns;
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
        margin: 5px;
    }
    .titulo{
        width: 100%;
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
        <div class="header">
            <div class="bloque logocontainer" style="width: 12%;">
                <img class="logo" src="https://aviacion.mil.ve/wp-content/uploads/2022/10/ESCUDOAMB-1.png" alt="Logo Aviacion">
            </div>
            <div class="bloque" style="text-align:center;font-size:1rem">
                <strong>
                <div> República Bolivariana de Venezuela </div>
                <div> Ministerio del Poder Popular para la Defensa </div>
                <div> Aviación Militar Bolivariana </div>
                </strong>
            </div>
        </div>

        <div class="titulo" style="text-align:center;font-size:1rem">
            Datos del Solicitante
        </div>

        <div class="formbloq" >
            <table>
              <tr>
                  <td>Nombre y Apellido</td>
                  <td>Cedula de Identidad</td>
                  <td>Cargo</td>
                  <td>Unidad</td>
              </tr>
              @foreach($datos as $datos)
              <tr>
                  <th>{{$datos->nombre1.' '.$datos->nombre2}}, {{$datos->apellido1.' '.$datos->apellido2}}</th>
                  <th>{{$datos->cedula}}</th>
                  <th>{{$datos->cargo}}</th>
                  <th>{{$datos->ubicacion}}</th>
              </tr>
              @endforeach
            </table>
          </div>

        <div class="formbloq">
            <div class="campo" style="width: 60%;">
                <div class="label" style="font-size:0.9rem">Nombre y Apellido</div>
                <div class="input" style="font-size:0.8rem"> <strong>{{$datos->nombre1.' '.$datos->nombre2}}, {{$datos->apellido1.' '.$datos->apellido2}}</strong> </div>
            </div>
            <div class="campo" style="width: 30%;">
                <div class="label" style="font-size:0.9rem">Cedula de Identidad</div>
                <div class="input" style="font-size:0.8rem"> <strong>{{$datos->cedula}}</strong> </div>
            </div>
            <div class="campo" style="width: 30%;">
                <div class="label" style="font-size:0.9rem">Cargo</div>
                <div class="input" style="font-size:0.8rem"> <strong>{{$datos->cargo}}</strong> </div>
            </div>
            <div class="campo" style="height:auto; width: 50%;">
                <div class="label" style="font-size:0.9rem">Unidad</div>
                <div class="input" style="font-size:0.8rem"> <strong>{{$datos->ubicacion}}</strong> </div>
            </div>
        </div>
        <br>
        </br>
        <div class="titulo" style="text-align:center;font-size:1rem">
            Historico de Ascensos
        </div>

        <div class="formbloq" >
          <table>
            <tr>
                <td>Grado</td>
                <td>Fecha de Ascenso</td>
                <td>Orden de Mérito</td>
                <td>Total de Orden de Mérito</td>
            </tr>
            @foreach($historico as $historico)
            <tr>
                <th>{{$historico->grado}}</th>
                <th>{{$historico->fecha_a}}</th>
                <th>{{$historico->orden_merito}}</th>
                <th>{{$historico->total_orden_merito}}</th>
            </tr>
            @endforeach
          </table>
        </div>
        <footer style="margin-top: 50%">
            <p>_______________________________________________</p>
            <p>Presidente de la Junta Permanente de Evaluación</p>
          </footer>
    </div>
    
</body>