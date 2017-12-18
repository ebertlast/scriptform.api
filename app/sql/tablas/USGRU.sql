/*Maestro de Procedimientos*/
IF OBJECT_ID('USGRU','U') IS NOT NULL DROP TABLE USGRU
GO
CREATE TABLE [dbo].[USGRU](
	[GrupoID] [varchar](30) NOT NULL,
	[DescripcionGrupo] [varchar](200) NOT NULL
)
GO
ALTER TABLE [dbo].[USGRU] ADD CONSTRAINT [USGRUGrupoID] PRIMARY KEY CLUSTERED ([GrupoID] ASC)
