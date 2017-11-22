/*Tipo de Relación*/
IF OBJECT_ID('TIPR','U') IS NOT NULL DROP TABLE TIPR
GO
CREATE TABLE [dbo].[TIPR](
	[TipoRelacionID] [int] NOT NULL,
	[DescripcionTipoRelacion] [varchar](50) NOT NULL,
	[LargoTipoRelacion] [int] NOT NULL,
	[TipoDatoTipoRelacion] [varchar](10) NOT NULL,
)
GO
ALTER TABLE [dbo].[TIPR] ADD CONSTRAINT [TIPRTipoRelacionID] PRIMARY KEY CLUSTERED ([TipoRelacionID] ASC)
GO

