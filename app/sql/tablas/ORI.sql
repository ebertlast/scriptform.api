/*Origen*/
IF OBJECT_ID('ORI','U') IS NOT NULL DROP TABLE ORI
GO
CREATE TABLE [dbo].[ORI](
	[TipoOrigenId] [varchar](20) NOT NULL,
	[DescripcionTipoOrigen] [varchar](80) NOT NULL,
	[LargoTipoOrigen] [int] NOT NULL,
	[TipoDatoTipoOrigen] [varchar](10) NOT NULL,
)
GO
ALTER TABLE [dbo].[ORI] ADD CONSTRAINT [ORITipoOrigenId] PRIMARY KEY CLUSTERED ([TipoOrigenId] ASC)
GO


