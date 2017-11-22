/*Género*/
IF OBJECT_ID('GEN','U') IS NOT NULL DROP TABLE GEN
GO
CREATE TABLE [dbo].[GEN](
	[GeneroID] [varchar](2) NOT NULL,
	[DescripcionGenero] [varchar](15) NOT NULL,
	[LargoGenero] [int] NOT NULL,
	[TipoDatoGenero] [varchar](10) NOT NULL,
)
GO
ALTER TABLE [dbo].[GEN] ADD CONSTRAINT [GENGeneroID] PRIMARY KEY CLUSTERED ([GeneroID] ASC)
GO