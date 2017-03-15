SELECT DISTINCT
    (rr.idruta),
    clientesProg,
    clientesvp,
    grupo,
    salida,
    llegada,
    CONCAT(FORMAT((rr.clientesvp / rr.clientesProg) * 100,
                1),
            '%') AS Efectividad_Visita,
    CONCAT(FORMAT((rr.clientescv / rr.clientesProg) * 100,
                1),
            '%') AS Efectividad_EntregaClientes,
    CONCAT(FORMAT((rr.cajasef / rr.cajaspfp) * 100,
                1),
            '%') AS Efectividad_EntregaCajas,
                IF(FORMAT((rr.clientesvp / rr.clientesProg) * 100,
            1) < 98,
        'rRojo',
        'rVerde') AS classEfectividadVisita,
    IF(FORMAT((rr.clientescv / rr.clientesProg) * 100,
            1) < 98,
        'rRojo',
        'rVerde') AS classEntregaClientes,
    IF(FORMAT((rr.cajasef / rr.cajaspfp) * 100,
            1) < 98,
        'rRojo',
        IF(FORMAT((rr.cajasef / rr.cajaspfp) * 100,
                1) < 100,
            'rVerde',
            'rAmarillo')) AS classEntregaCajas,
    (clientescv / clientesprog) AS EfectividadDeEntrega,
    salidaCedis,
    llegadaCedis,
    FORMAT(km, 1) AS KM_Teorico,
    FORMAT((odometrofin - odometroini),1) AS KM_Real,
    FORMAT((odometrofin - odometroini) - km,1) AS KM_Dif,
    (odometrofin - odometroini) - km AS Dif,
    CONCAT(FORMAT((((rr.odometrofin - rr.odometroini) / km) - 1) * 100,
                1),
           '%') AS desviacion,
                IF(FORMAT((((rr.odometrofin - rr.odometroini) / km) - 1) * 100,
            1) > 20,
        'rRojo',
        'rVerde') AS classDesviacion,
                CASE rr.tipoMercado
        WHEN 1 THEN '#E0FFFF'
        WHEN 2 THEN '#F0FFF0'
        WHEN 3 THEN '#FFFFE0'
        WHEN 5 THEN '#FFF5EE'
    END AS color,
    IF(TIME_TO_SEC(rr.salidaCedis) > TIME_TO_SEC(salida),
        'rRojo',
        'rVerde') AS classSalida,
    IF(TIME_TO_SEC(rr.llegadaCedis) > TIME_TO_SEC(llegada),
        'rRojo',
        'rVerde') AS classLlegada
FROM
    resumen_ruta rr
        LEFT JOIN
    (SELECT DISTINCT
        (ord.idruta), op.iddeposito, op.idoperacion, km, grupo,salida,llegada
    FROM
        orden ord
    INNER JOIN Operaciones op ON ord.idoperacion = op.idoperacion
    INNER JOIN ruta ru ON ru.iddeposito = op.iddeposito AND ru.idRuta = ord.idRuta
    INNER JOIN horariotablero ht ON ht.iddeposito = ru.iddeposito AND ht.idRuta = ru.idruta
    WHERE
        fecha = CURDATE()
            AND op.iddeposito = 281) a ON rr.idruta = a.idruta
        AND rr.iddeposito = a.iddeposito
WHERE
    rr.iddeposito = 281
        AND fechaOperacion = CURDATE()
        AND tiporuta = 6
