@extends('layouts.user_type.auth')

@section('content')
  @hasexactroles('administrador')
    <div class="row my-4">
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card ">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-9">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">Personal Militar Activo</p>
                  <h5 class="font-weight-bolder mb-0 mx-3">
                    # {{ number_format($militares_activos,0,'','.') }}
                    <span class="text-success text-sm font-weight-bolder"></span>
                  </h5>
                </div>
              </div>
              <div class="col-3 text-end">
                <div style="background-image:linear-gradient(310deg,#506793,#273244)" class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card ">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-9">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">Evaluaciones realizadas el año ({{ $ultimo_year}})</p>
                  <h5 class="font-weight-bolder mb-0 mx-3">
                    # {{ number_format($evaluaciones,0,'','.') }}
                    <span class="text-success text-sm font-weight-bolder"></span>
                  </h5>
                </div>
              </div>
              <div class="col-3 text-end">
                <div style="background-image:linear-gradient(310deg,#506793,#273244)" class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card ">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-9">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">Pruebas físicas realizadas el año ({{$ultimo_year}})</p>
                  <h5 class="font-weight-bolder mb-0 mx-3">
                    # {{ number_format($pafs,0,'','.') }}
                    <span class="text-success text-sm font-weight-bolder"></span>
                  </h5>
                </div>
              </div>
              <div class="col-3 text-end">
                <div style="background-image:linear-gradient(310deg,#506793,#273244)" class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row my-4">
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card ">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-9">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">Sanciones Registradas</p>
                  <h5 class="font-weight-bolder mb-0 mx-3">
                    # {{ number_format($sanciones,0,'','.') }}
                    <span class="text-success text-sm font-weight-bolder"></span>
                  </h5>
                </div>
              </div>
              <div class="col-3 text-end">
                <div style="background-image:linear-gradient(310deg,#506793,#273244)" class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card ">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-9">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">sanciones Aprobadas</p>
                  <h5 class="font-weight-bolder mb-0 mx-3">
                    # {{ number_format($sanciones_aprobadas,0,'','.') }}
                    <span class="text-success text-sm font-weight-bolder"></span>
                  </h5>
                </div>
              </div>
              <div class="col-3 text-end">
                <div style="background-image:linear-gradient(310deg,#506793,#273244)" class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card ">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-9">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">Sanciones Denegadas</p>
                  <h5 class="font-weight-bolder mb-0 mx-3">
                    # {{ number_format($sanciones_denegadas,0,'','.') }}
                    <span class="text-success text-sm font-weight-bolder"></span>
                  </h5>
                </div>
              </div>
              <div class="col-3 text-end">
                <div style="background-image:linear-gradient(310deg,#506793,#273244)" class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card ">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-9">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">Sanciones Pendientes por Autorizar</p>
                  <h5 class="font-weight-bolder mb-0 mx-3">
                    # {{ number_format($sanciones_pendientes,0,'','.') }}
                    <span class="text-success text-sm font-weight-bolder"></span>
                  </h5>
                </div>
              </div>
              <div class="col-3 text-end">
                <div style="background-image:linear-gradient(310deg,#506793,#273244)" class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card ">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-9">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">Sanciones Registradas el ultimo Año ({{ $ultimo_year}})</p>
                  <h5 class="font-weight-bolder mb-0 mx-3">
                    # {{ number_format($sanciones_registradas_year,0,'','.') }}
                    <span class="text-success text-sm font-weight-bolder"></span>
                  </h5>
                </div>
              </div>
              <div class="col-3 text-end">
                <div style="background-image:linear-gradient(310deg,#506793,#273244)" class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card ">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-9">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">Sanciones Aprobadas el ultimo Año ({{ $ultimo_year}})</p>
                  <h5 class="font-weight-bolder mb-0 mx-3">
                    # {{ number_format($sanciones_aprobadas_year,0,'','.') }}
                    <span class="text-success text-sm font-weight-bolder"></span>
                  </h5>
                </div>
              </div>
              <div class="col-3 text-end">
                <div style="background-image:linear-gradient(310deg,#506793,#273244)" class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card ">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-9">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">Sanciones Denegadas el ultimo Año ({{ $ultimo_year}})</p>
                  <h5 class="font-weight-bolder mb-0 mx-3">
                    # {{ number_format($sanciones_denegadas_year,0,'','.') }}
                    <span class="text-success text-sm font-weight-bolder"></span>
                  </h5>
                </div>
              </div>
              <div class="col-3 text-end">
                <div style="background-image:linear-gradient(310deg,#506793,#273244)" class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card ">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-9">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">Procedimientos Devueltos</p>
                  <h5 class="font-weight-bolder mb-0 mx-3">
                    # {{ number_format($procedimientos_devueltos,0,'','.') }}
                    <span class="text-success text-sm font-weight-bolder"></span>
                  </h5>
                </div>
              </div>
              <div class="col-3 text-end">
                <div style="background-image:linear-gradient(310deg,#506793,#273244)" class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endhasexactroles
  @hasanyrole('aviacion_dao|aviacion_grupo_aereo|administrador')
    <div class="row mt-4">
      <div class="col-lg-12">
        <div class="card z-index-2">
          <div class="card-header pb-0">
            <h6>Vuelos Registrados</h6>
          </div>
          <div class="card-body p-3">
            <div class="chart">
              <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endhasanyrole

@endsection
@push('dashboard')
  <script>
    window.onload = function() {
      var ctx2 = document.getElementById("chart-line").getContext("2d");

      var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

      gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
      gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

      var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

      gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
      gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

      /*var data = [];
      for(i = 0; i < opciones.datos.length; i++){
          data.push({
              x: opciones.datos[i].fecha,
              y: opciones.datos[i].cantidad
          });
      }*/
      console.log(@json($vuelos_completados));
      var vuelos = @json($vuelos_completados);

      new Chart(ctx2, {
        type: "line",
        data: {
          labels: vuelos.map(row => row.new_date),
          datasets: [{
              label: "Completados",
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 2,
              borderColor: "#cb0c9f",
              borderWidth: 3,
              backgroundColor: gradientStroke1,
              fill: true,
              data: vuelos.map(row => row.completados),
              maxBarThickness: 5

            },
            {
              label: "Pendientes",
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 2,
              borderColor: "#3A416F",
              borderWidth: 3,
              backgroundColor: gradientStroke2,
              fill: true,
              data: vuelos.map(row => row.pendientes),
              maxBarThickness: 5
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: true,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                padding: 10,
                color: 'black',
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                color: 'black',
                padding: 20,
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
          },
        },
      });
    }
  </script>
@endpush
