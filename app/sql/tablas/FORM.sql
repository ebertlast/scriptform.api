/*Registro de Formulario*/
IF OBJECT_ID('FORM','U') IS NOT NULL DROP TABLE FORM
GO
CREATE TABLE [dbo].[FORM](
	[FormularioID] [varchar](50) NOT NULL,
	[TipoTramite] [varchar](100),
	[TipoAfiliacion] [varchar](100),
	[Regimen] [varchar](100),
	[TipoAfiliado] [varchar](100),
	[TipoCotizante] [varchar](100),
	[PrimerApellido] [varchar](100),
	[SegundoApellido] [varchar](100),
	[PrimerNombre] [varchar](100),
	[SegundoNombre] [varchar](100),
	[TipoDocumentoIdentidad] [varchar](5),
	[DocumentoIdentidad] [varchar](20),
	[Sexo] [varchar](10),
	[FechaNacimiento] [varchar](10),
	[Etnia] [varchar](200),
	[TipoDiscapacidad] [varchar](100),
	[GradoDiscapacidad] [varchar](100),
	[PuntajeSISBEN] [varchar](100),
	[GrupoPoblacionalEspecial] [varchar](100),
	[ARL] [varchar](200),
	[AP] [varchar](200),
	[IBC] [varchar](200),
	[Direccion] [varchar](100),
	[TelefonoFijo] [varchar](15),
	[TelefonoCelular] [varchar](15),
	[CorreoElectronico] [varchar](100),
	[Zona] [varchar](100),
	[Municipio] [varchar](100),
	[Localidad] [varchar](100),
	[Conyugue] [varchar](100),
	[Empleador] [varchar](100),
    [SedeID] [varchar](100),
    [Usuario] [varchar](100),
    [FechaRegistro] [datetime] DEFAULT CURRENT_TIMESTAMP
)
GO
ALTER TABLE [dbo].[FORM] ADD CONSTRAINT [FORMFormularioID] PRIMARY KEY CLUSTERED ([FormularioID] ASC)



