/*Grupos de usuarios del sistema*/
IF OBJECT_ID('GRU','U') IS NOT NULL DROP TABLE GRU
GO
CREATE TABLE GRU(
	GRUPOID VARCHAR(100) NOT NULL
	,DENOMINACION VARCHAR(100) NOT NULL
)
GO
ALTER TABLE GRU ADD CONSTRAINT [GRUGRUPOID] PRIMARY KEY CLUSTERED (GRUPOID ASC)