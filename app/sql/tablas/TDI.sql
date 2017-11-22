/*Tipo de Discapacidad*/
IF OBJECT_ID('TDI','U') IS NOT NULL DROP TABLE TDI
GO

CREATE TABLE [dbo].[TDI](
	[TipoDiscapacidadId] [varchar](2) NOT NULL,
	[DescripcionTipoDiscapacidad] [varchar](15) NOT NULL,
	[LargoTipoDiscapacidad] [int] NOT NULL,
	[TipoDatoTipoDiscapacidad] [varchar](10) NOT NULL,
)
GO
ALTER TABLE [dbo].[TDI] ADD CONSTRAINT [TDITipoDiscapacidadId] PRIMARY KEY CLUSTERED ([TipoDiscapacidadId] ASC)
GO


