<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Escalafon</title>
        <style>
            .titulo {
                border-radius: 15px;
                background: #Bcbdbd;
                size: 10px;
                font-size: 13px;
            }

            .cabecera {
                width: 50px;
                padding: 0px 2px 0px 0px;
            }
        </style>
    </head>
    <body>
        <div class="titulo">
            <table cellspacing="20">
                <tr>
                    <th align="center">REPÚBLICA BOLIVARIANA DE VENEZUELA<br>MINISTERIO DEL PODER POPULAR PARA LA DEFENSA<br>AVIACIÓN MILITAR NACIONAL BOLIVARIANA</th>

                    <th align="center">ESCALAFON GENERAL DEL PERSONAL MILITAR</th>

                    <th align="left">FECHA: {{date('d/m/Y')}}<br>PAGINA: {{'PAGINA DE PAGINAS'}}</th>
                </tr>
            </table>
        </div>
        <br>

        <div>
            <table>
                <tr>
                    <th style="text-align: left">Grado: {{'grado'}}</th>
                </tr>
                <tr>
                    <th style="text-align: left">Categoria: {{'categoria'}}</th>
                </tr>
            </table>
            <hr>

            <table>
                <thead>
                    <tr>
                        <th class="cabecera">Orden Antig.</th>
                        <th class="cabecera">Cedula</th>
                        <th class="cabecera">Nombres y Apellidos</th>
                        <th class="cabecera">Edad</th>
                        <th class="cabecera">Sexo</th>
                        <th class="cabecera">O.M.P</th>
                        <th class="cabecera">Fecha Graduación</th>
                        <th class="cabecera">Fecha Ult. Asc.</th>
                        <th class="cabecera">Fecha Retiro</th>
                        <th class="cabecera">CEAMB-1</th>
                        <th class="cabecera">CEAMB-2</th>
                        <th class="cabecera" style="word-wrap: break-word;">Cargo y Ubicación</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Listo</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>