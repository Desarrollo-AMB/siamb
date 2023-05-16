<?php

namespace Database\Seeders;

use App\Models\AeronaveUnidades;
use App\Models\AeronaveModelo;
use App\Models\AeronaveMatricula;
use App\Models\ComponenteOrganismo;
use App\Models\VueloEnApoyo;
use App\Models\VueloOrdenadaPor;
use App\Models\FuncionTripulante;
use App\Models\CodigoTipoMision;
use App\Models\CodigoDespegue;
use App\Models\CodigoSensores;
use App\Models\UnidadesConsumible;
use App\Models\EmpleadoFuncion;
use App\Models\UnidadesMedidas;
use App\Models\CodigoTipoMisionSiglas;
use App\Models\CodigoAterrizaje;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AeronaveUnidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['unidad' => 'GRUPO AÉREO DE TRANSPORTE Nº4',               'codigos' => 'G-4',  'codigo_ubicacion' =>  '2011'],
            ['unidad' => 'GRUPO AÉREO DE TRANSPORTE Nº5',               'codigos' => 'G-5',  'codigo_ubicacion' =>  '2012'],
            ['unidad' => 'GRUPO AÉREO DE TRANSPORTE Nº6',               'codigos' => 'G-6',  'codigo_ubicacion' =>  '2023'],
            ['unidad' => 'GRUPO AÉREO DE VUELO INSTRUMENTAL Nº7',       'codigos' => 'G-7',  'codigo_ubicacion' =>  '4041'],
            ['unidad' => 'GRUPO AÉREO DE INTELIGENCIA, VIGILANCIA Y RECONOCIMIENTO ELECTRÓNICO Nº8', 'codigos' => 'G-8', 'codigo_ubicacion' => '1022'],
            ['unidad' => 'GRUPO AÉREO DE TRANSPORTE Nº9',               'codigos' => 'G-9' , 'codigo_ubicacion' => '2072'],
            ['unidad' => 'GRUPO AÉREO DE OPERACIONES ESPECIALES Nº10',  'codigos' => 'G-10', 'codigo_ubicacion' => '2024'],
            ['unidad' => 'GRUPO AÉREO DE CAZA Nº11',                    'codigos' => 'G-11', 'codigo_ubicacion' => '2022'],
            ['unidad' => 'GRUPO AÉREO DE CAZA Nº12',                    'codigos' => 'G-12', 'codigo_ubicacion' => '2031'],
            ['unidad' => 'GRUPO AÉREO DE CAZA Nº13',                    'codigos' => 'G-13', 'codigo_ubicacion' => '7285'],
            ['unidad' => 'GRUPO AÉREO DE CAZA Nº13',                    'codigos' => 'G-13', 'codigo_ubicacion' => '2041'],
            ['unidad' => 'GRUPO DE ENTRENAMIENTO AÉREO Nº14',           'codigos' => 'G-14', 'codigo_ubicacion' => '4004'],
            ['unidad' => 'GRUPO AÉREO DE OPERACIONES ESPECIALES Nº15',  'codigos' => 'G-15', 'codigo_ubicacion' => '2051'],
            ['unidad' => 'GRUPO AÉREO DE CAZA Nº16',                    'codigos' => 'G-16', 'codigo_ubicacion' => '2021'],
            ['unidad' => 'GRUPO AÉREO DE OPERACIONES ESPECIALES Nº17',  'codigos' => 'G-17', 'codigo_ubicacion' => '7015'],
            ['unidad' => 'GRUPO DE ENTRENAMIENTO AÉREO Nº18',           'codigos' => 'G-18', 'codigo_ubicacion' => '8696'],
            ['unidad' => 'GRUPO DE ENTRENAMIENTO AÉREO Nº19',           'codigos' => 'G-19', 'codigo_ubicacion' => '8697'],
        ];

        foreach ($items as $item) {
            AeronaveUnidades::create($item);
        }

        $aeronaves = [
            ['aeronave' => 'AIRBUS A319',                         'modelo' => 'A319CJ',    'codigo_unidad' => 'G-4' ],
            ['aeronave' => 'AS532 COUGAR',                        'modelo' => 'AS_532',    'codigo_unidad' => 'G-4' ],
            ['aeronave' => 'BOEING 707-320C',                     'modelo' => 'B_737',     'codigo_unidad' => 'G-4' ],
            ['aeronave' => 'EMBRAER 190',                         'modelo' => 'EMB190',    'codigo_unidad' => 'G-4' ],
            ['aeronave' => 'DASSAULT FALCON 900EX',               'modelo' => 'F_900EX',   'codigo_unidad' => 'G-4' ],
            ['aeronave' => 'MI17',                                'modelo' => 'MI17',      'codigo_unidad' => 'G-4' ],
            ['aeronave' => 'BERIEV BE-200',                       'modelo' => 'BE_200',    'codigo_unidad' => 'G-5' ],
            ['aeronave' => 'BEECHCRAFT SUPER KING AIR',           'modelo' => 'B_350',     'codigo_unidad' => 'G-5' ],
            ['aeronave' => 'CESSNA 550 CITATION II',              'modelo' => 'C_550',     'codigo_unidad' => 'G-5' ],
            ['aeronave' => 'SHAANXI Y-8 F-200W',                  'modelo' => 'Y8F200W',   'codigo_unidad' => 'G-6' ],
            ['aeronave' => 'LOCKHEED C-130 HERCULES',             'modelo' => 'C_130HV',   'codigo_unidad' => 'G-6' ],
            ['aeronave' => 'SHORTS 360',                          'modelo' => 'SD_360',    'codigo_unidad' => 'G-6' ],
            ['aeronave' => 'FAIRCHILD C-26 METROLINER',           'modelo' => 'C_26',      'codigo_unidad' => 'G-8' ],
            ['aeronave' => 'CESSNA SKYLANE 182',                  'modelo' => 'C_182S',    'codigo_unidad' => 'G-9' ],
            ['aeronave' => 'CESSNA 206',                          'modelo' => 'C_206H',    'codigo_unidad' => 'G-9' ],
            ['aeronave' => 'CESSNA 208 CARAVAN',                  'modelo' => 'C_208B',    'codigo_unidad' => 'G-9' ],
            ['aeronave' => 'DORNIER DO 228',                      'modelo' => 'DO_228',    'codigo_unidad' => 'G-9' ],
            ['aeronave' => 'EUROCOPTER AS332 SUPER PUMA',         'modelo' => 'AS332B1',   'codigo_unidad' => 'G-10'],
            ['aeronave' => 'AS532 COUGAR',                        'modelo' => 'AS532AC',   'codigo_unidad' => 'G-10'],
            ['aeronave' => 'SUKHOI SU-30MK2',                     'modelo' => 'SU30MK2',   'codigo_unidad' => 'G-11'],
            ['aeronave' => 'HONGDU K-8W KARAKORUM',               'modelo' => 'K8_W',      'codigo_unidad' => 'G-12'],
            ['aeronave' => 'CESSNA 421',                          'modelo' => 'C_421',     'codigo_unidad' => 'G-12'],
            ['aeronave' => 'SUKHOI SU-30MK2',                     'modelo' => 'SU30MK2',   'codigo_unidad' => 'G-13'],
            ['aeronave' => 'EMBRAER EMB 312 TUCANO',              'modelo' => 'T_27',      'codigo_unidad' => 'G-14'],
            ['aeronave' => 'AERMACCHI SF.260',                    'modelo' => 'F_260',     'codigo_unidad' => 'G-14'],
            ['aeronave' => 'HONGDU K-8W KARAKORUM',               'modelo' => 'k8_W',      'codigo_unidad' => 'G-15'],
            ['aeronave' => 'F-16 FIGHTING FALCON',                'modelo' => 'F_16',      'codigo_unidad' => 'G-16'],
            ['aeronave' => 'MIL MI-17V5',                         'modelo' => 'MI17V5',    'codigo_unidad' => 'G-17'],
            ['aeronave' => 'DIAMOND AIRCRAFT DA-40 DIAMOND STAR', 'modelo' => 'DA40NG',    'codigo_unidad' => 'G-18'],
            ['aeronave' => 'DIAMOND AIRCRAFT DA-42 TWIN STAR',    'modelo' => 'DA42VI',    'codigo_unidad' => 'G-18'],
            ['aeronave' => 'ENSTROM 480',                         'modelo' => 'EN480B',    'codigo_unidad' => 'G-19'],
            ['aeronave' => 'ENSTROM 280FX',                       'modelo' => 'EN280FX',   'codigo_unidad' => 'G-19'],
        ];

        foreach ($aeronaves as $modelos) {
            AeronaveModelo::create($modelos);
        }

        $matriculas = [
            ['matricula' => '0001',        'serial' => null,  'aeronave_id' => 1],//grupo 4
            ['matricula' => '59089',       'serial' => null,  'aeronave_id' => 2],
            ['matricula' => 'FANB-50200',  'serial' => null,  'aeronave_id' => 2],
            ['matricula' => '59180',       'serial' => null,  'aeronave_id' => 2],
            ['matricula' => '50109',       'serial' => null,  'aeronave_id' => 2],
            ['matricula' => '50201',       'serial' => null,  'aeronave_id' => 2],
            ['matricula' => '59194',       'serial' => null,  'aeronave_id' => 2],
            ['matricula' => '59195',       'serial' => null,  'aeronave_id' => 2],
            ['matricula' => '50202',       'serial' => null,  'aeronave_id' => 2],
            ['matricula' => '50203',       'serial' => null,  'aeronave_id' => 2],
            ['matricula' => '0207',        'serial' => null,  'aeronave_id' => 3],
            ['matricula' => 'YV3016',      'serial' => null,  'aeronave_id' => 4],
            ['matricula' => 'YV2486',      'serial' => null,  'aeronave_id' => 5],
            ['matricula' => 'YV2485',      'serial' => null,  'aeronave_id' => 5],
            ['matricula' => '61120 ',      'serial' => null,  'aeronave_id' => 6],
            ['matricula' => '61029',       'serial' => null,  'aeronave_id' => 6],
            ['matricula' => '0501',        'serial' => null,  'aeronave_id' => 6],
            ['matricula' => '2909',        'serial' => null,  'aeronave_id' => 6],
            ['matricula' => '1607',        'serial' => null,  'aeronave_id' => 6],
            ['matricula' => '1811',        'serial' => null,  'aeronave_id' => 6],
            ['matricula' => '0804',        'serial' => null,  'aeronave_id' => 6],
            ['matricula' => '0705',        'serial' => null,  'aeronave_id' => 6],
            ['matricula' => '0764',        'serial' => null,  'aeronave_id' => 6], 
            ['matricula' => '5134',        'serial' => 'BB466',   'aeronave_id' => 7],//grupo 5
            ['matricula' => '1112',        'serial' => 'BB1110',  'aeronave_id' => 7],
            ['matricula' => '1111',        'serial' => 'FM-8',    'aeronave_id' => 8],
            ['matricula' => '2836',        'serial' => null,      'aeronave_id' => 8],
            ['matricula' => '1603',        'serial' => null,      'aeronave_id' => 9],
            ['matricula' => '0403',        'serial' => null,      'aeronave_id' => 9],
            ['matricula' => '0102',        'serial' => '3703',  'aeronave_id' => 10],//grupo 6
            ['matricula' => '1909',        'serial' => '3704',  'aeronave_id' => 10],
            ['matricula' => '2509',        'serial' => '3801',  'aeronave_id' => 10],
            ['matricula' => '2810',        'serial' => '3705',  'aeronave_id' => 10],
            ['matricula' => '2803',        'serial' => '3701',  'aeronave_id' => 10],
            ['matricula' => '2410',        'serial' => '3702',  'aeronave_id' => 10],
            ['matricula' => '1192',        'serial' => '3802',  'aeronave_id' => 10],
            ['matricula' => '2703',        'serial' => '3803',  'aeronave_id' => 10],
            ['matricula' => '9508',        'serial' => '4409',  'aeronave_id' => 11],
            ['matricula' => '3134',        'serial' => '4801',  'aeronave_id' => 11],
            ['matricula' => '4951',        'serial' => '4407',  'aeronave_id' => 11],
            ['matricula' => '5320',        'serial' => '4577',  'aeronave_id' => 11],
            ['matricula' => '2358',        'serial' => 'SH-3761',  'aeronave_id' => 12],
            ['matricula' => '0009',        'serial' => 'AC-745B',  'aeronave_id' => 13],//grupo 8 
            ['matricula' => '1964',        'serial' => 'AC-740B',  'aeronave_id' => 13],
            ['matricula' => '1778',        'serial' => null,  'aeronave_id' => 14],//grupo 9
            ['matricula' => '1501',        'serial' => null,  'aeronave_id' => 14],
            ['matricula' => '4283',        'serial' => null,  'aeronave_id' => 14],
            ['matricula' => '1836',        'serial' => null,  'aeronave_id' => 14],
            ['matricula' => '0505',        'serial' => null,  'aeronave_id' => 15],
            ['matricula' => '0506',        'serial' => null,  'aeronave_id' => 15],
            ['matricula' => '1235',        'serial' => null,  'aeronave_id' => 15],
            ['matricula' => '1257',        'serial' => null,  'aeronave_id' => 15],
            ['matricula' => '1328',        'serial' => null,  'aeronave_id' => 15],
            ['matricula' => '1565',        'serial' => null,  'aeronave_id' => 15],
            ['matricula' => '1810',        'serial' => null,  'aeronave_id' => 15],
            ['matricula' => '2104',        'serial' => null,  'aeronave_id' => 15],
            ['matricula' => '2154',        'serial' => null,  'aeronave_id' => 15],
            ['matricula' => '2602',        'serial' => null,  'aeronave_id' => 15],
            ['matricula' => '2709',        'serial' => null,  'aeronave_id' => 15],
            ['matricula' => '2964',        'serial' => null,  'aeronave_id' => 15],
            ['matricula' => '3110',        'serial' => null,  'aeronave_id' => 15],
            ['matricula' => '0956',        'serial' => null,  'aeronave_id' => 16],
            ['matricula' => '1708',        'serial' => null,  'aeronave_id' => 16],
            ['matricula' => '2406',        'serial' => null,  'aeronave_id' => 16],
            ['matricula' => '4292',        'serial' => null,  'aeronave_id' => 16],
            ['matricula' => 'YV-2980',     'serial' => null,  'aeronave_id' => 17],
            ['matricula' => 'YV-3000',     'serial' => null,  'aeronave_id' => 17],
            ['matricula' => 'YV-3083',     'serial' => null,  'aeronave_id' => 17],
            ['matricula' => '49614',       'serial' => null,  'aeronave_id' => 18],//grupo 10
            ['matricula' => '0121',        'serial' => null,  'aeronave_id' => 18],
            ['matricula' => '5110',        'serial' => null,  'aeronave_id' => 18],
            ['matricula' => '50109',       'serial' => null,  'aeronave_id' => 19],
            ['matricula' => '50201',       'serial' => null,  'aeronave_id' => 19],
            ['matricula' => '59194',       'serial' => null,  'aeronave_id' => 19],
            ['matricula' => '59195',       'serial' => null,  'aeronave_id' => 19],
            ['matricula' => '50202',       'serial' => null,  'aeronave_id' => 19],
            ['matricula' => '50203',       'serial' => null,  'aeronave_id' => 19],
            ['matricula' => '59089',       'serial' => null,  'aeronave_id' => 19],
            ['matricula' => 'FANB-50200',  'serial' => null,  'aeronave_id' => 19],
            ['matricula' => '59180',       'serial' => null,  'aeronave_id' => 19],
            ['matricula' => '0460',        'serial' => null,  'aeronave_id' =>20],//grupo 11
            ['matricula' => '1259',        'serial' => '79810386001',  'aeronave_id' =>20],
            ['matricula' => '1265',        'serial' => '79810386104',  'aeronave_id' =>20],
            ['matricula' => '8963',        'serial' => '79810386003',  'aeronave_id' =>20],
            ['matricula' => '0962',        'serial' => '79810386106',  'aeronave_id' =>20],
            ['matricula' => '0167',        'serial' => '79810386105',  'aeronave_id' =>20],
            ['matricula' => '1075',        'serial' => '79810386207',  'aeronave_id' =>20],
            ['matricula' => '0457',        'serial' => null,           'aeronave_id' =>20],
            ['matricula' => '9959',        'serial' => '79810386411',  'aeronave_id' =>20],
            ['matricula' => '1175',        'serial' => '79810386208',  'aeronave_id' =>20],
            ['matricula' => '1161',        'serial' => '79810386618',  'aeronave_id' =>20],
            ['matricula' => '5812',        'serial' => '79810386723',  'aeronave_id' =>20],
            ['matricula' => '0402',        'serial' => 'L8W3200258',  'aeronave_id' =>21],//grupo 12
            ['matricula' => '0507',        'serial' => 'L8W3200257',  'aeronave_id' =>21],
            ['matricula' => '0611',        'serial' => 'L8W3200269',  'aeronave_id' =>21],
            ['matricula' => '2002',        'serial' => 'L8W3200260',  'aeronave_id' =>21],
            ['matricula' => '1904',        'serial' => 'L8W3200253',  'aeronave_id' =>21],
            ['matricula' => '2707',        'serial' => 'L8W3200259',  'aeronave_id' =>21],
            ['matricula' => '2912',        'serial' => 'L8W3200256',  'aeronave_id' =>21],
            ['matricula' => '9998',        'serial' => 'L8W3200255',  'aeronave_id' =>21],
            ['matricula' => '61864',       'serial' => 'L8W3200316',  'aeronave_id' =>21],
            ['matricula' => '61866',       'serial' => 'L8W3200318',  'aeronave_id' =>21],
            ['matricula' => '61868',       'serial' => 'L8W3200320',  'aeronave_id' =>21],
            ['matricula' => '61862',       'serial' => 'L8W3200314',  'aeronave_id' =>21],
            ['matricula' => '8774',        'serial' => '421C0611',  'aeronave_id' =>22],
            ['matricula' => '2711',        'serial' => '79810386310',  'aeronave_id' =>23],//grupo 13
            ['matricula' => '0462',        'serial' => '79810386412',  'aeronave_id' =>23],
            ['matricula' => '0564',        'serial' => '79810386413',  'aeronave_id' =>23],
            ['matricula' => '3564',        'serial' => '79810386514',  'aeronave_id' =>23],
            ['matricula' => '1168',        'serial' => '79810386515',  'aeronave_id' =>23],
            ['matricula' => '1169',        'serial' => '79810386516',  'aeronave_id' =>23],
            ['matricula' => '9463',        'serial' => '79810386617',  'aeronave_id' =>23],
            ['matricula' => '5965',        'serial' => '79810386619',  'aeronave_id' =>23],
            ['matricula' => '5790',        'serial' => '79810386620',  'aeronave_id' =>23],
            ['matricula' => '3363',        'serial' => '79810386721',  'aeronave_id' =>23],
            ['matricula' => '1157',        'serial' => '79810386722',  'aeronave_id' =>23],
            ['matricula' => '1783',        'serial' => '79810386724',  'aeronave_id' =>23],
            ['matricula' => '0040',        'serial' => '312-216',  'aeronave_id' =>24],//grupo 14
            ['matricula' => '0086',        'serial' => null,       'aeronave_id' =>24],
            ['matricula' => '0150',        'serial' => null,       'aeronave_id' =>24],
            ['matricula' => '0175',        'serial' => null,       'aeronave_id' =>24],
            ['matricula' => '0260',        'serial' => '312-228',  'aeronave_id' =>24],
            ['matricula' => '1405',        'serial' => null,  'aeronave_id' =>24],
            ['matricula' => '2280',        'serial' => null,  'aeronave_id' =>24],
            ['matricula' => '2460',        'serial' => null,  'aeronave_id' =>24],
            ['matricula' => '3050',        'serial' => null,  'aeronave_id' =>24],
            ['matricula' => '4000',        'serial' => '312-238',  'aeronave_id' =>24],
            ['matricula' => '4180',        'serial' => '312-239',  'aeronave_id' =>24],
            ['matricula' => '5050',        'serial' => '312-247',  'aeronave_id' =>24],
            ['matricula' => '7101',        'serial' => null,  'aeronave_id' =>24],
            ['matricula' => '7321',        'serial' => null,  'aeronave_id' =>24],
            ['matricula' => '8247',        'serial' => '312-265',  'aeronave_id' =>24],
            ['matricula' => '9244',        'serial' => '312-267',  'aeronave_id' =>24],
            ['matricula' => '0027',        'serial' => '2014',  'aeronave_id' =>25],
            ['matricula' => '1248',        'serial' => '2015',  'aeronave_id' =>25],
            ['matricula' => '3199',        'serial' => '2025',  'aeronave_id' =>25],
            ['matricula' => '3220',        'serial' => '2022',  'aeronave_id' =>25],
            ['matricula' => '4524',        'serial' => '2016',  'aeronave_id' =>25],
            ['matricula' => '5356',        'serial' => null,  'aeronave_id' =>25],
            ['matricula' => '6344',        'serial' => '2018',  'aeronave_id' =>25],
            ['matricula' => '6500',        'serial' => null,    'aeronave_id' =>25],
            ['matricula' => '7072',        'serial' => '2019',  'aeronave_id' =>25],
            ['matricula' => '8216',        'serial' => null,    'aeronave_id' =>25],
            ['matricula' => '9673',        'serial' => '2021',  'aeronave_id' =>25],
            ['matricula' => '1303',        'serial' => '3200263',  'aeronave_id' =>26],//grupo 15
            ['matricula' => '1504',        'serial' => '3200262',  'aeronave_id' =>26],// siniestrada
            ['matricula' => '1602',        'serial' => '3200265',  'aeronave_id' =>26],
            ['matricula' => '2510',        'serial' => '3200264',  'aeronave_id' =>26],
            ['matricula' => '2712',        'serial' => '3200266',  'aeronave_id' =>26],
            ['matricula' => '2908',        'serial' => '3200268',  'aeronave_id' =>26],
            ['matricula' => '0410',        'serial' => '3200270',  'aeronave_id' =>26],
            ['matricula' => '61863',       'serial' => '320315',   'aeronave_id' =>26],
            ['matricula' => '61865',       'serial' => '320317',   'aeronave_id' =>26],
            ['matricula' => '61867',       'serial' => '320319',   'aeronave_id' =>26],
            ['matricula' => '61869',       'serial' => '320321',   'aeronave_id' =>26],
            ['matricula' => '61960',       'serial' => '320322',   'aeronave_id' =>26],
            ['matricula' => '0094',        'serial' => null,  'aeronave_id' =>27],//grupo 16
            ['matricula' => '0220',        'serial' => null,  'aeronave_id' =>27],
            ['matricula' => '0678',        'serial' => null,  'aeronave_id' =>27],
            ['matricula' => '1041',        'serial' => null,  'aeronave_id' =>27],
            ['matricula' => '1715',        'serial' => null,  'aeronave_id' =>27],
            ['matricula' => '2337',        'serial' => null,  'aeronave_id' =>27],
            ['matricula' => '3260',        'serial' => null,  'aeronave_id' =>27],
            ['matricula' => '3648',        'serial' => null,  'aeronave_id' =>27],
            ['matricula' => '9583',        'serial' => null,  'aeronave_id' =>27],
            ['matricula' => '9864',        'serial' => null,  'aeronave_id' =>27],
            ['matricula' => '7268',        'serial' => null,  'aeronave_id' =>27],
            ['matricula' => '7635',        'serial' => null,  'aeronave_id' =>27],
            ['matricula' => '8924',        'serial' => null,  'aeronave_id' =>27],
            ['matricula' => '5422',        'serial' => null,  'aeronave_id' =>27],
            ['matricula' => '4226',        'serial' => null,  'aeronave_id' =>27],
            ['matricula' => '0501',        'serial' => null,  'aeronave_id' =>28],//grupo 17
            ['matricula' => '2909',        'serial' => null,  'aeronave_id' =>28],
            ['matricula' => '1607',        'serial' => null,  'aeronave_id' =>28],
            ['matricula' => '1811',        'serial' => null,  'aeronave_id' =>28],
            ['matricula' => '0804',        'serial' => null,  'aeronave_id' =>28],
            ['matricula' => '0705',        'serial' => null,  'aeronave_id' =>28],
            ['matricula' => '0764',        'serial' => null,  'aeronave_id' =>28],
            ['matricula' => '61121',       'serial' => null,  'aeronave_id' =>28],
            ['matricula' => '61029',       'serial' => null,  'aeronave_id' =>28],
            ['matricula' => '61346',       'serial' => null,  'aeronave_id' =>29],//grupo 18
            ['matricula' => '61347',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61348',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61349',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61440',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61441',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61442',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61443',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61444',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61445',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61446',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61447',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61448',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61449',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61540',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61541',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61552',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61553',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61554',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61555',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61556',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61557',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61558',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61559',       'serial' => null,  'aeronave_id' =>29],
            ['matricula' => '61650',       'serial' => null,  'aeronave_id' =>30],
            ['matricula' => '61651',       'serial' => null,  'aeronave_id' =>30],
            ['matricula' => '61652',       'serial' => null,  'aeronave_id' =>30],
            ['matricula' => '61653',       'serial' => null,  'aeronave_id' =>30],
            ['matricula' => '61654',       'serial' => null,  'aeronave_id' =>30],
            ['matricula' => '61655',       'serial' => null,  'aeronave_id' =>30],
            ['matricula' => '61646',       'serial' => '5198', 'aeronave_id' =>31],//grupo 19
            ['matricula' => '61647',       'serial' => '5208', 'aeronave_id' =>31],
            ['matricula' => '61648',       'serial' => '5209', 'aeronave_id' =>31],
            ['matricula' => '61649',       'serial' => '5210', 'aeronave_id' =>31],
            ['matricula' => '61750',       'serial' => '5216', 'aeronave_id' =>31],
            ['matricula' => '61751',       'serial' => 'X',    'aeronave_id' =>31],
            ['matricula' => '61752',       'serial' => '5218', 'aeronave_id' =>31],
            ['matricula' => '61753',       'serial' => '5219', 'aeronave_id' =>31],
            ['matricula' => '1805',        'serial' => 'X',    'aeronave_id' =>32],
            ['matricula' => '3009',        'serial' => '3009', 'aeronave_id' =>32]
        ];

        foreach ($matriculas as $item) {
            AeronaveMatricula::create($item);
        }

        $componentes = [
            ['componente' => 'AVIACION MILITAR BOLIVARIANA',                 'organismo' => 'AMB'],
            // ['componente' => 'EJERCITO BOLIVARIANO',                         'organismo' => null],
            // ['componente' => 'ARMADA BOLIVARIANA',                           'organismo' => null],
            // ['componente' => 'GUARDIA NACIONAL BOLIVARIANA',                 'organismo' => null],
            // ['componente' => 'MINISTERIO DEL PODER POPULAR PARA LA DEFENSA', 'organismo' => null],
        ];

        foreach ($componentes as $item) {
            ComponenteOrganismo::create($item);
        }

        $enApoyo = [
            ['nombre_apoyo' => 'GUARDIA DE HONOR PRESIDENCIAL',                                 'codigo' => 'GHP'],
            ['nombre_apoyo' => 'CEO',                                                           'codigo' => 'CEO'],
            ['nombre_apoyo' => 'COMANDANCIA GENERAL DE LA AVICION MILITAR BOLIVARIANA',         'codigo' => 'AMB'],
            ['nombre_apoyo' => 'COMANDANCIA GENERAL DEL EJERCITO',                              'codigo' => 'EJB'],
            ['nombre_apoyo' => 'COMANDANCIA GENERAL DE LA ARMADA NACIONAL BOLIVARIANA',         'codigo' => 'ARMB'],
            ['nombre_apoyo' => 'COMANDANCIA GENERAL DE LA GUARDIA NACIONAL BOLIVARIANA',        'codigo' => 'GNB'],
            ['nombre_apoyo' => 'MINISTERIO DEL PODER POPULAR PARA LA DEFENSA',                  'codigo' => 'MPPD'],
            ['nombre_apoyo' => 'MILICIA BOLIVARIANA',                                           'codigo' => 'MB'],
            ['nombre_apoyo' => 'REDI',                                                          'codigo' => 'REDI'],
            ['nombre_apoyo' => 'ZODI',                                                          'codigo' => 'ZODI'],
            ['nombre_apoyo' => 'ADI',                                                           'codigo' => 'ADI'],
            ['nombre_apoyo' => 'BAEL',                                                          'codigo' => 'BAEL'],
            ['nombre_apoyo' => 'BASUCRE',                                                       'codigo' => 'BASUCRE'],
            ['nombre_apoyo' => 'BAGFM',                                                         'codigo' => 'BAGFM'],
            ['nombre_apoyo' => 'BARU',                                                          'codigo' => 'BARU'],
            ['nombre_apoyo' => 'BALANDA',                                                       'codigo' => 'BALANDA'],
            ['nombre_apoyo' => 'BARAGUA',                                                       'codigo' => 'BARAGUA'],
            ['nombre_apoyo' => 'BAEMARI',                                                       'codigo' => 'BAEMARI'],
            ['nombre_apoyo' => 'BAVIVAS',                                                       'codigo' => 'BAVIVAS'],
            ['nombre_apoyo' => 'BAMEMDEZ',                                                      'codigo' => 'BAMEMDEZ'],
            ['nombre_apoyo' => 'BAVALLES',                                                      'codigo' => 'BAVALLES'],
            ['nombre_apoyo' => 'BAPAEZ',                                                        'codigo' => 'BAPAEZ'],
            ['nombre_apoyo' => 'BATAVI',                                                        'codigo' => 'BATAVI'],
            ['nombre_apoyo' => 'BAORI',                                                         'codigo' => 'BAORI'],
            ['nombre_apoyo' => 'BACASERES',                                                     'codigo' => 'BACASERES'],
            ['nombre_apoyo' => 'GRUPABAEL',                                                     'codigo' => 'GRUPABAEL'],
            ['nombre_apoyo' => 'GRUPABASUCRE',                                                  'codigo' => 'GRUPABASUCRE'],
            ['nombre_apoyo' => 'GRUPABAGFM',                                                    'codigo' => 'GRUPABAGFM'],
            ['nombre_apoyo' => 'EPABARU',                                                       'codigo' => 'EPABARU'],
            ['nombre_apoyo' => 'EPABALANDA',                                                    'codigo' => 'EPABALANDA'],
            ['nombre_apoyo' => 'EPABARAGUA',                                                    'codigo' => 'EPABARAGUA'],
            ['nombre_apoyo' => 'EPABAEMARI',                                                    'codigo' => 'EPABAEMARI'],
            ['nombre_apoyo' => 'EPABAVIVAS',                                                    'codigo' => 'EPABAVIVAS'],
            ['nombre_apoyo' => 'EPABAMENDEZ',                                                   'codigo' => 'EPABAMENDEZ'],
            ['nombre_apoyo' => 'EPABAVALLE',                                                    'codigo' => 'EPABAVALLE'],
            ['nombre_apoyo' => 'EPABAPAEZ',                                                     'codigo' => 'EPABAPAEZ'],
            ['nombre_apoyo' => 'GRUPO AEREO PRESIDENCIAL Nº 4',                                 'codigo' => 'GAC4'],
            ['nombre_apoyo' => 'GRUPO AEREO DE TRANSPORTE Nº 5',                                'codigo' => 'GAC5'],
            ['nombre_apoyo' => 'GRUPO AEREO DE TRANSPORTE Nº 6',                                'codigo' => 'GAC6'],
            ['nombre_apoyo' => 'GRUPO  AEREO DE ENTRENAMINTO INSTRUMENTAL  Nº 7',               'codigo' => 'GC7'],
            ['nombre_apoyo' => 'GRUPO AEREO DE RECONOCIMIENTO VIGILANCIA Y CONTROL Nº 8',       'codigo' => 'GAC8'],
            ['nombre_apoyo' => 'GRUPO AEREO DE TRANSPORTE Nº 9',                                'codigo' => 'GAC9'],
            ['nombre_apoyo' => 'GRUPO AEREO DE OERACINES ESPECIALES Nº10',                      'codigo' => 'GAC10'],
            ['nombre_apoyo' => 'GRUPO AEREO DE CAZA Nº11',                                      'codigo' => 'GAC11'],
            ['nombre_apoyo' => 'GRUPO AEREO DE CAZA Nº12',                                      'codigo' => 'GAC12'],
            ['nombre_apoyo' => 'GRUPO AEREO DE CAZA Nº13',                                      'codigo' => 'GAC13'],
            ['nombre_apoyo' => 'GRUPO AEREO DE ENTRENAMIENTO Nº14',                             'codigo' => 'GAC14'],
            ['nombre_apoyo' => 'GRUPO AEREO DE CAZA Nº15',                                      'codigo' => 'GAC15'],
            ['nombre_apoyo' => 'GRUPO AEREO DE CAZA Nº16',                                      'codigo' => 'GAC16'],
            ['nombre_apoyo' => 'GRUPO AEREO DE OPERACIONES ESPECIALES  Nº17',                   'codigo' => 'GAC17'],
            ['nombre_apoyo' => 'GRUPO AEREO DE ENTRENAMIENTO Nº18',                             'codigo' => 'GAC18'],
            ['nombre_apoyo' => 'GRUPO AEREO DE ENTRENAMIENTO Nº19',                             'codigo' => 'GAC19'],
            ['nombre_apoyo' => 'GRUPO  DE OPERACIONES ESPECIALES  Nº20',                        'codigo' => 'GC20'],
            ['nombre_apoyo' => 'GRUPO AEREO º21',                                               'codigo' => 'GAC21'],
            ['nombre_apoyo' => 'GOBERNACION',                                                   'codigo' => 'GOBERNACION'],
            ['nombre_apoyo' => 'ALCALDIA',                                                      'codigo' => 'ACALDIA'],
            ['nombre_apoyo' => 'DIRECCION REGIONAL DE SALUD',                                   'codigo' => 'DIGSALUD'],
            ['nombre_apoyo' => 'MISION MEDICA CUBANA',                                          'codigo' => 'MMC'],
            ['nombre_apoyo' => 'MINISTERIO DEL PODER POPULAR PARA HABITAD Y VIVIENDA.',         'codigo' => 'MIHVI'],
            ['nombre_apoyo' => 'MINISTERIO DEL PODER POPULAR PARA LA ECONOMÍA Y FINANZAS.',     'codigo' => 'MPPEFC'],
            ['nombre_apoyo' => 'MINISTERIO DEL PODER POPULAR PARA LA AGRICULTURA Y TIERRAS.',   'codigo' => 'MPPAT'],
            ['nombre_apoyo' => 'MINISTERIO DEL PODER POPULAR DE ENERGÍA Y PETRÓLEO.',           'codigo' => 'MINPET'],
            ['nombre_apoyo' => 'MINISTERIO DEL PODER POPULAR PARA LA ALIMENTACIÓN.',            'codigo' => 'MINPAL'],
            ['nombre_apoyo' => 'MINISTERIO DEL PODER POPULAR PARA LA PLANIFICACIÓN Y DESARROLLO','codigo' => 'MPPP'],
            ['nombre_apoyo' => 'MINISTERIO DEL PODER POPULAR PARA LA ECONOMÍA',                 'codigo' => 'MPPEFC'],
            ['nombre_apoyo' => 'MINISTERIO DEL PODER POPULAR PARA LAS RELACIONES INTERIORES JUSTICIA Y PAZ','codigo' => 'MPPRIJP '],
            ['nombre_apoyo' => 'MINISTERIO DEL PODER POPULAR PARA LA CIENCIA Y TECNOLOGÍA',                 'codigo' => 'MINCYT'],
            ['nombre_apoyo' => 'MINISTERIO DEL PODER POPULAR PARA LA COMUNICACIÓN Y LA INFORMACIÓN',        'codigo' => 'MPPCI '],
            ['nombre_apoyo' => 'MINISTERIO DEL PODER POPULAR PARA EL ECOSOCIALISMO',                        'codigo' => 'MINEC'],
            ['nombre_apoyo' => 'MINISTERIO DEL PODER POPULAR PARA EL TURISMO',                              'codigo' => 'MINTUR'],
            ['nombre_apoyo' => 'MINISTERIO DEL PODER POPULAR PARA LA CULTURA',                              'codigo' => 'MINCULTURA'],
            ['nombre_apoyo' => 'MINISTERIO DEL PODER POPULAR PARA LAS OBRAS PÚBLICAS Y VIVIENDAMINISTERIO DEL PODER POPULAR PARA VIVIENDA Y HÁBITAT.','codigo' => 'MINHVI'],
            ['nombre_apoyo' => 'MINISTERIO DEL PODER POPULAR PARA EL PROCESO SOCIAL DEL TRABAJO',           'codigo' => 'MPPPST'],
            ['nombre_apoyo' => 'MINISTERIO DE RELACIONES EXTERIORES',                                       'codigo' => 'MPPRE'],
        ];

        foreach ($enApoyo as $item) {
            VueloEnApoyo::create($item);
        }

        $ordenadaPor = [
            ['autoridad_orden_vuelo' => 'PRESIDENCIAL',                                                         'codigo' => 'GPH'],                                                     
            ['autoridad_orden_vuelo' => 'MINISTERIO DEL PODER POPULAR PARA LA DEFENSA ',                        'codigo' => 'MPPD'],                    
            ['autoridad_orden_vuelo' => 'COMANDO ESTRATÉGICO OPERACIONAL – DIRECTOR DE MEDIOS AÉREOS ',         'codigo' => 'CEO-DMA'],     
            ['autoridad_orden_vuelo' => 'COMANDANTE GENERAL AMB',                                               'codigo' => 'COMGRAL'],                                           
            ['autoridad_orden_vuelo' => 'COMANDO DE DEFENSA AÉREO ESPACIAL INTEGRAL – CENTRO DE DIRECCIÓN ',    'codigo' => 'CODAI - CDDAI'], 
            ['autoridad_orden_vuelo' => 'GRUPO AEREO PRESIDENCIAL Nº 4',                                        'codigo' => 'GAC4'],                                   
            ['autoridad_orden_vuelo' => 'GRUPO AEREO DE TRANSPORTE Nº 5',                                       'codigo' => 'GAC5'],                                  
            ['autoridad_orden_vuelo' => 'GRUPO AEREO DE TRANSPORTE Nº 6',                                       'codigo' => 'GAC6'],                                  
            ['autoridad_orden_vuelo' => 'GRUPO  AEREO DE ENTRENAMINTO INSTRUMENTAL  Nº 7',                      'codigo' => 'GAC7'],                 
            ['autoridad_orden_vuelo' => 'GRUPO AEREO DE RECONOCIMIENTO VIGILANCIA Y CONTROL Nº 8',              'codigo' => 'GAC8'],         
            ['autoridad_orden_vuelo' => 'GRUPO AEREO DE TRANSPORTE Nº 9',                                       'codigo' => 'GAC9'],                                  
            ['autoridad_orden_vuelo' => 'GRUPO AEREO DE OERACINES ESPECIALES Nº10',                             'codigo' => 'GAC10'],                       
            ['autoridad_orden_vuelo' => 'GRUPO AEREO DE CAZA Nº11',                                             'codigo' => 'GAC11'],                                        
            ['autoridad_orden_vuelo' => 'GRUPO AEREO DE CAZA Nº12',                                             'codigo' => 'GAC12'],                                        
            ['autoridad_orden_vuelo' => 'GRUPO AEREO DE CAZA Nº13',                                             'codigo' => 'GAC13'],                                        
            ['autoridad_orden_vuelo' => 'GRUPO AEREO DE ENTRENAMIENTO Nº14',                                    'codigo' => 'GAC14'],                               
            ['autoridad_orden_vuelo' => 'GRUPO AEREO DE CAZA Nº15',                                             'codigo' => 'GAC15'],                                        
            ['autoridad_orden_vuelo' => 'GRUPO AEREO DE CAZA Nº16',                                             'codigo' => 'GAC16'],                                       
            ['autoridad_orden_vuelo' => 'GRUPO AEREO DE OPERACIONES ESPECIALES  Nº17',                          'codigo' => 'GAC17'],                    
            ['autoridad_orden_vuelo' => 'GRUPO AEREO DE ENTRENAMIENTO Nº18',                                    'codigo' => 'GAC18'],                               
            ['autoridad_orden_vuelo' => 'GRUPO AEREO DE ENTRENAMIENTO Nº19',                                    'codigo' => 'GAC19'],                              
            ['autoridad_orden_vuelo' => 'OMANDO AÉREO DE OPERACIONES VÍA OCATA',                                'codigo' => 'CAO-OCATA'],                           
            ['autoridad_orden_vuelo' => 'COMANDO AÉREO DE OPERACIONES VÍA DIROPECAO',                           'codigo' => 'CAO-OPNES'],                    
            ['autoridad_orden_vuelo' => 'FUERZA DE TAREA',                                                      'codigo' => 'FTA'],                                                        
        ];

        foreach ($ordenadaPor as $item) {
            VueloOrdenadaPor::create($item);
        }

        $funcionTripulante = [
            ['funcion' => 'ALUMNO PILOTO',                          'codigo' => 'AP',   'codigo_funcion' => 4100100],
            ['funcion' => 'CO-PILOTO',                              'codigo' => 'CP',   'codigo_funcion' => 4100101],
            ['funcion' => 'PILOTO O CAPITÁN DE NAVE',               'codigo' => 'P',    'codigo_funcion' => 4100102],
            ['funcion' => 'PILOTO INSTRUCTOR',                      'codigo' => 'PI',   'codigo_funcion' => 4100103],
            ['funcion' => 'OPERADOR REMOTO INTERNO',                'codigo' => 'ORI',  'codigo_funcion' => 4100104],
            ['funcion' => 'OPERADOR REMOTO EXTERNO',                'codigo' => 'ORE',  'codigo_funcion' => 4100105],
            ['funcion' => 'ALUMNO OPERADOR REMOTO INTERNO',         'codigo' => 'AORI', 'codigo_funcion' => 4100106],
            ['funcion' => 'ALUMNO OPERADOR REMOTO EXTERNO',         'codigo' => 'AORE', 'codigo_funcion' => 4100107],
            ['funcion' => 'OBSERVADOR',                             'codigo' => 'OB',   'codigo_funcion' => 4100108],
            ['funcion' => 'OSANGE',                                 'codigo' => 'OS',   'codigo_funcion' => 4100109],
            ['funcion' => 'OPERADOR DE CARGA ÚTIL',                 'codigo' => 'PCU',  'codigo_funcion' => 4100110],
            ['funcion' => 'OFICIAL DE SOPORTE ELECTRÓNICO ',        'codigo' => 'OSE',  'codigo_funcion' => 4100111],
            ['funcion' => 'OFICIAL DE SOPORTE ELECTRÓNICO MAGINT ', 'codigo' => 'OSEM', 'codigo_funcion' => 4100112],
            ['funcion' => 'OFICIAL DE SOPORTE ELECTRÓNICO COMINT ', 'codigo' => 'OSEC', 'codigo_funcion' => 4100113],
            ['funcion' => 'OFICIAL DE SOPORTE ELECTRÓNICO SIGINT ', 'codigo' => 'OSES', 'codigo_funcion' => 4100114],
            ['funcion' => 'JEFE DE MÁQUINA ',                       'codigo' => 'JM',   'codigo_funcion' => 4100115],
            ['funcion' => 'INGENIERO DE VUELO ',                    'codigo' => 'IV',   'codigo_funcion' => 4100116],
            ['funcion' => 'NAVEGANTE ',                             'codigo' => 'N',    'codigo_funcion' => 4100117],
            ['funcion' => 'RADIO OPERADOR ',                        'codigo' => 'RO',   'codigo_funcion' => 4100118],
            ['funcion' => 'MAESTRO DE CARGA ',                      'codigo' => 'MC',   'codigo_funcion' => 4100119],
            ['funcion' => 'MAESTRO DE SALTO ',                      'codigo' => 'MS',   'codigo_funcion' => 4100120],
            ['funcion' => 'OPERADOR DE BOOM ',                      'codigo' => 'OB',   'codigo_funcion' => 4100121],
            ['funcion' => 'OPERADOR DE CESTA ',                     'codigo' => 'OC',   'codigo_funcion' => 4100122],
            ['funcion' => 'ARTILLERO ',                             'codigo' => 'ART',  'codigo_funcion' => 4100123],
            ['funcion' => 'FOTÓGRAFO AÉREO ',                       'codigo' => 'FA',   'codigo_funcion' => 4100124],
            ['funcion' => 'SEGURIDAD ABORDO ',                      'codigo' => 'SA',   'codigo_funcion' => 4100125],
            ['funcion' => 'ENFERMERO AERONÁUTICO ',                 'codigo' => 'EA',   'codigo_funcion' => 4100126],
            ['funcion' => 'MÉDICO AERONÁUTICO ',                    'codigo' => 'MA',   'codigo_funcion' => 4100127],
            ['funcion' => 'AUXILIAR DE JEFE DE MÁQUINA ',           'codigo' => 'AJM',  'codigo_funcion' => 4100128],
            ['funcion' => 'AUXILIAR DE INGENIERO DE VUELO ',        'codigo' => 'AIV',  'codigo_funcion' => 4100129],
            ['funcion' => 'AUXILIAR DE MAESTRO DE CARGA ',          'codigo' => 'AMC',  'codigo_funcion' => 4100130],
            ['funcion' => 'AUXILIAR DE MAESTRO DE SALTO ',          'codigo' => 'AMS',  'codigo_funcion' => 4100131],
            ['funcion' => 'AUXILIAR ABORDO (SOBRE CARGO) ',         'codigo' => 'AA',   'codigo_funcion' => 4100132],
            ['funcion' => 'OPERADOR DE GRÚA ',                      'codigo' => 'OG',   'codigo_funcion' => 4100133],
            ['funcion' => 'OPERADOR DE ESLINGA',                    'codigo' => 'OE',   'codigo_funcion' => 4100134],
        ];

        foreach ($funcionTripulante as $item) {
            FuncionTripulante::create($item);
        }

        // $empleadosSegunFunciones = [
        //     ['codigo_empleado' => '4731',  'codigo_grado' => '210', 'codigo_ubicacion' => '',     'id_funcion' => '16'],
        //     ['codigo_empleado' => '30284', 'codigo_grado' => '090', 'codigo_ubicacion' => '2022', 'id_funcion' => '16'],
        //     ['codigo_empleado' => '30286', 'codigo_grado' => '070', 'codigo_ubicacion' => '',     'id_funcion' => '16'],
        //     ['codigo_empleado' => '30285', 'codigo_grado' => '090', 'codigo_ubicacion' => '',     'id_funcion' => '16'],
        //     ['codigo_empleado' => '26795', 'codigo_grado' => '070', 'codigo_ubicacion' => '2031', 'id_funcion' => '3'],
        //     ['codigo_empleado' => '24622', 'codigo_grado' => '070', 'codigo_ubicacion' => '',     'id_funcion' => '2'],
        //     ['codigo_empleado' => '59921', 'codigo_grado' => '070', 'codigo_ubicacion' => '',     'id_funcion' => '3'],
        //     ['codigo_empleado' => '15694', 'codigo_grado' => '080', 'codigo_ubicacion' => '7285', 'id_funcion' => '11'],
        //     ['codigo_empleado' => '2242',  'codigo_grado' => '090', 'codigo_ubicacion' => '',     'id_funcion' => '12'],
        //     ['codigo_empleado' => '59855', 'codigo_grado' => '070', 'codigo_ubicacion' => '',     'id_funcion' => '2'],
            
        // ];

        // foreach ($empleadosSegunFunciones as $item) {
        //     EmpleadoFuncion::create($item);
        // }

        $codigoTipoMision = [
            ['codigo' => 10,  'nombre' => 'ENTRENAMIENTO/MANIOBRAS DE CONVERSIÓN'],
            ['codigo' => 11,  'nombre' => 'ENTRENAMIENTO/FORMACIÓN'],
            ['codigo' => 12,  'nombre' => 'ENTRENAMIENTO/FORMACIÓN TÁCTICA'],
            ['codigo' => 13,  'nombre' => 'ENTRENAMIENTO/ACROBACIA INDIVIDUAL'],
            ['codigo' => 14,  'nombre' => 'ENTRENAMIENTO/ACROBACIA EN FORMACIÓN'],
            ['codigo' => 20,  'nombre' => 'NAVEGACIÓN/NAVEGACIÓN A ESTIMA'],
            ['codigo' => 21,  'nombre' => 'NAVEGACIÓN/NAVEGACIÓN POR INSTRUMENTOS'],
            ['codigo' => 22,  'nombre' => 'NAVEGACIÓN/NAVEGACIÓN POR RADIO AYUDAS'],
            ['codigo' => 23,  'nombre' => 'NAVEGACIÓN/EVALUACIÓN DE RADIO AYUDAS Y/O PROCEDIMIENTOS INSTRUMENTALES'],
            ['codigo' => 24,  'nombre' => 'NAVEGACIÓN/TRASLADO DE AERONAVE'],
            ['codigo' => 30,  'nombre' => 'TÁCTICAS AIRE-AIRE/MANIOBRA BÁSICAS DE COMBATE AÉREO'],
            ['codigo' => 31,  'nombre' => 'TÁCTICAS AIRE-AIRE/MANIOBRAS DE COMBATE AÉREO'],
            ['codigo' => 32,  'nombre' => 'TÁCTICAS AIRE-AIRE/TÁCTICA DE COMBATES AÉREO'],
            ['codigo' => 33,  'nombre' => 'TÁCTICAS AIRE-AIRE/PATRULLAJE AÉREA DE COMBATE'],
            ['codigo' => 34,  'nombre' => 'TÁCTICAS AIRE-AIRE/ESCOLTA AÉREA'],
            ['codigo' => 35,  'nombre' => 'TÁCTICAS AIRE-AIRE/INTERCEPTACIÓN'],
            ['codigo' => 36,  'nombre' => 'TÁCTICAS AIRE-AIRE/BARRIDO DE CAZA'],
            ['codigo' => 37,  'nombre' => 'TÁCTICAS AIRE-AIRE/SUPRESIÓN DE DEFENSA AÉREA ENEMIGA'],
            ['codigo' => 38,  'nombre' => 'TÁCTICAS AIRE-AIRE/EMBOSCADA AÉREA'],
            ['codigo' => 40,  'nombre' => 'TÁCTICAS AIRE-TIERRA/NAVEGACIÓN TÁCTICA RASANTE'],
            ['codigo' => 41,  'nombre' => 'TÁCTICAS AIRE-TIERRA/TÁCTICAS APLICADAS'],
            ['codigo' => 42,  'nombre' => 'TÁCTICAS AIRE-TIERRA/LANZAMIENTO DE BENGALAS'],
            ['codigo' => 43,  'nombre' => 'TÁCTICAS AIRE-TIERRA/CONTROLADOR AÉREO AVANZADO'],
            ['codigo' => 44,  'nombre' => 'TÁCTICAS AIRE-TIERRA/RECONOCIMIENTO ARMADO'],
            ['codigo' => 50,  'nombre' => 'ENTREGA DE ORDENANZAS/BOMBARDEO EN PICADA'],
            ['codigo' => 51,  'nombre' => 'ENTREGA DE ORDENANZAS/BOMBARDEO HORIZONTAL'],
            ['codigo' => 52,  'nombre' => 'ENTREGA DE ORDENANZAS/BOMBARDEO EN PARÁBOLA'],
            ['codigo' => 53,  'nombre' => 'ENTREGA DE ORDENANZAS/BOMBARDEO RASANTE'],
            ['codigo' => 54,  'nombre' => 'ENTREGA DE ORDENANZAS/LANZAMIENTO DE BOMBAS GUIADAS (LASER/GPS/ÓPTICO)'],
            ['codigo' => 55,  'nombre' => 'ENTREGA DE ORDENANZAS/LANZAMIENTO DE COHETES AIRE – TIERRA'],
            ['codigo' => 56,  'nombre' => 'ENTREGA DE ORDENANZAS/TIRO AIRE – TIERRA CON CAÑONES O AMETRALLADORAS'],
            ['codigo' => 60,  'nombre' => 'ENTREGA DE ORDENANZAS/TIRO AIRE – AIRE CON CAÑONES O AMETRALLADORAS'],
            ['codigo' => 61,  'nombre' => 'ENTREGA DE ORDENANZAS/LANZAMIENTO DE MISILES AIRE – AIRE PASIVOS'],
            ['codigo' => 62,  'nombre' => 'ENTREGA DE ORDENANZAS/LANZAMIENTO DE MISILES AIRE – AIRE SEMI ACTIVOS'],
            ['codigo' => 63,  'nombre' => 'ENTREGA DE ORDENANZAS/LANZAMIENTO DE MISILES AIRE – AIRE ACTIVOS'],
            ['codigo' => 64,  'nombre' => 'ENTREGA DE ORDENANZAS/LANZAMIENTO DE MISILES AIRE – TIERRA'],
            ['codigo' => 65,  'nombre' => 'ENTREGA DE ORDENANZAS/LANZAMIENTO DE MISILES AIRE – MAR'],
            ['codigo' => 66,  'nombre' => 'ENTREGA DE ORDENANZAS/REMOLQUE DE BLANCOS AÉREOS'],
            ['codigo' => 70,  'nombre' => 'OPERACIONES AEROTRANSPORTADAS/TRANSPORTE DE CARGA'],
            ['codigo' => 71,  'nombre' => 'OPERACIONES AEROTRANSPORTADAS/TRANSPORTE DE PASAJEROS'],
            ['codigo' => 72,  'nombre' => 'OPERACIONES AEROTRANSPORTADAS/TRANSPORTE DE ANIMALES'],
            ['codigo' => 73,  'nombre' => 'OPERACIONES AEROTRANSPORTADAS/TRANSPORTE DE CARGA Y PASAJEROS'],
            ['codigo' => 74,  'nombre' => 'OPERACIONES AEROTRANSPORTADAS/TRANSPORTE DE CARGA Y ANIMALES'],
            ['codigo' => 75,  'nombre' => 'OPERACIONES AEROTRANSPORTADAS/TRANSPORTE DE PASAJEROS Y ANIMALES'],
            ['codigo' => 76,  'nombre' => 'OPERACIONES AEROTRANSPORTADAS/TRANSPORTE DE CARGA, PASAJEROS Y ANIMALES'],
            ['codigo' => 77,  'nombre' => 'OPERACIONES AEROTRANSPORTADAS/TRANSPORTE DE ARMAMENTO'],
            ['codigo' => 78,  'nombre' => 'OPERACIONES AEROTRANSPORTADAS/TRANSPORTE DE SUSTANCIA TÓXICA Y/O PELIGROSA'],
            ['codigo' => 79,  'nombre' => 'OPERACIONES AEROTRANSPORTADAS/ESLINGA (HELICÓPTERO) (EQUIVALENTE A TRANSFERENCIA VERTICAL DE CARGA)'],
            ['codigo' => 80,  'nombre' => 'OPERACIONES AEROTRANSPORTADAS/TRANSPORTE AEROMÉDICO'],
            ['codigo' => 81,  'nombre' => 'OPERACIONES AEROTRANSPORTADAS/EVACUACIÓN AEROMÉDICA'],
            ['codigo' => 82,  'nombre' => 'OPERACIONES AEROTRANSPORTADAS/TRANSPORTE Y LANZAMIENTO DE CARGA'],
            ['codigo' => 83,  'nombre' => 'OPERACIONES AEROTRANSPORTADAS/ASALTO AÉREO'],
            ['codigo' => 84,  'nombre' => 'OPERACIONES AEROTRANSPORTADAS/LANZAMIENTO DE PARACAIDISTA'],
            ['codigo' => 85,  'nombre' => 'OPERACIONES AEROTRANSPORTADAS/HELITÁCTICA (HELICÓPTERO)'],
            ['codigo' => 86,  'nombre' => 'OPERACIONES AEROTRANSPORTADAS/APAGA FUEGOS (CONTRAINCENDIOS)'],
            ['codigo' => 87,  'nombre' => 'OPERACIONES AEROTRANSPORTADAS/SIEMBRA (BOMBARDEO) DE NUBES'],
            ['codigo' => 90,  'nombre' => 'RECONOCIMIENTO Y BÚSQUEDA/RECONOCIMIENTO VISUAL'],
            ['codigo' => 91,  'nombre' => 'RECONOCIMIENTO Y BÚSQUEDA/RECONOCIMIENTO AEROFOTOGRÁFICO'],
            ['codigo' => 92,  'nombre' => 'RECONOCIMIENTO Y BÚSQUEDA/RECONOCIMIENTO METEOROLÓGICO'],
            ['codigo' => 93,  'nombre' => 'RECONOCIMIENTO Y BÚSQUEDA/RECONOCIMIENTO TELEMÉTRICO (EN REVISIÓN)'],
            ['codigo' => 94,  'nombre' => 'RECONOCIMIENTO Y BÚSQUEDA/AEROFOTOGRAFÍA CARTOGRÁFICA'],
            ['codigo' => 95,  'nombre' => 'RECONOCIMIENTO Y BÚSQUEDA/BÚSQUEDA Y RESCATE'],
            ['codigo' => 100,  'nombre' => 'GUERRA ELECTRÓNICA/SOPORTE ELECTRÓNICO'],
            ['codigo' => 101,  'nombre' => 'GUERRA ELECTRÓNICA/ATAQUE ELECTRÓNICO'],
            ['codigo' => 102,  'nombre' => 'GUERRA ELECTRÓNICA/PROTECCIÓN ELECTRÓNICA'],
            ['codigo' => 110,  'nombre' => 'SARC (UAV/SANT)/SOPORTE ELECTRÓNICO'],
            ['codigo' => 111,  'nombre' => 'SARC (UAV/SANT)/RECONOCIMIENTO METEOROLÓGICO'],
            ['codigo' => 112,  'nombre' => 'SARC (UAV/SANT)/RECONOCIMIENTO TELEMÉTRICO'],
            ['codigo' => 113,  'nombre' => 'SARC (UAV/SANT)/LANZAMIENTO DE BOMBAS AIRE – TIERRA'],
            ['codigo' => 114,  'nombre' => 'SARC (UAV/SANT)/LANZAMIENTO DE COHETES AIRE – TIERRA'],
            ['codigo' => 115,  'nombre' => 'SARC (UAV/SANT)/LANZAMIENTO DE MISILES AIRE – TIERRA'],
            ['codigo' => 116,  'nombre' => 'SARC (UAV/SANT)/LANZAMIENTO DE MISILES AIRE – AIRE'],
            ['codigo' => 120,  'nombre' => 'OPERACIONES AERONAVALES/LANZAMIENTO Y RECUPERACIÓN DE BUZOS'],
            ['codigo' => 121,  'nombre' => 'OPERACIONES AERONAVALES/MINADO AÉREO'],
            ['codigo' => 122,  'nombre' => 'OPERACIONES AERONAVALES/ANTI MINADO AÉREO'],
            ['codigo' => 123,  'nombre' => 'OPERACIONES AERONAVALES/ANTISUBMARINO'],
            ['codigo' => 130,  'nombre' => 'DEMOSTRACIONES AÉREAS/DESFILE AÉREO'],
            ['codigo' => 140,  'nombre' => 'ABASTECIMIENTO DE COMBUSTIBLE/REABASTECIMIENTO AÉREO'],
            ['codigo' => 141,  'nombre' => 'ABASTECIMIENTO DE COMBUSTIBLE/REABASTECIMIENTO VERTICAL DE COMBUSTIBLE (HELICÓPTERO) (OPERACIONES AERONAVALES)'],

        ];

        foreach ($codigoTipoMision as $item) {
            CodigoTipoMision::create($item);
        }

        $codigoTipoMisionSiglas = [
            ['siglas' => 'C',  'nombre' => 'COMBATE REAL'],
            ['siglas' => 'AC', 'nombre' => 'APOYO DE COMBATE'],
            ['siglas' => 'O',  'nombre' => 'OPERACIONALES' ],
            ['siglas' => 'E',  'nombre' => 'ENTRENAMIENTO' ],
            ['siglas' => 'I',  'nombre' => 'INSTRUCCIÓN' ],
            ['siglas' => 'Y',  'nombre' => 'VUELO DE CHEQUEO FUNCIONAL/PRUEBA/FERRY' ],
            ['siglas' => 'S',  'nombre' => 'ESPECIALES' ],
        ];

        foreach ($codigoTipoMisionSiglas as $item) {
            CodigoTipoMisionSiglas::create($item);
        }

        $codigoDespegue = [
            ['tipo_despegue' => 'NORMAL',                                                                                                        'codigo' => 'L'],
            ['tipo_despegue' => 'CON SALIDA INSTRUMENTAL',                                                                                       'codigo' => 'A'],
            ['tipo_despegue' => 'DESPEGUE DESDE ÁREAS CONFINADAS Y MONTAÑA ACM (SÓLO HELICÓPTERO)',                                              'codigo' => 'C'],
            ['tipo_despegue' => 'DESPEGUE DESDE BUQUES O PLATAFORMAS OCEÁNICAS, MARINAS, LACUSTRES O FLUVIALES (ANAVIAJE) (SÓLO HELICÓPTERO)',   'codigo' => 'H'],
            ['tipo_despegue' => 'DESDE SUPERFICIES ACUÁTICAS (HIDROAVIÓN / AVIÓN ANFIBIO / HELICÓPTERO)',                                        'codigo' => 'I'],
            ['tipo_despegue' => 'DESDE PISTAS NO PREPARADAS',                                                                                    'codigo' => 'J'],
            ['tipo_despegue' => 'DESDE PUNTOS DE RECOBRE OPERACIONAL (PRO) TIPO 4',                                                              'codigo' => 'K'],
            ['tipo_despegue' => 'DESDE PUNTOS DE RECOBRE OPERACIONAL (PRO) TIPO 5',                                                              'codigo' => 'M'],
            ['tipo_despegue' => 'DESDE PUNTOS DE RECOBRE OPERACIONAL (PRO) TIPO 6 (SÓLO HELICÓPTERO)',                                           'codigo' => 'N'],
            ['tipo_despegue' => 'DESDE PUNTOS DE RECOBRE OPERACIONAL (PRO) TIPO 7',                                                              'codigo' => 'O'],
        ];

        foreach ($codigoDespegue as $item) {
            CodigoDespegue::create($item);
        }

        $codigoAterrizaje = [
            ['tipo_aterrizaje' => 'NORMAL',                                                                                             'codigo' => 'L'],
            ['tipo_aterrizaje' => 'EN VUELO INSTRUMENTAL CON APROXIMACIÓN DE PRECISIÓN',                                                'codigo' => 'A'],
            ['tipo_aterrizaje' => 'EN VUELO INSTRUMENTAL CON APROXIMACIÓN DE NO PRECISIÓN',                                             'codigo' => 'B'],
            ['tipo_aterrizaje' => 'EN ÁREAS CONFINADAS Y MONTAÑA ACM (SÓLO HELICÓPTEROS)',                                              'codigo' => 'C'],
            ['tipo_aterrizaje' => 'EN BUQUES O PLATAFORMAS OCEÁNICAS, MARINAS, LACUSTRES O FLUVIALES (ANAVIAJE) (SÓLO HELICÓPTEROS)',   'codigo' => 'H'],
            ['tipo_aterrizaje' => 'EN SUPERFICIES ACUÁTICAS (HIDROAVIÓN / AVIÓN ANFIBIO / HELICÓPTERO)',                                'codigo' => 'I'],
            ['tipo_aterrizaje' => 'EN PISTAS NO PREPARADAS',                                                                            'codigo' => 'J'],
            ['tipo_aterrizaje' => 'EN PUNTOS DE RECOBRE OPERACIONAL (PRO) TIPO 4',                                                      'codigo' => 'K'],
            ['tipo_aterrizaje' => 'EN PUNTOS DE RECOBRE OPERACIONAL (PRO) TIPO 5',                                                      'codigo' => 'M'],
            ['tipo_aterrizaje' => 'EN PUNTOS DE RECOBRE OPERACIONAL (PRO) TIPO 6 (SÓLO HELICÓPTERO)',                                   'codigo' => 'N'],
            ['tipo_aterrizaje' => 'EN PUNTOS DE RECOBRE OPERACIONAL (PRO) TIPO 7',                                                      'codigo' => 'O'],
            
        ];

        foreach ($codigoAterrizaje as $item) {
            CodigoAterrizaje::create($item);
        }

        $codigoSensores = [
            ['sensores' => 'RADAR ABORDO ACTIVO MULTIFUNCIÓN',                              'codigo' => 'RDR'],
            ['sensores' => 'RADAR ABORDO ACTIVO MULTIFUNCIÓN DE APERTURA SINTÉTICA',        'codigo' => 'RDRS'],
            ['sensores' => 'RADAR ABORDO PASIVO (SIGINT)',                                  'codigo' => 'RDRP'],
            ['sensores' => 'BUSCADOR INFRARROJO FRONTAL (FLIR) O DE CUALQUIER OTRO TIPO',   'codigo' => 'FLIR'],
            ['sensores' => 'CÁMARA FOTOGRÁFICA',                                            'codigo' => 'CAMF'],
            ['sensores' => 'CÁMARA DE VIDEO',                                               'codigo' => 'CAMV'],
        ];

        foreach ($codigoSensores as $item) {
            CodigoSensores::create($item);
        }

        $consumibles = [
            ['consumible' => 'JET-A1',                                  'tipo' => 'COMBUSTIBLE'],
            ['consumible' => 'OXÍGENO',                                 'tipo' => 'COMBUSTIBLE'],
            ['consumible' => 'NITRÓGENO',                               'tipo' => 'COMBUSTIBLE'],
            ['consumible' => 'CRIOGENICO',                              'tipo' => 'COMBUSTIBLE'],
            ['consumible' => 'AV-GAS',                                  'tipo' => 'COMBUSTIBLE'],
            ['consumible' => 'HIDRAÚLICO/MIL-H-5606',                   'tipo' => 'ACEITE'],
            ['consumible' => 'HIDRAÚLICO/MIL-L-23699',                  'tipo' => 'ACEITE'],
            ['consumible' => 'HIDRAÚLICO/ H-83282',                     'tipo' => 'ACEITE'],
            ['consumible' => 'TURBONICOYL 306',                         'tipo' => 'ACEITE'],
            ['consumible' => 'ACEITE DE MOTOR/MIL-L 7808',              'tipo' => 'ACEITE'],
            ['consumible' => 'HIDRAULICO 90',                           'tipo' => 'ACEITE'],
            ['consumible' => 'ACEITE 28',                               'tipo' => 'ACEITE'],
            ['consumible' => 'ACEITE TURBONYCOIL 600',                  'tipo' => 'ACEITE'],
            ['consumible' => 'ACEITE W15-50  / ACEITE  W-100',          'tipo' => 'ACEITE'],
            ['consumible' => 'GRASA N°5',                               'tipo' => 'ACEITE'],
            ['consumible' => 'GREASE AEROSHELL 22 (MIL-PRF-81322G)',    'tipo' => 'ACEITE'],
            ['consumible' => 'OIL ENGINE (MIL-PRF-236999)',             'tipo' => 'ACEITE'],
            ['consumible' => 'OIL SILICONE (SF96-20)',                  'tipo' => 'ACEITE'],
            ['consumible' => 'MOBIL1 75W90 (MOBIL1 LS 75W-90)',         'tipo' => 'ACEITE'],
            ['consumible' => 'hidráulicoMIL- H5606',                    'tipo' => 'ACEITE'],
            ['consumible' => 'hidráulicoMIL- H5607',                    'tipo' => 'ACEITE'],
            ['consumible' => 'hidráulicoMIL- H5608',                    'tipo' => 'ACEITE'],
            ['consumible' => 'hidráulicoMIL- H5609',                    'tipo' => 'ACEITE'],
            ['consumible' => 'hidráulicoMIL- H5610',                    'tipo' => 'ACEITE'],
            ['consumible' => 'hidráulicoMIL- H5611',                    'tipo' => 'ACEITE'],
            ['consumible' => 'hidráulicoMIL- H5612',                    'tipo' => 'ACEITE'],
            ['consumible' => 'hidráulicoMIL- H5613',                    'tipo' => 'ACEITE'],
            ['consumible' => 'hidráulicoMIL- H5614',                    'tipo' => 'ACEITE'],
            ['consumible' => 'hidráulicoMIL- H5615',                    'tipo' => 'ACEITE'],
            ['consumible' => 'hidráulicoMIL- H5616',                    'tipo' => 'ACEITE'],
            ['consumible' => 'hidráulicoMIL- H5617',                    'tipo' => 'ACEITE'],
            ['consumible' => 'hidráulicoMIL- H5618',                    'tipo' => 'ACEITE'],
            ['consumible' => 'ACEITE TURBONYCOIL-321',                  'tipo' => 'ACEITE'],
            ['consumible' => 'ACEITE TURBONYCOIL-322',                  'tipo' => 'ACEITE'],
            ['consumible' => 'ACEITE TURBONYCOIL-323',                  'tipo' => 'ACEITE'],
            ['consumible' => 'ACEITE TURBONYCOIL-324',                  'tipo' => 'ACEITE'],
            ['consumible' => 'ACEITE TURBONYCOIL-325',                  'tipo' => 'ACEITE'],
            ['consumible' => 'ACEITE TURBONYCOIL-326',                  'tipo' => 'ACEITE'],
            ['consumible' => 'ACEITE TURBONYCOIL-327',                  'tipo' => 'ACEITE'],
            ['consumible' => 'ACEITE TURBONYCOIL-328',                  'tipo' => 'ACEITE'],
            ['consumible' => 'ACEITE TURBONYCOIL-329',                  'tipo' => 'ACEITE'],
            ['consumible' => 'ACEITE TURBONYCOIL-330',                  'tipo' => 'ACEITE'],
            ['consumible' => 'ACEITE TURBONYCOIL-331',                  'tipo' => 'ACEITE'],
            ['consumible' => 'ACEITE TURBONYCOIL-332',                  'tipo' => 'ACEITE'],
            ['consumible' => 'ACEITEW100',                              'tipo' => 'ACEITE'],
            ['consumible' => 'HYDRAUNICOIL FH51',                       'tipo' => 'ACEITE'],
            ['consumible' => 'HYDRAUNICOIL FH52',                       'tipo' => 'ACEITE'],
            ['consumible' => 'HYDRAUNICOIL FH53',                       'tipo' => 'ACEITE'],
            ['consumible' => 'HYDRAUNICOIL FH54',                       'tipo' => 'ACEITE'],
            ['consumible' => 'HYDRAUNICOIL FH55',                       'tipo' => 'ACEITE'],
            ['consumible' => 'HYDRAUNICOIL FH56',                       'tipo' => 'ACEITE'],
            ['consumible' => 'ACEITE AMG-10 RUSO',                      'tipo' => 'ACEITE'],
            ['consumible' => 'SHATIN-201',                              'tipo' => 'ACEITE'],
            ['consumible' => 'SHATIN-202',                              'tipo' => 'ACEITE'],
            ['consumible' => 'SHATIN-203',                              'tipo' => 'ACEITE'],
            ['consumible' => 'SHATIN-204',                              'tipo' => 'ACEITE'],
            ['consumible' => 'SHATIN-205',                              'tipo' => 'ACEITE'],
            ['consumible' => 'SHATIN-206',                              'tipo' => 'ACEITE'],
            ['consumible' => 'AEROSELL W-100',                          'tipo' => 'ACEITE'],
            ['consumible' => 'AEROSELL W-101',                          'tipo' => 'ACEITE'],
            ['consumible' => 'AEROSELL W-102',                          'tipo' => 'ACEITE'],
            ['consumible' => 'AEROSELL W-103',                          'tipo' => 'ACEITE'],
            ['consumible' => 'AEROSELL W-104',                          'tipo' => 'ACEITE'],
            ['consumible' => 'AEROSELL W-105',                          'tipo' => 'ACEITE'],
            ['consumible' => 'SHELL 54 AX 80W-90',                      'tipo' => 'ACEITE'],
            ['consumible' => 'SHELL 54 AX 80W-91',                      'tipo' => 'ACEITE'],
            ['consumible' => 'SHELL 54 AX 80W-92',                      'tipo' => 'ACEITE'],
            ['consumible' => 'SHELL 54 AX 80W-93',                      'tipo' => 'ACEITE'],
            ['consumible' => 'SHELL 54 AX 80W-94',                      'tipo' => 'ACEITE'],
            ['consumible' => 'SHELL 54 AX 80W-95',                      'tipo' => 'ACEITE'],
            ['consumible' => 'MOBIL JET OIL II',                        'tipo' => 'ACEITE'],
            ['consumible' => 'ACEITE/MIL-L-33699B',                     'tipo' => 'ACEITE'],        
            
        ];

        foreach ($consumibles as $item) {
            UnidadesConsumible::create($item);
        }

        $unidades_medida = [
            ['unidad' => 'LTS'],
            ['unidad' => 'LBS'],
            ['unidad' => 'GAL'],
            ['unidad' => 'US'],
            ['unidad' => 'LPS'],
            ['unidad' => 'OTRO'],
        ];

        foreach ($unidades_medida as $item) {
            UnidadesMedidas::create($item);
        }


    }
}
