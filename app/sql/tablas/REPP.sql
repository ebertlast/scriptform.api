/*Parametros de Reportes*/
IF OBJECT_ID('REPP','U') IS NOT NULL DROP TABLE REPP
GO
CREATE TABLE REPP(
	PARAMETROID BIGINT NOT NULL IDENTITY(1,1)
	,NOMBRE VARCHAR(100) NOT NULL
	,TIPO VARCHAR(20) NOT NULL DEFAULT 'Alfanumerico'
	,VALOR VARCHAR(MAX) DEFAULT NULL
	,UTILIZAQUERY SMALLINT DEFAULT 0
	,QUERY VARCHAR(MAX) DEFAULT NULL
	,REPORTEID BIGINT NOT NULL
)
GO
ALTER TABLE REPP ADD CONSTRAINT REPPPARAMETROID PRIMARY KEY CLUSTERED (PARAMETROID ASC)
GO
ALTER TABLE REPP ADD CONSTRAINT REPPREPORTEID_REPREPORTEID FOREIGN KEY (REPORTEID) REFERENCES REP(REPORTEID)
