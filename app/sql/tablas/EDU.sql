/*Entidad Educativa*/
IF OBJECT_ID('EDU','U') IS NOT NULL DROP TABLE EDU
GO

CREATE TABLE [dbo].[EDU](
	[TipoEntidadId] [varchar](20) NOT NULL,
	[DescripcionTipoEntidad] [varchar](80) NOT NULL,
	[LargoTipoEntidad] [int] NOT NULL,
	[TipoDatoTipoEntidad] [varchar](10) NOT NULL,
)
GO
ALTER TABLE [dbo].[EDU] ADD CONSTRAINT [EDUTipoEntidadId] PRIMARY KEY CLUSTERED ([TipoEntidadId] ASC)


