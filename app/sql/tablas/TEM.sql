/*Tipo de Empresa*/
IF OBJECT_ID('TEM','U') IS NOT NULL DROP TABLE TEM
GO
CREATE TABLE [dbo].[TEM](
	[TipoEmpresaID] [varchar](2) NOT NULL,
	[DescripcionTipoEmpresa] [varchar](30) NOT NULL,
)
GO
ALTER TABLE [dbo].[TEM] ADD CONSTRAINT [TEMTipoEmpresaID] PRIMARY KEY CLUSTERED ([TipoEmpresaID] ASC)
GO

