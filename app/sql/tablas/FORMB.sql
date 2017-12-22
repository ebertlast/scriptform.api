/*Beneficiarions en el Formulario*/
IF OBJECT_ID('FORMB','U') IS NOT NULL DROP TABLE FORMB
GO
CREATE TABLE [dbo].[FORMB](
	[FormularioID] [varchar](50) NOT NULL,
	[TipoId] [varchar](2) NOT NULL,
	[NumeroIdentificacion] [varchar](16) NOT NULL
)
GO
ALTER TABLE [dbo].[FORMB] ADD CONSTRAINT [FORMBFormularioIDTipoIdNumeroIdentificacion] 
PRIMARY KEY CLUSTERED ([FormularioID] ASC,[TipoId] ASC,[NumeroIdentificacion] ASC)
