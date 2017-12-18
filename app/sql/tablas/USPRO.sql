/*Maestro de Procedimientos*/
IF OBJECT_ID('USPRO','U') IS NOT NULL DROP TABLE USPRO
GO
CREATE TABLE [dbo].[USPRO](
	[ProcedimientoID] [varchar](30) NOT NULL,
	[DescripcionProcedimiento] [varchar](200) NOT NULL
)
GO
ALTER TABLE [dbo].[USPRO] ADD CONSTRAINT [USPROProcedimientoID] PRIMARY KEY CLUSTERED ([ProcedimientoID] ASC)
