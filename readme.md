Consuta para inicializar saldos de depositos


DELETE FROM saldos;
REPLACE into saldos (select productos_id,depositos_id,sum(cantidad) from vista_movimientos group by productos_id,depositos_id);


Vista movimientos
CREATE
 ALGORITHM = UNDEFINED
 VIEW `vista_movimientos`
 AS SELECT m.*,d.nombre as nombre_deposito,d.nombre as deposito,l.productos_id,l.vencimiento as vencimiento,l.numero as lote FROM movimientos m,depositos d,lotes_mp l where d.id=m.depositos_id and m.lotes_mp_id=l.id union 
 SELECT m.*,d.nombre as nombre_deposito,d.nombre as deposito,l.productos_id,DATE_ADD(lp.fecha, INTERVAL 6 MONTH) as vencimiento,l.lotes_produccion_id as lote FROM movimientos m,depositos d,productos_lote_produccion l,lotes_produccion lp where d.id=m.depositos_id and m.productos_lote_produccion_id=l.id and l.lotes_produccion_id=lp.id