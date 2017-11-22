/*Municipios*/
IF OBJECT_ID('MUN','U') IS NOT NULL DROP TABLE MUN
GO
CREATE TABLE [dbo].[MUN](
	[MunicipioID] [varchar](10) NOT NULL,
	[DescripcionMunicipio] [varchar](30) NOT NULL,
	[DepartamentoID] [varchar](2) NOT NULL,
	[CodigoMunicipio] [varchar](3) NOT NULL,
)
GO
ALTER TABLE [dbo].[MUN] ADD CONSTRAINT [MUNMunicipioID] PRIMARY KEY CLUSTERED ([MunicipioID] ASC)

