/*Causal de Ingresos*/
IF OBJECT_ID('CAU','U') IS NOT NULL DROP TABLE CAU
GO
CREATE TABLE [dbo].[CAU](
	[TipoIngresoId] [varchar](2) NOT NULL,
	[DescripcionTipoIngreso] [varchar](50) NOT NULL,
	[LargoTipoIngreso] [int] NOT NULL,
	[TipoDatoTipoIngreso] [varchar](10) NOT NULL,
)
GO
ALTER TABLE [dbo].[CAU] ADD CONSTRAINT [CAUTipoIngresoId] PRIMARY KEY CLUSTERED ([TipoIngresoId] ASC)


