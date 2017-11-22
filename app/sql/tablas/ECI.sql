/*Estado Civil*/
IF OBJECT_ID('ECI','U') IS NOT NULL DROP TABLE ECI
GO
CREATE TABLE [dbo].[ECI](
	[EstadoId] [varchar](2) NOT NULL,
	[DescripcionEstado] [varchar](15) NOT NULL,
	[LargoEstado] [int] NOT NULL,
	[TipoDato] [varchar](10) NOT NULL,
)
GO
ALTER TABLE [dbo].[ECI] ADD CONSTRAINT [ECIEstadoId] PRIMARY KEY CLUSTERED ([EstadoId] ASC)



