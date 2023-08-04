-- total de ciertos egresos
SELECT c.id_config, c.nombre, sum(descuento) as descuento FROM public.nom_rol_pagod d inner join public.nom_config_regimen r on r.id_config_reg = d.id_config inner join public.nom_config c on c.id_config = r.id_config WHERE anio = 2022 and c.id_config in (4,31,28,13,14) AND d.id_rol in (18) GROUP BY c.id_config,c.nombre

-- ver anticipos por cedula
SELECT * FROM public.co_anticipo WHERE anio = 2023 and idprov in ('1723274740','2300046568','1717610131','1717124661','2350079816') and estado='contabilizado' ORDER BY id_anticipo ASC



-- crear descuento

INSERT INTO nom_rol_pagod values (26,77602,114,1286,0,912.50,'2360003540001',2023,'07',2478,5,24,'NOMBRAMIENTOS LOSEP', '2021-04-01','1717124661',30,null, 288.69,'N',131,null)

INSERT INTO nom_rol_pagod values (26,77604,114,1360,0,152.22,'2360003540001',2023,'07',585,133,18,'NOMBRAMIENTOS LOSEP', '2018-04-09','2350079816',30,null, 68.15,'N',223,null)

INSERT INTO nom_rol_pagod values (26,77605,114,1360,0,77.78,'2360003540001',2023,'07',585,134,18,'NOMBRAMIENTOS LOSEP', '2018-04-09','1723274740',30,null, 68.15,'N',223,null)

INSERT INTO nom_rol_pagod values (26,77606,114,1360,0,200,'2360003540001',2023,'07',622,143,19,'NOMBRAMIENTOS LOSEP', '2015-01-07','1717610131',30,null, 72.46,'N',223,null)