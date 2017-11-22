/*Sucursales*/
IF OBJECT_ID('SUC','U') IS NOT NULL DROP TABLE SUC
GO
CREATE TABLE [dbo].[SUC](
	[SucursalId] [varchar](20) NOT NULL,
	[DescripcionSucursal] [varchar](80) NOT NULL,
	[LargoSucursal] [int] NOT NULL,
	[TipoDatoSucursal] [varchar](10) NOT NULL,
)
GO
ALTER TABLE [dbo].[SUC] ADD CONSTRAINT [SUCSucursalId] PRIMARY KEY CLUSTERED ([SucursalId] ASC)
GO
