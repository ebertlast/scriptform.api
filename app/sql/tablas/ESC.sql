/*Escolaridad*/
IF OBJECT_ID('ESC','U') IS NOT NULL DROP TABLE ESC
GO
CREATE TABLE [dbo].[ESC](
	[TipoEscolaridadId] [varchar](20) NOT NULL,
	[DescripcionTipoEscolaridad] [varchar](20) NOT NULL,
	[LargoTipoEscolaridad] [int] NOT NULL,
	[TipoDatoTipoEscolaridad] [varchar](10) NOT NULL,
)
GO
ALTER TABLE [dbo].[ESC] ADD CONSTRAINT [ESCTipoEscolaridadId] PRIMARY KEY CLUSTERED ([TipoEscolaridadId] ASC)


