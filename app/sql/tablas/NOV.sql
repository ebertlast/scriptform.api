/*Novedades*/
IF OBJECT_ID('NOV','U') IS NOT NULL DROP TABLE NOV
GO
CREATE TABLE [dbo].[NOV](
	[NovedadID] [varchar](9) NOT NULL,
	[DescripcionNovedad] [varchar](100) NOT NULL,
	[Afiliacion] [bit] NOT NULL,
	[NovedadContrato] [bit] NOT NULL,
	[NovedadGenerales] [bit] NOT NULL,
	[NovedadEmpleador] [bit] NOT NULL,
	[NovedadEstado] [bit] NOT NULL,
)
GO
ALTER TABLE [dbo].[NOV] ADD CONSTRAINT [NOVNovedadID] PRIMARY KEY CLUSTERED ([NovedadID] ASC)
GO
ALTER TABLE [dbo].[NOV] ADD  DEFAULT ((1)) FOR [NovedadEstado]
GO


