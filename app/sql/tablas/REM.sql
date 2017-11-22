/*Regimen Empleador*/
IF OBJECT_ID('REM','U') IS NOT NULL DROP TABLE REM
GO
CREATE TABLE [dbo].[REM](
	[RegimeEmpresaID] [varchar](2) NOT NULL,
	[DescripcionRegimenEmpresa] [varchar](15) NOT NULL,
)
GO
ALTER TABLE [dbo].[REM] ADD CONSTRAINT [REMRegimeEmpresaID] PRIMARY KEY CLUSTERED ([RegimeEmpresaID] ASC)


