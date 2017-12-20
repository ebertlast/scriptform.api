/*Usuarios del sistema*/
IF OBJECT_ID('USU','U') IS NOT NULL DROP TABLE USU
GO
CREATE TABLE USU(
	USUARIOID VARCHAR(100) NOT NULL
	,CLAVE VARBINARY(8000) NOT NULL
	,NOMBRE VARCHAR(100) NOT NULL
	,GRUPOID VARCHAR(30) NOT NULL
	,ACTIVO SMALLINT DEFAULT 0
	,EMAIL VARCHAR(100) NOT NULL
	,SEDEID VARCHAR(100) NOT NULL
)
GO
ALTER TABLE USU ADD CONSTRAINT USUUSUARIOIDSEDEID PRIMARY KEY CLUSTERED (USUARIOID,SEDEID)
GO
--ALTER TABLE USU ADD CONSTRAINT USUGRUPOID_USGUHGRUPOID FOREIGN KEY (GRUPOID) REFERENCES USGRU(GrupoId)
--GO
ALTER TABLE USU ADD CONSTRAINT USUSEDEID_SEDSEDEID FOREIGN KEY (SEDEID) REFERENCES SED(SEDEID)

