/*Grupo Poblacional*/
IF OBJECT_ID('GPO','U') IS NOT NULL DROP TABLE GPO
GO
CREATE TABLE [dbo].[GPO](
	[GrupoId] [varchar](2) NOT NULL,
	[DescripcionGrupo] [varchar](100) NOT NULL,
	[LargoGrupo] [int] NOT NULL,
	[TipoDatoGrupo] [varchar](10) NOT NULL,
)
GO
ALTER TABLE [dbo].[GPO] ADD CONSTRAINT [GrupoId] PRIMARY KEY CLUSTERED ([GrupoId] ASC)

