/*Grado de Discapacidad*/
IF OBJECT_ID('GDI','U') IS NOT NULL DROP TABLE GDI
GO
CREATE TABLE [dbo].[GDI](
	[GradoDiscapacidadId] [varchar](2) NOT NULL,
	[DescripcionGradoDiscapacidad] [varchar](15) NOT NULL,
	[LargoGradoDiscapacidad] [int] NOT NULL,
	[TipoDatoGradoDiscapacidad] [varchar](10) NOT NULL,
)
GO
ALTER TABLE [dbo].[GDI] ADD CONSTRAINT [GDIGradoDiscapacidadId] PRIMARY KEY CLUSTERED ([GradoDiscapacidadId] ASC)


