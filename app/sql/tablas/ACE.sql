/*Actividades Económicas*/
IF OBJECT_ID('ACE','U') IS NOT NULL DROP TABLE ACE
GO
CREATE TABLE [dbo].[ACE](
	[ActividadEconomicaId] [varchar](20) NOT NULL,
	[DescripcionActividadEconomica] [varchar](255) NOT NULL,
	[LargoActividadEconomica] [int] NOT NULL,
	[TipoDatoActividadEconomica] [varchar](10) NOT NULL,
	[PorcentajeActividadEconomica] [decimal](3, 2) NOT NULL,
) 
GO
ALTER TABLE ACE ADD CONSTRAINT ACEActividadEconomicaId PRIMARY KEY CLUSTERED (ActividadEconomicaId ASC)



