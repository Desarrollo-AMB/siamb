@extends('layouts.user_type.auth')
{{-- ////@extends('layouts/contentNavbarLayout') --}}

<style>
    /* Ajustar el tamaño del gráfico */
    .chart-small {
        width: 100%;
        height: 25px;
    }
</style>
<style>
    /* Ajustar el tamaño del gráfico */
    .chart-small {
        width: 100%;
        height: 25px;
    }

    /* Estilos para la etiqueta del gráfico */
    .chart-label {
        margin-top: 10px;
    }

    .dark-gradient {
        background-image: linear-gradient(to bottom right, #122fb1c0, #1ae7ee, #2a159e94);
    }

    .dark-gradient1 {
        background-image: linear-gradient(to bottom right, #0c3557, #3ec8fa73);
    }

    .black-text {
        color: black;
    }
</style>

@section('content')
<script src="{{ asset('js/apexcharts.min.js') }}"></script>
<script src="{{ asset('js/chart.js') }}"></script>
@hasanyrole('administrador|consulta|jefe_de_personal|personal_militar|personal_militar_noprof|personal_civil|bienestar_social|junta_permanente')
<div class="container-fluid card z-index-3 custom-card dark-gradient">
    <div class="row my-4">
        <div class="col-sm-4 mb-xl-0 mb-4">
            <div class="card shadow-lg">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-9">
                            <div class="numbers">
                                <div class="d-flex align-items-center">
                                    <h5 class="font-weight-bolder mb-0 mr-3 black-text">
                                        #{{ number_format($evaluaciones, 0, '', '.') }}
                                    </h5>
                                    <div id="chart-12" class="apexcharts"></div>
                                </div>
                                <p class="text-xs mb-0 text-capitalize font-weight-bold black-text">Evaluaciones
                                    realizadas el año ({{ $ultimo_year }})</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 mb-xl-0 mb-4">
            <div class="card overflow-hidden shadow-lg">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-9">
                            <div class="numbers">
                                <div class="d-flex align-items-center">
                                    <h5 class="font-weight-bolder mb-0 mr-3 black-text">#{{ number_format($pafs, 0, '',
                                        '.') }}</h5>
                                    <div id="deporte" class="apexcharts apexcharts-responsive"></div>
                                </div>
                                <p class="text-xs mb-0 text-capitalize font-weight-bold black-text">Pruebas físicas
                                    realizadas el año ({{ $ultimo_year }})</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 mb-xl-4 mb-4">
            <div class="card overflow-hidden shadow-lg">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-9">
                            <div class="numbers">
                                <div class="d-flex align-items-center">
                                    <h5 class="font-weight-bolder mb-0 mx-3 black-text">#{{
                                        number_format($procedimientos_devueltos, 0, '', '.') }}</h5>
                                    <div id="chart-13" class="apexcharts"></div>
                                </div>
                                <p class="text-sm mb-0 text-capitalize font-weight-bold black-text">Procedimientos
                                    Devueltos</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-5 mb-xl-4 mb-5">
            <div class="card shadow-lg">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div id="chart1" class="apexcharts chart-small"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-sm-5 mb-xl-0 mb-6">
            <div class="card-responsive">
                <div class="card shadow-lg" style="max-width: 100%;">
                    <div class="card-body">
                        <div class="chart-container">
                            <div id="chart-year"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-4 mb-xl-0 mb-2">
            <div class="card-responsive">
                <div class="card shadow-lg" style="max-width: 100%;">
                    <div class="card-body">
                        <div class="chart-container">
                            <div id="chart24"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endhasanyrole
    @hasanyrole('aviacion_dao|aviacion_grupo_aereo|administrador|consulta')

    <div class="row">
        {{-- <div class="col-lg-6">
            <div class="card z-index-3 custom-card shadow-lg">
                <div class="card-header pb-2">
                    <h6 class="black-text">Vuelos Registrados</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>--}}
        <div class="col-xl-12 col-sm-4 mb-xl-0 mb-2" id="custom-card">
            <div class="card z-index-3 custom-card shadow-lg">
                <div class="card-header pb-2">
                    <h6 class="black-text">Vuelos Programados</h6>
                </div>
                <div class="card-body p-4">
                    <div id="chart"></div>
                </div>
            </div>
        </div>
    </div>



</div>
@endhasanyrole

@endsection
@push('dashboard')


<script>
    //sin usar
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
<script>
    var data1 = {!! json_encode($data1) !!};

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data1: {
                labels: data.labels,
                datasets: [{
                    label: 'Ventas',
                    data1: data.values,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
</script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/themes/dark-unica.js"></script>
<script>
    Highcharts.chart('container', {
            chart: {
                type: 'column'
            },

            xAxis: {
                categories: [
                    @foreach ($data as $item)
                        '{{ $item[0] }}',
                    @endforeach
                ]
            },
            yAxis: {
                title: {
                    text: 'Cantidad'
                }
            },
            series: [{
                name: 'Ventas 2019',
                data: [
                    @foreach ($data as $item)
                        {{ $item[1] }},
                    @endforeach
                ]
            }]
        });
</script>
<script>
    var dias = @json($vuelosPorDia);

    var datosProgramados = [];
    var datosCompletados = [];
    var datosPendientes = [];
    var categorias = [];

    dias.forEach(function(dia) {
        categorias.push(dia.fecha);
        datosProgramados.push(dia.total);
        datosCompletados.push(dia.completado);
        datosPendientes.push(dia.pendiente);
    });

    var options = {
        chart: {
            type: 'bar',
        },
        series: [{
            name: 'programados',
            data: datosProgramados
        }, {
            name: 'completados',
            data: datosCompletados
        }, {
            name: 'pendientes',
            data: datosPendientes
        }],
        xaxis: {
            categories: categorias
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>
<script>
    // Simulación de carga
    function simulateLoading() {
      const radioGraphs = document.getElementsByClassName("radio-graph");
      Array.from(radioGraphs).forEach((graph) => {
        graph.classList.add("loading");
        setTimeout(() => {
          graph.classList.remove("loading");
        }, 2000);
      });
    }

    simulateLoading();
</script>

<script>
    var chartElement = document.querySelector("#chart1");

// Agrega un evento de clic al elemento
chartElement.addEventListener("click", function() {
    var url = "{{ route('sireh.personal.militar.parte.index') }}";
  window.location.href = url;
});
    var militares_activos = <?php echo $militares_activos; ?>; // Asegúrate de que la variable $militares_activos esté definida antes de este código

    // Calcula el porcentaje basado en un total de 10,000
    var porcentaje = (militares_activos / 10000) * 100;

    var options = {
    series: [porcentaje],
    chart: {
        height: 200,
        type: 'radialBar',
        offsetY: -30
    },
    plotOptions: {
        radialBar: {
            startAngle: -135,
            endAngle: 135,
            dataLabels: {
                name: {
                    fontSize: '14px',
                    color: '#000000', // Color azul marino
                    offsetY: 80 // Ajusta este valor para acercar o alejar las etiquetas del gráfico
                }
            }
        }
    },
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'dark',
            shadeIntensity: 0.15,
            inverseColors: false,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 50, 65, 91],
            colorStops: [
                {
                    offset: 0,
                    color: '#3ec8fa73' // Color azul marino
                },
                {
                    offset: 100,
                    color: '#00aced' // Color azul marino
                }
            ]
        }
    },
    stroke: {
        dashArray: 2
    },
    labels: [militares_activos + ' Efectivos activos'],
};

var chart = new ApexCharts(document.querySelector("#chart1"), options);
chart.render();
</script>


<script>
    ///////evaluaciones//////////
    var evaluaciones = <?php echo $evaluaciones; ?>;
    var evaluacionesANT = <?php echo $evaluacionesANT; ?>;
    var evaluacionesANTe = <?php echo $evaluacionesANTe; ?>;
  var options1 = {
    series: [{
      data: [evaluacionesANTe,evaluacionesANT,evaluaciones]
    }],
    chart: {
      type: 'line',
      width: 100,
      height: 35,
      sparkline: {
        enabled: true
      }
    },
    tooltip: {
      fixed: {
        enabled: false
      },
      x: {
        show: false
      },
      y: {
        title: {
          formatter: function (seriesName) {
            return ''
          }
        }
      },
      marker: {
        show: false
      }
    }
  };

  var chart12 = new ApexCharts(document.querySelector("#chart-12"), options1);
  chart12.render();
</script>
<script>
    var pafs = <?php echo $pafs; ?>;
    var pafs1 = <?php echo $pafs1; ?>;
    var pafs2 = <?php echo $pafs2; ?>;
  var options2 = {
    series: [{
      data: [pafs2,pafs1,pafs]
    }],
    chart: {
      type: 'line',
      width: 100,
      height: 35,
      sparkline: {
        enabled: true
      }
    },
    tooltip: {
      fixed: {
        enabled: false
      },
      x: {
        show: false
      },
      y: {
        title: {
          formatter: function (seriesName) {
            return ''
          }
        }
      },
      marker: {
        show: false
      }
    }
  };

  var deporte = new ApexCharts(document.querySelector("#deporte"), options2);
  deporte.render();
</script>

<script>
    var sanciones = <?php echo $sanciones; ?>;
var sanciones_aprobadas = <?php echo $sanciones_aprobadas; ?>;
var sanciones_denegadas = <?php echo $sanciones_denegadas ; ?>;
var sanciones_pendientes = <?php echo $sanciones_pendientes; ?>;
var sanciones_registradas_year = <?php echo $sanciones_registradas_year; ?>;
var sanciones_aprobadas_year = <?php echo $sanciones_aprobadas_year; ?>;
var sanciones_denegadas_year = <?php echo $sanciones_denegadas_year; ?>;

var options = {
  series: [sanciones, sanciones_aprobadas, sanciones_denegadas, sanciones_pendientes, sanciones_registradas_year, sanciones_aprobadas_year, sanciones_denegadas_year],
  chart: {
    width: 380,
    type: 'donut',
  },
  plotOptions: {
    pie: {
      startAngle: -90,
      endAngle: 270
    }
  },
  dataLabels: {
    enabled: false
  },
  fill: {
    type: 'gradient',
  },
  legend: {
    formatter: function(val, opts) {
      return val + " - " + opts.w.globals.series[opts.seriesIndex]
    }
  },
  title: {
    text: 'Sanciones'
  },
  responsive: [{
    breakpoint: 480,
    options: {
      chart: {
        width: 200
      },
      legend: {
        position: 'bottom'
      }
    }
  }],
  labels: ['Sanciones Registradas', 'Sanciones Aprobadas', 'Sanciones Denegadas', 'Sanciones Pendientes', 'Registradas en el Año', ' Aprobadas en el Año', ' Denegadas en el Año']
};

var chartYear = new ApexCharts(document.querySelector("#chart-year"), options);
chartYear.render();
</script>
<script>
    var procedimientos_devueltos1 = <?php echo $procedimientos_devueltos1; ?>;
    var procedimientos_devueltos2 = <?php echo $procedimientos_devueltos2; ?>;
    var procedimientos_devueltos = <?php echo $procedimientos_devueltos; ?>;
  var options1 = {
    series: [{
      data: [procedimientos_devueltos2,procedimientos_devueltos1,procedimientos_devueltos]
    }],
    chart: {
      type: 'line',
      width: 100,
      height: 35,
      sparkline: {
        enabled: true
      }
    },
    tooltip: {
      fixed: {
        enabled: false
      },
      x: {
        show: false
      },
      y: {
        title: {
          formatter: function (seriesName) {
            return ''
          }
        }
      },
      marker: {
        show: false
      }
    }
  };

  var chart13 = new ApexCharts(document.querySelector("#chart-13"), options1);
  chart13.render();
</script>
<script>
    var aeronaved = <?php echo $aeronave->first()->disponible; ?>;
    var aeronaveidc = <?php echo $aeronave->first()->disponible_combate; ?>;
    var aeronavein = <?php echo $aeronave->first()->indisponible; ?>;
    var aeronaveis = <?php echo $aeronave->first()->siniestrada; ?>;
    var options = {
        series: [aeronaved, aeronaveidc, aeronavein, aeronaveis],
        chart: {
            type: 'donut',
            width: 320 // Ajustar el ancho del gráfico según tus necesidades
        },
        plotOptions: {
            pie: {
                startAngle: -90,
                endAngle: 90,
                offsetY: 10
            }
        },
        labels: ['Disponible','Acta para Combate','Indisponible','Siniestrada'], // Cambiar las etiquetas del gráfico
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }],
        annotations: {
            position: 'front',
            yaxis: [{
                y: -30, // Ajustar la posición vertical del histograma
                offsetY: 0,
                borderColor: '#999',
                fillColor: '#FEB019',
                opacity: 0.4,
                label: {
                    borderColor: '#999',
                    style: {
                        fontSize: '12px',
                        color: '#333',
                        background: '#FEB019',
                    },
                    text: 'Histograma',
                }
            }]
        },
        layout: {
            padding: {
                top: 30 // Ajustar el espacio superior para mostrar el histograma
            }
        },
        title: {
            text: 'Aeronaves' // Agregar el título de la gráfica aquí
        },
        colors: ['#006600', '#0000ff', '#eb780e', '#ff0000'] // Asignar colores personalizados
    };

    var chart24 = new ApexCharts(document.querySelector("#chart24"), options);
    chart24.render();
</script>
@endpush
