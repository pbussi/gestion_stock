Consuta para inicializar saldos de depositos

REPLACE into saldos (select productos_id,depositos_id,sum(cantidad) from movimientos,lotes_mp where movimientos.lotes_mp_id=lotes_mp.id group by productos_id,depositos_id)
