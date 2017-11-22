/*Tipo Cotizante*/
IF OBJECT_ID('TIPC','U') IS NOT NULL DROP TABLE TIPC
GO
CREATE TABLE [dbo].[TIPC](
	[TipoCotizanteId] [varchar](20) NOT NULL,
	[DescripcionTipoCotizante] [varchar](80) NOT NULL,
	[LargoTipoCotizante] [int] NOT NULL,
	[TipoDatoTipoCotizante] [varchar](10) NOT NULL,
	[TipoCotizanteIdNuevo] [varchar](8) NULL,
)
GO
ALTER TABLE [dbo].[TIPC] ADD CONSTRAINT [TIPCTipoCotizanteId] PRIMARY KEY CLUSTERED ([TipoCotizanteId] ASC)
GO


