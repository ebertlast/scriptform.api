/*Asesor*/
IF OBJECT_ID('ASE','U') IS NOT NULL DROP TABLE ASE
GO
CREATE TABLE [dbo].[ASE](
	[AsesorID] [varchar](15) NOT NULL,
	[NombreAsesor] [varchar](1000) NOT NULL,
	[AsesorIDAlterno] [varchar](15) NOT NULL,
	[NombreAsesorAlterno] [varchar](1000) NOT NULL,
	[AsesorEstado] [bit] NOT NULL,
) 
GO
ALTER TABLE [dbo].[ASE] ADD CONSTRAINT [ASEAsesorID] PRIMARY KEY CLUSTERED ([AsesorID] ASC)
GO
ALTER TABLE [dbo].[ASE] ADD  DEFAULT ((1)) FOR [AsesorEstado]
GO


