/*Cargos*/
IF OBJECT_ID('CAR','U') IS NOT NULL DROP TABLE CAR
GO
CREATE TABLE [dbo].[CAR](
	[TipoCargoId] [varchar](20) NOT NULL,
	[DescripcionTipoCargo] [varchar](80) NOT NULL,
	[LargoTipoCargo] [int] NOT NULL,
	[TipoDatoTipoCargo] [varchar](10) NOT NULL,
)
GO
ALTER TABLE [dbo].[CAR] ADD CONSTRAINT [CARTipoCargoId] PRIMARY KEY CLUSTERED ([TipoCargoId] ASC)


