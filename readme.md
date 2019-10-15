Consuta para inicializar saldos de depositos


REPLACE into saldos (select productos_id,depositos_id,sum(cantidad) from vista_movimientos group by productos_id,depositos_id)