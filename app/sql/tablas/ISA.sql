/*Instituciones de Salud*/
IF OBJECT_ID('ISA','U') IS NOT NULL DROP TABLE ISA
GO
CREATE TABLE [dbo].[ISA](
	[InstitucionSaludId] [varchar](6) NOT NULL,
	[InstitucionSaludTipo] [varchar](5) NOT NULL,
	[InstitucionSaludIdentificacion] [numeric](10, 0) NOT NULL,
	[InstitucionSaludRazonSocial] [varchar](80) NOT NULL,
	[InstitucionSaludMunicipioID] [varchar](5) NOT NULL,
	[InstitucionMixta] [bit] NOT NULL,
	[InstitucionMedica] [bit] NOT NULL,
	[InstitucionOdontologia] [bit] NOT NULL,
	[InstitucionSaludEstado] [bit] NULL,
)
GO
ALTER TABLE [dbo].[ISA] 
ADD CONSTRAINT [ISAInstitucionSaludIdInstitucionSaludMunicipioIDInstitucionSaludTipo] 
PRIMARY KEY CLUSTERED ([InstitucionSaludId] ASC,
	[InstitucionSaludMunicipioID] ASC,
	[InstitucionSaludTipo] ASC)


