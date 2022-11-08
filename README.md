# siamb
Sistema Integral de la Aviación Militar Bolivariana

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

SIAMB V.1.0
## Install
- composer install
- php artisan key:generate
- php artisan migrate --seed

## Exportacion de Datos desde las BD anteriores
1. BD SIREH: Ejecutar las siguientes SQL's y el resultado ejecutarlos como sentencias "INSERT" a la BD SIAMB:
* La tabla empleados:
```
SELECT codigo_empleado, cedula, nombre1, nombre2, apellido1, apellido2, situacion, 
    CASE WHEN fecha_nacim ='0000-00-00' THEN NULL ELSE fecha_nacim END AS fecha_nacim,
	sexo, edo_civil, telefono, nivel_instruccion, estudia, profesion, nacionalidad,
	direccion, ciudad, estado, cod_postal, peso, talla_pant, talla_chaqueta, talla_camisa, 
    talla_falda, numero_calzado, zur_der_amb, act_culturales, cta_ahorro_hab, otro_telefono,
	estatura, color, cabellos, ojos, grupo_sanguineo, cara, frente, cejas, nariz, boca,
	labios, barba, contextura, religion, correo, telefono_cel, telefono_ofi, persona_contacto,
	talla_gorra, ubicacion_admpub, discapacidad, tipo_discapacidad, alergias	
  FROM empleados
```
* La tabla nomina:
```
SELECT `codigo_empleado`, `cedula` , `nombre1`, `nombre2`, `apellido1`, `apellido2`, `codigo_cia`,
	`codigo_ubicacion`, `codigo_cargo`, `cargo_real`, `tipo_emp`, `horas_diarias`, `tipo_ingreso`,
	CASE WHEN fecha_ingreso ='0000-00-00' THEN NULL ELSE fecha_ingreso END AS fecha_ingreso,
	`forma_pago`, `codigo_banco`, `tipo_cuenta`, `nro_cuenta`, `situacion`, `porcentaje_retencion_islr`,
	`sueldo`, `pool`, `apartado_intereses`, `apartado_prestaciones`, `supervisor`, `tiene_beca`, `monto_bono_salario`, 
    `justificacion`, `autorizado_por`, `porcentaje_ahorro`, `paga_sso`, `cargo_tabulador`, `unidad_horas_diarias`,
	CASE WHEN fecha_ingreso_anterior ='0000-00-00' THEN NULL ELSE fecha_ingreso_anterior END AS fecha_ingreso_anterior,
	`anos_servicio`, `mes_servicio`, `dias_servicio`, `anos_banco`, `mes_banco`, `dias_banco`,
	CASE WHEN fecha_disfrute ='0000-00-00' THEN NULL ELSE fecha_disfrute END AS fecha_disfrute, 
	`turno`, `tipo_refa`, `intereses_prestac`, `intereses_ahorros`, `montepio`,	`subsidio-empresarial` AS subsidio_empresarial,
	`pago_retroactivo`, `codigo_localidad`, `codigo_nomina`, `codigo_caja`, `codigo_sindicato`, `codigo_pptrio`,
	CASE WHEN fecha_ingreso_caja ='0000-00-00' THEN NULL ELSE fecha_ingreso_caja END AS fecha_ingreso_caja, 
	CASE WHEN fecha_egreso_caja ='0000-00-00' THEN NULL ELSE fecha_egreso_caja END AS fecha_egreso_caja,
	`codigo-programa` AS codigo_programa, `ano_alterno`, `mes_alterno`,	`dia_alterno`,
	CASE WHEN fecha_ingreso_adm ='0000-00-00' THEN NULL ELSE fecha_ingreso_adm END AS fecha_ingreso_adm,
	`nuevo_sueldo`, `nueva_compensacion`, `certificado_carrera`,
	CASE WHEN fecha_solic_certif ='0000-00-00' THEN NULL ELSE fecha_solic_certif END AS fecha_solic_certif,
	`grado_militar`, `cambio-dollar` AS cambio_dollar, `sin_desc_alimentacion`, `cod_clasifaereo`,
	`cod_rac`, `cod_ubicacion_detallada`, `nro_resolucion_cargo`, `nro_resolucion_ubicacion`,
	CASE WHEN fecha_inic_cargo ='0000-00-00' THEN NULL ELSE fecha_inic_cargo END AS fecha_inic_cargo,
	CASE WHEN fecha_inic_ubicacion ='0000-00-00' THEN NULL ELSE fecha_inic_ubicacion END AS fecha_inic_ubicacion,
	`observacion_cargo`,
	CASE WHEN fecha_reincorporacion ='0000-00-00' THEN NULL ELSE fecha_reincorporacion END AS fecha_reincorporacion,
	`codigo_reincorporacion`, `grado_tentativo`, `codigo_clase`, `categoria_clas`, `nivel_escala`, `codigo_clase1`,
	`observaciones`
FROM nomina
```
2. Con el manejador de Bases de Datos, exportar directamente desde la BD SIREH, las siguientes tablas:
- datos_militares
- conceptos_pagados
- familiares

3. Con el manejador de Bases de Datos, exportar directamente desde la BD SEID, las siguientes tablas:
- intelectuales
- paf
- datos_boleta

4. Con el manejador de Bases de Datos, exportar directamente desde la BD EDUCACION, las siguientes tablas:
- estudios_realizados
- cursos_realizados

5. Actualmente las siguientes tablas se alimentan por ejecucion Insert/Seeder, cuando se establezca el proyecto SIAMB en Producción se deben Exportar con el manejador de Bases de Datos directamente desde la BD SIREH:
- ubicaciones 
- cargos
- ubicaciones_detalladas



